<?php
class Vip_level_model extends CI_Model {
	var $COUNT_PER_PAGE = 10;
	public function search($area_id){
		$this->load->database($area_id."_game_db");
		$query = $this->db->query("select `viplevel`,count(`digitid`) as `count` from `player_yuanbao` group by `viplevel`");
		$result = $query->result();
		$this->db->close();
		return $result;
	}
}
?>