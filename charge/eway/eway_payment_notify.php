<?php
	require_once '../../unity/self_log.php';
	require_once '../../unity/self_platform_define.php';
	require_once 'common.php';
	
	$ret_result = array();

	//判断是否设置了相应的登陆参数
	if (!is_param_right($_REQUEST)) {
		return;
	}
	
	$transaction_id = $_REQUEST['trans_id'];
	$game_order = $_REQUEST['game_order'];
	$app_id = $_REQUEST['game_code'];
	$order_platform_id = ORDER_SOURCE_PLAT_FORM::EWAY;
	$currency = $_REQUEST['currency'];
	$amount = $_REQUEST['money'];
	
	if (!proccess_recieved_order_notify($game_order,$transaction_id,$app_id,$order_platform_id,$currency,$amount)) {
		make_response($_REQUEST,ErrorCode::ERROR_PROCESS_ORDER_FAILURE);
		return false;	
	}
	make_response($_REQUEST,ErrorCode::SUCCESS);
	
	function is_param_right($request)
	{
		if (!isset($request)) {
			make_response($request,ErrorCode::ERROR_NOT_SET_CHARGE_NOTIFY_PARAMS);	
			writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)." not set params!", LOG_NAME::ERROR_LOG_FILE_NAME);
			return false;
		}
		if (!isset($request['username'])) {
			make_response($request,ErrorCode::ERROR_CHARGE_NOTIFY_PARAMS_ERROR);	
			writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)." not set params username!", LOG_NAME::ERROR_LOG_FILE_NAME);
			return false;
		}
		if (!isset($request['user_id'])) {
			make_response($request,ErrorCode::ERROR_CHARGE_NOTIFY_PARAMS_ERROR);	
			writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)." not set params user_id!", LOG_NAME::ERROR_LOG_FILE_NAME);
			return false;
		}
		if (!isset($request['game_code'])) {
			make_response($request,ErrorCode::ERROR_CHARGE_NOTIFY_PARAMS_ERROR);
			writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)." not set params game_code", LOG_NAME::ERROR_LOG_FILE_NAME);	
			return false;
		}
		if (!isset($request['trans_id'])) {
			make_response($request,ErrorCode::ERROR_CHARGE_NOTIFY_PARAMS_ERROR);	
			writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)." not set params trans_id", LOG_NAME::ERROR_LOG_FILE_NAME);
			return false;
		}
		if (!isset($request['telco'])) {
			make_response($request,ErrorCode::ERROR_CHARGE_NOTIFY_PARAMS_ERROR);
			writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)." not set params telco", LOG_NAME::ERROR_LOG_FILE_NAME);	
			return false;
		}
			
		if (!isset($request['serial'])) {
			make_response($request,ErrorCode::ERROR_CHARGE_NOTIFY_PARAMS_ERROR);
			writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)." not set params serial", LOG_NAME::ERROR_LOG_FILE_NAME);	
			return false;
		}
		if (!isset($request['pincode'])) {
			make_response($request,ErrorCode::ERROR_CHARGE_NOTIFY_PARAMS_ERROR);
			writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)." not set params pincode", LOG_NAME::ERROR_LOG_FILE_NAME);	
			return false;
		}
		if (!isset($request['money'])) {
			make_response($request,ErrorCode::ERROR_CHARGE_NOTIFY_PARAMS_ERROR);	
			writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)." not set params money", LOG_NAME::ERROR_LOG_FILE_NAME);
			return false;
		}
		if (!isset($request['currency'])) {
			make_response($request,ErrorCode::ERROR_CHARGE_NOTIFY_PARAMS_ERROR);
			writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)." not set params currency", LOG_NAME::ERROR_LOG_FILE_NAME);	
			return false;
		}
		
		if (!isset($request['game_money'])) {
			make_response($request,ErrorCode::ERROR_CHARGE_NOTIFY_PARAMS_ERROR);	
			writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)." not set params game_money", LOG_NAME::ERROR_LOG_FILE_NAME);
			return false;
		}
		if (!isset($request['token'])) {
			make_response($request,ErrorCode::ERROR_CHARGE_NOTIFY_PARAMS_ERROR);
			writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)." not set params token", LOG_NAME::ERROR_LOG_FILE_NAME);	
			return false;
		}
		if (!isset($request['game_order'])) {
			make_response($request,ErrorCode::ERROR_CHARGE_NOTIFY_PARAMS_ERROR);	
			writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)." not set params game_order", LOG_NAME::ERROR_LOG_FILE_NAME);
			return false;
		}
		
		
		$token = $request['token'];
		$serial = $request['serial'];
		$pincode = $request['pincode'];
		if ($token != md5('9chau_sdk_'.$serial.'_'.$pincode)) {
			make_response($requst,ErrorCode::ERROR_VERIFY_FAILURE);	
			writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)." token verify error", LOG_NAME::ERROR_LOG_FILE_NAME);
			return false;	
		}
		return true;
	}
	
	function make_response($requst,$error_code) {
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
		$result_ret['trans_id'] = isset($requst['trans_id']) ? $requst['trans_id'] : '';
		$result_ret['telco'] = isset($requst['telco']) ? $requst['telco'] : '';
		$result_ret['pincode'] = isset($requst['pincode']) ? $requst['pincode'] : '';
		$result_ret['money'] = isset($requst['money']) ? $requst['money'] : '';
		$result_ret['serial'] = isset($requst['serial']) ? $requst['serial'] : '';
		$result_ret['game_order'] = isset($requst['game_order']) ? $requst['game_order'] : '';

		$Res = json_encode($result_ret);
		print_r(urldecode($Res));
	}
?>