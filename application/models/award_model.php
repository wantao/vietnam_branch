<?php 
class Award_model extends CI_Model {
	var $gm_tool_str="gm_tool";
	var $err_success = 0;//成功
	var $err_not_set_server_name = -1;//没有设置服务器名字
	var $err_not_set_award_send_condition_type = -2;//没有设置奖励发送类型
	var $err_not_set_award_send_condition = -3;//没有设置奖励发送条件
	var $err_not_set_msg_award_type = -4;//没有设置邮件奖励类型
	var $err_not_set_msg_award_title = -5;//没有设置邮件奖励主题
	var $err_not_set_msg_award_content = -6;//没有设置邮件奖励消息内容
	var $err_not_set_msg_award = -7;//没有设置邮件奖励
	var $err_not_set_sign = -8;//没有设置签名
	var $err_sign_false = -9;//签名不对
	var $err_not_find_server_name = -10;//没有找到该服务器名
	var $err_award_formate_is_error = -11;//奖励格式错误
	var $err_not_find_player_id = -12;//未找到该玩家id
	var $err_player_id_has_illegal_characters = -13;//玩家id存在非法字符
	var $err_player_level_has_illegal_characters = -14;//玩家等级存在非法字符
	var $err_among_player_ids_foramte_is_error = -15;//玩家id之间格式错误
	var $err_not_write_player_id = -16;//没有填写玩家id
	
	public function __construct(){
		parent::__construct();
	}
	
	public function is_requst_legal($request_arry) {
		if (!isset($request_arry['server_name'])) {
			return $this->err_not_set_server_name;	
		}
		if (!isset($request_arry['condition_type'])) {
			return $this->err_not_set_award_send_condition_type;	
		}
		if (!isset($request_arry['condition'])) {
			return $this->err_not_set_award_send_condition;	
		}
		if (!isset($request_arry['msg_type'])) {
			return $this->err_not_set_msg_award_type;	
		}
		if (!isset($request_arry['msg_title'])) {
			return $this->err_not_set_msg_award_title;	
		}
		if (!isset($request_arry['msg_content'])) {
			return $this->err_not_set_msg_award_content;	
		}
		if (!isset($request_arry['award'])) {
			return $this->err_not_set_msg_award;	
		}
		if (!isset($request_arry['sign'])) {
			return $this->err_not_set_sign;	
		}	
		return $this->err_success;
	}
	
	public function get_err_desc($err_code) {
		if ($this->err_success == $err_code) {
			return "success";//成功	
		}	
		if ($this->err_not_set_server_name == $err_code) {
			return "not_set_server_name";//没有设置服务器名字	
		}
		if ($this->err_not_set_award_send_condition_type == $err_code) {
			return "not_set_award_send_condition_type";//没有设置奖励发送类型
		}
		if ($this->err_not_set_award_send_condition == $err_code) {
			return "not_set_award_send_condition";//没有设置奖励发送条件
		}
		if ($this->err_not_set_msg_award_type == $err_code) {
			return "not_set_msg_award_type";//没有设置邮件奖励类型	
		}
		if ($this->err_not_set_msg_award_title == $err_code) {
			return "not_set_msg_award_title";//没有设置邮件奖励主题
		}
		if ($this->err_not_set_msg_award_content == $err_code) {
			return "not_set_msg_award_content";//没有设置邮件奖励消息内容
		}
		if ($this->err_not_set_msg_award == $err_code) {
			return "not_set_msg_award";//没有设置邮件奖励	
		}
		if ($this->err_not_set_server_name == $err_code) {
			return "not_set_sign";//没有设置签名
		}
		if ($this->err_sign_false == $err_code) {
			return "sign_false";//签名不对
		}
		if ($this->err_not_find_server_name == $err_code) {
			return "not_find_server_name";//没有找到该服务器名
		}
		if ($this->err_award_formate_is_error == $err_code) {
			return "award_formate_is_error";//奖励格式错误	
		}
		if ($this->err_not_find_player_id == $err_code) {
			return "not_find_player_id";//未找到该玩家id	
		}
		if ($this->err_player_id_has_illegal_characters == $err_code) {
			return "player_id_has_illegal_characters";//玩家id存在非法字符
		}
		if ($this->err_player_level_has_illegal_characters == $err_code) {
			return "player_level_has_illegal_characters";//玩家等级存在非法字符	
		}
		if ($this->err_among_player_ids_foramte_is_error == $err_code) {
			return "among_player_ids_foramte_is_error";//玩家id之间格式错误	
		}
		if ($this->err_not_write_player_id == $err_code) {
			return "not_write_player_id";//没有填写玩家id
		}
		return "unkonw_err_desc";//未知错误描述
	}
	
	public function writeLog($msg){
		$log_dir = "award_log";
		if (!file_exists($log_dir) && !mkdir($log_dir)){
			$err_logFile = 'error-'.date('Y-m-d').'.log';
 			$msg = date('H:i:s').': '.' mkdir '."$log_dir"." error"."\r\n";
 			file_put_contents($logFile,$msg,FILE_APPEND);	

 			$logFile = 'award-'.date('Y-m-d').'.log';
 			$msg = date('H:i:s').': '.$msg."\r\n";
 			file_put_contents($logFile,$msg,FILE_APPEND);
 			return;
		}
 		$logFile = "$log_dir".'/award-'.date('Y-m-d').'.log';
 		$msg = date('H:i:s').': '.$msg."\r\n";
 		file_put_contents($logFile,$msg,FILE_APPEND);
	}
	
	public function  make_return_err_code_and_des($err_code,$err_desc) {
		$result_ret = array();
		$result_ret["err_code"]=$err_code;
		$result_ret["err_desc"]=$err_desc;
		$Res = json_encode($result_ret);
		print_r(urldecode($Res));	
	}
	
	public function make_curl_param($type,$condition,$area) {
		$this->load->model('main_model');
		$server_url = $this->main_model->get_server_url_by_areaid($area);
		if (!$server_url) {
			echo "<br>"."get server_url failure"."<br>";
			return NULL;	
		}
		$url_with_param = sprintf("%s/?type=$type&condition=$condition",$server_url);	
		return $url_with_param;
	}
	
	public function curl_send($curl_param) {
		if (NULL == $curl_param) {
			return;	
		}
		//初始化
		$ch = curl_init();
		//设置选项，包括URL
		//curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:20000/?type=gm&account=test1&cmd=reload+py_cpp");
		curl_setopt($ch, CURLOPT_URL, $curl_param);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		
		//执行并获取HTML文档内容
		$output = curl_exec($ch);
		echo $output;
		//释放curl句柄
		curl_close($ch);	
	}
	
	public function send_msg_to_gameserver($type,$condition,$area) {
		$this->curl_send($this->make_curl_param($type,$condition,$area));			
	}
	
	public function is_exists_digitid($digitid,$area) {
		$db = $this->load->database($area . "_game_db",true);
		$sql = "select * from `player_base` where digitid = $digitid;";
		$query_result = $db->query($sql);
		$result = $query_result->result();
		if (0 >= count($result)) {
			$this->make_return_err_code_and_des($this->err_not_find_player_id,$this->get_err_desc($this->err_not_find_player_id));
			$db->close();
			return false;	
		}
		$db->close();
		return true;	
	}

	public function is_digit_id_legal($digitid) {
		if(preg_match('/^\d+$/i',$digitid)) {
			return true;		
		}
		$this->make_return_err_code_and_des($this->err_player_id_has_illegal_characters,$this->get_err_desc($this->err_player_id_has_illegal_characters));
		return false;
	}
	
	public function is_level_legal($level) {
		if(preg_match('/^\d+$/i',$level)) {
			return true;		
		}
		$this->make_return_err_code_and_des($this->err_player_level_has_illegal_characters,$this->get_err_desc($this->err_player_level_has_illegal_characters));
		return false;
	}
	
	public function insert_one($digitid, $msg_type, $msg_title, $msg_content, $award, $area){
		if (!$this->is_digit_id_legal($digitid)) {
			return false;	
		}
		if (!$this->is_exists_digitid($digitid,$area)) {
			return false;	
		}
		$this->load->library('session');	
		$msg_title = urldecode($msg_title);
		$msg_content = urldecode($msg_content);
		$this->load->database($area."_game_db_m");
		$this->db->trans_begin();
		$this->db->insert('player_sysmsg', array(
			"msg_type" => $msg_type,
			"digitid" => $digitid,
			"send_name" => $this->gm_tool_str,
			"title" => $msg_title,
			"content" => $msg_content,
			"award" => $award
		));
		$this->db->insert('player_sysmsg_gm_tool', array(
			"msg_type" => $msg_type,
			"digitid" => $digitid,
			"send_name" => $this->gm_tool_str,
			"title" => $msg_title,
			"content" => $msg_content,
			"award" => $award,
			"execute_account" => $this->session->userdata('username'),
			"execute_ip" => $this->session->userdata('ip_address')
		));
		$this->db->insert('gm_tool_award_send_record', array(
			"execute_account" => $this->session->userdata('username'),
			"execute_ip" => $this->session->userdata('ip_address'),
			"msg_type" => $msg_type,
			"recieve_type" => 0,
			"reciever" => $digitid,
			"title" => $msg_title,
			"content" => $msg_content,
			"award" => $award
		));
		
		if ($this->db->trans_status() === FALSE){	
    		$this->db->trans_rollback();
    		$this->db->close();
			return false;
		} 
    	$this->db->trans_commit();
    	$this->writeLog("server_area:".$area." digitid:".$digitid.
			" msg_type:".$msg_type." msg_title:".$msg_title." msg_content:".$msg_content." award:".$award);
			//通知gs
		$this->send_msg_to_gameserver("to_one",$digitid,$area);

		$this->db->close();
		
		return true;
	}
	
	public function is_exsits_digitid_list($digitid_list,$area){
		$digitid_count = count($digitid_list);
		if (0 >= $digitid_count) {
			return false;		
		}
		$db = $this->load->database($area . "_game_db",true);
		$sql = "select digitid from `player_base` where digitid in (";
		$i = 1;
		foreach($digitid_list as $digitid) {
			if (!$this->is_digit_id_legal($digitid)) {
				$db->close();
				return false;	
			}
			if (1 == $digitid_count || $i == $digitid_count) {
				$sql .= $digitid.")";	
			} else {
				$sql .= $digitid.",";
			}	
			$i += 1;
		}
		$query_result = $db->query($sql);
		$result = $query_result->result();
		if (0 >= count($result)) {
			$this->make_return_err_code_and_des($this->err_not_find_player_id,$this->get_err_desc($this->err_not_find_player_id));
			$db->close();
			return false;	
		}
		$ret_flag = true;
		foreach($digitid_list as $digitid) {
			$is_find = false;
			foreach ($result as $row) {
				if ($digitid == $row->digitid) {
					$is_find = true;	
				}	
			} 
			if (!$is_find) {
				$this->make_return_err_code_and_des($this->err_not_find_player_id,$this->get_err_desc($this->err_not_find_player_id));	
				$ret_flag = false;
			}
		}
		$db->close();
		return $ret_flag;	
	}
	
	public function insert_range($digitids, $msg_type, $msg_title, $msg_content, $award, $area){
		$digitid_list = explode(":", $digitids);
		if(!$digitid_list){
			$this->make_return_err_code_and_des($this->err_among_player_ids_foramte_is_error,$this->get_err_desc($this->err_among_player_ids_foramte_is_error));
			return false;
		}
		$digitid_count = count($digitid_list);
		if (count($digitid_list) <= 0) {
			$this->make_return_err_code_and_des($this->err_not_write_player_id,$this->get_err_desc($this->err_not_write_player_id));	
			return false;	
		}
		if (!$this->is_exsits_digitid_list($digitid_list,$area)) {
			//echo "<br>"."send failure"."<br>";
			return false;	
		}
		$msg_title = urldecode($msg_title);
		$msg_content = urldecode($msg_content);
		
		$this->load->database($area . "_game_db_m");
		$sql = "insert into `player_sysmsg` (`msg_type`,`digitid`,`send_name`,`title`,`content`,`award`) values ";
		$i = 1;
		$digitid_list_tmp = $digitid_list;
		foreach($digitid_list as $digitid) {
			if ($digitid_count == 1 || $i == $digitid_count) {
				$sql .= "('$msg_type', '$digitid', '$this->gm_tool_str', ".$this->db->escape($msg_title).", ".$this->db->escape($msg_content).", ".$this->db->escape($award).")";	
			} else {
				$sql .= "('$msg_type', '$digitid', '$this->gm_tool_str', ".$this->db->escape($msg_title).", ".$this->db->escape($msg_content).", ".$this->db->escape($award)."),";
			}	
			$i += 1;
		}
		$sql_gm_tool = "insert into `player_sysmsg_gm_tool` (`msg_type`,`digitid`,`send_name`,`title`,`content`,`award`,`execute_account`,`execute_ip`) values ";
		$i = 1;
		$this->load->library('session');
		$execute_account = $this->session->userdata('username');
		$execute_ip = $this->session->userdata('ip_address');
		foreach($digitid_list_tmp as $digitid) {
			if ($digitid_count == 1 || $i == $digitid_count) {
				$sql_gm_tool .= "('$msg_type', '$digitid', '$this->gm_tool_str', ".$this->db->escape($msg_title).", ".$this->db->escape($msg_content).", ".$this->db->escape($award).", ".$this->db->escape($execute_account).", ".$this->db->escape($execute_ip).")";	
			} else {
				$sql_gm_tool .= "('$msg_type', '$digitid', '$this->gm_tool_str', ".$this->db->escape($msg_title).", ".$this->db->escape($msg_content).", ".$this->db->escape($award).", ".$this->db->escape($execute_account).", ".$this->db->escape($execute_ip)."),";
			}	
			$i += 1;
		}
		
		//$query = "select `account`, `playername` from `player_base` where `digitid` in (select `digitid` from player_exp where `level` >= $range)";
		$this->db->trans_begin();
		$this->db->query($sql);
		$this->db->query($sql_gm_tool);
		$this->db->insert('gm_tool_award_send_record', array(
			"execute_account" => $execute_account,
			"execute_ip" => $execute_ip,
			"msg_type" => $msg_type,
			"recieve_type" => 1,
			"reciever" => $digitids,
			"title" => $msg_title,
			"content" => $msg_content,
			"award" => $award
		));
		if ($this->db->trans_status() === FALSE){	
    		$this->db->trans_rollback();
    		$this->db->close();
			return false;
		} 
    	$this->db->trans_commit();
		$this->writeLog("server_area:".$area." digitids:".$digitids.
			" msg_type:".$msg_type." msg_title:".$msg_title." msg_content:".$msg_content." award:".$award);
			//通知gs
		$this->send_msg_to_gameserver("to_more",$digitids,$area);
		$this->db->close();
		return true;
	}
	
	public function insert_by_player_min_level($min_level, $msg_type, $msg_title, $msg_content, $award, $area){
		if (!$this->is_level_legal($min_level)) {
			//$this->make_return_err_code_and_des($this->err_player_level_has_illegal_characters,$this->get_err_desc($this->err_player_level_has_illegal_characters));
			return false;	
		}
		if ($min_level < 0) {
			$this->make_return_err_code_and_des($this->err_player_level_has_illegal_characters,$this->get_err_desc($this->err_player_level_has_illegal_characters));
			return false;
		}
		$msg_title = urldecode($msg_title);
		$msg_content = urldecode($msg_content);
		$db = $this->load->database($area."_game_db_m",true);
		
		$sql = "insert into `player_sysmsg` (`digitid`,`msg_type`,`send_name`,`title`,`content`,`award`) "."
		SELECT T2.digitid, $msg_type, '$this->gm_tool_str',". $db->escape($msg_title).",". $db->escape($msg_content).",".$db->escape($award)." FROM `player_exp` AS T2 WHERE T2.`level` >= $min_level";

		$this->load->library('session');
		$execute_account = $this->session->userdata('username');
		$execute_ip = $this->session->userdata('ip_address');
		$sql_gm_tool = "insert into `player_sysmsg_gm_tool` (`digitid`,`msg_type`,`send_name`,`title`,`content`,`award`,`execute_account`,`execute_ip`) "."
		SELECT T2.digitid, $msg_type, '$this->gm_tool_str',". $db->escape($msg_title).",". $db->escape($msg_content).",".$db->escape($award).",'$execute_account','$execute_ip' FROM `player_exp` AS T2 WHERE T2.`level` >= $min_level";
	
		$db->trans_begin();
		$db->query($sql);
		if ($db->trans_status() === FALSE){	
    		$db->trans_rollback();
    		$db->close();
			return false;
		} 
		$db->query($sql_gm_tool);
		if ($db->trans_status() === FALSE){	
    		$db->trans_rollback();
    		$db->close();
			return false;
		} 
		$db->insert('gm_tool_award_send_record', array(
			"execute_account" => $execute_account,
			"execute_ip" => $execute_ip,
			"msg_type" => $msg_type,
			"recieve_type" => 2,
			"reciever" => $min_level,
			"title" => $msg_title,
			"content" => $msg_content,
			"award" => $award
		));
		if ($db->trans_status() === FALSE){	
    		$db->trans_rollback();
    		$db->close();
			return false;
		} 
    	$db->trans_commit();
		$this->writeLog("server_area:".$area." min_level:".$min_level.
			" msg_type:".$msg_type." msg_title:".$msg_title." msg_content:".$msg_content." award:".$award);
			//通知gs
		$this->send_msg_to_gameserver("min_level",$min_level,$area);
		$db->close();
		return true;
	}
	
	public function get_recent_send_record($area)
	{
		$db = $this->load->database($area."_game_db",true);	
		$sql = "select * from `gm_tool_award_send_record` order by `currenttime` desc limit 20";
		$query_result = $db->query($sql);
		if (!$query_result) {
			return false;
		}
		$result = $query_result->result();
		$db->close();
		return $result;
	}
}
?>