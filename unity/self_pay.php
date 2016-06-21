<?php

require_once  'self_config.php';
require_once  'self_log.php';
require_once  'self_error_code.php';


/*
订单处理通用类
*/
class OrderOperation
{
    /*
    处理第三方平台处理过并传回来的orderId
    查询tbl_recharge_order中是否存在该orderId，存在则将该orederId的pay_ok字段置为1，
    并在tbl_recharge中插入一条记录
    */
    public function processOrder($orderId,$platform,$platformOrderId)
    {
        $link = my_connect_mysql($GLOBALS["global_db"]["all"]); 
    	if(!link){
    	    writeLog("in function ".__FUNCTION__." db operate error:".mysql_error(),"log");
    	    return ErrorCode::DB_OPERATION_FAILURE;
    	} 
		//这里需要用到事务
	    mysql_query("BEGIN");
	    try{
    		$search_result = mysql_query("select `id`,`digitid`,`areaid`, `money`, `yuanbao`, `pay_ok`,`shop_type` from `tbl_recharge_order` where `id` = $orderId");
    		if (!$search_result) {
    		    mysql_query("ROLLBACK");
    		    writeLog("in function ".__FUNCTION__." db operate error:".mysql_error(),"log");
    	        return ErrorCode::DB_OPERATION_FAILURE;        
    		}
    		$row = mysql_fetch_array($search_result, MYSQL_ASSOC);
    		if (!$row) {
    			mysql_query("ROLLBACK");
    			writeLog("in function ".__FUNCTION__." Can't find this order orderid=$orderId","log");
    			return ErrorCode::NOT_FIND_ORDER;
    		}
    		$id = $row['id'];
    		if ($row[`pay_ok`] == 1) {
    			//查询订单在前，平台通知在后时，用平台流水号替换掉以前用订单号做成的流水号
    		    $updateSql = "update tbl_recharge set `orderid` = `$platformOrderId` where `Id` = $id";
	    		if (!mysql_query($updateSql)) {
	    			mysql_query("ROLLBACK");
	    			writeLog("in function ".__FUNCTION__." db operate error:".mysql_error(),"log");
	    	        return ErrorCode::DB_OPERATION_FAILURE;
	    		}
    		    mysql_query("COMMIT"); // 提交成功
	    		mysql_query("END"); 
    			writeLog("in function ".__FUNCTION__." orderid=$orderId has been processed","log");
    			return ErrorCode::PROCESSED_ORDER;    
    		}
    		
    		$digitid = $row['digitid'];
    		$areaid = $row['areaid'];
    		$money = $row['money'];
    		$yuanbao = $row['yuanbao']; 
    		$shoptype = $row['shop_type'];
    		mysql_free_result($search_result);
    		
    		$update_pay_ok = "update tbl_recharge_order set `pay_ok`=1 where `id`=$id";
    		if (!mysql_query($update_pay_ok)) {
    			mysql_query("ROLLBACK");
    			writeLog("in function ".__FUNCTION__." db operate error:".mysql_error(),"log");
    	        return ErrorCode::DB_OPERATION_FAILURE;
    		}
    		
    		$query = "insert into tbl_recharge set `Id` = $id, `playerid` = $digitid, `area_no` = $areaid, `money` = $money, `yuanbao` = $yuanbao, `orderid` = `$platformOrderId`,`ping_tai` = $platform,`shop_type` = $shoptype";
    		if (!mysql_query($query)) {
    			mysql_query("ROLLBACK");
    			writeLog("in function ".__FUNCTION__." db operate error:".mysql_error(),"log");
    	        return ErrorCode::DB_OPERATION_FAILURE;
    		}
	    } catch (Exception $e) {
    		mysql_query("ROLLBACK");
    		writeLog("in function ".__FUNCTION__." mysql Exception:".mysql_error(),"log");
    	    return ErrorCode::DB_OPERATION_FAILURE;
	    }
	    mysql_query("COMMIT"); // 提交成功
	    mysql_query("END"); 
	    return ErrorCode::SUCCESS;
    }
    
    
    //获取订单状态
    public function getOrderStatus($orderId,$platform)
    {
    	$link = my_connect_mysql($GLOBALS["global_db"]["all"]); 
    	if(!link){
    	    writeLog("in function ".__FUNCTION__." db operate error:".mysql_error(),"log");
    	    return ErrorCode::DB_OPERATION_FAILURE;
    	}
    	$search_result = mysql_query("select `pay_ok` from `tbl_recharge_order` where `id` = $orderId");
    	if (!$search_result) {
    	    writeLog("in function ".__FUNCTION__." db operate error:".mysql_error(),"log");
            return ErrorCode::DB_OPERATION_FAILURE;        
    	}
    	$row = mysql_fetch_array($search_result, MYSQL_ASSOC);
    	if ($row) {
    		if ($row[`pay_ok`] == 1) {
    			writeLog("in function ".__FUNCTION__." id=$orderId has been processed","log");
    			return ErrorCode::PROCESSED_ORDER;    
    		}
    		return ErrorCode::ORDER_IS_NOT_PROCESSED;
    	}
    	writeLog("in function ".__FUNCTION__." Can't find this order id=$orderId","log");
    	//根据平台流水号再查一次
    	$platform_search_res = mysql_query("select `pay_ok` from `tbl_recharge_order` where `orderid` = '$orderId' and `ping_tai` = $platform");
    	if (!$platform_search_res) {
    	    writeLog("in function ".__FUNCTION__." db operate error:".mysql_error(),"log");
            return ErrorCode::DB_OPERATION_FAILURE;        
    	}
    	$platform_search_row = mysql_fetch_array($search_result, MYSQL_ASSOC);
    	if ($platform_search_row) {
    		if ($platform_search_row[`pay_ok`] == 1) {
    			writeLog("in function ".__FUNCTION__." orderId=$orderId,pingtai=$platform has been processed","log");
    			return ErrorCode::PROCESSED_ORDER;    
    		}
    		return ErrorCode::ORDER_IS_NOT_PROCESSED;
    	}
    	return ErrorCode::NOT_FIND_ORDER;
    }
    
    //判断订单是否已经存在
    public function get_order_status($orderId,$order_platform)
    {
	    $db_key = 'default';
		$db_link = my_connect_mysql($db_key);
		if (!$db_link) {
			return ErrorCode::DB_OPERATION_FAILURE;
		}
    	//先判断在tbl_recharge中是否存在该订单
    	$tbl_recharge_sql = "select * from `tbl_recharge` where order_ping_tai=$order_platform and orderid='".mysql_real_escape_string($orderId,$db_link)."'";
	    $query_result = mysql_query($tbl_recharge_sql,$db_link);
    	if (!$query_result) {
			writeLog("error:".mysql_error($db_link)." sql:".$tbl_recharge_sql, LOG_NAME::ERROR_LOG_FILE_NAME);
			mysql_close($db_link);
			return ErrorCode::DB_OPERATION_FAILURE;			
		}
		$row = mysql_num_rows($query_result);
		if ($row > 0) {
			return ErrorCode::PROCESSED_ORDER;
		}
		
		//再判断tbl_all_recharge中是否存在该订单
    	$tbl_all_recharge_sql = "select * from `tbl_all_recharge` where order_ping_tai=$order_platform and orderid='".mysql_real_escape_string($orderId,$db_link)."'";
	    $query_result = mysql_query($tbl_all_recharge_sql,$db_link);
    	if (!$query_result) {
			writeLog("error:".mysql_error($db_link)." sql:".$tbl_all_recharge_sql, LOG_NAME::ERROR_LOG_FILE_NAME);
			mysql_close($db_link);
			return ErrorCode::DB_OPERATION_FAILURE;			
		}
		$row = mysql_num_rows($query_result);
		if ($row > 0) {
			mysql_close($db_link);
			return ErrorCode::PROCESSED_ORDER;
		}
		mysql_close($db_link);
		return ErrorCode::NOT_FIND_ORDER;
    }
    
 	//查找db中商品信息
    public function get_db_product_info($digitid,$product_id)
    {
    	$res_return = array();
	    $db_key = 'default';
		$db_link = my_connect_mysql($db_key);
		if (!$db_link) {
			$res_return['error_code'] = ErrorCode::DB_OPERATION_FAILURE; 
			return $res_return;
		}
    	//先判断在tbl_recharge中是否存在该记录
    	$tbl_recharge_sql = "select * from `tbl_recharge` where playerid=$digitid and product_id='$product_id' order by `successtime` desc limit 1";
	    $query_result = mysql_query($tbl_recharge_sql,$db_link);
    	if (!$query_result) {
			writeLog("error:".mysql_error($db_link)." sql:".$tbl_recharge_sql, LOG_NAME::ERROR_LOG_FILE_NAME);
			mysql_close($db_link);
			$res_return['error_code'] = ErrorCode::DB_OPERATION_FAILURE; 
			return $res_return;		
		}
		$row = mysql_num_rows($query_result);
		if ($row > 0) {	
				
			$row_value = mysql_fetch_array($query_result,MYSQL_ASSOC);
    		$shop_type = $row_value['shop_type'];
    		if (2 == $shop_type) {//推荐商品
    			$res_return['error_code'] = ErrorCode::ERROR_TUIJIAN_PRODUCT_ONLY_BUY_ONCE; 
    			mysql_close($link);
    			return $res_return;
    		}
			if (1 == $shop_type) {//月卡商品
				$time_sec = strtotime($row_value['successtime']);
				if (time() - $time_sec < 27*86400) {
					$res_return['error_code'] = ErrorCode::ERROR_YUEKA_IS_NOT_IN_DEAD_TIME; 
					mysql_close($link);
    				return $res_return;	
				}
    		}
    		$res_return['error_code'] = ErrorCode::SUCCESS;
    		mysql_close($link);
    		return $res_return;	
		}
		
		//再判断tbl_all_recharge中是否存在该订单
    	$tbl_all_recharge_sql = "select * from `tbl_all_recharge` where playerid=$digitid and product_id='$product_id' order by `successtime` desc limit 1";
	    $query_result = mysql_query($tbl_all_recharge_sql,$db_link);
    	if (!$query_result) {
			writeLog("error:".mysql_error($db_link)." sql:".$tbl_all_recharge_sql, LOG_NAME::ERROR_LOG_FILE_NAME);
			mysql_close($db_link);
			return ErrorCode::DB_OPERATION_FAILURE;			
		}
		$row = mysql_num_rows($query_result);
		if ($row > 0) {
			$row_value = mysql_fetch_array($query_result,MYSQL_ASSOC);
    		$shop_type = $row_value['shop_type'];
    		if (2 == $shop_type) {//推荐商品
    			$res_return['error_code'] = ErrorCode::ERROR_TUIJIAN_PRODUCT_ONLY_BUY_ONCE; 
    			mysql_close($link);
    			return $res_return;
    		}
			if (1 == $shop_type) {//月卡商品
				$time_sec = strtotime($row_value['successtime']);
				if (time() - $time_sec < 27*86400) {
					$res_return['error_code'] = ErrorCode::ERROR_YUEKA_IS_NOT_IN_DEAD_TIME; 
					mysql_close($link);
    				return $res_return;	
				}
    		}
    		$res_return['error_code'] = ErrorCode::SUCCESS;
    		mysql_close($link);
    		return $res_return;	
		}
		$res_return['error_code'] = ErrorCode::ERROR_NOT_FIND_THE_PRODUCT_INFO;
		mysql_close($db_link);
		return $res_return;
    }
    
    //从tbl_recharge_order表(下单表)中获取玩家信息
    public function get_game_order_player_info($game_order) {
    	$res_return = array();
	    $db_key = 'default';
		$db_link = my_connect_mysql($db_key);
		if (!$db_link) {
			writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)." db connect error:".mysql_error(), LOG_NAME::ERROR_LOG_FILE_NAME);
			return false;
		} 	
		$select_sql = "select `id`,`digitid`,`areaid`,`shop_type` from `tbl_recharge_order` where `id`=".intval($game_order);
		$query_result = mysql_query($select_sql,$db_link);
		if (!$query_result || 0 >= mysql_num_rows($query_result)) {
			writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)."select error:".mysql_error()." sql:".$select_sql, LOG_NAME::ERROR_LOG_FILE_NAME);
			return false;
		}
		$res_return = mysql_fetch_array($query_result,MYSQL_ASSOC);
		return $res_return;
    }

    //将收到的并且经过验证的订单通知信息写到db
    public function order_info_write_to_db ($app_id,$game_order_player_info = array(),$user_platform_id,$order_platform_id,$transaction_id,$currency,$production_info = array()) {
    	if (!isset($game_order_player_info) || empty($game_order_player_info)
    	|| !isset($production_info) || empty($production_info)) {
    		return false;
    	}
    	$db_key = 'default';
		$db_link = my_connect_mysql($db_key);
		if (!$db_link) {
			writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)." db connect error:".mysql_error(), LOG_NAME::ERROR_LOG_FILE_NAME);
			return false;
		}
		
		$game_order_id = $game_order_player_info['id'];
		$digit_id = $game_order_player_info['digitid'];
		$area_id = $game_order_player_info['areaid'];
		$cash = $production_info['cash'];
		$yuanbao = $production_info['yuanbao'];
		$shop_type = $production_info['shop_type'];
		$item_id = $production_info['item_id'];
		$product_id_str = (isset($production_info['product_id_str']) ? $production_info['product_id_str'] : "");
		
		$insert_tbl_recharge_sql = "insert into `tbl_recharge` (`Id`, `playerid`, `area_no`, `money`, `yuanbao`, `orderid`, `ping_tai`,`shop_type`,`item_id`,`order_ping_tai`,`product_id`,`currency`,`app_id`) values
		($game_order_id,$digit_id,$area_id,$cash,$yuanbao,'".mysql_real_escape_string($transaction_id,$db_link)."',
		$user_platform_id,$shop_type,$item_id,$order_platform_id,'$product_id_str','$currency','$app_id')";
		
   		mysql_query($insert_tbl_recharge_sql,$db_link);
		$errno = mysql_errno($db_link);
		if (0 != $errno && 1062 != $errno) {
			writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)." error:".mysql_error($db_link)." sql:".$insert_tbl_recharge_sql, LOG_NAME::ERROR_LOG_FILE_NAME);
			mysql_close($db_link);
			return false;	
		}
		if (1062 == $errno) {//主键重复
			writeLog(get_str_log_prex(__FILE__,__LINE__,__FUNCTION__)."area_id:".$area_id." digit_id:".$digit_id." game_order_id:".$game_order_id." has been proccessed", LOG_NAME::ERROR_LOG_FILE_NAME);
			mysql_close($db_link);
			return true;
		}
		mysql_close($db_link);
		writeLog("server_id:".$area_id." player_digitid:".$digit_id." charge success,cash:".$cash." currency:".$currency." yuanbao:".$yuanbao." item_id:".$item_id,LOG_NAME::CHARGE_SUCCESS_LOG_FILE_NAME);
		return true;	
    }
}