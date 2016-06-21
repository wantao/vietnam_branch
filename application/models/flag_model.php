<?php 
class Flag_model extends CI_Model {
	public function search($area_id){
		$this->load->database($area_id."_game_db");
		$query = $this->db->get("system_flag");
		$ary = $query->result();
		$this->db->close();
		return $ary;
	}
}
?>