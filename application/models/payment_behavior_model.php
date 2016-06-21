<?php
class Payment_behavior_model extends CI_Model {
	
	
	public function get_behavior_info($area_id,$date) {	
		$db = $this->load->database($area_id . '_game_log', true);
		$select_sql = "select strDesc,count(strDesc) as count ,SUM(nchange) as nchanges from `yuanbaotrace$date` where nchange < 0 GROUP BY strDesc ORDER BY nchanges";
		$query = $db->query($select_sql);
		$result = $query->result();
		$db->close();
		return $result;
	}
}
?>