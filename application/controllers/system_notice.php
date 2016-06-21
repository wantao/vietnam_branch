<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'common_func.php';
class System_notice extends CI_Controller{
	var $CURRENT_PAGE = "LG_SYSTEM_NOTICE";
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
		$data["area_id"] = isset($params["area_id"]) ? $params["area_id"]:0;
		
		$this->load->view("templates/header", $data);
		$this->load->view("system_notice/system_notice_show", $data);
		$this->load->view("templates/footer");
	}
	public function execute($area_id){
		$this->load->model("system_notice_model");
		$info = $this->system_notice_model->get_system_notice_info($area_id);

		$property_names = $this->system_notice_model->get_system_notice_property_names();
		$data['property_name'] = $property_names;
		$data['info'] = $info;
		$data['area_id'] = $area_id;
		$this->load->view("system_notice/system_notice_info_result", $data);
	}
	public function execute_delete($area_id, $id){
		$area_id = urldecode($this->_getParam($area_id));
		$id = urldecode($this->_getParam($id));
		$this->load->model("system_notice_model");
		$info = $this->system_notice_model->delete_one_system_notice_active($area_id, $id);
		if(!$info){
			echo "delete error.";
			return;
		}
		$this->show(array(
			"area_id" => $area_id,
			));
		$this->ntf_server($area_id);
	}
	
	public function show_add_model($area_id){
		$date_time = date('Y-m-d H:i:s',time());
		
		$data['begin_time'] = (isset($params["begin_time"]) ? $params["begin_time"] : $date_time);
		$data['end_time'] = (isset($params["end_time"]) ? $params["end_time"] : $date_time);
		$data['area_id'] = $area_id;
		
		$this->show(array(
			"area_id" => $area_id,
		));
		$this->load->view("system_notice/system_notice_opt_add", $data);
	}
	
	public function show_edit_model($area_id, $id){
		$area_id = $this->_getParam($area_id);
		$id = $this->_getParam($id);
		$this->load->model("system_notice_model");
		$info = $this->system_notice_model->get_one_system_notice_info($area_id, $id);
		if(!$info){
			echo "show_edit_model error.";
			return;
		}
		foreach($info as $row){
			$data['area_id'] = $row->area_id;
			$data['idx'] = $row->idx;
			$data['begin_time'] = $row->begin_time;
			$data['end_time'] = $row->end_time;
			$data['frequency'] = $row->frequency;
			$data['delay_begin'] = $row->delay_begin;
			$data['content'] = $row->content;
			break;
		}
		$this->show(array(
			"area_id" => $area_id,
		));
		$this->load->view("system_notice/system_notice_opt_edit", $data);
	}
	
	public function execute_add($area_id, $idx, $begin_time, $end_time, $frequency, $delay_begin, $content){
		$area_id = $this->_getParam($area_id);
		$idx = $this->_getParam($idx);
		$begin_time = urldecode($this->_getParam($begin_time));
		$end_time = urldecode($this->_getParam($end_time));
		$frequency = $this->_getParam($frequency);
		$delay_begin = $this->_getParam($delay_begin);
		$content = urldecode($this->_getParam($content));
		$content = str_replace("_", "/", $content);
		
		if (!is_numeric($idx) || !is_numeric($frequency) || !is_numeric($delay_begin)) {
			echo "wrong param";
			return;	
		}
		
		if (strlen($content) > 1024){
			echo "content size too long";
			return;
		} 
		$start_date_time_param = explode(" ", $begin_time);
		$end_date_time_param = explode(" ", $end_time);
		
		if(!$this->common_model->check_string_date($start_date_time_param[0]) || !$this->common_model->check_string_time($start_date_time_param[1]) ||
			!$this->common_model->check_string_date($end_date_time_param[0]) || !$this->common_model->check_string_time($end_date_time_param[1])){
			echo "time is wrong";
			return;
		}
		
		$this->load->model("system_notice_model");
		$info = $this->system_notice_model->add_one_system_notice_active($area_id, $idx, $begin_time, $end_time, $frequency, $delay_begin, $content);
		if(!$info){
			echo "add_one_system_notice_active error.";
			return;
		}
		$this->show(array(
			"area_id" => $area_id,
		));
		$this->ntf_server($area_id);
	}
	
	public function execute_edit($area_id, $idx, $begin_time, $end_time, $frequency, $delay_begin, $content){
		$area_id = $this->_getParam($area_id);
		$idx = $this->_getParam($idx);
		$begin_time = urldecode($this->_getParam($begin_time));
		$end_time = urldecode($this->_getParam($end_time));
		$frequency = $this->_getParam($frequency);
		$delay_begin = $this->_getParam($delay_begin);
		$content = urldecode($this->_getParam($content));
		$content = str_replace("_", "/", $content);
		
		if (!is_numeric($idx) || !is_numeric($frequency) || !is_numeric($delay_begin)) {
			echo "wrong param";
			return;	
		}
		
		if (strlen($content) > 1024){
			echo "content size too long";
			return;
		} 
		
		$start_date_time_param = explode(" ", $begin_time);
		$end_date_time_param = explode(" ", $end_time);
		
		if(!$this->common_model->check_string_date($start_date_time_param[0]) || !$this->common_model->check_string_time($start_date_time_param[1]) ||
			!$this->common_model->check_string_date($end_date_time_param[0]) || !$this->common_model->check_string_time($end_date_time_param[1])){
			echo "time is wrong";
			return;
		}
		
		$this->load->model("system_notice_model");
		$info = $this->system_notice_model->edit_one_system_notice_active($area_id, $idx, $begin_time, $end_time, $frequency, $delay_begin, $content);
		if(!$info){
			echo "add_one_system_notice_active error.";
			return;
		}
		$this->show(array(
			"area_id" => $area_id,
		));
		$this->ntf_server($area_id);
	}
	
	public function _getParam($param){
		$this->load->model("common_model");
		return $this->common_model->deprefix($param);
	}
	
	public function ntf_server($area_id){
		$this->load->model('main_model');
		$url = $this->main_model->get_server_url_by_areaid($area_id);
		if ($url != NULL){
			$this->curl_send($url);
		}
	}
	
	public function curl_send($url) {
		//初始化
		$ch = curl_init();
		$curl_param = sprintf("%s/?type=gm&account=test1&cmd=reload_system_notice", $url);
		#echo $curl_param;
		curl_setopt($ch, CURLOPT_URL, $curl_param);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		
		//执行并获取HTML文档内容
		$output = curl_exec($ch);
		#echo $output;
		//释放curl句柄
		curl_close($ch);	
	}
}
?>