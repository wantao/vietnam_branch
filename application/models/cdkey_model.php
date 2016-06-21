<?php 
class Cdkey_model extends CI_Model {
	var $PROPERTY_NAMES = array(
		'id'              => 'id',
		'area_no'         => LG_AREA_NUMBER,
		'title'           => LG_TITLE,
		'desc'            => LG_DESCRIPTION,
		'bn_url'          => LG_PICTURE_URL,
		'begin_time'      => LG_BEGIN_TIME,
		'end_time'        => LG_END_TIME,
		'level'           => LG_MIN_LEVEL,
		'award'           => LG_AWARD
	);
	public function __construct(){
		parent::__construct();
	}

	public function get_cdkey_info(){
		$this->load->database("default");
		$select_columns = array();
		foreach($this->get_cdkey_property_names() as $property => $name){
			$select_columns[] = "tbl_cdkey_active.$property";
		}
		$select = implode(',', $select_columns);
		$query = "select $select from tbl_cdkey_active where has_delete=0";
		$sql = $this->db->query($query);
		$result = $sql->result();
		$this->db->close();
		
		foreach($result  as $entry){
			foreach($this->get_cdkey_property_names() as $property => $name){
				if ("desc" == $property) {
					$order   = array("\r\n", "\n", "\r");
					$replace = '<br />';
					$str_desc = str_replace($order, $replace, $entry->$property);
					$entry->$property = $str_desc;
				} 
			}
		}
		return $result;
	}
	
	public function get_one_cdkey_info($id){
		$this->load->database("default");
		$select_columns = array();
		foreach($this->get_cdkey_property_names() as $property => $name){
			$select_columns[] = "tbl_cdkey_active.$property";
		}
		$select = implode(',', $select_columns);
		$query = "select $select from tbl_cdkey_active where has_delete=0 and `id`=$id ";
		$sql = $this->db->query($query);
		$result = $sql->result();
		$this->db->close();
		return $result;
	}
	
	public function get_cdkey_property_names(){
		return $this->PROPERTY_NAMES;
	}
	
	public function delete_one_cdkey_active($id){
		$this->load->database("default_m");
		$query = "update tbl_cdkey_active set has_delete = 1 where `id`=$id ";
		$result = $this->db->query($query);
		$this->db->close();
		return $result;
	}
	
	public function add_one_cdkey_active($area_no, $title, $desc, $bn_url, $begin_time, $end_time, $level, $award){
		$this->load->database("default_m");
		$this->db->query("set charset utf8");
		$this->db->query("set names utf8");

		$query = "insert into tbl_cdkey_active set `area_no` = ".$this->db->escape($area_no).", `title` = ".$this->db->escape($title).",
		`desc` = ".$this->db->escape($desc).", `bn_url` = ".$this->db->escape($bn_url).",`begin_time` = '$begin_time' ,`end_time` = '$end_time' ,
		`level` = $level ,`award` = ".$this->db->escape($award)." ";
		$result = $this->db->query($query);
		$this->db->close();
		return $result;
	}
	
	public function edit_one_cdkey_active($id, $area_no, $title, $desc, $bn_url, $begin_time, $end_time, $level, $award){
		$this->load->database("default_m");
		$this->db->query("set charset utf8");
		$this->db->query("set names utf8");

		
		$query = "update tbl_cdkey_active set `area_no` = ".$this->db->escape($area_no).", `title` = ".$this->db->escape($title).",
		`desc` = ".$this->db->escape($desc).", `bn_url` = ".$this->db->escape($bn_url).",`begin_time` = '$begin_time' ,`end_time` = '$end_time' ,
		`level` = $level ,`award` = ".$this->db->escape($award)." where `id`=$id";
		$result = $this->db->query($query);
		$this->db->close();
		return $result;
	}
}
?>