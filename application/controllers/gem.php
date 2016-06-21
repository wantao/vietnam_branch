<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'common_func.php';
class Gem extends CI_Controller {
	var $CURRENT_PAGE = "元宝获得与消耗";
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
		$data['area_list'] = (isset($params["area_list"]) ? $params["area_list"] : $this->common_model->add_selected_key_for_arealist($this->common_model->get_arealist()));
		
		
		$date_time = date('Y-m-d H:i:s',time());
		
		$data['start_date_time'] = (isset($params["start_date_time"]) ? $params["start_date_time"] : $date_time);
		$data['end_date_time'] = (isset($params["end_date_time"]) ? $params["end_date_time"] : $date_time);
		
		$data["result"] = (isset($params["result_struct"]) ? $params["result_struct"] : array());
		
		$this->load->model('gem_model');
		$data["type"] = $this->gem_model->get_type();
		
		$this->load->view("templates/header", $data);
		$this->load->view("gem/gem_show", $data);
		$this->load->view("templates/footer");
	}
	
	public function execute($area_id, $start_date_time, $end_date_time, $player_id, $desc, $type, $page = "_1_"){
		$area_id = $this->_getParam($area_id);
		$start_date_time = $this->_getParam($start_date_time);
		$end_date_time = $this->_getParam($end_date_time);
		$page = $this->_getParam($page);
		$player_id = $this->_getParam($player_id);
		$desc = urldecode($this->_getParam($desc));
		$type = $this->_getParam($type);
		
		if (strlen($player_id) > 0 && !is_numeric($player_id)) {
			exit;	
		}
		if (!is_numeric($area_id) || !is_numeric($page) || !is_numeric($type)) {
			exit;
		}
		
		$start_date_time = urldecode($start_date_time);
		$end_date_time = urldecode($end_date_time);
		$start_date_time_param = explode(" ", $start_date_time);
		$end_date_time_param = explode(" ", $end_date_time);
		
		if(!$this->common_model->check_string_date($start_date_time_param[0]) || !$this->common_model->check_string_time($start_date_time_param[1]) ||
			!$this->common_model->check_string_date($end_date_time_param[0]) || !$this->common_model->check_string_time($end_date_time_param[1])){
			echo "输入错误";
			return;
		}
		
		$this->load->model("gem_model");
		$result = $this->gem_model->search($area_id, $start_date_time_param[0], $start_date_time_param[1], $end_date_time_param[0], $end_date_time_param[1], $player_id, ($desc), $type, $page);
		$next_page_url = "";
		$previous_page_url = "";
		$count_per_page = $this->gem_model->get_count_per_page();
		if(count($result) > $count_per_page){
			$next_page_url = $this->gem_model->make_url($area_id, $start_date_time_param[0], $start_date_time_param[1], $end_date_time_param[0], $end_date_time_param[1], $player_id, $desc, $type, $page + 1); 
		}
		if($page > 1){
			$previous_page_url = $this->gem_model->make_url($area_id, $start_date_time_param[0], $start_date_time_param[1], $end_date_time_param[0], $end_date_time_param[1], $player_id, $desc, $type, $page - 1);
		}
		
		$result_show = array_slice($result, 0, $count_per_page);
		$total = 0;
		foreach($result_show as $row){
			$total += $row->nchange;
		}
		$result_struct = array(
			"result" => $result_show,
			"total" => $total,
			"next_page_url" => $next_page_url,
			"previous_page_url" => $previous_page_url,
		);
		$this->show(array(
			"result_struct" => $result_struct,
			"start_date_time" => $start_date_time,
			"end_date_time" => $end_date_time,
			"area_list" => $this->common_model->set_selected_flag_for_arealist($area_id,$this->common_model->get_arealist()),
		));
	}
	
	public function _getParam($param){
		$this->load->model("common_model");
		return $this->common_model->deprefix($param);
	}
}
?>