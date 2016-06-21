<?php
class Guide_step_model extends CI_Model {
	var $COUNT_PER_PAGE = 10;
	public function search($area_id){
		$this->load->database($area_id."_game_db");
		$query = $this->db->query("SELECT guidestep, count(guidestep) as N FROM `player_info` GROUP BY guidestep ORDER BY guidestep ");
		$result = $query->result();
		$this->db->close();
		return $result;
	}
}
?>