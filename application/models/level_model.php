<?php
class Level_model extends CI_Model {
	var $COUNT_PER_PAGE = 10;
	public function search($area_id){
		$this->load->database($area_id."_game_db");
		$query = $this->db->query("select `level`, count(*) as `count` from `player_exp` group by `level`");
		$result = $query->result();
		$this->db->close();
		return $result;
	}
}
?>