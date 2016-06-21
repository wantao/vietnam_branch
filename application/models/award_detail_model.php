<?php
class Award_Detail_model extends CI_Model {
	var $COUNT_PER_PAGE = 10;
	public function get_count_per_page(){
		return $this->COUNT_PER_PAGE;
	}
	
	public function pet_name_select_id($area_id, $pet_name){
		$this->load->database($area_id . "_game_db");
		$query = "select `id` from `c_pet_property` where `name`=".$this->db->escape($pet_name)."";
		$sql = $this->db->query($query);
		$result = $sql->first_row();
		$this->db->close();
		return $result;
	}
	
	public function goods_name_select_id($area_id, $goods_name){
		$this->load->database($area_id . "_game_db");
		$query = "select `id` from `c_goods_property` where `name`=".$this->db->escape($goods_name)."";
		$sql = $this->db->query($query);
		$result = $sql->first_row();
		$this->db->close();
		return $result;
	}
	
	public function get_type(){
		return array(
			array("name" => LG_AWARD_EXP, "value" => 1),
			array("name" => LG_AWARD_GOLD, "value" => 2),
			array("name" => LG_AWARD_YUANBAO, "value" => 3),
			array("name" => LG_AWARD_PET, "value" => 4),
			array("name" => LG_AWARD_ACTION_COUNT, "value" => 5),
			array("name" => LG_AWARD_FRIEND_SHIP, "value" => 6),
			array("name" => LG_AWARD_EQUIP, "value" => 7),
			array("name" => LG_AWARD_RANDOM_PET, "value" => 8),
			array("name" => LG_AWARD_RANDOM_EQUIP, "value" => 9),
			array("name" => LG_AWARD_GOODS, "value" => 10),
			array("name" => LG_AWARD_OTHER_WORLD_INTRUSION_CURRENCY, "value" => 11),
			array("name" => LG_AWARD_OTHER_WORLD_EXPEDITION_CURRENCY, "value" => 12),
			array("name" => LG_AWARD_GUILD_CURRENCY, "value" => 13),
			array("name" => LG_AWARD_EQUIP_RAFFLE_TICKETS, "value" => 14),
			array("name" => LG_AWARD_PET_RAFFLE_TICKETS, "value" => 15),
			array("name" => LG_AWARD_FIRST_QUEUE_PET_EXP, "value" => 16),
			array("name" => LG_AWARD_PVP_CURRENCY, "value" => 18)
		);
	}
	
	public function get_other_type($type){
		if (8 == $type){
			return array(
				array("name" => LG_1_STAR_PET, "value" => 1, "param" => 1),
				array("name" => LG_2_STAR_PET, "value" => 2, "param" => 2),
				array("name" => LG_3_STAR_PET, "value" => 3, "param" => 3),
				array("name" => LG_4_STAR_PET, "value" => 4, "param" => 4),
				array("name" => LG_5_STAR_PET, "value" => 5, "param" => 5),
				array("name" => LG_6_STAR_PET, "value" => 6, "param" => 6),
			);
		}else if (9 == $type){
			return array(
				array("name" => LG_WHITE_EQUIP, "value" => 1, "param" => 1),
				array("name" => LG_GREEN_EQUIP, "value" => 2, "param" => 2),
				array("name" => LG_BLUE_EQUIP, "value" => 3, "param" => 3),
				array("name" => LG_PRUPLE_EQUIP, "value" => 4, "param" => 4),
				array("name" => LG_ORANGE_EQUIP, "value" => 5, "param" => 5),
			);
		}else if (14 == $type){
			return array(
				array("name" => LG_WHITE_BLUE_ITEM, "value" => 1),
				array("name" => LG_GREEN_PURPLE_ITEM, "value" => 2),
				array("name" => LG_BLUE_PURPLE_ITEM, "value" => 3),
				array("name" => LG_BLUE_ORANGE_ITEM, "value" => 4),
				array("name" => LG_PURPLE_ORANGE_ITEM, "value" => 5),
			);
		}else if (15 == $type){
			return array(
				array("name" => LG_1_3_CALL, "value" => 1),
				array("name" => LG_1_4_CALL, "value" => 2),
				array("name" => LG_3_4_CALL, "value" => 3),
				array("name" => LG_3_5_CALL, "value" => 4),
				array("name" => LG_4_5_CALL, "value" => 5),
			);
		}else {
			return array(
				array("name" => LG_NOTHING, "value" => 1),
			);
		}
	}
}
?>