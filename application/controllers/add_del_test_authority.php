<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'common_func.php';
class Add_del_test_authority extends CI_Controller {
	var $CURRENT_PAGE = LG_ADD_DEL_TEST_AUTHORITY;
	var $GM_LEVEL = "-1";
	public function show($result = array()){
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

		$data["result"] = (isset($result["result"]) ? $result["result"] : array());
		
		$this->load->view("templates/header", $data);
		$this->load->view("add_del_test_authority/add_del_test_authority_show", $data);
		$this->load->view("templates/footer");
	}
	public function execute($account,$type){
		$this->load->model("common_model");
		$account = urldecode($account);
		$ret_str = "";
		$this->load->model("add_del_test_authority_model");
		if (0 == $type) {
			if ($this->add_del_test_authority_model->add_test_authority($account)) {
				$ret_str="add test authority success";	
			} else {
				$ret_str="add test authority failure";
			}
		} else if (1 == $type) {
			if ($this->add_del_test_authority_model->del_test_authority($account)) {
				$ret_str="del test authority success";	
			} else {
				$ret_str="del test authority failure";
			}	
		} else if (2 == $type) {
			if ($this->add_del_test_authority_model->del_all_test_authority($account)) {
				$ret_str="del all test authority success";	
			} else {
				$ret_str="del all test authority failure";
			}	
		}
		$data['result'] = $ret_str;
		$this->load->view("add_del_test_authority/add_del_test_authority_result", $data);
	}
}
?>