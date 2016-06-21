<?php
	require_once  'unity/self_config.php';
	require_once  'unity/self_error_code.php';
	require_once  'unity/self_account.php';
	
	
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
	$server_id = urldecode($_REQUEST['server_id']);	
	
	if (!is_numeric($platform_id) || !is_numeric($server_id)) {
		exit;		
	}
	
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
	$login_server_info = get_login_server_info($server_id);
	if (empty($login_server_info)) {
		make_return_err_code_and_des(ErrorCode::ERROR_NOT_FIND_THE_SERVER_CODE,get_err_desc(ErrorCode::ERROR_NOT_FIND_THE_SERVER_CODE));	
		return;
	}
	$is_gm_account = $oa->is_gm_account($account);
	if (2 == $login_server_info['status'] && !$is_gm_account) {
		make_return_err_code_and_des(ErrorCode::ERROR_SERVER_IS_MAINTAINING,get_err_desc(ErrorCode::ERROR_SERVER_IS_MAINTAINING));	
		return;		
	}
	$oa->send_account_info_to_lg_server($user_id, $token, $platform_id, $login_server_info['current_code'],$token_result["enable"]);
	
	$Res = array();
	
	//unset($login_server_info["current_code"]);
	unset($login_server_info["udp_server_ip"]);
	unset($login_server_info["udp_server_port"]);
	unset($login_server_info["udp_key"]);
	unset($login_server_info['belong_to']);
	$Res["error_code"] = ErrorCode::SUCCESS;
	$Res["login_server_info"] = $login_server_info;
	
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
		if (!isset($request['server_id'])) {
			make_return_err_code_and_des(ErrorCode::URL_HAS_NO_SERVER_CODE,get_err_desc(ErrorCode::URL_HAS_NO_SERVER_CODE));	
			return false;	
		}
		return true;
	}
?>