<?php
class Yuanbao_trace_model extends CI_Model {
	
	
	public function get_yuanbao_trace($player_id,$date) {
		$this->load->model("common_model");
		$player_info = $this->common_model->get_playerid_info($player_id);	
		if (!$player_info) {
			exit("db operate error or cannot find playerid:".$player_id);
		}	
		$db = $this->load->database($player_info->areaid . '_game_log', true);
		$select_sql = "select * from yuanbaotrace$date where player_id=$player_id";
		$query = $db->query($select_sql);
		$result = $query->result();
		$db->close();
		return $result;
	}
}
?>