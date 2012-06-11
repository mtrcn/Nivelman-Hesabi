<?php
/**
 * User Class
 *
 * Üye işlemlerinin yapılabilmesi için metodlar içerir
 *
 * @author Mete Ercan Pakdil
 */
class User extends Controller {

	/**
	* User sınıfını yükler.
	*/
	function User()
	{
		parent::Controller();
	}
	
	/**
	* Varsayılan olarak hiç bir metod tarayıcıdan çağırılmadığında gelecektir.
	*/
	function index()
	{
		$this->load->view('header');
		$this->load->view('index');
		$this->load->view('footer');
	}
	
	/**
	* Kullanıcıya ait projeleri gösterir
	*/
	function projects(){
		if (!$this->gu_session->isLogged()) redirect("");
		$this->load->view('header');
		$data["projects"]=$this->db->where("uid",$this->gu_session->getUID())->order_by('date','DESC')->get("projects");
		$this->load->view('user/projects',$data);
		$this->load->view('footer');
	}
	
	/**
	 * Google ile oturum aç
	 */
	function login_with_google()
	{
		$this->load->library('openid',array('host'=>base_url()));
		if(!$this->input->get('openid_mode')) {
			$this->openid->identity = 'https://www.google.com/accounts/o8/id';
			redirect($this->openid->authUrl());
		}
		elseif($_GET['openid_mode'] == 'cancel')
		{
			redirect('');
		}
		else {
			if($this->openid->validate()){
				$this->_login($_GET);
			}
			else{
				redirect('');
			}
		}
	}
	
	/**
	 * myOpenID ile oturum aç
	 */
	function login_with_myopenid()
	{
		$this->load->library('openid',array('host'=>base_url()));
		if(!$this->input->get('openid_mode')) {
			$this->openid->identity = 'https://www.myopenid.com/';
			redirect($this->openid->authUrl());
		}
		elseif($_GET['openid_mode'] == 'cancel')
		{
			redirect('');
		}
		else {
			if($this->openid->validate()){
				$this->_login($_GET);
			}
			else{
				redirect('');
			}
		}
	}
	
	
	/**
	 * OpenID sağlayıcısından gelen bilgilerle oturum açar
	 *
	 * @param Array $openid_data OpenID sağlayıcısından gelen bilgiler (gerekli)
	 */
	private function _login($openid_data)
	{
		$dbResult=$this->db->where('uid',$openid_data['openid_identity'])->get('users')->row();
		if ($dbResult==NULL){
			//Kullanıcı daha önce veritabanında yoksa veritabınında kullanıcı için yeni bir kayıt oluşturulur.
			$dbResult=$this->db->insert('users',array('uid'=>(string)$openid_data['openid_identity']));
			if (!$dbResult)
				show_error('Bilgileriniz veritabanına kaydedilemedi.<br>Lütfen tekrar deneyin.');
			//Kullanıcı için her poligon türünden bir örnek proje oluşturulur.
			$this->_loadSampleData((string)$openid_data['openid_claimed_id']);
		}
		$this->session->set_userdata(array('uid' => $openid_data['openid_claimed_id']));
		redirect('user/projects');
	}
	
	/**
	 * Oturumu sonlandırır
	 *
	 */
	function logout()
	{
		if ($this->gu_session->isLogged()) {
			$this->session->sess_destroy();
		}
		redirect('');
	}
	
	/**
	* Örnek proje verileri yükleyen özel(private) metod.
	* 
	* @param Integer $uid üye hesap numarası (gerekli)
	*/
	function _loadSampleData($uid) {
		$this->db->query('
		INSERT INTO nh_projects (uid, tag, date, type, num_points, id, f_deltah, b_deltah, f_l, b_l, H, wl, max_dhi) VALUES
		(\''.$uid.'\', \'Bağlı Nivelman Örneği\', '.time().', \'closed\', 6, \'a:6:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"3";i:3;s:1:"4";i:4;s:1:"5";i:5;s:1:"6";}\', \'a:5:{i:0;s:5:"1.054";i:1;s:7:"-19.802";i:2;s:5:"5.250";i:3;s:6:"12.491";i:4;s:6:"-4.023";}\', \'a:5:{i:0;s:6:"-1.049";i:1;s:6:"19.801";i:2;s:6:"-5.246";i:3;s:7:"-12.490";i:4;s:5:"4.023";}\', \'a:5:{i:0;s:3:"300";i:1;s:3:"300";i:2;s:3:"300";i:3;s:3:"300";i:4;s:3:"300";}\', \'a:5:{i:0;s:3:"300";i:1;s:3:"300";i:2;s:3:"300";i:3;s:3:"300";i:4;s:3:"300";}\', \'a:2:{i:0;s:6:"91.644";i:5;s:6:"86.607";}\', 15, 12),
		(\''.$uid.'\', \'Açık Nivelman Örneği\', '.time().', \'free\', 4, \'a:4:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"3";i:3;s:1:"4";}\', \'a:3:{i:0;s:5:"2.038";i:1;s:6:"-1.606";i:2;s:5:"1.902";}\', \'a:3:{i:0;s:6:"-2.034";i:1;s:5:"1.605";i:2;s:6:"-1.897";}\', \'a:3:{i:0;s:3:"300";i:1;s:3:"300";i:2;s:3:"300";}\', \'a:3:{i:0;s:3:"300";i:1;s:3:"300";i:2;s:3:"300";}\', \'a:1:{i:0;s:7:"345.150";}\', 15, 12),
		(\''.$uid.'\', \'Kapalı Nivelman Örneği\', '.time().', \'ring\', 6, \'a:6:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"3";i:3;s:1:"4";i:4;s:1:"5";i:5;s:1:"6";}\', \'a:6:{i:0;s:6:"13.233";i:1;s:7:"-22.181";i:2;s:6:"-1.077";i:3;s:6:"-1.606";i:4;s:6:"-2.557";i:5;s:6:"14.202";}\', \'a:6:{i:0;s:7:"-13.231";i:1;s:6:"22.185";i:2;s:5:"1.079";i:3;s:5:"1.601";i:4;s:5:"2.557";i:5;s:7:"-14.204";}\', \'a:6:{i:0;s:3:"300";i:1;s:3:"300";i:2;s:3:"300";i:3;s:3:"300";i:4;s:3:"300";i:5;s:3:"300";}\', \'a:6:{i:0;s:3:"300";i:1;s:3:"300";i:2;s:3:"300";i:3;s:3:"300";i:4;s:3:"300";i:5;s:3:"300";}\', \'a:1:{i:0;s:6:"77.679";}\', 15, 12);
		');
	}
	
	/**
	 * GU lisans sistemi ile kaydedilen projeleri yükler.
	 *
	 */
	function load_gu_projects()
	{
		$uid = floatval($this->input->post("id"));
		$result=$this->db->where('uid',(string)$uid)->get('projects');
		$count = 0;
		try{
			foreach ($result->result() as $row)
			{
				$this->db->where('pid',$row->pid)->update('projects',array('uid'=>$this->gu_session->getUID()));
				$count++;
			}
			if ($count > 0)
			{
				echo '<div class="alert alert-success">Toplam '.$count.' projeniz yeni hesabınıza aktarıldı.</div>';
			}
			else
			{
				echo '<div class="alert">Hesap numarasına ilişkin herhangi bir proje bulunamadı.</div>';
			}
		}catch(Exception $ex)
		{
			echo '<div class="alert alert-error">İşlem tamamlanamadı!</div>';
		}
	}
	
}