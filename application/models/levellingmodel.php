<?php
/**
 * LevellingModel Class
 *
 * Nivelman hesabı işlemleri
 *
 * @author Mete Ercan Pakdil
 */
class LevellingModel extends Model {

	function LevellingModel()
	{
		parent::Model();
	}

	/**
	 * Çizelge verilerini POST global değişkeninden çekerek dizi oluşturur
	 *
	 * @return Array
	 */
	function getData(){
		$result=array(
      		'numPoints'=>$this->input->post('num_points'),
      		'levellingType'=>$this->input->post('levelling_type'),
			'WL'=>$this->input->post('WL'),
			'maxDHI'=>$this->input->post('maxDHI'),
      		'isValid'=>TRUE,
      		'isEmpty'=>FALSE
		);
		foreach($_POST as $key=>$value)
		{
			if(in_array(preg_replace('/[^A-z]/', '', $key), array('id', 'b_deltah','f_deltah','f_l','b_l','H'))){
				if(!empty($value))
				{
					$result[preg_replace('/[^A-z]/', '', $key)][preg_replace('/[^0-9]/', '', $key)]=$value;
				}else
				{
					$result['isEmpty']=TRUE;
					$result['isValid']=FALSE;
				}
			}
		}
		return $result;
	}

	/**
	 * Proje verilerini veritabanından yükler
	 *
	 * @param Integer $pid proje no (gerekli)
	 * @return Array
	 */
	function getDataFromDB($pid)
	{
		$dbResult = $this->db->where('pid',$pid)->where('uid',$this->gu_session->getUID())->get('projects')->row();
		if ($dbResult==null)
		{
			return null;
		}
		$result = array(
			'levellingType' => $dbResult->type,
			'numPoints' => $dbResult->num_points,
			'id' => unserialize($dbResult->id),
			'f_deltah' => unserialize($dbResult->f_deltah),
			'b_deltah' => unserialize($dbResult->b_deltah),
			'f_l' => unserialize($dbResult->f_l),
			'b_l' => unserialize($dbResult->b_l),
			'H' => unserialize($dbResult->H),
			'WL' => $dbResult->wl,
			'maxDHI' => $dbResult->max_dhi,
			'isValid'=>TRUE,
      		'isEmpty'=>FALSE
		);
		return $result;
	}

	/**
	 * Proje daha önce kayıtlı mı kontrol eder
	 *
	 * @param String $tag proje etiketi (gerekli)
	 * @return Boolean
	 */
	function isExist($tag){
		$isExist=$this->db->where('uid',$this->gu_session->getUID())->where('tag',$tag)->get('projects')->num_rows();
		if ($isExist)
		{
			return TRUE;
		}else
		{
			return FALSE;
		}
	}
	
	/**
	 * Yeni proje kayıt eder
	 *
	 * @param Array $data proje verileri (gerekli)
	 * @return Boolean
	 */
	function save($data){
		return $this->db->insert('projects',$data);
	}
	
	/**
	 * Kayıtlı projeyi siler
	 *
	 * @param Integer $pid proje no (gerekli)
	 * @return Boolean
	 */
	function delete($pid)
	{
		$dbResult = $this->db->where('pid',$pid)->where('uid',$this->gu_session->getUID())->delete('projects');
		return $dbResult;
	}

	/**
	 * Açık nivelman hesabını gerçekleştirir
	 *
	 * @param Array $data hesap çizelgesi verileri (gerekli)
	 * @return Array
	 */
	function freeLevelling($data){
		#debug print_r($data);
		for ($i=0;$i<$data['numPoints']-1;$i++){
	        $data['fh'][$i]=abs($data['f_deltah'][$i]+$data['b_deltah'][$i])*1000;
	        $data['m_deltah'][$i]=($data['f_deltah'][$i]-$data['b_deltah'][$i])/2;
	        $data['m_l'][$i]=($data['f_l'][$i]+$data['b_l'][$i])/2;
	        $data['H'][$i+1]=$data['H'][$i]+$data['m_deltah'][$i];
      	}
      	return $data;
	}

	/**
	 * Kapalı nivelman hesabını gerçekleştirir
	 *
	 * @param Array $data hesap çizelgesi verileri (gerekli)
	 * @return Array
	 */
	function ringLevelling($data){
		#debug print_r($data);

		for ($i=0;$i<$data['numPoints'];$i++) {
			$data['fh'][$i]=abs($data['f_deltah'][$i]+$data['b_deltah'][$i])*1000;
			$data['m_l'][$i]=($data['f_l'][$i]+$data['b_l'][$i])/2;
			$data['dhi'][$i]=$data['maxDHI']*sqrt($data['m_l'][$i]/1000);
			if($data['fh'][$i]>$data['dhi'][$i])
			{
				$data['errorMessage']=($i+1).' ve '.($i+2).' nolu noktalar arasında gidiş-dönüş kapanma hatası var! (dh = '.sprintf("%.2f mm",$data['dhi'][$i]).')<br>';
			}
			$data['m_deltah'][$i]=($data['f_deltah'][$i]-$data['b_deltah'][$i])/2;
		}
		for ($i=0;$i<$data['numPoints'];$i++) {
			$data['vh'][$i]=-(array_sum($data['m_deltah'])/array_sum($data['m_l']))*$data['m_l'][$i];
			$data['deltah'][$i]=$data['vh'][$i]+$data['m_deltah'][$i];
			$data['H'][$i+1]=$data['H'][$i]+$data['deltah'][$i];
		}
		if(abs(array_sum($data['m_deltah'])*1000)>$data['WL']*sqrt(array_sum($data['m_l'])/1000))
		{
			$data['errorMessage']="Lup kapanma hatası var!";
		}
		return $data;
	}

	/**
	 * Bağlı nivelman hesabını gerçekleştirir
	 *
	 * @param Array $data hesap çizelgesi verileri (gerekli)
	 * @return Array
	 */
	function closedLevelling($data){
		#debug print_r($data);
		for ($i=0;$i<$data['numPoints']-1;$i++) {
			$data['fh'][$i]=abs($data['f_deltah'][$i]+$data['b_deltah'][$i])*1000;
			$data['m_l'][$i]=($data['f_l'][$i]+$data['b_l'][$i])/2;
			$data['dhi'][$i]=$data['maxDHI']*sqrt($data['m_l'][$i]/1000);
			if($data['fh'][$i]>$data['dhi'][$i])
			{
				$data['errorMessage']=($i+1).' ve '.($i+2).' nolu noktalar arasında gidiş-dönüş kapanma hatası var! (dh = '.sprintf("%.2f mm",$data['dhi'][$i]).')<br>';
			}
			$data['m_deltah'][$i]=($data['f_deltah'][$i]-$data['b_deltah'][$i])/2;
		}
		$w=array_sum($data['m_deltah'])-($data['H'][$data['numPoints']-1]-$data['H'][0]);
		for ($i=0;$i<$data['numPoints']-1;$i++) {
			$data['vh'][$i]=-($w/array_sum($data['m_l']))*$data['m_l'][$i];
			$data['deltah'][$i]=$data['vh'][$i]+$data['m_deltah'][$i];
			$data['H'][$i+1]=$data['H'][$i]+$data['deltah'][$i];
		}
		if(abs($w*1000)>$data['WL']*sqrt(array_sum($data['m_l'])/1000))
		{
			$data['errorMessage']="Nivelmanda Kapanma Hatası Var!";
		}
		return $data;
	}
}