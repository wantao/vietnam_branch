<?php
	require_once '../../unity/self_log.php';
	require_once '../../unity/self_pay.php';
	require_once '../../unity/self_platform_define.php';
	require_once '../../unity/self_error_code.php';
	require_once '../../unity/self_common.php';
	require_once 'config.php';
	
	function proccess_recieved_order_notify($game_order,$transaction_id,$app_id,$order_platform_id,$currency,$amount){
		//判断订单是否已经被处理过
		$op = new OrderOperation();
		$order_status = $op->get_order_status($transaction_id,$order_platform_id);
		if (ErrorCode::PROCESSED_ORDER == $order_status) {
			writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)." order_platform_id:".$order_platform_id." transaction_id:".$transaction_id." has been proccessed!", LOG_NAME::ERROR_LOG_FILE_NAME);
			return true;	
		}
		if (ErrorCode::NOT_FIND_ORDER != $order_status) {
			writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)." order_platform_id:".$order_platform_id." transaction_id:".$transaction_id." err_msg:".get_err_desc($order_status), LOG_NAME::ERROR_LOG_FILE_NAME);	
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
		return $op->order_info_write_to_db($app_id,$game_order_player_info,PLATFORM::EWAY,$order_platform_id,$transaction_id,$currency,$product_info);
	}
?>