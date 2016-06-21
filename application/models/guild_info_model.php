<?php
class Guild_info_model extends CI_Model {
	
	
	public function get_guild_info($area_id) {	
		$db = $this->load->database($area_id . '_game_db', true);
		$select_sql = "select C.`lianmeng_id`,C.`name`,C.`level`,GROUP_CONCAT(conv( oct( C.`digitid` ) , 8, 10 ) SEPARATOR ':') as `lianmeng_member` from 
		(select A.`lianmeng_id`,A.`name`,A.`level`,B.`digitid` from `player_lianmeng` as A,player_lianmeng_member as B where A.lianmeng_id=B.lianmeng_id and A.delete_flag=0) as C GROUP BY C.lianmeng_id;";
		$query = $db->query($select_sql);
		$result = $query->result();
		$db->close();
		return $result;
	}
}
?>