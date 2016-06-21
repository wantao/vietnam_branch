<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'common_func.php';
class Player_equipment extends CI_Controller{
	var $CURRENT_PAGE = "宠物信息";
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
		
		$data['player_id'] = isset($params["player_id"]) ? $params["player_id"] : '';
		$data["result"] = (isset($params["result"]) ? $params["result"] : array());
		
		$this->load->view("templates/header", $data);
		$this->load->view("player_equipment/player_equipment_show", $data);
		$this->load->view("templates/footer");
	}
	
	public function _getParam($param){
		$this->load->model("common_model");
		return $this->common_model->deprefix($param);
	}
	
	public function execute($player_id){
		$player_id = $this->_getParam($player_id);
		if (!is_numeric($player_id)) {
			exit("error playerid:".$player_id);	
		}
		$this->load->model("player_equipment_model");
		$this->show(array(
			"player_id" => $player_id,
			"result" => $this->player_equipment_model->get_equipment_info($player_id),
		));
	}
}
?>