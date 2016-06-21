<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'common_func.php';
class Log extends CI_Controller{
	var $CURRENT_PAGE = "各服日志";
	var $GM_LEVEL = "-1";
	public function show($params = array()){
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
        
		$this->load->helper('directory');
		$map = directory_map('F:\wt\wampServer\setUpDir\wamp\www\game_log', 0, TRUE); 
		$data["folder_list"] = $map;
        
		$this->load->view("templates/header", $data);
		$this->load->view("log/log_show", $data);
		$this->load->view("templates/footer");
	}
	public function execute($name){
		$this->show(array());
	}
}
?>
