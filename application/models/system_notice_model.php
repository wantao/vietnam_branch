<?php 
class System_notice_model extends CI_Model {
	var $PROPERTY_NAMES = array(
		'area_id'         => LG_AREA_NUMBER,
		'idx'             => LG_NOTICE_IDX,
		'begin_time'      => LG_BEGIN_TIME,
		'end_time'        => LG_END_TIME,
		'frequency'       => LG_FREQUENCY,
		'delay_begin'     => LG_DELAY_BEGIN,
		'content'         => LG_CONTENT,
	);
	public function __construct(){
		parent::__construct();
	}

	public function get_system_notice_info($area_id){
		$this->load->database($area_id . "_game_db");
		$select_columns = array();
		foreach($this->get_system_notice_property_names() as $property => $name){
			$select_columns[] = "system_notice.$property";
		}
		$select = implode(',', $select_columns);
		$query = "select $select from system_notice";
		$sql = $this->db->query($query);
		$result = $sql->result();
		$this->db->close();
		
		foreach($result  as $entry){
			foreach($this->get_system_notice_property_names() as $property => $name){
				if ("content" == $property) {
					$order   = array("\r\n", "\n", "\r");
					$replace = '<br />';
					$str_desc = str_replace($order, $replace, $entry->$property);
					$entry->$property = $str_desc;
				} 
			}
		}
		return $result;
	}
	
	public function get_one_system_notice_info($area_id, $idx){
		$db = $this->load->database($area_id . "_game_db", true);
		$select_columns = array();
		foreach($this->get_system_notice_property_names() as $property => $name){
			$select_columns[] = "system_notice.$property";
		}
		$select = implode(',', $select_columns);
		$query = "select $select from `system_notice` where `area_id`=$area_id and `idx`=$idx";
		$sql = $db->query($query);
		$result = $sql->result();
		$db->close();
		return $result;
	}
	
	public function get_system_notice_property_names(){
		return $this->PROPERTY_NAMES;
	}
	
	public function delete_one_system_notice_active($area_id, $idx){
		$db = $this->load->database($area_id . "_game_db_m", true);
		$query = "delete from system_notice where `area_id`=$area_id and `idx`=$idx";
		$result = $db->query($query);
		$db->close();
		return $result;
	}
	
	public function add_one_system_notice_active($area_no, $idx, $begin_time, $end_time, $frequency, $delay_begin, $content){
		$db = $this->load->database($area_no . "_game_db_m", true);
		$db->query("set charset utf8");
		$db->query("set names utf8");

		$query = "insert into `system_notice` set `area_id` = $area_no, `idx` = $idx,
		`begin_time` = '$begin_time' ,`end_time` = '$end_time' ,
		`frequency` = $frequency ,`delay_begin` = $delay_begin ,`content` = ".$db->escape($content)." ";
		$result = $db->query($query);
		$db->close();
		return $result;
	}
	
	public function edit_one_system_notice_active($area_no, $idx, $begin_time, $end_time, $frequency, $delay_begin, $content){
		$db = $this->load->database($area_no . "_game_db_m", true);
		$db->query("set charset utf8");
		$db->query("set names utf8");

		$query = "update `system_notice` set `begin_time` = '$begin_time' ,`end_time` = '$end_time' ,
		`frequency` = $frequency ,`delay_begin` = $delay_begin ,`content` = ".$db->escape($content)." 
		where `area_id` = $area_no and `idx` = $idx";
		$result = $db->query($query);
		$db->close();
		return $result;
	}
}
?>