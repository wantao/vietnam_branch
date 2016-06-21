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
	$platform_id = PLATFORM::APPTO;
	
	$curl_param = "https://api.appota.com/game/get_user_info?access_token=".$access_token;
	$ch = curl_init();
	//设置选项，包括URL
	curl_setopt($ch, CURLOPT_URL, $curl_param);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	//curl_setopt($ch, CURLOPT_POSTFIELDS, $param_data);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    // https请求 不验证证书和hosts
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	
	//执行并获取HTML文档内容
	$output = curl_exec($ch);
	curl_close($ch);
	$output_tmp = json_decode($output);

	//writeLog("output_tmp:".$output_tmp, LOG_NAME::ERROR_LOG_FILE_NAME);
	$status = $output_tmp->status;
	if (!$status) {
		$error_code = $output_tmp->error_code;
		if (1 == $error_code) {
			$ret_result['error_code'] = ErrorCode::ERROR_VERIFY_FAILURE;	
			$ret_result['error_desc'] = "Some parameters are invalid"; 
			echo json_encode($ret_result);
			writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)." auth failure,return code:".$status, LOG_NAME::ERROR_LOG_FILE_NAME);
			return;
		} else if (99 == $error_code) {
			$ret_result['error_code'] = ErrorCode::ERROR_VERIFY_FAILURE;	
			$ret_result['error_desc'] = "System is not available at the moment"; 
			echo json_encode($ret_result);
			writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)." auth failure,return code:".$status, LOG_NAME::ERROR_LOG_FILE_NAME);
			return;	
		} else if (0 != $error_code) {
			$ret_result['error_code'] = ErrorCode::ERROR_VERIFY_FAILURE;	
			$ret_result['error_desc'] = "unkown error desc"; 
			echo json_encode($ret_result);
			writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)."auth failure,return code:".$status, LOG_NAME::ERROR_LOG_FILE_NAME);
			return;	
		}
	}
	
	
	$data_object = get_object_vars($output_tmp->data);
	if (!isset($data_object["user_id"])) {
		writeLog("appota_login_auth.php in return msg not set user_id:", LOG_NAME::ERROR_LOG_FILE_NAME);
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
		return true;
	}
?>