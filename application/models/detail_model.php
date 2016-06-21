<?php
class Detail_model extends CI_Model {
	var $COUNT_PER_PAGE = 10;
	//当天创建角色数量
	public function get_dnu($area_id, $date){
		$db = $this->load->database($area_id."_game_db", true);
		$query = $db->query("select count(*) as count from `player_base` where day(create_time) = day('$date')");
		$result = $query->result();
		$db->close();
		if(count($result) == 0){
			return 0;
		}
		return $result[0]->count;
	}
	//当天登陆角色数量
	public function get_dau($area_id, $date){
		$params = explode("-", $date);
		$year = $params[0];
		$month = $params[1];
		$db = $this->load->database($area_id."_game_log", true);
		$query = $db->query(sprintf("select count(*) as count from `firstlogintrace%04d%02d` where day(today_first_login_time) = day('$date')", $year, $month));
		$result = $query->result();
		$db->close();
		if(count($result) == 0){
			return 0;
		}
		return $result[0]->count;
	}
	//当天同时在线人数最大值
	public function get_max_player_count($area_id, $date){
		$params = explode("-", $date);
		$year = $params[0];
		$month = $params[1];
		$db = $this->load->database($area_id."_game_log", true);
		$query = $db->query(sprintf("select max(playernumber) as count from `onlinenumberlog%04d%02d` where day(logtime) = day('$date')", $year, $month));
		$result = $query->result();
		$db->close();
		if(count($result) == 0){
			return 0;
		}
		return (is_null($result[0]->count)? 0 : $result[0]->count);
	}
	//当天充值人数，次数，总额
	public function get_charge_info($area_id, $date){
		$db = $this->load->database("default", true);
		$query = $db->query("select count(distinct playerid) as player, count(*) as times, sum(money) as money from `tbl_all_recharge` where `area_no` in (select id  from tbl_server where current_code=%d) and day(activetime) = day('$date')");
		$result = $query->result();
		$db->close();
		return $result[0];
	}
	public function get_exp_changed_new_player_count($area_id, $date){
		$params = explode("-", $date);
		$year = $params[0];
		$month = $params[1];
		$db = $this->load->database($area_id."_game_log", true);
		$query = $db->query(sprintf("select count(distinct digitid) as count from `exptrace%04d%02d` where `cur` = `change` and day(activetime) = day('$date')", $year, $month));
		$result = $query->result();
		$db->close();
		if(count($result) == 0){
			return 0;
		}
		return $result[0]->count;
	}
	
	
	
	//********************批量取数据**********************
	//当天创建角色数量
	public function get_dnu_range($area_id, $start_date, $end_date){
		$db = $this->load->database($area_id."_game_db", true);
		$query = $db->query("select `digitid`, `create_time` from `player_base` where day(create_time) >= day('$start_date') and day(create_time) <= day('$end_date')");
		$result = $query->result();
		//result: (digitid, create_time)
		$db->close();
		return $result;
	}
	public function get_dnu_map($result){
		//result: (digitid, create_time)
		$map = array();
		foreach($result as $row){
			$date = $this->get_date($row->create_time);
			if(isset($map[$date])){
				$map[$date] ++;
			}else{
				$map[$date] = 1;
			}
		}
		return $map;
	}
	//当天登陆角色数量
	public function get_dau_range($area_id, $start_date, $end_date){
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
			$select = $select . sprintf(" select `digitid`, `today_first_login_time` from firstlogintrace%04d%02d where day(today_first_login_time) >= day('$start_date') and day(today_first_login_time) <= day('$end_date') ", $start_year, $start_month);
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
		
		$query = $db->query($select);
		$result = $query->result();
		//result: (digitid, today_first_login_time)
		$db->close();
		return $result;
	}
	
	public function get_dau_map($result){
		//result: (digitid, today_first_login_time)
		$map = array();
		foreach($result as $row){
			$date = $this->get_date($row->today_first_login_time);
			if(isset($map[$date])){
				$map[$date] ++;
			}else{
				$map[$date] = 1;
			}
		}
		return $map;
	}
	//当天同时在线人数最大值
	public function get_max_player_range($area_id, $start_date, $end_date){
		$db = $this->load->database($area_id."_game_log", true);
		//$query = $db->query(sprintf("select max(playernumber) as count from `onlinenumberlog%04d%02d` where day(logtime) = day('$date')", $year, $month));
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
			$select = $select . sprintf(" select `playernumber`, `logtime` from onlinenumberlog%04d%02d where day(logtime) >= day('$start_date') and day(logtime) <= day('$end_date') ", $start_year, $start_month);
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
		$query = $db->query($select);
		$result = $query->result();
		//result: (playernumber, logtime)
		$db->close();
		return $result;
	}
	
	public function get_max_player_map($result){
		//result: (playernumber, logtime)
		$map = array();
		foreach($result as $row){
			$date = $this->get_date($row->logtime);
			if(isset($map[$date])){
				if($map[$date] < $row->playernumber){
					$map[$date] = $row->playernumber;
				}
			}else{
				$map[$date] = $row->playernumber;
			}
		}
		return $map;	
	}
	//当天充值人数，次数，总额
	public function get_charge_info_range($area_id, $start_date, $end_date){
		$db = $this->load->database("default", true);
		$query = $db->query("select `playerid`, `money`, `activetime` from `tbl_all_recharge` where `area_no` in (select id  from tbl_server where current_code=$area_id) and day(activetime) >= day('$start_date') and day(activetime) <= day('$end_date') order by `playerid`");
		$result = $query->result();
		//result: (playerid, money, activetime) sorted by playerid
		$db->close();
		return $result;
	}
	public function get_charge_player_map($result){
		//result: (playerid, money, activetime)
		$map = array();
		$last_id = 0;
		foreach($result as $row){
			$date = $this->get_date($row->activetime);
			if(isset($map[$date])){
				if($row->playerid != $last_id){
					$map[$date] ++;
				}
			}else{
				$map[$date] = 1;
			}
			$last_id = $row->playerid;
		}
		return $map;	
	}
	public function get_charge_times_map($result){
		//result: (playerid, money, activetime)
		$map = array();
		foreach($result as $row){
			$date = $this->get_date($row->activetime);
			if(isset($map[$date])){
				$map[$date] ++;
			}else{
				$map[$date] = 1;
			}
			$last_id = $row->playerid;
		}
		return $map;	
	}
	public function get_charge_money_map($result){
		//result: (playerid, money, activetime)
		$map = array();
		foreach($result as $row){
			$date = $this->get_date($row->activetime);
			if(isset($map[$date])){
				$map[$date] += $row->money;
			}else{
				$map[$date] = $row->money;
			}
		}
		return $map;
	}
	public function get_exp_changed_new_player_range($area_id, $start_date, $end_date){
		$db = $this->load->database($area_id."_game_log", true);
		//$query = $db->query(sprintf("select count(distinct digitid) as count from `exptrace%04d%02d` where `cur` = `change` and day(activetime) = day('$date')", $year, $month));
		$start_date_param = explode("-", $start_date);
		$start_year = $start_date_param[0];
		$start_month = $start_date_param[1];
		
		$end_date_param = explode("-", $end_date);
		$end_year = $end_date_param[0];
		$end_month = $end_date_param[1];
		
		$dates = $this->_get_log_tables($area_id, $db->database, "exptrace");
		$select = "";
		while($end_year > $start_year || ($end_year == $start_year && $end_month >= $start_month)){
			if(in_array(sprintf("%04d%02d", $start_year, $start_month), $dates)){		
				if(strlen($select) != 0){
					$select = $select . " union all ";
				}
			$select = $select . sprintf(" select `digitid`, `activetime` from exptrace%04d%02d where `cur` = `change` and day(activetime) >= day('$start_date') and day(activetime) <= day('$end_date') ", $start_year, $start_month);
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
		$query = $db->query($select);
		$result = $query->result();
		//result: (digitid, activetime)
		$db->close();
		return $result;
	}
	public function get_real_new_player_map($result){
		//result: (digitid, activetime)
		$map = array();
		foreach($result as $row){
			$date = $this->get_date($row->activetime);
			if(isset($map[$date])){
				$map[$date] ++;
			}else{
				$map[$date] = 1;
			}
		}
		return $map;
	}
	private function get_date($date_string){
		return substr($date_string, 0, 10);
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