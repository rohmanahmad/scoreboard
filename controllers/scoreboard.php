<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('SERVER_URL','http://'.$_SERVER['HTTP_HOST']);
define('UPLOAD_PATH','/home/server/www/ADM_UPLOAD/scoreboard/');
define('HTTP_UPLOAD_PATH',SERVER_URL.'/ADM_UPLOAD/scoreboard/');

class Scoreboard extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper(array('url','html'));
		$this->load->model('score_board_model','m');
		$this->load->library('encrypt');
	}
 
	function header($data=array()){
	 	$this->load->view('main/header',$data);
	}
	
	function get_uRights(){
		$s=$this->session->userdata('session_user');
		//print_r($s['hak']); 
		//return 1;
		return $s['hak'];
	}
	
	function get_uId(){
		$s=$this->session->userdata('session_user');
		return($s['ID']); 
	}
	
	function flash(){
		$this->load->library('session');
		return $this->session;
	}
	
	function path($name=''){
		return UPLOAD_PATH.$name;
	}
	
	function uri_segment(){
		return $this->uri;
	}
	
	function index(){
		$this->home();
	}
	
	function home($data=array()){
		$user_id=$this->get_uId();
		$data['include_js'] = jquery_js_core() . 
			'<script src="' .base_url(). 'assets/js/jquery-1.7.min.js"></script>';
		$this->load->helper('form');
		$q_data=$this->m->get_current_scoreboard(date('Y-m-d'),$user_id);
		if(count($q_data) == 1){
			$id=$q_data->ID;
			redirect('scoreboard/scoreBoard/'.$id);
		}
		$this->header($data);
		$this->load->view('view_sbd',$data);
		$this->load->view('footer',$data);
	}
	
	function targets(){
		/*$this->m->admin_get_all_targets();
		exit;*/
		$ur=$this->get_uRights();
		$uId=$this->get_uId();
		if($ur == 1){
			$this->load->helper(array('my_date','form'));
			$data['users']=$this->m->get_all_users();
			$data['result']=$this->m->filter_targets();
			$data['admin']=true;
		}else{
			$data['result']=$this->m->getTargets($uId);
		}
		$this->header();
		$this->load->view('targets',$data);
		$this->load->view('footer',$data);
	}
	
	function save(){
		$userId=$this->get_uId();
		$res=$this->m->save($userId);
		if ($res == 1) redirect('scoreboard/targets');
		echo $res;
		exit;
	}
	
	function scoreBoard($id=''){
		if ($id=='') exit;
		if($this->get_uRights() == 1)$data['admin']=true;
		$data['include_js'] = jquery_js_core() . 
			'<script src="' .base_url(). 'assets/js/jquery-1.7.min.js"></script>';
		$this->header($data);
		$result=$this->m->getJobs($id);
		$data['result']=$result;
		$data['model']=$this->m;
		$data['encrypt']=$this->encrypt;
		$data['c']=$this;
		$this->load->helper('form');
		$this->load->view('scoreboard',$data);
		$this->load->view('footer',$data);
	}
	
	function browse_job_result($scID=0){
		$this->session->set_flashdata('last_url',$this->uri->uri_string());
		$userId=$this->get_uId();
		if($this->get_uRights() == 1){$data['admin']=true;$userId='';}
		$data['job_res_datas']=$this->m->get_job_result($scID,$userId);
		$data['uri']=$this->uri;
		$this->header($data);
		$this->load->view('browse_job_result',$data);
		$this->load->view('footer',$data);
	}
	
	function delete_file($path){
		if(file_exists($path)){
			@unlink($path);
		}else{
			echo 'unable to find the file!';
			exit;
		}
	}
	
	private function set_upload_options()
	{   
	//  upload an image options
	    $config = array();
	    $dir=UPLOAD_PATH.date('d-m-y');
	    if(!is_dir($dir)){
	    	mkdir($dir,0777,true);
	    	chmod($dir, 0777);
	    }
	    $config['upload_path'] = $dir;
	    $config['allowed_types'] = '*';
	    //$config['max_size']      = '990000';
	    $config['overwrite']     = FALSE;
	    $config['file_name']     = date('dmygis');


	    return $config;
	}
	
	function change_field($name='',$id=''){
		if($_POST){
		 $target_id=$this->flash()->flashdata('id');
			if($name == 'period'){
				$this->save_post_period($target_id);
			}elseif($name == 'tname'){
				$this->save_post_target($target_id);
			}elseif($name == 'job'){
				$this->save_post_job($target_id);
			}
			exit;
			redirect('scoreboard/change_field/sboard/'.$target_id);
		}
		$q=$this->m->get_all_job($id);//get_all_job([parameters])
		$data['result']=$q;
		$data['name']=$name;
		$data['ID']=$id;
		$data['flash']=$this->flash();
		$data['uri']=$this->uri_segment();
		$this->load->helper('form');
		$data['include_js'] = jquery_js_core() . 
			'<script src="' .base_url(). 'assets/js/jquery-1.7.min.js"></script>';
		
		$this->header($data);
		$this->load->view('edit_fields',$data);
		$this->load->view('footer',$data);
	}
	
	function save_post_period($target_id=0){
		$user_id=$this->get_uId();
		$target_id=$this->flash()->flashdata('id');
		$this->m->save_post_period($target_id,$user_id);
		redirect('scoreboard/targets');
	}
	
	function save_post_target($target_id=0){
		if($_POST){
			$name=$this->input->post('tname');
			$this->m->save_post_target($name,$target_id);
		}else{echo 'error';exit;}
		
		redirect('scoreboard/targets/'.$target_id);
	}
	
	function save_post_job($target_id){
		if($_POST){
		$job_data=array();
		 for($a=0;$a<=count($_POST['job'])-1;$a++){
		 	$job=$_POST['job'][$a];
		 	 if($job=='')$job='NotSet(Empty)';
		 	$job_id=$_POST['jid'][$a];
		 	if($job_id != ''){
				$this->m->update_job($job,$job_id);
			}else{
				$job_data[]=$job;
			}
		 }

		 $this->create_new_job($target_id,$job_data);

		}else{echo 'error';exit;}
		redirect('scoreboard/targets/'.$target_id);
		
	}
	
	function create_new_job($target_id,$job_data){
		if(!empty($job_data)){
			$date=explode('|',$this->input->post('date_period'));
			$start=$date[0];
			$finish=$date[1];
			$userId=$this->get_uId();
			$this->m->create_data($userId,'',$target_id,$start,$finish,$job_data);
		}
	}
	
	function log($bagian,$value){
		print_r(br().'['.$bagian.'<>'.$value.']'.br());
	}	
	
	function delete_target($tId=0){
		$userId=$this->get_uId();
		$q=$this->m->getTargets($userId,$tId);
		if(count($q)>0){
			$data=$this->m->get_job_res_from_tId($tId);
			foreach($data as $r){
				$url=$r->url;
				$path=str_replace(array('http://','file://'),'',$url);
			  	 	$ex=explode('/',$path);
			  	 	$index=count($ex)-1;
				  	$filename=UPLOAD_PATH.$ex[$index-1].'/'.$ex[$index];
						if(file_exists($filename)){
							$this->delete_file($filename); //DELETE
						}
			}
			$this->m->delete_target_packet($tId);
		}
		//redirect('scoreboard');
	}
	
	function delete_job($job_id=0,$target_id=0){
		$user_id=$this->get_uId();
		$data=$this->m->select_job_res_file_only($job_id,$user_id);
		foreach($data as $r){
			$path=str_replace(array('http://','file://'),'',$r->url);
			  	 	$ex=explode('/',$path);
			  	 	$index=count($ex)-1;
				  	$filename=UPLOAD_PATH.$ex[$index-1].'/'.$ex[$index];
						if(file_exists($filename)){
							$this->delete_file($filename); //DELETE
						 }
		}
		$this->m->delete_job($job_id,$target_id);
		redirect('scoreboard/scoreBoard/'.$target_id);
	}
	
	function add_job_result($scID=0){
		$this->add_new_job_res($scID);
		$userId=$this->get_uId();
		$data['include_js'] = jquery_js_core() . 
			'<script src="' .base_url(). 'assets/js/jquery-1.7.min.js"></script>';
		$this->session->keep_flashdata('last_url');
		$data['flash']=$this->flash();
		$data['uri']=$this->uri;
		$this->load->helper('form');
		$data['res']=$this->m->get_score($scID,$userId);
		$this->header($data);
		$this->load->view('add_job_result',$data);
		$this->load->view('footer',$data);
	}
	
	function add_new_job_res($sc_id){
		if($_POST){
			if(empty($sc_id))$sc_id=$this->flash()->flashdata('ID');
			// URL CONTENT
			if(!empty($_POST['content'])){
				$this->process_add($sc_id);
			}
			// FILE UPLOAD
			if($_FILES['userfile']['name'][0] != ''){
				$this->load->library('upload');
				$files = $_FILES;
				$cpt = count($_FILES['userfile']['name']);
				for($i=0; $i<$cpt; $i++)
				{
					$_FILES['userfile']['name']= $files['userfile']['name'][$i];
					$_FILES['userfile']['type']= $files['userfile']['type'][$i];
					$_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
					$_FILES['userfile']['error']= $files['userfile']['error'][$i];
					$_FILES['userfile']['size']= $files['userfile']['size'][$i];    
					$this->upload->initialize($this->set_upload_options());
					if(!$this->upload->do_upload())	{
						print_r($this->upload->display_errors());
					}else{
						$data=$this->upload->data();
						$this->m->insert_new_job_res($sc_id,'file://'.$data['full_path']);
					}
				}
			}
			$url=$this->flash()->flashdata('last_url');
			if(empty($url))$url='scoreboard/targets';
			
			redirect($url);
		}
	}
	
	function process_add($sc_id){
		$str=urlencode($_POST['content']);
	 	if(!empty($str)){
	 	 $ex=explode('%0A',$str);
	 	 $total=count($ex);
	 	}else{
	 	 $total=0;
	 	}
		if($total <= 0)$url=array();
		 for($a=0;$a <= $total-1;$a++){
		 	if($ex[$a] !== '')
		 	$url[]=urldecode($ex[$a]);
		 }
		$count_url=count($url);
		 
		  for($a=0;$a<=$count_url - 1;$a++){
		   	$content=$url[$a];
		   	$this->m->insert_new_job_res($sc_id,$content);
		  }
		 return $sc_id;
	}
	
	function delete_result($id=0,$target=0){
		$userid=$this->get_uId();
		$data=$this->m->get_job_res_by_id($id,$userid);
		foreach($data->result() as $r){
			$content=substr($r->url,0,4);
			if($content == 'file'){
				$path=str_replace(array('http://','file://'),'',$r->url);
			  	 	$ex=explode('/',$path);
			  	 	$index=count($ex)-1;
				  	$filename=UPLOAD_PATH.$ex[$index-1].'/'.$ex[$index];
						if(file_exists($filename)){
							$this->delete_file($filename); //DELETE
							$this->m->prepare_delete_jres($id);
						 }
			}
		}
		$this->m->delete_result($id,$userid);
		redirect('scoreboard/browse_job_result/'.$target);
	}
	
	function reset_data($table=''){
		$table=array('job','job_result','schedule','targets');
		foreach($table as $table){
			$this->m->reset_table($table);
		}
		redirect('scoreboard');
	}	
	
	function edit_targets(){
		if(isset($_POST['id'])){
			$this->m->edit_target();
			redirect('scoreboard/targets');
		}
		if(!isset($_POST['check'])){echo 'tidak ada field yang akan di edit!!!';exit;}
		$post=$this->input->post('check');
		foreach($post as $sc_id){
		 $data_form[]=$this->m->get_sch_datas($sc_id);
		}
		$data['fields']=$data_form;
		$this->load->helper('form');
		$this->header();
		$this->load->view('change_field_schedule',$data);
		$this->load->view('footer',$data);
	}
	
	function get_smile($status=':-)'){
		$this->load->helper('smiley');
		$data = parse_smileys($status,base_url().'assets/images/smileys/');
		return $data;
	}
	
	function get_period($jId){
		$data=$this->m->get_period($jId);
		return $data;
	}
	
	function getjobRes($jobId){
		$data=$this->m->getJobRes($jobId);
		return $data;
	}
	
	function get_total_contents($id){
		return $this->m->get_total_contents($id);
	}
	
}
