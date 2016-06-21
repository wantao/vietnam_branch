<?php
class Login_ip_model extends CI_Model {
	
	
	public function get_behavior_info($area_id, $player_id, $date) {	
		$db = $this->load->database($area_id . '_game_log', true);
		$select_sql = "select digitid,IP ,activetime from `loginouttrace$date` where digitid = $player_id and opt = 1 ORDER BY activetime desc limit 1";
		$query = $db->query($select_sql);
		$result = $query->result();
		$db->close();
		return $result;
	}
}
?>