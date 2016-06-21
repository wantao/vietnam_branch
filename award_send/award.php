<?php 
	require_once 'common.php';

	$err_code = is_requst_legal($_REQUEST);
	if (ErrorCode::err_success != $err_code) {
		make_return_err_code_and_des($err_code,get_err_desc($err_code));
		return;
	}
	//判断签名是否正确
	$app_account = urldecode($_REQUEST['app_account']);
	$app_key = get_app_key($app_account);
	if (!$app_key) {
		return;
	}
	$digit_id = urldecode($_REQUEST['player_id']);
	$msg_type = urldecode($_REQUEST['msg_type']);
	if (!is_numeric($digit_id) || !is_numeric($msg_type)) {
		exit;	
	}
	if (!(0 == $msg_type || 2 == $msg_type)) {
		make_return_err_code_and_des(ErrorCode::err_msg_award_type_not_exist,get_err_desc(ErrorCode::err_msg_award_type_not_exist));
		return;	
	}
	$msg_title = urldecode($_REQUEST['msg_title']);
	$msg_content = urldecode($_REQUEST['msg_content']);
	$award = urldecode($_REQUEST['award']);
	if (!is_award_legal($award)) {
		return;
	}
	$sign = urldecode($_REQUEST['sign']);	
	$local_sign = md5($app_account.$digit_id.$msg_type.$msg_title.$msg_content.$award.$app_key); 
	if ($sign != $local_sign) {
		make_return_err_code_and_des(ErrorCode::err_sign_false,get_err_desc(ErrorCode::err_sign_false));
		return;
	}
	$area_id = get_server_area_id_by_digit_id($digit_id);
	if (!$area_id) {	
		return;
	}
	if(!insert_one(($app_account),$digit_id,$msg_type,($msg_title),($msg_content),($award))){
		return;
	}
	make_return_err_code_and_des(ErrorCode::err_success,get_err_desc(ErrorCode::err_success));
?>