<?php 
	require_once 'database_config.php';
	require_once 'error_code.php';
	require_once 'award_config.php';
	
	function writeLog($msg,$log_dir){
		if (!file_exists($log_dir) && !mkdir($log_dir)){
			$err_logFile = date('Y-m-d').'.log';
 			$msg = date('H:i:s').': '.' mkdir '."$log_dir"." error"."\r\n";
 			file_put_contents($logFile,$msg,FILE_APPEND);	

 			$logFile = 'award-'.date('Y-m-d').'.log';
 			$msg = date('H:i:s').': '.$msg."\r\n";
 			file_put_contents($logFile,$msg,FILE_APPEND);
 			return;
		}
 		$logFile = "$log_dir".'/'.date('Y-m-d').'.log';
 		$msg = date('H:i:s').': '.$msg."\r\n";
 		file_put_contents($logFile,$msg,FILE_APPEND);
	}
	
	function my_connect_mysql($db_key){
		global $db;
		$db_config = $db[$db_key];
		if (0 == count($db_config)) {
			writeLog("my_connect_mysql not find db_key:".$db_key,"error_log"); 
			return NULL;
		}
		$link = @mysql_connect($db_config['hostname'],$db_config['username'],$db_config['password']);
		if (!$link) {
			writeLog("my_connect_mysql connect error:".mysql_error(),"error_log"); 
			return NULL;	
		}
		if (!mysql_set_charset('utf8', $link)) {
			writeLog("my_connect_mysql set link utf8 faliure,db_key:".$db_key,"error_log"); 
			return NULL;		
		}
		if (!isset($db_config['database'])) {
			writeLog("my_connect_mysql not set database,db_key:".$db_key,"error_log"); 
			return NULL;	
		} 
		//$charset = mysql_client_encoding($link);
		//printf ("current character set is %s\n", $charset);
		if (!mysql_select_db($db_config['database'], $link)) {
			writeLog("my_connect_mysql select database,db_key:".$db_key,"error_log"); 
			return NULL;		
		}
		return $link;
	}
	
	function get_server_url_by_areaid($area)
	{
		$db_key = 'default';
		$db_link = my_connect_mysql($db_key);
		if (!$db_link) {
			return false;
		}
		$sql = "select * from tbl_server where id=$area";
		$query_result = mysql_query($sql,$db_link);
		$nums = mysql_num_rows($query_result);
		if (0 == $nums) {
			writeLog("get_server_url_by_areaid not find areaid:".$area,"error_log");
			mysql_close($db_link);
			return false;
		}
		while ($row = mysql_fetch_array($query_result,MYSQL_ASSOC)) {
			$server_ip = $row['url'];
			$server_port = $row['port'];
			if (0 == count($server_ip) || 0 == count($server_port)) {
				mysql_free_result($query_result);
				mysql_close($db_link);
				writeLog("server_areaid ".$area." server_ip or server_port is not set!!!!!","error_log");
				return false;	
			}
			$ret_url = $row['url'].":".$row['port'];
			mysql_free_result($query_result);
			mysql_close($db_link);
			return $ret_url;
		}
		mysql_free_result($query_result);
		mysql_close($db_link);
		return false;
	}
	
	function make_curl_param($type,$condition,$area) {
		$server_url = get_server_url_by_areaid($area);
		if (!$server_url) {
			return NULL;	
		}
		$url_with_param = sprintf("%s/?type=$type&condition=$condition",$server_url);	
		return $url_with_param;
	}
	
	function curl_send($curl_param) {
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
		//echo $output;
		//释放curl句柄
		curl_close($ch);	
	}
	
	function send_msg_to_gameserver($type,$condition,$area) {
		curl_send(make_curl_param($type,$condition,$area));			
	}
	
	function insert_one($app_account,$digitid, $msg_type, $msg_title, $msg_content, $award){
		$server_area_id = get_server_area_id_by_digit_id($digitid);
		if (!$server_area_id) {
			return false;	
		}
		$database = $server_area_id."_game_db";
		$mysql_link = my_connect_mysql($database);
		if (!$mysql_link) {
			return false;
		}
		
		$insert_sql = "insert into `player_sysmsg` (`msg_type`,`digitid`,`title`,`content`,`award`) values ($msg_type,$digitid,'".mysql_real_escape_string($msg_title,$mysql_link)."','".mysql_real_escape_string($msg_content,$mysql_link)."','".mysql_real_escape_string($award,$mysql_link)."');";
		$excult_result = mysql_query($insert_sql,$mysql_link);
		if($excult_result){
			writeLog("app_account:".$app_account." digitid:".$digitid.
			" msg_type:".$msg_type." msg_title:".$msg_title." msg_content:".$msg_content." award:".$award,"award_send_log");
			mysql_close($mysql_link);
			//通知gs
			send_msg_to_gameserver("to_one",$digitid,$server_area_id);
		} else {
			writeLog("insert_one error:".mysql_error($mysql_link),"error_log");
			mysql_close($mysql_link);
			return false;
		}
		return true;
	}
	
	function get_server_area_id_by_digit_id($digit_id) {
		$db_link = my_connect_mysql('default');
		if (!$db_link) {
			make_return_err_code_and_des(ErrorCode::err_db_operate_failure,get_err_desc(ErrorCode::err_db_operate_failure));
			return false;
		}
		$sql = "select areaid from `tbl_user` where id=$digit_id;";
		$query = mysql_query($sql,$db_link);
		if (!$query) {
			writeLog("get_server_area_id_by_digit_id error:".mysql_error($db_link),"error_log");
			mysql_close($db_link);
			return false;
		}
		$nums = mysql_num_rows($query);
		if (0 == $nums) {
			make_return_err_code_and_des(ErrorCode::err_not_find_player_id,get_err_desc(ErrorCode::err_not_find_player_id));
			mysql_close($db_link);
			return false;	
		}
		while($row = mysql_fetch_array($query, MYSQL_ASSOC)){
			$area_id = $row['areaid'];	
			mysql_free_result($query);
			mysql_close($db_link);	
			return $area_id;
		}	
		mysql_free_result($query);
		mysql_close($db_link);	
		return false;
	}
	
	function is_requst_legal($request_arry) {
		if (!isset($request_arry['app_account'])) {
			return ErrorCode::err_not_set_app_account;		
		}
		if (!isset($request_arry['player_id'])) {
			return ErrorCode::err_not_set_player_id;	
		}
		if (!isset($request_arry['msg_type'])) {
			return ErrorCode::err_not_set_msg_award_type;	
		}
		if (!isset($request_arry['msg_title'])) {
			return ErrorCode::err_not_set_msg_award_title;	
		}
		if (!isset($request_arry['msg_content'])) {
			return ErrorCode::err_not_set_msg_award_content;	
		}
		if (!isset($request_arry['award'])) {
			return ErrorCode::err_not_set_msg_award;	
		}
		if (!isset($request_arry['sign'])) {
			return ErrorCode::err_not_set_sign;	
		}	
		return ErrorCode::err_success;
	}
	function get_err_desc($err_code) {
		if (ErrorCode::err_success == $err_code) {
			return "success";//成功	
		}	
		if (ErrorCode::err_not_set_player_id == $err_code) {
			return "not_set_player_id";//没有设置玩家id	
		}
		if (ErrorCode::err_not_set_msg_award_type == $err_code) {
			return "not_set_msg_award_type";//没有设置邮件奖励类型	
		}
		if (ErrorCode::err_not_set_msg_award_title == $err_code) {
			return "not_set_msg_award_title";//没有设置邮件奖励主题
		}
		if (ErrorCode::err_not_set_msg_award_content == $err_code) {
			return "not_set_msg_award_content";//没有设置邮件奖励消息内容
		}
		if (ErrorCode::err_not_set_msg_award == $err_code) {
			return "not_set_msg_award";//没有设置邮件奖励	
		}
		if (ErrorCode::err_not_set_sign == $err_code) {
			return "not_set_sign";//没有设置签名
		}
		if (ErrorCode::err_sign_false == $err_code) {
			return "sign_false";//签名不对
		}
		if (ErrorCode::err_award_formate_is_error == $err_code) {
			return "award_formate_is_error";//奖励格式错误	
		}
		if (ErrorCode::err_not_find_player_id == $err_code) {
			return "not_find_player_id";//未找到该玩家id	
		}
		if (ErrorCode::err_not_set_app_account == $err_code) {
			return "not_set_app_account";//没有设置app_account
		}
		if (ErrorCode::err_not_find_app_acount == $err_code) {
			return "not_find_app_acount";//未找到该app_account
		}
		if (ErrorCode::err_db_operate_failure == $err_code) {
			return "db_operate_failure";//db操作失败	
		}
		if (ErrorCode::err_msg_award_type_not_exist == $err_code) {
			return "msg_award_type_not_exist";//邮件奖励类型不存在
		}
		if (ErrorCode::err_award_kind_not_exist == $err_code) {
			return "award_kind_not_exist";//奖励类型不存在	
		}
		if (ErrorCode::err_equip_raffle_tickets_kind_not_exist == $err_code) {
			return "equip_raffle_tickets_kind_not_exist";//装备抽奖券的小类型不存在
		}
		if (ErrorCode::err_pet_raffle_tickets_kind_not_exist == $err_code) {
			return "pet_raffle_tickets_kind_not_exist";//宠物抽奖券的小类型不存在	
		}
		return "unkonw_err_desc";//未知错误描述
	}
	function make_return_err_code_and_des($err_code,$err_desc) {
		$result_ret = array();
		$result_ret["err_code"]=$err_code;
		$result_ret["err_desc"]=$err_desc;
		$Res = json_encode($result_ret);
		print_r(urldecode($Res));	
	}
	
	function get_app_key($app_account) {
		if (empty($app_account)) {
			make_return_err_code_and_des(ErrorCode::err_db_operate_failure,get_err_desc(ErrorCode::err_db_operate_failure));
			return false;		
		}
		$db_link = my_connect_mysql('default');
		if (!$db_link) {
			make_return_err_code_and_des(ErrorCode::err_db_operate_failure,get_err_desc(ErrorCode::err_db_operate_failure));
			return false;
		}
		$sql = "select `app_key` from `tbl_app_account_key` where app_account='".mysql_real_escape_string($app_account,$db_link)."';";
		$query = mysql_query($sql,$db_link);
		$nums = mysql_num_rows($query);
		if (0 == $nums) {
			make_return_err_code_and_des(ErrorCode::err_not_find_app_acount,get_err_desc(ErrorCode::err_not_find_app_acount));
			mysql_close($db_link);
			return false;		
		}
		while($row = mysql_fetch_array($query, MYSQL_ASSOC)){
			$app_key = trim($row['app_key']);
			mysql_free_result($query);
			mysql_close($db_link);
			return $app_key;	
		}
		mysql_free_result($query);
		mysql_close($db_link);
		return false;
	}
	function is_award_legal($award) {
		if (0 == count($award)) {
			return false;	
		}
		$award_list = explode(":", $award);
		if (!$award_list || !(count($award_list) == 3 || count($award_list) == 4)) {
			return false;	
		}
		$award_kind = $award_list[0];
		$award_id = $award_list[1];
		$award_num = $award_list[2];
		if (!is_numeric($award_kind) || !is_numeric($award_id) || !is_numeric($award_num)) {
			return false;	
		}
		$is_find = false;
		global $award_kind_arry;
		foreach ($award_kind_arry as $award_kind_tmp) {
			if ($award_kind == $award_kind_tmp) {
				$is_find = true;
				break;
			}	
		}
		if (!$is_find) {
			make_return_err_code_and_des(ErrorCode::err_award_kind_not_exist, get_err_desc(ErrorCode::err_award_kind_not_exist));
			return false;	
		}
		$is_find = false;
		if (AWARD_KIND::AWARD_EQUIP_RAFFLE_TICKETS == $award_kind) {
			global $equip_raffle_tickets_kind_arry;
			foreach ($equip_raffle_tickets_kind_arry as $equip_raffle_tickets_kind) {
				if ($award_id == $equip_raffle_tickets_kind) {
					$is_find = true;
					break;
				}	
			}
			if (!$is_find) {
				make_return_err_code_and_des(ErrorCode::err_equip_raffle_tickets_kind_not_exist, get_err_desc(ErrorCode::err_equip_raffle_tickets_kind_not_exist));
				return false;	
			}	
		} else if (AWARD_KIND::AWARD_PET_RAFFLE_TICKETS == $award_kind) {
			$is_find = false;
			global $pet_raffle_tickets_kind_arry;
			foreach ($pet_raffle_tickets_kind_arry as $pet_raffle_tickets_kind) {
				if ($award_id == $pet_raffle_tickets_kind) {
					$is_find = true;
					break;
				}	
			}
			if (!$is_find) {
				make_return_err_code_and_des(ErrorCode::err_pet_raffle_tickets_kind_not_exist, get_err_desc(ErrorCode::err_pet_raffle_tickets_kind_not_exist));
				return false;	
			}	
		} else {
			//其他情况暂时pass
		}
		return true;
	}
?>