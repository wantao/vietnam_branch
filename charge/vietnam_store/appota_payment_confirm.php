<?php
	require_once '../../unity/self_log.php';
	require_once 'common.php';
	
	$ret_result = array();
	//判断是否设置了相应的登陆参数
	if (!is_param_right($_REQUEST)) {
		return;
	}
	$transaction_id = $_REQUEST['transaction_id'];
	if (empty($transaction_id)) {
		writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)."transaction_id is empty:".$transaction_id, LOG_NAME::ERROR_LOG_FILE_NAME);
		return;
	}
	//writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)."tran_id:".$transaction_id." post_trans_id:".$_POST['transaction_id'], LOG_NAME::ERROR_LOG_FILE_NAME);
	
	//sanbox mode
	//$api_key = 'SK-A170639-U00000-YGP0NL-DCC55F1D37D9AFA5';

	//real mode 
	$api_key = 'K-A170639-U00000-R80WZJ-B5B6EE8A5200FE2C';
	
	$curl_param = "https://pay.appota.com/payment/confirm?api_key=$api_key&lang=LANG";
	$curl_param_data =  array('transaction_id' => $transaction_id);
	//writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)."curl_param:".$curl_param, LOG_NAME::ERROR_LOG_FILE_NAME);
	$ch = curl_init();
	//设置选项，包括URL
	curl_setopt($ch, CURLOPT_URL, $curl_param);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $curl_param_data);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    // https请求 不验证证书和hosts
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	
	//执行并获取HTML文档内容
	$output = curl_exec($ch);
	curl_close($ch);
	//writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)."response:".$output, LOG_NAME::ERROR_LOG_FILE_NAME);
	$output_tmp = json_decode($output);

	$status = $output_tmp->status;
	if (!$status) {
		make_return_err_code_and_des(ErrorCode::ERROR_VERIFY_FAILURE,get_err_desc(ErrorCode::ERROR_VERIFY_FAILURE));	
		return false;	
	}
	$data_object = get_object_vars($output_tmp->data);
	if (!isset($data_object["type"])) {
		writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)." not set type:", LOG_NAME::ERROR_LOG_FILE_NAME);
		return;	
	}
	if (!isset($data_object["amount"])) {
		writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)." not set amount:", LOG_NAME::ERROR_LOG_FILE_NAME);
		return;	
	}
	if (!isset($data_object["currency"])) {
		writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)." not set currency:", LOG_NAME::ERROR_LOG_FILE_NAME);
		return;	
	}
	if (!isset($data_object["state"])) {
		writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)." not set state:", LOG_NAME::ERROR_LOG_FILE_NAME);
		return;	
	}
	
	$type = $data_object["type"];
	$amount = $data_object["amount"];
	$currency = $data_object["currency"];
	$state = $data_object["state"];
	//$state = 'orderID:21';
	$game_order_arry = explode(':',$state);
	$game_order = $game_order_arry[1];
	
	if (!proccess_order($game_order,$transaction_id,$api_key,$type,$currency,$amount)) {
		make_return_err_code_and_des(ErrorCode::ERROR_PROCESS_ORDER_FAILURE,get_err_desc(ErrorCode::ERROR_PROCESS_ORDER_FAILURE));	
		return false;	
	}
	make_return_err_code_and_des(ErrorCode::SUCCESS,get_err_desc(ErrorCode::SUCCESS));
	
	function is_param_right($request)
	{
		if (!isset($request)) {
			make_return_err_code_and_des(ErrorCode::ERROR_NOT_SET_CHARGE_NOTIFY_PARAMS,get_err_desc(ErrorCode::ERROR_NOT_SET_CHARGE_NOTIFY_PARAMS));	
			return false;
		}
		if (!isset($request['transaction_id'])) {
			make_return_err_code_and_des(ErrorCode::ERROR_NOT_SET_PLATE_KEY,get_err_desc(ErrorCode::ERROR_NOT_SET_PLATE_KEY));	
			return false;
		}
		return true;
	}
?>