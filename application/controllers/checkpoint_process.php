<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'common_func.php';
class Checkpoint_process extends CI_Controller{
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
		$this->load->model("checkpoint_process_model");
		$data['area_list'] = (isset($params["area_list"]) ? $params["area_list"] : $this->common_model->add_selected_key_for_arealist($this->common_model->get_arealist()));
		$data['type_list'] = (isset($params["type_list"]) ? $params["type_list"] :  $this->checkpoint_process_model->add_selected_key_for_typelist($this->checkpoint_process_model->get_type_list()));
		$data["result"] = (isset($params["result"]) ? $params["result"] : array());
		$this->load->view("templates/header", $data);
		$this->load->view("checkpoint_process/checkpoint_process_show", $data);
		$this->load->view("templates/footer");
	}
	
	public function _getParam($param){
		$this->load->model("common_model");
		return $this->common_model->deprefix($param);
	}
	
	public function execute($area_id, $type){
		$area_id = $this->_getParam($area_id);
		$type = $this->_getParam($type);
		if (!is_numeric($area_id) || !is_numeric($type)) {
			exit("error area_id:".$area_id." or type:".$type);	
		}
		// 执行model,获得数据
		$this->load->model("checkpoint_process_model");
		
		$result = array(
			"area_list" => $this->common_model->set_selected_flag_for_arealist($area_id,$this->common_model->get_arealist()),
			"type_list" => $this->checkpoint_process_model->set_selected_flag_for_typelist($type,$this->checkpoint_process_model->get_type_list()),
			"result" => $this->checkpoint_process_model->get_checkpoint_process_info($area_id, $type),
		);
		
		$this->show($result);
	}

}

?>

