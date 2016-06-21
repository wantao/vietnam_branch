<?php
	require_once  'unity/self_config.php';
	require_once  'unity/self_error_code.php';
	require_once  'unity/self_account.php';
	//require_once  'unity/self_log.php';
	
	
	//header("Content-type: text/html; charset=utf-8");
	
	if (!function_exists('json_decode')){
	exit('您的PHP不支持JSON，请升级您的PHP版本。');
	}
	
	$ret_result = array();
	//判断是否设置了相应的登陆参数
	if (!is_param_right($_REQUEST)) {
		return;
	}
	
	$user_id = urldecode($_REQUEST['user_id']);
	$token = urldecode($_REQUEST['token']);
	$platform_id = urldecode($_REQUEST['platform_id']);

	$cellphone_os_type = 0;
	if (isset($_REQUEST['cellphone_os_type'])) {
		$cellphone_os_type = urldecode($_REQUEST['cellphone_os_type']);
		if (!is_numeric($cellphone_os_type)) {
			exit;	
		}	
	}
	
	if (!is_numeric($platform_id)) {
		exit;
	}
	
	//writeLog("cellphone_os_type:".$cellphone_os_type." client_version:".$client_version, LOG_NAME::ERROR_LOG_FILE_NAME);
	
	$account = $platform_id.'_'.$user_id;
	$oa = new AccountOperation();
	$token_result = $oa->getTokenInfo($account);
	if (empty($token_result)) {
		make_return_err_code_and_des(ErrorCode::ERROR_NOT_FIND_THE_UID,get_err_desc(ErrorCode::ERROR_NOT_FIND_THE_UID));	
		return;	
	}
	/*if (0 == $token_result["is_accept_license"]) {
		make_return_err_code_and_des(ErrorCode::ERROR_NOT_ACCEPT_LICENSE,get_err_desc(ErrorCode::ERROR_NOT_ACCEPT_LICENSE));	
		return;	
	}*/
	$db_token = $token_result["access_token"];
	if ($token != $db_token) {
		make_return_err_code_and_des(ErrorCode::ERROR_TOKEN_ERROR,get_err_desc(ErrorCode::ERROR_TOKEN_ERROR));	
		return;	
	}
	
	$is_gm_account = $oa->is_gm_account($account);
	$Res = array();
	$Res["is_gm_account"] = ($is_gm_account ? '1' : '0');

	$last_areadid = $oa->get_last_login_server_id($user_id,$platform_id);
	if ($last_areadid > 0) {
		$cellphone_os_type = 0;
		$login_server_info = get_login_server_info_by_cellphone_os($last_areadid,$cellphone_os_type);
		if (!empty($login_server_info)) {
			$Res["last_login"] = make_last_login_server_info($login_server_info);	
		}	
	}

	$Res["error_code"] = ErrorCode::SUCCESS;
	if ($cellphone_os_type == 0 || 1 == $cellphone_os_type) {//默认android
		foreach ($GLOBALS["server_list"] as $server_key=>$server_value) {
		    if (2 == $server_value["is_trial"]) {//该区不对外显示
		        continue;
		    }
			$Res["server_list"][$server_key] = make_server_value($server_value);	
		}	
	} 
	$Res = json_encode($Res);
	print_r(urldecode($Res));
	
	
	function is_param_right($request)
	{
		if (!isset($request)) {
			make_return_err_code_and_des(ErrorCode::ERROR_NOT_SET_LOGIN_AUTH_PARAMS,get_err_desc(ErrorCode::ERROR_NOT_SET_LOGIN_AUTH_PARAMS));	
			return false;
		}
		if (!isset($request['token'])) {
			make_return_err_code_and_des(ErrorCode::ERROR_NOT_SET_PLATE_KEY,get_err_desc(ErrorCode::ERROR_NOT_SET_PLATE_KEY));	
			return false;
		}
		if (!isset($request['user_id'])) {
			make_return_err_code_and_des(ErrorCode::ERROR_NOT_SET_UID,get_err_desc(ErrorCode::ERROR_NOT_SET_UID));	
			return false;	
		}
		if (!isset($request['platform_id'])) {
			make_return_err_code_and_des(ErrorCode::ERROR_NOT_SET_PING_TAI_ID,get_err_desc(ErrorCode::ERROR_NOT_SET_PING_TAI_ID));	
			return false;	
		}
		return true;
	}
	function make_server_value($server_value) {
		$server_value['name'] = urlencode($server_value['name']);
		unset($server_value['belong_to']);
		unset($server_value['current_code']);
		unset($server_value['login_server_ip']);
		unset($server_value['login_server_port']);
		unset($server_value['udp_server_ip']);
		unset($server_value['udp_server_port']);
		unset($server_value['udp_key']);
		return $server_value;
	}
	
	function make_last_login_server_info($login_server_info){
		unset($login_server_info['login_server_ip']);
		unset($login_server_info['login_server_port']);
		unset($login_server_info['udp_server_ip']);
		unset($login_server_info['udp_server_port']);
		unset($login_server_info['udp_key']);
		unset($login_server_info['belong_to']);	
		return $login_server_info;
	}
?>