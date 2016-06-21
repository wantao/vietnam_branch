<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'common_func.php';
class Server_state extends CI_Controller{
	var $CURRENT_PAGE = "服务器状态";
	var $GM_LEVEL = "-1";
	public function show(){
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
		
		$this->load->view("templates/header", $data);
		$this->load->view("server_state/server_state_show", $data);
		$this->load->view("templates/footer");
	}
	public function execute($name){
		$this->load->model("server_state_model");
		$info = $this->server_state_model->get_server_state_info();
		if(!$info){
			echo "Playername error.";
			return;
		}
		$property_names = $this->server_state_model->get_server_state_property_names();
		$data['property_name'] = $property_names;
		$data['info'] = $info;
		$this->load->view("server_state/server_state_result", $data);
	}
}
?>