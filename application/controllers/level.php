<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'common_func.php';
class Level extends CI_Controller {
	var $CURRENT_PAGE = LG_LEVEL_SPREAD;
	var $GM_LEVEL = "-1";
	public function show($result = array()){
		$this->load->library('session');
		$logged_in = $this->session->userdata('logged_in');
		if($logged_in == false){
			$this->load->view("main/main_not_logged");
			return;
		}
		$gm_level = $this->session->userdata('gm_level');
		$this->load->model('main_model');
		$pages = $this->main_model->get_pages($gm_level);
		if(!isset($pages)){
			$this->load->view("main/main_not_enough_level");
			$this->load->view("templates/footer");
			return;
		}
		
		$data['current_page'] = $this->CURRENT_PAGE;
		$data['pages'] = $pages;
		
		$uri_string = $this->session->CI->uri->segments[1];
		if (!is_sub_url_string($data['pages'],$uri_string)) {
			$this->load->view("main/main_not_enough_level");
			$this->load->view("templates/footer");
			return;	
		}
		
		$this->load->model("common_model");
		$data['area_list'] = (isset($result["area_list"]) ? $result["area_list"] : $this->common_model->add_selected_key_for_arealist($this->common_model->get_arealist()));
		
		$data["result"] = (isset($result["result"]) ? $result["result"] : array());
		
		$this->load->model('level_model');
		
		$this->load->view("templates/header", $data);
		$this->load->view("level/level_show", $data);
		$this->load->view("templates/footer");
	}
	public function execute($area_id){
		$this->load->model("common_model");
		$area_id = $this->common_model->deprefix($area_id);
		if (!is_numeric($area_id)) {
			exit;
		}
		$this->load->model("level_model");
		$result = $this->level_model->search($area_id);
		$this->show(array(
			"result" => $result,
			"area_list" => $this->common_model->set_selected_flag_for_arealist($area_id,$this->common_model->get_arealist()),
			)
		);
	}
	public function export($area_id){
		if (!is_numeric($area_id)) {
			exit;
		}
		$this->load->model("common_model");
		$area_id = $this->common_model->deprefix($area_id);
		
		$this->load->model("level_model");
		$result = $this->level_model->search($area_id);
		
		$ua = $_SERVER["HTTP_USER_AGENT"];  
		$filename = "level_area_$area_id.csv";  
		header("Content-Type: application/octet-stream");    
		if (preg_match("/MSIE/", $_SERVER['HTTP_USER_AGENT']) ) {    
    		header('Content-Disposition:  attachment; filename="' . $encoded_filename . '"');    
		} elseif (preg_match("/Firefox/", $_SERVER['HTTP_USER_AGENT'])) {    
    		header('Content-Disposition: attachment; filename*="utf8' .  $filename . '"');    
		} else {    
    		header('Content-Disposition: attachment; filename="' .  $filename . '"');    
		}
		echo "#等级, 人数\r\n";
		foreach($result as $row){	
			echo "$row->level , $row->count \r\n";
		}
	}
}
?>