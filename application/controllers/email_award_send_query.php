<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'common_func.php';
class Email_award_send_query extends CI_Controller{
	var $CURRENT_PAGE = "玩家id查询";
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
		$this->load->model('common_model');
		$data['server_list'] = $this->common_model->get_arealist();
		
		$this->load->view("templates/header", $data);
		$this->load->view("email_award_send_query/email_award_send_query_show", $data);
		$this->load->view("templates/footer");
	}
	public function execute($player_id,$server){
		if (!is_numeric($player_id) || !is_numeric($server)) {
			return;	
		}
		$this->load->model("email_award_send_query_model");
		$result = $this->email_award_send_query_model->search($player_id,$server);
		if (!$result) {
			echo "not find any award send record for this player id in this area";
			return;	
		}
		$data['result'] = $result;
		$this->load->view("email_award_send_query/email_award_send_query_result", $data);
		return;
	}
}
?>