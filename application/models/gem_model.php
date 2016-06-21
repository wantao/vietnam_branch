<?php
class Gem_model extends CI_Model {
	var $COUNT_PER_PAGE = 10;
	var $COST = 0;
	var $CHARGE = 1;
	public function search($area_id, $start_date, $start_time, $end_date, $end_time, $player_id, $desc, $type, $page){
		$this->load->database($area_id."_game_log");
		
		$start_date_param = explode("-", $start_date);
		$start_year = $start_date_param[0];
		$start_month = $start_date_param[1];
		
		$end_date_param = explode("-", $end_date);
		$end_year = $end_date_param[0];
		$end_month = $end_date_param[1];
		
		$db = $this->load->database($area_id."_information_schema", true);
		//$db = $this->load->database("information_schema", true);
		$query = $db->query("select table_name from tables where table_name like 'yuanbaotrace%' and table_schema = '".$this->db->database."'");
		$tables = $query->result();
		$db->close();
		$dates = array();
		foreach($tables as $table){
			$date = substr($table->table_name, strlen("yuanbaotrace"));
			array_push($dates, $date);
		}
		
		$select = "";
		while($end_year > $start_year || ($end_year == $start_year && $end_month >= $start_month)){
			if(in_array(sprintf("%04d%02d", $start_year, $start_month), $dates)){
				if(strlen($select) != 0){
					$select = $select . " union all ";
				}
				$select = $select . sprintf(" select `player_id`, `playername`, `nchange`, `activetime` from `player_base` as A, yuanbaotrace%04d%02d as B where B.player_id = A.digitid and B.activetime >= \"%s %s\" and B.activetime <= \"%s %s\" ", $start_year, $start_month, $start_date, $start_time, $end_date, $end_time);
				if($player_id){
					$select = $select . "and `player_id` = ".$this->db->escape($player_id)." ";
				}
				if($desc){
					$select = $select . "and B.strDesc = " . $this->db->escape($desc) . " ";
				}
				if($type == $this->COST){
					$select = $select . "and `nchange` < 0 ";
				}else if($type == $this->CHARGE){
					$select = $select . "and `nchange` > 0 ";
				}
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
		$select = $select . "order by `activetime` desc ";
		$start_index = ($page - 1) * $this->COUNT_PER_PAGE;
		$count = $this->COUNT_PER_PAGE + 1;
		$select = $select . " limit $start_index, $count ";
		
		$query = $this->db->query($select);
		$ary = $query->result();
		$this->db->close();
		return $ary;
	}
	public function get_count_per_page(){
		return $this->COUNT_PER_PAGE;
	}
	public function make_url($area_id, $start_date, $start_time, $end_date, $end_time, $player_id, $desc, $type, $page = 1){
		$url = "/index.php/gem/execute/_{$area_id}_/_{$start_date}%20{$start_time}_/_{$end_date}%20{$end_time}_/_{$player_id}_/_{$desc}_/_{$type}_/_{$page}_";
		return $url;
	}
	public function get_type(){
		return array(
			array("name" => "消费", "value" => $this->COST),
			array("name" => "充值", "value" => $this->CHARGE)
		);
	}
}
?>