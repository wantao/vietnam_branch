<?php 
	/*函数功能：限制结束时间和开始时间在同一个月内
	     参数格式：$start_date="xxxx-xx-xx" $end_date="xxxx-xx-xx",$end_time="xx:xx:xx"
	    返回:限制后的$end_date
	*/
	include_once($system_path.'helpers/date_helper.php');
	function limit_end_date_and_start_date_in_the_same_month($start_date,$end_date,$end_time) {	
		$start_date_param = explode("-", $start_date);
		$start_year = $start_date_param[0];
		$start_month = $start_date_param[1];
		
		$end_date_param = explode("-", $end_date);
		$end_year = $end_date_param[0];
		$end_month = $end_date_param[1];
		$end_days = $end_date_param[2];
			
		if ($end_year == $start_year) {
			if ($end_month != $start_month) {
				$end_days = days_in_month($start_month,$start_year);
				if (!empty($end_time)) {
					return date("Y-m-d H:i:s", mktime(23, 59, 59, $start_month, $end_days, $start_year));	
				}
				return date("Y-m-d", mktime(0, 0, 0, $start_month, $end_days, $start_year));
			}
		} else {
			$end_days = days_in_month($start_month,$start_year);
			if (!empty($end_time)) {
				return date("Y-m-d H:i:s", mktime(23, 59, 59, $start_month, $end_days, $start_year));	
			}
			return date("Y-m-d", mktime(0, 0, 0, $start_month, $end_days, $start_year));
		}
		if (!empty($end_time)) {
			$end_time_param = explode(":", $end_time);	
			return date("Y-m-d H:i:s", mktime($end_time_param[0],$end_time_param[1],$end_time_param[2],$end_month, $end_days, $end_year));
		}
		return date("Y-m-d", mktime(0, 0, 0, $end_month, $end_days, $end_year));
	}
	
	function is_sub_url_string($url_arry,$url_string) {
		if (empty($url_string) || !isset($url_arry)) {
			return false;
		}
		foreach($url_arry as $one_url){
			if (stripos($one_url['url'],$url_string)) {
				return true;
			}
		}
		return false;
	}
?>