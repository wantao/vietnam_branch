<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'common_func.php';
class Channel_detail extends CI_Controller {
	var $CURRENT_PAGE = "渠道明细";
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
		
		
		$date = date('Y-m-d',time());
		$data["date"] = $date;
		
		$data['start_date'] = (isset($params["start_date"]) ? $params["start_date"] : $date);
		$data['end_date'] = (isset($params["end_date"]) ? $params["end_date"] : $date); 
		$data['end_date'] = limit_end_date_and_start_date_in_the_same_month($data['start_date'],$data['end_date'],"");
		
		$data["result"] = (isset($params["result"]) ? $params["result"] : array());
		
		$this->load->view("templates/header", $data);
		$this->load->view("channel_detail/channel_detail_show", $data);
		$this->load->view("templates/footer");
	}
	
	public function execute($start_date, $end_date){
		$start_date = $this->_getParam($start_date);
		$end_date = $this->_getParam($end_date);
		$end_date = limit_end_date_and_start_date_in_the_same_month($start_date,$end_date,"");
		 
		if(!$this->common_model->check_string_date($start_date) || !$this->common_model->check_string_date($end_date)){
			echo "输入错误";
			return;
		}
		
		
		$start_timestamp = strtotime($start_date);
		$end_timestamp = strtotime($end_date);
		$this->load->model('channel_detail_model');
		$result = $this->channel_detail_model->get_channel_charge_info($start_date,$end_date);
		
		$this->show(array(
			"result" => $result,
			"start_date" => $start_date,
			"end_date" => $end_date,
		));
	}
	
	public function _getParam($param){
		$this->load->model("common_model");
		return $this->common_model->deprefix($param);
	}
}
?>