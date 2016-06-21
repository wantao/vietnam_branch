<?php 

	require_once '../../unity/self_error_code.php';
	require_once '../../unity/self_account.php';
	require_once '../../unity/self_platform_define.php';
	require_once '../../unity/self_log.php';
	require_once '../../unity/self_common.php';

	$ret_result = array();
	//判断是否设置了相应的登陆参数
	if (!is_param_right($_REQUEST)) {
		return;
	}
	
	$access_token = $_REQUEST['access_token'];
	$user_id = $_REQUEST['user_id'];
	$app_id = $_REQUEST['app_id'];
	$platform_id = PLATFORM::VIETNAM;
	
	//client 端还未接入sdk，相关参数不能得到，登录验证暂时取消
	
	//向ingamemobi平台发起登陆验证请求
	//sandbox
	//$curl_param = "https://api.ingamemobi.com:8443/sdk/get_user_info";
	//real mode
	$url = "https://api.ingamemobi.com/sdk/get_user_info";
	$param_data = "access_token=$access_token&user_id=$user_id&app_id=$app_id";
	
	$output_tmp = get_https_data($url,$param_data,'POST');
	//writeLog("output_tmp:".$output_tmp, LOG_NAME::ERROR_LOG_FILE_NAME);
	$status = $output_tmp->status;
	if (0 == $status) {
		$ret_result['error_code'] = ErrorCode::ERROR_VERIFY_FAILURE;	
		$ret_result['error_desc'] = "Query data inaccuracies"; 
		echo json_encode($ret_result);
		writeLog("login_auth.php auth failure,return code:".$status, LOG_NAME::ERROR_LOG_FILE_NAME);
		return;
	} else if (99 == $status) {
		$ret_result['error_code'] = ErrorCode::ERROR_VERIFY_FAILURE;	
		$ret_result['error_desc'] = "The system can not query at this time"; 
		echo json_encode($ret_result);
		writeLog("login_auth.php auth failure,return code:".$status, LOG_NAME::ERROR_LOG_FILE_NAME);
		return;	
	} else if (1 != $status) {
		$ret_result['error_code'] = ErrorCode::ERROR_VERIFY_FAILURE;	
		$ret_result['error_desc'] = "unkown error desc"; 
		echo json_encode($ret_result);
		writeLog("login_auth.php auth failure,return code:".$status, LOG_NAME::ERROR_LOG_FILE_NAME);
		return;	
	}
	
	$data_object = get_object_vars($output_tmp->data);
	if (!isset($data_object["user_id"])) {
		writeLog("login_auth.php in return msg not set user_id:", LOG_NAME::ERROR_LOG_FILE_NAME);
		return;	
	}
	$user_id = strval($data_object["user_id"]);
	
	$session_key_arr = array();
	$oa = new AccountOperation();
    if (!$oa->update_account_info($user_id,$access_token,$platform_id)) {
    	make_return_err_code_and_des(ErrorCode::DB_OPERATION_FAILURE,get_err_desc(ErrorCode::DB_OPERATION_FAILURE));	
    	return;
    }
    
    $token_result = $oa->getTokenInfo($platform_id.'_'.$user_id);
	
    $session_key_arr["error_code"] = ErrorCode::SUCCESS;
    $session_key_arr["session_key"] = $oa->get_session_key($user_id, $access_token, $platform_id);
    //$session_key_arr["is_accept_license"] = $token_result["is_accept_license"];
    $ret_result = json_encode($session_key_arr);
    print_r(urldecode($ret_result));
	//print_r($output);
	
	function is_param_right($request)
	{
		if (!isset($request)) {
			make_return_err_code_and_des(ErrorCode::ERROR_NOT_SET_LOGIN_AUTH_PARAMS,get_err_desc(ErrorCode::ERROR_NOT_SET_LOGIN_AUTH_PARAMS));	
			return false;
		}
		if (!isset($request['access_token'])) {
			make_return_err_code_and_des(ErrorCode::ERROR_NOT_SET_PLATE_KEY,get_err_desc(ErrorCode::ERROR_NOT_SET_PLATE_KEY));	
			return false;
		}
		if (!isset($request['user_id'])) {
			make_return_err_code_and_des(ErrorCode::ERROR_NOT_SET_UID,get_err_desc(ErrorCode::ERROR_NOT_SET_UID));	
			return false;	
		}
		if (!isset($request['app_id'])) {
			make_return_err_code_and_des(ErrorCode::URL_HAS_NO_APP_KEY,get_err_desc(ErrorCode::URL_HAS_NO_APP_KEY));	
			return false;	
		}
		return true;
	}
?>