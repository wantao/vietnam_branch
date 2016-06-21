<?php 
class Pet_model extends CI_Model {
		var $PROPERTY_NAMES = array(//对应表里必须含有Digitid列才可使用该结构进行查询
			'c_pet_property' => array(
				'name'            => LG_PET_NAME
			),
			'player_pet'  => array(
				'id'              => LG_PET_DIGITAL_ID,
				'pet_id'          => LG_PET_CLASS_ID,
				'level'           => LG_LEVEL,
				'exp'             => LG_EXP,
				'protect'         => LG_IS_PROTECTED,
				'create_time'     => LG_CREATE_TIME,
				'skill_level'     => LG_SKILL_LEVEL,
				'equip_id_1'      => LG_EQUIP_ID_1,
				'equip_id_2'      => LG_EQUIP_ID_2,
				'equip_id_3'      => LG_EQUIP_ID_3,
				'new_state'       => LG_NEW_STATE
			)
	);

	public function __construct(){
		parent::__construct();
	}

	public function get_pet_info($playername){
		$this->load->model("player_model");
		$area = $this->player_model->get_player_area($playername);
		if(!$area){
			return;
		}
		$this->load->database($area . "_game_db");
		$select_columns = array();
		foreach($this->PROPERTY_NAMES as $table => $property_names){
			foreach($property_names as $property => $name){
				$select_columns[] = "$table.$property";
			}
		}
		$select = implode(',', $select_columns);
		$query = "select $select from player_pet, player_base, c_pet_property 
		where player_base.playername = ".$this->db->escape($playername)." and player_pet.digitid = player_base.digitid 
		and player_pet.has_delete=0 and c_pet_property.id = player_pet.pet_id";
		$sql = $this->db->query($query);
		$result = $sql->result();
		$this->db->close();
		return $result;
	}
	
	public function get_pet_property_names(){
		return $this->PROPERTY_NAMES;
	}
}
?>