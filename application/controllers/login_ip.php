<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'common_func.php';
class Login_ip extends CI_Controller{
	var $CURRENT_PAGE = "留存率";
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
		
		$this->load->model("common_model");
		$data['player_id'] = isset($params["player_id"]) ? $params["player_id"] : '';
		$data['area_list'] = (isset($params["area_list"]) ? $params["area_list"] : $this->common_model->add_selected_key_for_arealist($this->common_model->get_arealist()));
		$data['start_date'] = (isset($params["start_date"]) ? $params["start_date"] : date('Y-m',time()));
		$data["result"] = (isset($params["result"]) ? $params["result"] : array());
		
		$this->load->view("templates/header", $data);
		$this->load->view("login_ip/login_ip_show", $data);
		$this->load->view("templates/footer");
	}
	
	public function _getParam($param){
		$this->load->model("common_model");
		return $this->common_model->deprefix($param);
	}
	
	public function execute($area_id, $player_id, $date){
		$area_id = $this->_getParam($area_id);
		$player_id = $this->_getParam($player_id);
		if (!is_numeric($area_id)) {
			exit("error area_id:".$area_id);	
		}
		if (!is_numeric($player_id)) {
			exit("error player_id:".$player_id);	
		}
		$date = $this->_getParam($date);
		$date_tmp = $date;
		$this->load->model("common_model");
		$arry = explode('-',$date);
		if (!is_numeric($arry[0]) || !is_numeric($arry[1])) {
			exit("data error date:".$date);	
		}
		$date = $arry[0].$arry[1];
		// 执行model,获得数据
		$this->load->model("login_ip_model");
		
		$result = array(
			"player_id" => $player_id,
			"area_list" => $this->common_model->set_selected_flag_for_arealist($area_id,$this->common_model->get_arealist()),
			"start_date" => $date_tmp,
			"result" => $this->login_ip_model->get_behavior_info($area_id,$player_id,  $date),
		);
		
		$this->show($result);
	}

}

?>

