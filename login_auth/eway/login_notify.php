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
	
	$access_token = $_REQUEST['token'];
	$user_id = $_REQUEST['user_id'];
	$app_id = $_REQUEST['game_code'];
	$platform_id = PLATFORM::EWAY;
	
	$session_key_arr = array();
	$oa = new AccountOperation();
    if (!$oa->update_account_info($user_id,$access_token,$platform_id)) {
    	make_response($requst,ErrorCode::DB_OPERATION_FAILURE,'');	
    	return;
    }
    
    /*$token_result = $oa->getTokenInfo($platform_id.'_'.$user_id);
    $session_key_arr["is_accept_license"] = $token_result["is_accept_license"];*/
	make_response($_REQUEST,ErrorCode::SUCCESS,$oa->get_session_key($user_id, $access_token, $platform_id));
	
    
	function is_param_right($request)
	{
		if (!isset($request)) {
			make_response($request,ErrorCode::ERROR_NOT_SET_LOGIN_AUTH_PARAMS,'');
			return false;
		}
		if (!isset($request['token'])) {
			make_response($request,ErrorCode::ERROR_NOT_SET_PLATE_KEY,'');
			return false;
		}
		if (!isset($request['user_id'])) {
			make_response($request,ErrorCode::ERROR_NOT_SET_UID,'');
			return false;	
		}
		if (!isset($request['username'])) {
			make_response($request,ErrorCode::ERROR_NOT_SET_UID,'');
			return false;	
		}
		if (!isset($request['game_code'])) {
			make_response($request,ErrorCode::URL_HAS_NO_APP_KEY,'');	
			return false;	
		}
		if ($request['token'] != md5('9chau_sdk_'.$request['game_code'].'_'.$request['username'])) {
			make_response($request,ErrorCode::ERROR_VERIFY_FAILURE,'');	
			return false;		
		}
		return true;
	}
	
	function make_response($requst,$error_code,$session_key) {
		$result_ret = array();
		if (ErrorCode::SUCCESS == $error_code) {
			$result_ret['status'] = 1;	
			$result_ret['message'] = get_err_desc(ErrorCode::SUCCESS);
		} else {
			$result_ret['status'] = $error_code;	
			$result_ret['message'] = get_err_desc($error_code);	
		} 
		$result_ret['username'] = isset($requst['username']) ? $requst['username'] : '';
		$result_ret['user_id'] = isset($requst['user_id']) ? $requst['user_id'] : '';
		$result_ret['game_code'] = isset($requst['game_code']) ? $requst['game_code'] : '';
		$result_ret['token'] = isset($requst['token']) ? $requst['token'] : '';
		$result_ret['error_code'] = $error_code;
		$result_ret['session_key'] = $session_key;
		$Res = json_encode($result_ret);
		print_r(urldecode($Res));
	}
?>