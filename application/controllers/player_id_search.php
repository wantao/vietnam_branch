<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'common_func.php';
class Player_id_search extends CI_Controller{
	var $CURRENT_PAGE = "玩家id查询";
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
		$this->load->view("player_id_search/player_id_search_show", $data);
		$this->load->view("templates/footer");
	}
	public function execute($player_id){
		if (!is_numeric($player_id)) {
			return;	
		}
		$this->load->model("player_id_search_model");
		$result = $this->player_id_search_model->search(($player_id));
		$data['result'] = $result;
		$this->load->view("player_id_search/player_id_search_result", $data);
		return;
	}
}
?>