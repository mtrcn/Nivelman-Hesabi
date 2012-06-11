<?php
/**
 * Traverse Class
 *
 * Poligon hesabı işlemleri için gereken metdolar
 *
 * @author Mete Ercan Pakdil
 */
class Levelling extends Controller {

	var $title_tr = array('free' => 'Açık','ring' => 'Kapalı','closed' => 'Bağlı');
	
	/**
	* Levelling sınıfını yükler.
	*/
	function Levelling()
	{
		parent::Controller();
		$this->load->library('gupa');
		$this->load->model('LevellingModel', '', TRUE);
	}

	/**
	* Yeni proje oluşturmak için 
	*/
	function new_project(){
		if (!$this->gu_session->isLogged()) redirect("");
		$this->load->view('header');
		$this->load->view('levelling/new_project');
		$this->load->view('footer');
	}
	
	/**
	* Seçilen nivelman tipine göre nivelman hesabı çizelgesini yükler.
	*/
	function table(){
		if (!$this->gu_session->isLogged()) redirect("");
		$data=$this->LevellingModel->getData();
		$data['title']=$this->title_tr[$data['levellingType']].' Nivelman Hesabı';
		$this->load->view('header');
		$this->load->view('levelling/table_header',$data);
		$this->load->view('levelling/'.$data['levellingType'].'_levelling_table',$data);
		$this->load->view('levelling/table_footer',$data);
		$this->load->view('footer');
	}
	
	/**
	* Çizelgeden gelen verilere göre nivelman hesabını yapar.
	*/
	function calculate(){
		if (!$this->gu_session->isLogged()) redirect("");
		//POST global değişkeni ile gelen parametreler okunur
		$data=$this->LevellingModel->getData();
		//Gerekli parametreler gelmiş mi kontrol edilir
		if (!$data['isEmpty'])
		{
			//Nivelman tipine göre ilgili hesap metodu çağırılır
			switch ($data['levellingType'])
			{
				case "free":
					$data=$this->LevellingModel->freeLevelling($data);
					break;
				case "ring":
					$data=$this->LevellingModel->ringLevelling($data);
					$data['regulation'] = $this->_prepareRegulation($data);
					break;
				case "closed":
					$data=$this->LevellingModel->closedLevelling($data);
					$data['regulation'] = $this->_prepareRegulation($data);
					break;
			}
		}else //Eğer gerekli parametreler yoksa hata mesajı oluşturulur
		{
			$data['errorMessage']="Lütfen tüm eksik alanları doldurun aksi halde hesaplama gerçekleşmeyecektir!";
		}

		$data['title']=$this->title_tr[$data['levellingType']].' Nivelman Hesabı';
		$this->load->view('header');
		$this->load->view('levelling/table_header',$data);
		$this->load->view('levelling/'.$data['levellingType'].'_levelling_table',$data);
		$this->load->view('levelling/table_footer',$data);
		$this->load->view('footer');
	}
	
	/**
	* Nivelman hesabını daha sonra çalışmak üzere kaydeder.
	*/
	function save(){
		if (!$this->gu_session->isLogged()) die("Erişim Yetkiniz Yok!");
		$tag = trim($this->input->post('tag',TRUE));
		if (empty($tag))
		{
			echo '<div class="alert alert-error">Lütfen etiket alanını boş bırakmayın.</div>';
			exit();
		}
		$data=$this->LevellingModel->getData();
		if (!$data['isEmpty'])
		{
			$isExist = $this->LevellingModel->isExist($tag);
			if ($isExist)
			{
				echo '<div class="alert alert-error">Bu etiketle başka bir proje kaydetmişsiniz. Lütfen farklı bir etiket kullanın.</div>';
			}else
			{
				$saveData=array(
					'uid' => $this->gu_session->getUID(),
					'date' => time(),
					'tag' => $tag,
					'type' => $data['levellingType'],
					'num_points' => $data['numPoints'],
					'id' => serialize($data['id']),
					'f_deltah' => serialize($data['f_deltah']),
					'b_deltah' => serialize($data['b_deltah']),
					'f_l' => serialize($data['f_l']),
					'b_l' => serialize($data['b_l']),
					'H' => serialize($data['H']),
					'wl' => $data['WL'],
					'max_dhi' => $data['maxDHI']
				);
				$this->LevellingModel->save($saveData);
				echo '<div class="alert alert-success">Projeniz başarıyla kaydedildi.</div>';
			}
		}else
		{
			echo '<div class="alert">Tablodaki tüm alanları doldurmadan projenizi kaydedemezsiniz.</div>';
		}
	}

	/**
	* Daha önceden kaydedilmiş poligon hesabı projesini yükler
	*/
	function open()
	{
		if (!$this->gu_session->isLogged()) redirect("");
		$pid = intval($this->uri->segment(3));
		if (!$pid)
		{
			redirect("user/projects");
		}
		$data = $this->LevellingModel->getDataFromDB($pid);
		if ($data==null)
		{
			show_error("Proje bulunamadı!");
			exit();
		}
		$data['title']=$this->title_tr[$data['levellingType']].' Nivelman Hesabı';
		$this->load->view('header');
		$this->load->view('levelling/table_header',$data);
		$this->load->view('levelling/'.$data['levellingType'].'_levelling_table',$data);
		$this->load->view('levelling/table_footer',$data);
		$this->load->view('footer');
	}
	
	/**
	* Kayıtlı projeyi siler
	*/
	function delete()
	{
		if (!$this->gu_session->isLogged()) redirect("");
		$pid = intval($this->uri->segment(3));
		if (!$pid)
		{
			redirect("user/projects");
		}
		$this->LevellingModel->delete($pid);
		redirect("user/projects");	
	}
	
	/**
	* Büyük Ölçekli Harita ve Harita Bilgileri Üretim yönetmeliğine göre hesap kontrollerini görselleştiren özel(private) metod.
	* 
	* @param Array $data hesap kontrolleri için gerekli parametreler (gerekli)
	* @return String
	*/
	function _prepareRegulation($data){
		$regulation  = '<h3>Hesap Kontrolü</h3>';
		$regulation .= '<div class="row">';
		$regulation .= '<div class="span3">';
		$regulation .= '<p>w<sub>L</sub> = '.sprintf("%0.1f mm",array_sum($data['m_deltah'])*1000).'</p>';
		$regulation .= '<p><img src="'.base_url().'images/regulation/lkm.png" align="absbottom"> = '.sprintf("%.3f",array_sum($data['m_l'])/1000).'</p>';
		$regulation .= '</div><div class="span3">';
		$regulation .= '<p><img src="'.base_url().'images/regulation/wlkucuk.png" align="absbottom"><input type="text" value="'.$data['WL'].'" class="input-mini" name="WL"><img src="'.base_url().'images/regulation/lkm.png" align="absbottom"></p>';
		$regulation .= '<p><img src="'.base_url().'images/regulation/wkucuk.png" align="absbottom"><input type="text" value="'.$data['maxDHI'].'" class="input-mini" name="maxDHI"><img src="'.base_url().'images/regulation/skm.png" align="absbottom"></p>';
		$regulation .= '</div></div>';
		return $regulation;
	}
}