<?php
class Charge_model extends CI_Model {
	var $COUNT_PER_PAGE = 10;
	public function search($area_id, $start_date, $start_time, $end_date, $end_time, $order_id, $player_name, $page){
		$this->load->database("default");
		$select = "select `area_no`, `name`, `money`, `yuanbao`, `activetime`, `has_add_to_game`, `successtime`, `orderid`,`app_id` from `tbl_all_recharge` as A, `tbl_idname` as B where A.activetime >= \"$start_date $start_time\" and A.activetime <= \"$end_date $end_time\" and A.area_no = $area_id  and A.playerid = B.id ";
		if(strlen($order_id) != 0){
			$select = "select `area_no`, `name`, `money`, `yuanbao`, `activetime`, `has_add_to_game`, `successtime`, `orderid`,`app_id` from `tbl_all_recharge` as A, `tbl_idname` as B where A.activetime >= \"$start_date $start_time\" and A.activetime <= \"$end_date $end_time\"  and A.playerid = B.id ";
			$select = $select . " and A.orderid = ".$this->db->escape($order_id)." ";
		}else if(strlen($player_name) != 0){
			$select = $select . " and B.name = ".$this->db->escape($player_name)." ";
		}
		if ($page > 0) {
			$start_index = ($page - 1) * $this->COUNT_PER_PAGE;
			$count = $this->COUNT_PER_PAGE + 1;
			$select = $select . " order by `activetime` desc limit $start_index, $count";	
		} else {
			$select = $select . " order by `activetime` desc";	
		}
		$query = $this->db->query($select);
		$ary = $query->result();
		$this->db->close();
		return $ary;
	}
	public function get_count_per_page(){
		return $this->COUNT_PER_PAGE;
	}
	public function make_url($area_id, $start_date, $start_time, $end_date, $end_time, $player_name, $page = 1){
		$url = "/index.php/charge/execute/_{$area_id}_/_{$start_date}%20{$start_time}_/_{$end_date}%20{$end_time}_/_{$player_name}_/_{$page}_";
		return $url;
	}
	public function get_platform(){
		$this->load->database("default");
		$query = $this->db->get('tbl_platform');
		$ary = $query->result();
		$this->db->close();
		return $ary;
	}
	public function get_player_charge_info($player_name,$area_id, $start_date,$start_time,$end_date,$end_time) {
		if(strlen($player_name) == 0){
			return NUll;
		}
		$this->load->database("default");
		$select = "select sum(money) as total_money, count(*) as total_times from `tbl_all_recharge` as A, `tbl_idname` as B where A.playerid = B.id and A.`area_no` = $area_id and A.`activetime` >= '$start_date $start_time' and A.activetime <= '$end_date $end_time' and B.name = ".$this->db->escape($player_name)."";
		$query = $this->db->query($select);
		$result = $query->result();
		$this->db->close();
		return array(
			"player_name" => $player_name,
			"total_money" => intval($result[0]->total_money),
			"total_times" => $result[0]->total_times,
		);
	}
}
?>