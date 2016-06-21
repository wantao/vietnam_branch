<?php
	
	class LOG_NAME
	{
		const ERROR_LOG_FILE_NAME = "error_log";
		const CHARGE_SUCCESS_LOG_FILE_NAME = "charge_success";
	}
	
    function writeLog($msg,$log_dir){
		if (!file_exists($log_dir) && !mkdir($log_dir)){
			$err_logFile = date('Y-m-d').'.log';
 			$msg = date('H:i:s').': '.' mkdir '."$log_dir"." error"."\r\n";
 			file_put_contents($logFile,$msg,FILE_APPEND);	

 			$logFile = 'log-'.date('Y-m-d').'.log';
 			$msg = date('H:i:s').': '.$msg."\r\n";
 			file_put_contents($logFile,$msg,FILE_APPEND);
 			return;
		}
 		$logFile = "$log_dir".'/'.date('Y-m-d').'.log';
 		$msg = date('H:i:s').': '.$msg."\r\n";
 		file_put_contents($logFile,$msg,FILE_APPEND);
	}
	
	//获取日志前缀，记录哪个文件，哪一行出现的日志
	function get_str_log_prex($file_name,$line_num,$function_name) {
		return "[".$file_name."][".$line_num."][".$function_name."] ";	
	}
?>