<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'common_func.php';
class Remain extends CI_Controller{
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
		$data['area_list'] = (isset($params["area_list"]) ? $params["area_list"] : $this->common_model->add_selected_key_for_arealist($this->common_model->get_arealist()));
		
		$date = date('Y-m-d',time());
		$data["date"] = $date;
		$data['start_date'] = (isset($params["start_date"]) ? $params["start_date"] : $date);
		
		$data["result"] = (isset($params["result"]) ? $params["result"] : array());
		
		$this->load->view("templates/header", $data);
		$this->load->view("remain/remain_show", $data);
		$this->load->view("templates/footer");
	}
	
	public function _getParam($param){
		$this->load->model("common_model");
		return $this->common_model->deprefix($param);
	}
	
	public function execute($area_id, $start_date){
		//echo $area_id . "</p>" . $start_date . "</p>";
		$area_id = $this->_getParam($area_id);
		if (!is_numeric($area_id)) {
			
		}
		$start_date = $this->_getParam($start_date);
		//echo $area_id . "</p>" . $start_date . "</p>";
		$this->load->model("common_model");
		if(!$this->common_model->check_string_date($start_date)){
			echo "输入错误";
			return;
		}
		
		// 执行model,获得数据
		$this->load->model("remain_model");
		$dnux = $this->remain_model->get_dnu($area_id, $start_date);
		
		$result = array(
			"start_date" => $start_date,
			"result" => $dnux,
			"area_list" => $this->common_model->set_selected_flag_for_arealist($area_id,$this->common_model->get_arealist()),
		);
		
		$this->show($result);
	}

}

?>

