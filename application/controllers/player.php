<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'common_func.php';
class Player extends CI_Controller{
	var $CURRENT_PAGE = "玩家基本信息";
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
		$this->load->view("player/player_show", $data);
		$this->load->view("templates/footer");
	}
	public function execute($name){
		$this->load->model("player_model");
		$info = $this->player_model->get_player_info((urldecode($name)));
		if(!$info){
			echo "Playername error.";
			return;
		}
		$property_name_ori = $this->player_model->get_property_names();
		$property_names = array();
		foreach ($property_name_ori as $table => $property_name){
			$property_names = array_merge($property_names, $property_name);
		}
		$data['info'] = $info;
		$data['property_name'] = $property_names;
		$this->load->view("player/player_info_result", $data);
	}
}
?>