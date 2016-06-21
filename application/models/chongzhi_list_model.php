<?php
class Chongzhi_list_model extends CI_Model {
	var $COUNT_PER_PAGE = 10;
	//单区充值榜
	public function get_chongzhi_list($area_id, $start_date_time,$end_date_time){			
		$db = $this->load->database("default", true);
		$sql = sprintf("select item_id,count(item_id) as count,sum(money) as sum from tbl_all_recharge where area_no = %d and successtime >= '%s' and successtime <= '%s' GROUP BY item_id order by sum desc",$area_id,$start_date_time,$end_date_time);
		$query = $db->query($sql);
		$result = $query->result();
		$result_map = array();
		foreach($result as $row){
			$charge_money_frt = number_format($row->sum,2,'.',',');
			$one_result = array(
				"item_id" => $row->item_id,
				"count" => $row->count,
				"sum" => $charge_money_frt,
			);
			array_push($result_map, $one_result);
		}
		$db->close();	
		return $result_map;
	}

}
?>