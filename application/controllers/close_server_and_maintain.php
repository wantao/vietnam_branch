<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'common_func.php';
class Close_server_and_maintain extends CI_Controller {
	var $CURRENT_PAGE = "停服维护";
	var $GM_LEVEL = "-1";
	var $LOG_DIR_NAME = "close_server_and_maintain_log";
	
	public function get_login_user_name(){
		$this->load->library('session');
		return $this->session->userdata('username');		
	}
	
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
		//$data['area_list'] = (isset($params["area_list"]) ? $params["area_list"] : $this->common_model->add_selected_key_for_arealist($this->common_model->get_arealist()));
		$data['area_list'] = (isset($params["area_list"]) ? $params["area_list"] : $this->common_model->get_arealist());
		$this->load->model('close_server_and_maintain_model');
		
		$data['server_run_status_list'] = (isset($params["server_run_status_list"]) ? $params["server_run_status_list"] : $this->close_server_and_maintain_model->get_server_run_status_list());
		$data['server_fluency_status_list'] = (isset($params["server_fluency_status_list"]) ? $params["server_fluency_status_list"] : $this->close_server_and_maintain_model->get_server_fluency_status_list());
		
		$this->load->view("templates/header", $data);
		$this->load->view("close_server_and_maintain/close_server_and_maintain_show", $data);
		$this->load->view("templates/footer");
	}
	
	public function excute_close_server_and_maintain($url, $cmd, $arg, $account, $password){
		$url = urldecode($this->getParam($url));
		$cmd = $this->getParam($cmd);
		$arg = $this->getParam($arg);
		$account = $this->getParam($account);
		$password = $this->getParam($password);
		
		$url_with_param = sprintf("%s/?type=gm&account=%s&psw=%s&cmd=%s+%s",$url, $account, $password, $cmd, $arg);
		//初始化
		$ch = curl_init();
		//设置选项，包括URL
		//curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:20000/?type=gm&account=test1&cmd=reload+py_cpp");
		curl_setopt($ch, CURLOPT_URL, $url_with_param);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		
		//执行并获取HTML文档内容
		$output = curl_exec($ch);
		
		//释放curl句柄
		curl_close($ch);
		
		//打印获得的数据
		print_r($output);
		$this->load->model("common_model");
		$this->common_model->writeLog("login account:".$this->get_login_user_name()." excute_close_server_and_maintain!!!",$this->LOG_DIR_NAME);
	}
	
	public function excute_set_servers_run_status($server_ids,$run_status,$account, $password) {
		$server_ids = $this->getParam(urldecode($server_ids));
		$run_status = $this->getParam(urldecode($run_status));
		$account = $this->getParam($account);
		$password = $this->getParam($password);
		
		/*$password = md5($password);
		$this->load->model('login_model');
		$result = $this->login_model->get_account($account, $password);
		if(count($result) == 0){
			echo "account or password error";
			return;	
		}*/
		
		$this->load->model('close_server_and_maintain_model');
		if (!$this->close_server_and_maintain_model->set_servers_run_status($server_ids,$run_status)) {
			echo "set_servers_run_status failure";
			return;
		}
		echo "set_servers_run_status success";
		$this->load->model("common_model");
		$this->common_model->writeLog("login account:".$this->get_login_user_name()." excute_set_servers_run_status run_status:".$run_status,$this->LOG_DIR_NAME);
	}
	
	public function excute_set_servers_fluency_status($server_ids,$fluency_status,$account, $password) {
		$server_ids = $this->getParam(urldecode($server_ids));
		$fluency_status = $this->getParam(urldecode($fluency_status));
		$account = $this->getParam($account);
		$password = $this->getParam($password);
		
		/*$password = md5($password);
		$this->load->model('login_model');
		$result = $this->login_model->get_account($account, $password);
		if(count($result) == 0){
			echo "account or password error";
			return;	
		}*/
		
		$this->load->model('close_server_and_maintain_model');
		if (!$this->close_server_and_maintain_model->set_servers_fluency_status($server_ids,$fluency_status)) {
			echo "set_servers_fluency_status failure";
			return;
		}
		echo "set_servers_fluency_status success";
		$this->load->model("common_model");
		$this->common_model->writeLog("login account:".$this->get_login_user_name()." excute_set_servers_fluency_status,fluency_status:".$fluency_status,$this->LOG_DIR_NAME);
	}
	
	private function getParam($param)
	{
		 return substr($param, 1, strlen($param) - 2);
	}
}
?>