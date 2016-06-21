<?php
	
function cmp($ary1 = array("itemid" => "","name" => "","buy_count" => "","buy_desc" => ""),$ary2 = array("itemid" => "","name" => "","buy_count" => "","buy_desc" => "")) {
	return intval($ary1["buy_count"]) <= intval($ary2["buy_count"]);	
}
class Props_purchase_list_model extends CI_Model {
	var $COUNT_PER_PAGE = 10;
	//单区道具购买榜
	public function get_props_purchase_list($area_id, $start_date_time,$end_date_time){	
		$start_date_time_params = explode(" ", $start_date_time);
		$end_date_time_params = explode(" ", $end_date_time);
		$params = explode("-", $start_date_time_params[0]);
		$year = $params[0];
		$month = $params[1];
		$db_game_log = $this->load->database($area_id."_game_log", true);
		$result=array();
		if (!$db_game_log) {
			echo "db_game_log connector failure"."<br>";
			return $result;	
		}
		$db_game_db = $this->load->database($area_id."_game_db", true);
		if (!$db_game_db) {
			echo "db_game_db connector failure"."<br>";
			return $result;	
		}
		
		//物品
		//异界入侵商店
		$trace_tbl = sprintf("goodstrace%04d%02d",$year,$month);
		$property_tbl = "c_goods_property";
		$statistics_result = $this->statistics_trace_results($db_game_log,$trace_tbl,11,$start_date_time,$end_date_time);
		if (isset($statistics_result)) {
			$result = $this->add_item_name_to_statistics($db_game_db,$property_tbl,$statistics_result,$result);	
		}
		//公会商店
		$statistics_result = $this->statistics_trace_results($db_game_log,$trace_tbl,13,$start_date_time,$end_date_time);
		if (isset($statistics_result)) {
			$result = $this->add_item_name_to_statistics($db_game_db,$property_tbl,$statistics_result,$result);	
		}
		
		//宠物
		//异界入侵商店
		$trace_tbl = sprintf("petstrace%04d%02d",$year,$month);
		$property_tbl = "c_pet_property";
		$statistics_result = $this->statistics_trace_results($db_game_log,$trace_tbl,11,$start_date_time,$end_date_time);
		if (isset($statistics_result)) {
			$result = $this->add_item_name_to_statistics($db_game_db,$property_tbl,$statistics_result,$result);	
		}
		//公会商店
		$statistics_result = $this->statistics_trace_results($db_game_log,$trace_tbl,13,$start_date_time,$end_date_time);
		if (isset($statistics_result)) {
			$result = $this->add_item_name_to_statistics($db_game_db,$property_tbl,$statistics_result,$result);	
		}
		//var_dump($result);
		usort($result,"cmp");
		//var_dump($result);
		$db_game_log->close();	
		$db_game_db->close();		
		return $result;
	}
	
	

	public function statistics_trace_results($db_game_log,$trace_tbl_name,$shop_type,$start_date_time,$end_date_time) {
		if (!$db_game_log || !$db_game_log->table_exists($trace_tbl_name)) {
			return array();
		}
		$trace_sql = sprintf("select `itemid`,count(`itemid`) as count,`desc` from $trace_tbl_name where `desc` like '%%b_s_g %d%%' and `activetime` >= '%s' and `activetime` <= '%s' GROUP BY `itemid`",$shop_type,$start_date_time,$end_date_time);
		$trace_query = $db_game_log->query($trace_sql);
		return ($trace_query ? $trace_query->result() : array());	
	}
	
	public function add_item_name_to_statistics($db_game_db,$property_tbl_name,$trace_query_result,$result) {
		if (!$db_game_db || !isset($trace_query_result) || !$db_game_db->table_exists($property_tbl_name)) {
			return array();	
		}
		foreach($trace_query_result as $row){		
			$property_query = $db_game_db->query("select `name` from $property_tbl_name where `id`='$row->itemid';");
			$property_result = $property_query->result();
			$one_result = array(
				"itemid" => $row->itemid,
				"name" => $property_result[0]->name,
				"buy_count" => $row->count,
				"buy_desc" => $row->desc,
			);
			array_push($result, $one_result);
		}	
		return $result;
	}
}
?>