<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'common_func.php';
class Award_Detail extends CI_Controller {
	var $CURRENT_PAGE = LG_AWARD_TYPE;
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
				
		$data["pet_id"] = isset($params["pet_id"]) ? $params["pet_id"]:0;
		$data["goods_id"] = isset($params["goods_id"]) ? $params["goods_id"]:0;
		$data["pet_name"] = isset($params["pet_name"]) ? $params["pet_name"]:"";
		$data["goods_name"] = isset($params["goods_name"]) ? $params["goods_name"]:"";
		$data["out_put"] = isset($params["out_put"]) ? $params["out_put"]:"";
		$this->load->model('award_detail_model');
		
		$data["type"] = $this->award_detail_model->get_type();
		$data["cur_type"] = isset($params["cur_type"]) ? $params["cur_type"]:1;
		$data["other_type"] = $this->award_detail_model->get_other_type(isset($params["cur_type"]) ? $params["cur_type"]:0);
		
		$this->load->view("templates/header", $data);
		$this->load->view("award_detail/award_detail_show", $data);
		$this->load->view("templates/footer");
	}
	
	public function execute_pet_name_select_id($area_id, $pet_name, $out_put,$cur_type){
		$area_id = urldecode($this->_getParam($area_id));
		$pet_name = urldecode($this->_getParam($pet_name));
		$out_put = urldecode($this->_getParam($out_put));
		$out_put = str_replace("_", ",", $out_put);
		$cur_type = urldecode($this->_getParam($cur_type));
		$this->load->model("award_detail_model");
		$id = 0;
		$relust = $this->award_detail_model->pet_name_select_id($area_id, $pet_name);
		if(!$relust){
			$trs_name = FanJianConvert::tradition2simple($pet_name);
			$relust = $this->award_detail_model->pet_name_select_id($area_id, $trs_name);
			if($relust){
				$id = $relust->id;
			}
		}else{
			$id = $relust->id;
		}
		
		$this->show(array(
			"pet_id" => $id,
			"pet_name" => $pet_name,
			"cur_type" => $cur_type,
			"out_put" => $out_put,
			"area_list" => $this->common_model->set_selected_flag_for_arealist($area_id,$this->common_model->get_arealist()),
		));
	}
	
	public function execute_goods_name_select_id($area_id, $goods_name, $out_put, $cur_type){
		$area_id = urldecode($this->_getParam($area_id));
		$goods_name = urldecode($this->_getParam($goods_name));
		$out_put = urldecode($this->_getParam($out_put));
		$out_put = str_replace("_", ",", $out_put);
		$cur_type = urldecode($this->_getParam($cur_type));
		$this->load->model("award_detail_model");
		$id = 0;
		$relust = $this->award_detail_model->goods_name_select_id($area_id, $goods_name);
		if(!$relust){
			$trs_name = FanJianConvert::tradition2simple($goods_name);
			$relust = $this->award_detail_model->goods_name_select_id($area_id, $trs_name);
			if($relust){
				$id = $relust->id;
			}
		}else{
			$id = $relust->id;
		}
		
		$this->show(array(
			"goods_id" => $id,
			"goods_name" => $goods_name,
			"cur_type" => $cur_type,
			"out_put" => $out_put,
			"area_list" => $this->common_model->set_selected_flag_for_arealist($area_id,$this->common_model->get_arealist()),
		));
	}
	
	public function execute_change_type_select_id($area_id, $out_put, $cur_type){
		$area_id = urldecode($this->_getParam($area_id));
		$out_put = urldecode($this->_getParam($out_put));
		$out_put = str_replace("_", ",", $out_put);
		$cur_type = urldecode($this->_getParam($cur_type));
		
		$this->show(array(
			"out_put" => $out_put,
			"cur_type" => $cur_type,
			"area_list" => $this->common_model->set_selected_flag_for_arealist($area_id,$this->common_model->get_arealist()),
		));
	}
	
	public function _getParam($param){
		$this->load->model("common_model");
		return $this->common_model->deprefix($param);
	}
}
?>