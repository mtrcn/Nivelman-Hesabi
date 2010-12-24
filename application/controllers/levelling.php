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
			echo '<div id="warning">Lütfen etiket alanını boş bırakmayın.</div>';
			exit();
		}
		$data=$this->LevellingModel->getData();
		if (!$data['isEmpty'])
		{
			$isExist = $this->LevellingModel->isExist($tag);
			if ($isExist)
			{
				echo '<div id="warning">Bu etiketle başka bir proje kaydetmişsiniz. Lütfen farklı bir etiket kullanın.</div>';
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
				echo '<div id="success">Projeniz başarıyla kaydedildi.</div>';
			}
		}else
		{
			echo '<div id="warning">Tablodaki tüm alanları doldurmadan projenizi kaydedemezsiniz.</div>';
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
		$regulation  = '<fieldset><legend><b>Hesap Kontrolü</b></legend>';
		$regulation .= '<table cellspacing="10" width="100%"><tr><td valign="top" class="regulation">';
		$regulation .= 'w<sub>L</sub> = '.sprintf("%0.1f mm",array_sum($data['m_deltah'])*1000).' &nbsp;&nbsp;';
		$regulation .= '<img src="'.base_url().'images/regulation/lkm.png" align="absbottom"> = '.sprintf("%.3f",array_sum($data['m_l'])/1000);
		$regulation .= '<br/><br/><img src="'.base_url().'images/regulation/wlkucuk.png" align="absbottom"><input type="text" size="1" value="'.$data['WL'].'" style="text-align:center;" name="WL"><img src="'.base_url().'images/regulation/lkm.png" align="absbottom">';
		$regulation .= '&nbsp;&nbsp;<img src="'.base_url().'images/regulation/wkucuk.png" align="absbottom"><input type="text" size="1" value="'.$data['maxDHI'].'" style="text-align:center;" name="maxDHI"><img src="'.base_url().'images/regulation/skm.png" align="absbottom">';
		$regulation .= '<td></tr></table></fieldset>';
		return $regulation;
	}
}