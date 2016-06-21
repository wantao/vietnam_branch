<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'common_func.php';
class Cdkey extends CI_Controller{
	var $CURRENT_PAGE = "cdkey活动";
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
		$this->load->view("cdkey/cdkey_show", $data);
		$this->load->view("templates/footer");
	}
	public function execute(){
		$this->load->model("cdkey_model");
		$info = $this->cdkey_model->get_cdkey_info();

		$property_names = $this->cdkey_model->get_cdkey_property_names();
		$data['property_name'] = $property_names;
		$data['info'] = $info;
		$this->load->view("cdkey/cdkey_info_result", $data);
	}
	public function execute_delete($id){
		$this->load->model("cdkey_model");
		$info = $this->cdkey_model->delete_one_cdkey_active($id);
		if(!$info){
			echo "Playername error.";
			return;
		}
		$this->show();
		$this->ntf_server();
	}
	
	public function show_add_model(){
		$date_time = date('Y-m-d H:i:s',time());
		
		$data['begin_time'] = (isset($params["begin_time"]) ? $params["begin_time"] : $date_time);
		$data['end_time'] = (isset($params["end_time"]) ? $params["end_time"] : $date_time);
		
		$this->show();
		$this->load->view("cdkey/cdkey_opt_add", $data);
	}
	
	public function show_edit_model($id){
		$this->load->model("cdkey_model");
		$info = $this->cdkey_model->get_one_cdkey_info($id);
		if(!$info){
			echo "show_edit_model error.";
			return;
		}
		foreach($info as $row){
			$data['id'] = $row->id;
			$data['area_no'] = $row->area_no;
			$data['title'] = $row->title;
			$data['desc'] = $row->desc;
			$data['bn_url'] = $row->bn_url;
			$data['begin_time'] = $row->begin_time;
			$data['end_time'] = $row->end_time;
			$data['level'] = $row->level;
			$data['award'] = $row->award;
			break;
		}
		$this->show();
		$this->load->view("cdkey/cdkey_opt_edit", $data);
	}
	
	public function execute_add($area_no, $title, $desc, $bn_url, $begin_time, $end_time, $level, $award){
		$area_no = urldecode($this->_getParam($area_no));
		$title = urldecode($this->_getParam($title));
		$desc = urldecode($this->_getParam($desc));
		$bn_url = urldecode($this->_getParam($bn_url));
		$begin_time = urldecode($this->_getParam($begin_time));
		$end_time = urldecode($this->_getParam($end_time));
		$level = $this->_getParam($level);
		$award = urldecode($this->_getParam($award));
		$area_no = str_replace("_", ",", $area_no);
		$bn_url = str_replace("_", "/", $bn_url);
		$award = str_replace("_", ",", $award);
		
		if (!is_numeric($level)) {
			echo "wrong level";
			return;	
		}
		
		$area_no_param = explode(",", $area_no);
		foreach($area_no_param as $param){
			if (strlen($param) > 0 && !is_numeric($param)) {
				echo "wrong area_no";
				return;	
			}
		}
		
		if (strlen($award) < 9 || substr_count($award, '{')<1 || substr_count($award, '}')<1 || substr_count($award, ':')<3 ){
			echo "wrong award format, must use like 1:{2:0:100}-2:{2:0:100}-";
			return;	
		}
		if (strlen($area_no) > 1024 || strlen($title) > 128 || strlen($desc) > 1024 || strlen($bn_url) > 512 || strlen($award) > 512) {
			echo "lenth is too long";
			return;	
		}
		
		$start_date_time_param = explode(" ", $begin_time);
		$end_date_time_param = explode(" ", $end_time);
		
		if(!$this->common_model->check_string_date($start_date_time_param[0]) || !$this->common_model->check_string_time($start_date_time_param[1]) ||
			!$this->common_model->check_string_date($end_date_time_param[0]) || !$this->common_model->check_string_time($end_date_time_param[1])){
			echo "time is wrong";
			return;
		}
		
		$this->load->model("cdkey_model");
		$info = $this->cdkey_model->add_one_cdkey_active($area_no, $title, $desc, $bn_url, $begin_time, $end_time, $level, $award);
		if(!$info){
			echo "add_one_cdkey_active error.";
			return;
		}
		$this->show();
		$this->ntf_server();
	}
	
	public function execute_edit($id, $area_no, $title, $desc, $bn_url, $begin_time, $end_time, $level, $award){
		$id = $this->_getParam($id);
		$area_no = urldecode($this->_getParam($area_no));
		$title = urldecode($this->_getParam($title));
		$desc = urldecode($this->_getParam($desc));
		$bn_url = urldecode($this->_getParam($bn_url));
		$begin_time = urldecode($this->_getParam($begin_time));
		$end_time = urldecode($this->_getParam($end_time));
		$level = $this->_getParam($level);
		$award = urldecode($this->_getParam($award));
		$area_no = str_replace("_", ",", $area_no);
		$bn_url = str_replace("_", "/", $bn_url);
		$award = str_replace("_", ",", $award);
		$desc = str_replace("_", "/", $desc);
		
		if (!is_numeric($level)) {
			echo "wrong level";
			return;	
		}
		
		$area_no_param = explode(",", $area_no);
		foreach($area_no_param as $param){
			if (strlen($param) > 0 && !is_numeric($param)) {
				echo "wrong area_no";
				return;	
			}
		}
		
		if (strlen($award) < 9 || substr_count($award, '{')<1 || substr_count($award, '}')<1 || substr_count($award, ':')<3 ){
			echo "wrong award format, must use like 1:{2:0:100}-2:{2:0:100}-";
			return;	
		}
		
		if (strlen($area_no) > 1024 || strlen($title) > 128 || strlen($desc) > 1024 || strlen($bn_url) > 512 || strlen($award) > 512) {
			echo "lenth is too long";
			return;	
		}
		
		$start_date_time_param = explode(" ", $begin_time);
		$end_date_time_param = explode(" ", $end_time);
		
		if(!$this->common_model->check_string_date($start_date_time_param[0]) || !$this->common_model->check_string_time($start_date_time_param[1]) ||
			!$this->common_model->check_string_date($end_date_time_param[0]) || !$this->common_model->check_string_time($end_date_time_param[1])){
			echo "time is wrong";
			return;
		}
		
		$this->load->model("cdkey_model");
		$info = $this->cdkey_model->edit_one_cdkey_active($id, $area_no, $title, $desc, $bn_url, $begin_time, $end_time, $level, $award);
		if(!$info){
			echo "Playername error.";
			return;
		}
		$this->show();
		$this->ntf_server();
	}
	
	public function _getParam($param){
		$this->load->model("common_model");
		return $this->common_model->deprefix($param);
	}
	
	public function ntf_server(){
		$this->load->model('common_model');
		$server_list = $this->common_model->get_arealist();
		foreach($server_list as $server_info){
			$url = $server_info->url;
			$length = strlen($url);
			while($url{$length - 1} == '/'){
				$length --;
				$url = substr($url, 0, $length);
			}
			$url = sprintf("%s:%d", $url, $server_info->port);
			$this->curl_send($url);
		}
	}
	
	public function curl_send($url) {
		//初始化
		$ch = curl_init();
		$curl_param = sprintf("%s/?type=gm&account=test1&cmd=reload_cdkey_active", $url);
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