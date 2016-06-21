<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'common_func.php';
class System_activity extends CI_Controller{
	var $CURRENT_PAGE = "LG_SYSTEM_ACTIVITY";
	var $GM_LEVEL = "-1";
	var $LOG_DIR_NAME = "change_active_log";
	var $INPUT_LOG_DIR_NAME = "input_active_log";
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
		$data['area_list'] = (isset($params["area_list"]) ? $params["area_list"] : $this->common_model->add_selected_key_for_arealist($this->common_model->get_arealist()));
		$data["area_id"] = isset($params["area_id"]) ? $params["area_id"]:0;
		$data["execut_msg"] = isset($params["execut_msg"]) ? $params["execut_msg"]:'';
	
		$data["cur_type"] = isset($params["cur_type"]) ? $params["cur_type"]:1;
		$cur_area_id = $data["area_id"];
		if ($cur_area_id < 1){
			foreach($data['area_list'] as $area){
				$cur_area_id = $area['id'];
				break;
			}
		}
		
		$this->load->model("system_activity_model"); 
		$data['type_list'] = (isset($params["type_list"]) ? $params["type_list"] : $this->system_activity_model->get_types_system_activity_info($cur_area_id));
		
		$this->load->view("templates/header", $data);
		$this->load->view("system_activity/system_activity_show", $data);
		$this->load->view("templates/footer");
	}
	
	public function execute($area_id, $type){
		$area_id = $this->_getParam($area_id);
		$type = $this->_getParam($type);
		$this->load->model("system_activity_model");
		$info = $this->system_activity_model->get_system_activity_info($area_id, $type);
		
		$property_names = $this->system_activity_model->get_system_activity_property_names();
		$data['property_name'] = $property_names;
		$data['info'] = $info;
		$data['area_id'] = $area_id;
		$data['type'] = $type;
		$this->load->view("system_activity/system_activity_info_result", $data);
	}
	
	public function execute_take_effect($area_id, $type){
		$area_id = $this->_getParam($area_id);
		$type = $this->_getParam($type);
		$this->load->model("system_activity_model");
		$info = $this->system_activity_model->execute_active_take_effect($area_id);
		$msg = 'execute success';
		if (!$info){
			$msg = 'execute fail';	
		}
		$this->show(array(
			"area_id" => 0,
			"cur_type" => $type,
			"execut_msg" => $msg,
		));
		$this->ntf_server($area_id);
		$this->load->model("common_model");
		$this->common_model->writeLog("login account:".$this->get_login_user_name()." excute_change active!!!",$this->LOG_DIR_NAME);
	}
	
	public function show_edit_model($area_id, $id){
		$area_id = $this->_getParam($area_id);
		$id = $this->_getParam($id);
		$this->load->model("system_activity_model");
		$info = $this->system_activity_model->get_one_system_activity_info($area_id, $id);
		if(!$info){
			echo "show_edit_model error.";
			return;
		}
		foreach($info as $row){
			$data['id'] = $row->id;
			$data['type'] = $row->type;
			$data['begin_time'] = $row->begin_time;
			$data['end_time'] = $row->end_time;
			$data['get_award_time'] = $row->get_award_time;
			$data['name'] = $row->name;
			$data['desc'] = $row->desc;
			$data['award'] = $row->award;
			$data['value'] = $row->value;
			$data['is_open'] = $row->is_open;
			if (9 == $row->type) {
				$data['inventory'] = $info['inventory'];
				$data['today_limit_buy_count'] = $info['today_limit_buy_count'];
				$data['today_bought_count'] = $info['today_bought_count'];	
			}
			break;
		}
		$data["states"] = $this->system_activity_model->get_state();

		$this->show(array(
			"area_id" => $area_id,
			"cur_type" => $data['type'],
		));
		$this->load->view("system_activity/system_activity_opt_edit", $data);
	}
	
	public function execute_edit($area_id, $id, $type, $begin_time, $end_time, $get_award_time, $name, $desc, $award, $value, $is_open,$inventory=0,$today_limit_buy_count=0){
		$area_id = $this->_getParam($area_id);
		$id = $this->_getParam($id);
		$type = $this->_getParam($type);
		$begin_time = urldecode($this->_getParam($begin_time));
		$end_time = urldecode($this->_getParam($end_time));
		$get_award_time = urldecode($this->_getParam($get_award_time));
		$name = urldecode($this->_getParam($name));
		$desc = urldecode($this->_getParam($desc));
		$desc = str_replace("_", "/", $desc);
		$award = urldecode($this->_getParam($award));
		$value = urldecode($this->_getParam($value));
		$value = str_replace("%", ",", $value);
		$award = str_replace("_", ",", $award);
		$name = str_replace("_", ",", $name);
		$is_open = $this->_getParam($is_open);
		$inventory = $this->_getParam($inventory);
		$today_limit_buy_count = $this->_getParam($today_limit_buy_count);
		
		if (strlen($name) > 1024 || strlen($desc) > 1024 || strlen($award) > 1024 || strlen($value) > 512){
			echo "content size too long";
			return;
		} 
		
		$start_date_time_param = explode(" ", $begin_time);
		$end_date_time_param = explode(" ", $end_time);
		$get_award_date_time_param = explode(" ", $get_award_time);
		
		if(!$this->common_model->check_string_date($start_date_time_param[0]) || !$this->common_model->check_string_time($start_date_time_param[1]) ||
			!$this->common_model->check_string_date($end_date_time_param[0]) || !$this->common_model->check_string_time($end_date_time_param[1]) ||
			!$this->common_model->check_string_date($get_award_date_time_param[0]) || !$this->common_model->check_string_time($get_award_date_time_param[1])){
			echo "time is wrong";
			return;
		}
		
		$this->load->model("system_activity_model");
		$info = $this->system_activity_model->edit_one_system_activity_active($area_id, $id, $type, $begin_time, $end_time, $get_award_time, $name, $desc, $award, $value, $is_open,$inventory,$today_limit_buy_count);
		if(!$info){
			echo "edit_one_system_activity_active error.";
			return;
		}
		$this->show(array(
			"area_id" => $area_id,
			"cur_type" => $type,
		));
		$this->load->model("common_model");
		$str = $area_id.$id.$begin_time.$end_time.$get_award_time.$name.$begin_time.$desc.$award.$begin_time.$value.$is_open;
		$this->common_model->writeLog("login account:".$this->get_login_user_name()." excute_change active!!!".$str,$this->LOG_DIR_NAME);
	}
	
	public function execute_change_select_id($area_id){
		$this->load->model("system_activity_model"); 
		$type_list = $this->system_activity_model->get_types_system_activity_info($area_id);
		
		$this->show(array(
			"area_id" => $area_id,
			"cur_type" => 0,
			"type_list" => $type_list,
		));
	}
	
	public function execute_input_file($area_id){
		$msg = 'input file success';
		if ($_FILES["up_file"]["size"] > 1024*200 || $_FILES["up_file"]["size"] < 1){
			$msg = "Invalid file";
		}else if($_FILES["up_file"]["error"] > 0){
			$msg = "input file fail Return Code: " . $_FILES["up_file"]["error"];
		}else if(strtolower(end(explode('.',$_FILES["up_file"]['name']))) != "sql"){
			$msg = "wrong file name: " . $_FILES["up_file"]["name"];
		}else if(!file_exists($this->INPUT_LOG_DIR_NAME) && !mkdir($this->INPUT_LOG_DIR_NAME)){
			$msg = $this->INPUT_LOG_DIR_NAME."is not exist";
		}else{
			$new_name = $this->INPUT_LOG_DIR_NAME."/".$area_id."_c_system_activity_copy_new.sql";
			if(!move_uploaded_file($_FILES["up_file"]["tmp_name"], $new_name)){
				$msg = "move_uploaded_file fail";
			}else {
				#上传文件成功之后，再备份原来的sql语句
				$this->load->model("system_activity_model");
				$sql_data_array = $this->system_activity_model->get_copy_system_activity_sql_data($area_id);
				$old_filename = $this->INPUT_LOG_DIR_NAME."/".$area_id."_c_system_activity_copy_old.sql";
				$fh_old = fopen($old_filename, "w");
				if ($fh_old){
					foreach($sql_data_array as $line){
						fwrite($fh_old, $line);
					}
					
					$array_sql = array();
					$a = file($new_name);
					$wrong_sql = false;
   					foreach($a as $line => $content){
   						$array_sql[] = $content;
   						if(stripos($content, "delete")!==false){
   							$msg = "sql file has wrong sql";
   							$wrong_sql = true;
   							break;
   						}
    				}
    				
    				if (!$wrong_sql){
    				    $execute_sql_data = $this->system_activity_model->execute_new_system_activity_sql_data($area_id, $array_sql);
						if(!$execute_sql_data){
							$msg = "execute new sql file fail";	
						}
    				}
				}else{
					$msg = "back old file fail";
		        }
				fclose($fh_old);	
			}
	  	}

		$this->show(array(
			"area_id" => $area_id,
			"cur_type" => 0,
			"execut_msg" => $msg,
		));
	}
	
	public function execute_output_file($area_id){
		$this->load->model("system_activity_model"); 
		$sql_data_array = $this->system_activity_model->get_copy_system_activity_sql_data($area_id);
		$filename = "c_system_activity_copy.sql";
		$fh = fopen($filename, "w");
		if ($fh){
			foreach($sql_data_array as $line){
				fwrite($fh, $line);
			}
			
			Header("Content-type: application/octet-stream"); 
            Header("Content-Ranges: bytes"); 
			Header("Content-Length:".filesize($filename)); 
            header("Content-Disposition: attachment; filename=".$filename);
            readfile($filename);
		}else{
            echo "doload file fail"; 
        }
		fclose($fh);
		
		$this->show(array(
			"area_id" => $area_id,
			"cur_type" => 0,
		));
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
		$curl_param = sprintf("%s/?type=gm&account=test1&cmd=reload_system_activity", $url);
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