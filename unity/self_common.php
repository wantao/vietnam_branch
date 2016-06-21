<?php
	require_once 'self_config.php';
	require_once 'self_log.php';
	require_once 'self_error_code.php';
	
	$server_list = get_server_list();
	function get_server_list() {
		$ret_array = array();
		$db_link = my_connect_mysql('default');
		if (NULL == $db_link) {
			return $ret_array;
		}	
		$select_sql = "select * from tbl_server";
		$query_result = mysql_query($select_sql,$db_link);
		if (!$query_result) {
			writeLog("get_server_list,sql:".$sql, LOG_NAME::ERROR_LOG_FILE_NAME);
			mysql_close($db_link);
			return $ret_array;
		}
		while ($row = mysql_fetch_array($query_result,MYSQL_ASSOC)) {
			$arry_tmp = array();
			$arry_tmp['belong_to'] = $row['belong_to'];
			$arry_tmp['current_code'] = $row['current_code'];
			$arry_tmp['name'] = $row['name'];
			$arry_tmp['login_server_ip'] = $row['login_server_ip'];
			$arry_tmp['login_server_port'] = $row['login_server_port'];
			$arry_tmp['udp_server_ip'] = $row['udp_server_ip'];
			$arry_tmp['udp_server_port'] = $row['udp_server_port'];
			$arry_tmp['udp_key'] = $row['udp_key'];
			$arry_tmp['is_trial'] = $row['is_trial'];
			if (2 == $row['run_status']) {//维护
				$arry_tmp['status'] = 2;		
			} else {
				$arry_tmp['status'] = $row['fluency_status'];	
			}
			$ret_array[$row['id']] = $arry_tmp;
		}
		mysql_close($db_link);
		return $ret_array;
	}
	
	function my_connect_mysql($db_key){
		global $global_db;
		$db_config = $global_db[$db_key];
		if (0 == count($db_config)) {
			writeLog("my_connect_mysql not find db_key:".$db_key,LOG_NAME::ERROR_LOG_FILE_NAME); 
			return NULL;
		}
		$link = @mysql_connect($db_config['hostname'],$db_config['username'],$db_config['password']);
		if (!$link) {
			writeLog("my_connect_mysql connect error:".mysql_error(),LOG_NAME::ERROR_LOG_FILE_NAME); 
			return NULL;	
		}
		if (!mysql_set_charset('utf8', $link)) {
			writeLog("my_connect_mysql set link utf8 faliure,db_key:".$db_key,LOG_NAME::ERROR_LOG_FILE_NAME); 
			return NULL;		
		}
		if (!isset($db_config['database'])) {
			writeLog("my_connect_mysql not set database,db_key:".$db_key,LOG_NAME::ERROR_LOG_FILE_NAME); 
			return NULL;	
		} 
		//$charset = mysql_client_encoding($link);
		//printf ("current character set is %s\n", $charset);
		if (!mysql_select_db($db_config['database'], $link)) {
			writeLog("my_connect_mysql select database,db_key:".$db_key,LOG_NAME::ERROR_LOG_FILE_NAME); 
			return NULL;		
		}
		return $link;
	}

	function get_login_server_info($server_code){
		foreach ($GLOBALS["server_list"] as $server_key=>$server_value) {
			if ($server_key == $server_code) {
				$server_value["name"] = urlencode($server_value["name"]);
				return $server_value;
			}
		}
		writeLog("get_login_server_info error not find server_id:".$server_code,LOG_NAME::ERROR_LOG_FILE_NAME); 	
		return array();
	}
	
	function get_login_server_info_by_cellphone_os($server_code,$cellphone_os){
		foreach ($GLOBALS["server_list"] as $server_key=>$server_value) {
			if ($server_key == $server_code) {
				if ($cellphone_os != $server_value['belong_to']) {
					return array();	
				}
				$server_value["name"] = urlencode($server_value["name"]);
				return $server_value;
			}
		}
		writeLog("get_login_server_info_by_cellphone_os error not find server_id:".$server_code,LOG_NAME::ERROR_LOG_FILE_NAME); 	
		return array();
	}

	function get_player_digit_id_by_uid($uid,$plate_code,$server_id){
		//约定玩家账号的格式:	plate_code_uid
		$player_account = $plate_code.'_'.$uid;
		$db_link = my_connect_mysql('default');
		if (!$db_link) {
			return false;	
		}
		$sql = "select id from tbl_user where account='".mysql_real_escape_string($player_account,$db_link)."' and areaid=$server_id and platform=$plate_code;";
		$query_result = mysql_query($sql,$db_link);
		if (!$query_result) {
			writeLog("get_player_digit_id_by_uid error:".$sql, LOG_NAME::ERROR_LOG_FILE_NAME);
			mysql_close($db_link);
			return false;
		}
		$nums = mysql_num_rows($query_result);
		if (0 == $nums) {
			writeLog("get_player_digit_id_by_uid find nothing,sql:".$sql,LOG_NAME::ERROR_LOG_FILE_NAME);
			mysql_close($db_link);
			return false;
		}
		while ($row = mysql_fetch_array($query_result,MYSQL_ASSOC)) {
			$digit_id = $row['id'];	
			mysql_close($db_link);
			return $digit_id;
		}
		mysql_close($db_link);
		return false;
	}
	
	function get_notice_info($server_code)
	{
		$ret_arr = array();
		$db_link = my_connect_mysql('default');
		if (!$db_link) {
			return false;	
		}
		$server_code = mysql_real_escape_string($server_code,$db_link);
		$sql = "select * from tbl_notice where area_ids like '%,$server_code,%';";
		$query_result = mysql_query($sql,$db_link);
		if (!$query_result) {
			writeLog("get_notice_info error:".$sql, LOG_NAME::ERROR_LOG_FILE_NAME);
			mysql_close($db_link);
			return false;
		}
		while ($row = mysql_fetch_array($query_result,MYSQL_ASSOC)) {
			$arr_tmp = array();
			$arr_tmp['title'] = urlencode($row['title']);
			$arr_tmp['content'] = urlencode($row['content']);
			$arr_tmp['activity_title'] = urlencode($row['activity_title']);
			$arr_tmp['activity_content'] = urlencode($row['activity_content']);
			array_push($ret_arr,$arr_tmp);
		}
		mysql_close($db_link);
		return $ret_arr;
	}
	
	//从https的url中获取数据，$method:POST
	function get_https_data($url,$param_data,$method)
	{
		$aHTTP = array(
		  'http' => // The wrapper to be used
			array(
			'method'  => $method, // Request Method
			'header'  => 'Content-type: application/json',
			'content' => $param_data
		  )
		);
		$context = stream_context_create($aHTTP);
		$handle = fopen($url, 'r', false, $context);
		$contents = '';
		while (!feof($handle)) {
		  $contents .= fread($handle, 8192);
		}
		fclose($handle);
		return json_decode($contents);		
	}

?>