<?php
class Checkpoint_process_model extends CI_Model {
	
	
	public function get_checkpoint_process_info($area_id,$type) {	
		$db = $this->load->database($area_id . '_game_db', true);
		$select_sql = "select chapter,checkpoint,count(digitid) as count FROM `player_checkpoint` where chapter_kind=$type GROUP BY chapter,checkpoint";
		$query = $db->query($select_sql);
		$result = $query->result();
		$db->close();
		return $result;
	}
	
	public function get_type_list() {
		$ret_array = array(
			array('id'=>0,'name'=>LG_PUTONG_CHAPTER),
			array('id'=>1,'name'=>LG_JINGYING_CHAPTER),
			array('id'=>2,'name'=>LG_ACTIVE_CHAPTER),
			array('id'=>3,'name'=>LG_OTHER_WORLD_INTRUSION_CHAPTER),
			array('id'=>4,'name'=>LG_GUILD_CHAPTER),
			array('id'=>5,'name'=>LG_OTHER_WORLD_EXPEDITION_CHAPTER),
		);
		return $ret_array;
	}
	
	public function add_selected_key_for_typelist($typelist){
		if (empty($typelist)) {
			return false;
		}
		$area_arry = array();
		foreach($typelist as $type){
			$area_arry_tmp = array();
			$area_arry_tmp['id'] = $type['id'];
			$area_arry_tmp['name'] = $type['name'];
			$area_arry_tmp['selected'] = 0;	
			array_push($area_arry, $area_arry_tmp);
		}
		return $area_arry;
	}
	
	public function set_selected_flag_for_typelist($type_id,$typelist){
		$area_arry = array();
		foreach($typelist as $type){
			$area_arry_tmp = array();
			$area_arry_tmp['id'] = $type['id'];
			$area_arry_tmp['name'] = $type['name'];
			if ($type_id == $type['id']) {
				$area_arry_tmp['selected'] = 1;		
			} else {
				$area_arry_tmp['selected'] = 0;	
			}
			array_push($area_arry, $area_arry_tmp);
		}
		return $area_arry;
	}
}
?>