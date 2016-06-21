<?php 
class Player_equipment_model extends CI_Model {
	public function __construct(){
		parent::__construct();
	}
	
	public function get_equipment_info($player_id) {
		$this->load->model("common_model");
		$player_info = $this->common_model->get_playerid_info($player_id);	
		if (!$player_info) {
			exit("db operate error or cannot find playerid:".$player_id);
		}	
		$db = $this->load->database($player_info->areaid . '_game_db', true);
		$select_sql = "select A.*,B.name as name from player_equip as A,c_goods_property as B where A.digitid=$player_id and A.has_delete=0 and A.goods_id=B.id";
		$query = $db->query($select_sql);
		$result = $query->result();
		$db->close();
		return $result;
	}
}
?>