<?php

require_once 'self_config.php';
require_once 'self_error_code.php';
require_once 'self_log.php';

/**
 * 对本地帐号表的一些操作
 */
class AccountOperation
{
    /**
     * 更新或插入一个用户的登录记录
     * @param string $account  平台返回的唯一id
     * @param string $access_token  平台返回的token
     * @param int  $platform_id  平台id. 我们自己定义
     * @return array("login_server_ip","login_server_port","server_code","session_key") , 失败返回 带错误码的数组
     */
    public function updateAccount($account, $access_token, $platform_id, $server_code)
    {
    	$Result = array();//存放结果数组
    	$login_server_info = get_login_server_info($server_code);
    	if (empty($login_server_info)) {
    		$Result["error_code"] = ErrorCode::AUTHENTICATE_FAILURE;
    		$Result["error_desc"] = get_err_desc(ErrorCode::AUTHENTICATE_FAILURE);
    		return $Result;
    	}
        $self_account = $platform_id . "_" . $account; // 使用平台id 作为前缀
        $session_key = md5($self_account . $access_token); // 签名
		{// 发送账号等相关信息给登入服务器
			$sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
			$msg = $self_account . "|" . $session_key . "|" . $platform_id . "|" .$server_code . "|" .$login_server_info["udp_key"];
			$len = strlen($msg);
			socket_sendto($sock, $msg, $len, 0, $login_server_info["udp_server_ip"], $login_server_info["udp_server_port"]);
			socket_close($sock);
		}
        $link = my_connect_mysql("default");
        if (!$link) {
        	$Result["error_code"] = ErrorCode::DB_OPERATION_FAILURE;
			$Result["error_desc"] = get_err_desc(ErrorCode::DB_OPERATION_FAILURE);
			return $Result;
        }
        $query = " INSERT INTO `tbl_account` SET `account`='$self_account', `session_key`='$session_key', `platform`=$platform_id, `access_token`='$access_token', `login_time`=NOW()
        ON DUPLICATE KEY UPDATE `session_key`='$session_key', `access_token`='$access_token', `login_time`=NOW() " ;
		if ( mysql_query($query) ) {
			if (mysql_affected_rows($link) > 0) {
				// ok 
				$Result["error_code"] = ErrorCode::SUCCESS;
				$Result["error_desc"] = get_err_desc(ErrorCode::SUCCESS);
				unset($login_server_info["current_code"]);
				unset($login_server_info["udp_server_ip"]);
				unset($login_server_info["udp_server_port"]);
				unset($login_server_info["udp_key"]);
				$Result["login_server_info"] = $login_server_info;
				$Result["session_key"] = $session_key;
			} 
		} else {
			writeLog("mysql operation error,sql:".$query, "error_log");
			$Result["error_code"] = ErrorCode::DB_OPERATION_FAILURE;
			$Result["error_desc"] = get_err_desc(ErrorCode::DB_OPERATION_FAILURE);
		}
		mysql_close($link);
		return $Result;
    }
    
    public function send_account_info_to_lg_server($account, $access_token, $platform_id, $server_code, $enable)
    {
    	$login_server_info = get_login_server_info($server_code);
    	if(empty($login_server_info)) 
    		return;
    	$self_account = $platform_id . "_" . $account; // 使用平台id 作为前缀
        $session_key = md5($self_account . $access_token); // 签名
		{// 发送账号等相关信息给登入服务器
			$sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
			$msg = $self_account . "|" . $session_key . "|" . $platform_id . "|" .$server_code . "|" .$login_server_info["udp_key"] . "|" .$enable;
			$len = strlen($msg);
			socket_sendto($sock, $msg, $len, 0, $login_server_info["udp_server_ip"], $login_server_info["udp_server_port"]);
			socket_close($sock);
		}
    }
    
    public function get_session_key($account, $access_token, $platform_id)
    {
    	$self_account = $platform_id . "_" . $account; // 使用平台id 作为前缀
        $session_key = md5($self_account . $access_token); // 签名
        return $session_key;
    }
    
    public function update_account_info($account, $access_token, $platform_id)
    {
    	$link = my_connect_mysql("default");
        if (!$link) {
        	return false;
        }
    	$session_key = $this->get_session_key($account, $access_token, $platform_id);
    	$self_account = $platform_id . "_" . $account; // 使用平台id 作为前缀
    	$query = " INSERT INTO `tbl_account` SET `account`='$self_account', `session_key`='$session_key', `platform`=$platform_id, `access_token`='$access_token', `login_time`=NOW()
        ON DUPLICATE KEY UPDATE `session_key`='$session_key', `access_token`='$access_token', `login_time`=NOW() " ;
    	if ( !mysql_query($query) ) {
    		mysql_close($link);
    		writeLog("update_account_info error,sql:".$query, LOG_NAME::ERROR_LOG_FILE_NAME);
    		return false;
    	}
    	mysql_close($link);
    	return true;
    }
    
    public function get_last_login_server_id($account,$platform_id)
    {
    	$link = my_connect_mysql("default");
        if (!$link) {
        	return false;
        }
    	$self_account = $platform_id . "_" . $account; // 使用平台id 作为前缀
    	$query = "select `last_areaid` from `tbl_account` where `account`='$self_account';";
    	
    	$select_query = mysql_query($query,$link);
		if (!$select_query) {
			writeLog("error:".mysql_error($link)." sql:".$query, LOG_NAME::ERROR_LOG_FILE_NAME);
			mysql_close($link);	
			return false;			
		}
		$nums = mysql_num_rows($select_query);
    	if ($nums <= 0) {
    		mysql_close($link);
    		return false;
    	}
    	while ($row = mysql_fetch_array($select_query,MYSQL_ASSOC)) {
    		$last_areaid = $row['last_areaid'];
    		if ($last_areaid <= 0) {
    			mysql_close($link);
    			return false;
    		}
    		mysql_close($link);
    		return $last_areaid;
    	}
    	mysql_close($link);
    	return false;
    }
    
    public function is_account_actived($self_account) 
    {
    	$link = my_connect_mysql("default");
        if (!$link) {
        	return false;
        }
        $query = "select `enable` from `tbl_account` where `account`='".mysql_real_escape_string($self_account,$link)."';";
    	
    	$select_query = mysql_query($query,$link);
		if (!$select_query) {
			writeLog("is_account_actived error:".mysql_error($link)." sql:".$query, LOG_NAME::ERROR_LOG_FILE_NAME);
			mysql_close($link);	
			return false;			
		}
		$nums = mysql_num_rows($select_query);
    	if ($nums <= 0) {
    		mysql_close($link);
    		return false;
    	}
    	while ($row = mysql_fetch_array($select_query,MYSQL_ASSOC)) {
    		$enable = $row['enable'];
    		if ($enable == 1) {
    			mysql_close($link);
    			return true;
    		}
    		break;
    	}
    	mysql_close($link);
    	return false;
    }
    
    public function get_invitation_code_status($invitation_code)
    {
    	$res = array();
    	$link = my_connect_mysql("default");
        if (!$link) {
        	$res["error_code"] = ErrorCode::DB_OPERATION_FAILURE;
        	return $res;
        }
        $query = "select * from `tbl_invitation_code` where `code`='".mysql_real_escape_string($invitation_code,$link)."';";
    	
    	$select_query = mysql_query($query,$link);
		if (!$select_query) {
			writeLog("is_exist_invitation_code error:".mysql_error($link)." sql:".$query, LOG_NAME::ERROR_LOG_FILE_NAME);
			mysql_close($link);
			$res["error_code"] = ErrorCode::DB_OPERATION_FAILURE;	
			return $res;			
		}
		$nums = mysql_num_rows($select_query);
    	if ($nums <= 0) {
    		mysql_close($link);
    		$res["error_code"] = ErrorCode::ERROR_INVITATION_CODE_ERROR;
    		return $res;
    	}
    	while ($row = mysql_fetch_array($select_query,MYSQL_ASSOC)) {
    		$has_use = $row['has_use'];
    		$res["error_code"] = ErrorCode::SUCCESS;
    		$res["status"] = $has_use;
    		mysql_close($link);
    		return $res;
    	}
    }
    
    public function bind_account_and_invitation_and_active_account($account,$invitation_code)
    {
    	$link = my_connect_mysql("default");
        if (!$link) {
        	$res["error_code"] = ErrorCode::DB_OPERATION_FAILURE;
        	return $res;
        }
        mysql_query("BEGIN");
        try {
       		$update_tbl_invitation_sql = "update `tbl_invitation_code` set `account`='".mysql_real_escape_string($account,$link)."',`has_use`=1 where `code`='".mysql_real_escape_string($invitation_code,$link)."';"; 
       		if (!mysql_query($update_tbl_invitation_sql,$link)) {
       			mysql_query("ROLLBACK");
				throw new Exception("bind_account_and_invitation_and_active_account error,sql:".$update_tbl_invitation_sql);
       		}
       		       		
       		$update_tbl_account_sql = "update `tbl_account` set `enable`=1 where `account`='".mysql_real_escape_string($account,$link)."';";
        	$update_result = mysql_query($update_tbl_account_sql,$link);
       		if (!$update_result) {
       			mysql_query("ROLLBACK");
				throw new Exception("bind_account_and_invitation_and_active_account error,sql:".$update_tbl_account_sql);
       		}
       		
       		if (mysql_affected_rows($link) <= 0) {
       			mysql_query("ROLLBACK");
				throw new Exception("bind_account_and_invitation_and_active_account error,not find account:".$account." sql:".$update_tbl_account_sql);
       		}
        } catch (Exception $e) {
			writeLog("throw exception:" . $e->getMessage(),LOG_NAME::ERROR_LOG_FILE_NAME);
			$res["error_code"] = ErrorCode::DB_OPERATION_FAILURE;
			mysql_close($link);
			return $res;
        }
        mysql_query("COMMIT"); 
        mysql_close($link);
        $res["error_code"] = ErrorCode::SUCCESS;
        return $res;
    }

    /**
     * 获取token. 用来获取平台信息, 或者支付等使用
     * @param String $self_account
     * @return string token. 失败返回空字符串
     */
    public function getTokenInfo($self_account)
    {
    	$res = array();
    	$link = my_connect_mysql("default");
    	if (!$link) {
    		writeLog("getTokenInfo my_connect_mysql failure", LOG_NAME::ERROR_LOG_FILE_NAME);
    		return $res;	
    	}
    	$query = " SELECT `access_token`,`enable`,`is_accept_license` FROM `tbl_account` WHERE `account`='".mysql_real_escape_string($self_account,$link)."' ";
    	$result = mysql_query($query, $link);
    	if ($result) {
	    	if ($row = mysql_fetch_array($result, MYSQL_NUM)) {
				$res["access_token"] = $row[0];
				$res["enable"] = $row[1];
				$res["is_accept_license"] = $row[2];
				return $res; 
	    	}
	    	mysql_free_result($result);	
    	}
    	writeLog("getTokenInfo error:"." sql:".$query, LOG_NAME::ERROR_LOG_FILE_NAME);
    	return $res;
    }
    
    public function update_accept_license_flag($flag,$account)
    {
    	$link = my_connect_mysql("default");
    	if (!$link) {
    		writeLog("update_accept_license_flag my_connect_mysql failure", LOG_NAME::ERROR_LOG_FILE_NAME);
    		return false;	
    	}
    	$update_sql = "update `tbl_account` set `is_accept_license` =".(($flag != 0) ? 1 : 0)." where `account`='".mysql_real_escape_string($account,$link)."'";
    	if(!mysql_query($update_sql, $link)) {
    		writeLog("getTokenInfo error:"." sql:".$update_sql, LOG_NAME::ERROR_LOG_FILE_NAME);
    		return false;
    	}
    	return true;
    }
    
 	//判断账号是否是gm账号
    public function is_gm_account($account)
    {
    	$link = my_connect_mysql("default");
    	if (!$link) {
    		writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)." my_connect_mysql failure", LOG_NAME::ERROR_LOG_FILE_NAME);
    		return false;	
    	}
    	$select_sql = "select * from `tbl_gmlist` where `account`="."'".mysql_real_escape_string($account,$link)."'";
    	$result = mysql_query($select_sql, $link);
    	if(!$result) {
    		writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)." sql:".$select_sql, LOG_NAME::ERROR_LOG_FILE_NAME);
    		return false;
    	}
    	if (mysql_num_rows($result) <= 0) {
    		return false;
    	}
    	return true;
    }

}

