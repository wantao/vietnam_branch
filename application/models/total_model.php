<?php
class Total_model extends CI_Model {
	public function get_total_player_number($area_id){
		$db = $this->load->database($area_id."_game_db", true);
		$query = $db->query("select count(*) as count from `player_base`");
		$result = $query->result();
		$db->close();
		if(count($result) == 0){
			return 0;
		}else{
			return $result[0]->count;
		}
	}
	public function get_max_online_player_number($area_id, $start_date, $end_date){
		$db = $this->load->database($area_id."_game_log", true);
		$start_date_param = explode("-", $start_date);
		$start_year = $start_date_param[0];
		$start_month = $start_date_param[1];
		
		$end_date_param = explode("-", $end_date);
		$end_year = $end_date_param[0];
		$end_month = $end_date_param[1];
		$dates = $this->_get_log_tables($area_id, $db->database, "onlinenumberlog");
		$select = "";
		while($end_year > $start_year || ($end_year == $start_year && $end_month >= $start_month)){
			if(in_array(sprintf("%04d%02d", $start_year, $start_month), $dates)){
				if(strlen($select) != 0){
					$select = $select . " union all ";
				}
				$select = $select . sprintf(" select playernumber from onlinenumberlog%04d%02d where `logtime` >= \"%s 00:00:00\" and `logtime` <= \"%s 23:59:59\" ", $start_year, $start_month, $start_date, $end_date);
			}
			if($start_month < 12){
				$start_month ++;
			}else{
				$start_year ++;
				$start_month = 1;
			}
		}
		if(strlen($select) == 0){
			return 0;
		}
		$select = $select . " order by playernumber desc limit 0, 1 ";
		$query = $db->query($select);
		$result = $query->result();
		
		if(count($result) == 0){
			return 0;
		}else{
			return $result[0]->playernumber;
		}
	}
	public function get_charge_info($area_id, $start_date, $end_date){
		$db = $this->load->database("default", true);
		$query = $db->query(sprintf("select count(distinct playerid) as total_player, count(*) as total_times, sum(money) as total_money from `tbl_all_recharge` where `area_no` in (select id  from tbl_server where current_code=%d) and `activetime` >= \"%s 00:00:00\" and `activetime` <= \"%s 23:59:59\" ", $area_id, $start_date, $end_date));
		$result = $query->result();
		$db->close();
		return $result[0];
	}
	public function get_login_player_number($area_id, $start_date, $end_date){
		$db = $this->load->database($area_id."_game_log", true);
		
		$start_date_param = explode("-", $start_date);
		$start_year = $start_date_param[0];
		$start_month = $start_date_param[1];
		
		$end_date_param = explode("-", $end_date);
		$end_year = $end_date_param[0];
		$end_month = $end_date_param[1];
		
		$dates = $this->_get_log_tables($area_id, $db->database, "firstlogintrace");
		$select = "";
		while($end_year > $start_year || ($end_year == $start_year && $end_month >= $start_month)){
			if(in_array(sprintf("%04d%02d", $start_year, $start_month), $dates)){
				if(strlen($select) != 0){
					$select = $select . " union all ";
				}
				$select = $select . " select count(*) as total_login from firstlogintrace%04d%02d where `today_first_login_time` >= '$start_date' and `logtime` <= '$end_date' ";
			}
			if($start_month < 12){
				$start_month ++;
			}else{
				$start_year ++;
				$start_month = 1;
			}
		}
		if(strlen($select) == 0){
			return array();
		}
	}
	private function _get_log_tables($area_id, $database, $name_without_date){
		$db = $this->load->database($area_id."_information_schema", true);
		//$db = $this->load->database("information_schema", true);
		$query = $db->query("select table_name from tables where table_name like '$name_without_date%' and table_schema = '$database'");
		$tables = $query->result();
		$db->close();
		$result = array();
		foreach($tables as $table){
			$date = substr($table->table_name, strlen($name_without_date));
			array_push($result, $date);
		}
		return $result;
	}
}
?>