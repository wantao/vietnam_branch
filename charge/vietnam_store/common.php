<?php
	require_once '../../unity/self_log.php';
	require_once '../../unity/self_pay.php';
	require_once '../../unity/self_platform_define.php';
	require_once '../../unity/self_error_code.php';
	require_once '../../unity/self_common.php';
	require_once 'config.php';
	
	//验证收到的订单通知
	function verify_order_notify ($transaction_id,$app_id,$verify_url) {
		$param_data = "transaction_id=$transaction_id&app_id=$app_id";
		$output_tmp = get_https_data($verify_url,$param_data,'POST');
		return $output_tmp->status == 1 ? true : false;
	}
	
	function get_transaction_type_id($transaction_type) {
		//writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)." tansaction_type:".$transaction_type, LOG_NAME::ERROR_LOG_FILE_NAME);	
		if ('CARD' == $transaction_type) {
			return ORDER_SOURCE_PLAT_FORM::VIETNAM_CARD;	
		} 
		if ('BANK' == $transaction_type) {
			return ORDER_SOURCE_PLAT_FORM::VIETNAM_BANK;	
		}
		if ('GOOGLE' == $transaction_type) {
			return ORDER_SOURCE_PLAT_FORM::GOOGLE_PLAY;	
		}
		if ('APPLE' == $transaction_type) {
			return ORDER_SOURCE_PLAT_FORM::APP_STORE;	
		}	
		if ('SMS' == $transaction_type) {
			return ORDER_SOURCE_PLAT_FORM::SMS;	
		}
		if ('PAYPAL' == $transaction_type) {
			return ORDER_SOURCE_PLAT_FORM::PAYPAL;	
		}
		return false;
	}
	
	function get_app_scret($app_id) {
		if ('4150ee1fedfb016340a5d7f0a5bbf082' == $app_id) {
			return '331aeaf75e626a4c9e6196cd76a13dc2';	
		}
		if ('3c8953f6568c92a46ecace70bf673c52' == $app_id) {
			return '7b772bf1c792f2b24e09073b27ebebe4';	
		}
		if ('50d239ea8326a712c6abb7c242cffa32' == $app_id) {
			return 'ff7a7c293bf4ab2f531b826397113e37';	
		}
		if ('f5f4e46f022771c650e17b17a20c453a' == $app_id) {
			return 'a03889486c3a825d6947dda55a782fe6';	
		}
		if ('e659f8af4336490427be06d2b239c91a' == $app_id) {
			return 'b7d579c4f5f65f6ac0a8fd17cdc16384';	
		}
		else {
			writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)." not find app_id:".$app_id, LOG_NAME::ERROR_LOG_FILE_NAME);	
			return '';
		}
	}
	
	function proccess_recieved_order_notify($game_order,$transaction_id,$app_id,$verify_url,$transaction_type,$currency,$amount){
		//判断order_platform_id是否存在
		$order_platform_id = get_transaction_type_id($transaction_type);
		if (!$order_platform_id) {
			writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)." not find tansaction_type:".$transaction_type." transaction_id:".$transaction_id, LOG_NAME::ERROR_LOG_FILE_NAME);	
			return false;
		}
		//writeLog(__FUNCTION__." verify_url:".$verify_url,LOG_NAME::ERROR_LOG_FILE_NAME);
		//验证收到的订单通知
		if (!verify_order_notify($transaction_id,$app_id,$verify_url)) {
			return false;	
		}
		//判断订单是否已经被处理过
		$op = new OrderOperation();
		$order_status = $op->get_order_status($transaction_id,$order_platform_id);
		if (ErrorCode::PROCESSED_ORDER == $order_status) {
			writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)." tansaction_type:".$transaction_type." transaction_id:".$transaction_id." has been proccessed!", LOG_NAME::ERROR_LOG_FILE_NAME);
			return true;	
		}
		if (ErrorCode::NOT_FIND_ORDER != $order_status) {
			writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)." tansaction_type:".$transaction_type." transaction_id:".$transaction_id." err_msg:".get_err_desc($order_status), LOG_NAME::ERROR_LOG_FILE_NAME);	
			return false;	
		}
		//查找订单的对应的玩家id
		$game_order_player_info = $op->get_game_order_player_info($game_order);
		if (!$game_order_player_info) {
			return false;
		}
		$product_info = array();
		//月卡订单
		if (1 == $game_order_player_info['shop_type']) {
			$product_info = get_yueka_product_info($currency,$amount);	
			if (!$product_info) {//结果买的不是月卡
				//查找订单对应的商品信息
				$product_info = get_product_info($currency,$amount);
				if (!$product_info) {
					return false;	
				}	
			}
		} else {//非月卡订单
			//查找订单对应的商品信息
			$product_info = get_product_info($currency,$amount);
			if (!$product_info) {
				return false;	
			}	
		}
		//将订单写入db，用到事务	
		return $op->order_info_write_to_db($app_id,$game_order_player_info,PLATFORM::VIETNAM,$order_platform_id,$transaction_id,$currency,$product_info);
	}
	
	function proccess_order($game_order,$transaction_id,$app_id,$transaction_type,$currency,$amount){
		//判断order_platform_id是否存在
		$order_platform_id = get_transaction_type_id($transaction_type);
		if (!$order_platform_id) {
			writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)." not find tansaction_type:".$transaction_type." transaction_id:".$transaction_id, LOG_NAME::ERROR_LOG_FILE_NAME);	
			return false;
		}
		//判断订单是否已经被处理过
		$op = new OrderOperation();
		$order_status = $op->get_order_status($transaction_id,$order_platform_id);
		if (ErrorCode::PROCESSED_ORDER == $order_status) {
			writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)." tansaction_type:".$transaction_type." transaction_id:".$transaction_id." has been proccessed!", LOG_NAME::ERROR_LOG_FILE_NAME);
			return true;	
		}
		if (ErrorCode::NOT_FIND_ORDER != $order_status) {
			writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)." tansaction_type:".$transaction_type." transaction_id:".$transaction_id." err_msg:".get_err_desc($order_status), LOG_NAME::ERROR_LOG_FILE_NAME);	
			return false;	
		}
		//查找订单的对应的玩家id
		$game_order_player_info = $op->get_game_order_player_info($game_order);
		if (!$game_order_player_info) {
			return false;
		}
		$product_info = array();
		//月卡订单
		if (1 == $game_order_player_info['shop_type']) {
			$product_info = get_appota_yueka_product_info($currency,$amount);	
			if (!$product_info) {//结果买的不是月卡
				//查找订单对应的商品信息
				$product_info = get_appota_product_info($currency,$amount);
				if (!$product_info) {
					return false;	
				}	
			}
		} else {//非月卡订单
			//查找订单对应的商品信息
			$product_info = get_appota_product_info($currency,$amount);
			if (!$product_info) {
				return false;	
			}	
		}
		//将订单写入db，用到事务	
		return $op->order_info_write_to_db($app_id,$game_order_player_info,PLATFORM::APPTO,$order_platform_id,$transaction_id,$currency,$product_info);
	}
?>