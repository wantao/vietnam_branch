<?php
class Add_del_test_authority_model extends CI_Model {
	var $COUNT_PER_PAGE = 10;
	public function add_test_authority($account){
		$this->load->database("default_m");
		$query = $this->db->query("insert into `tbl_gmlist` (`account`) values(".$this->db->escape($account).") on duplicate key update `account`=".$this->db->escape($account));
		if (!$query) {
			return false;
		}
		return true;
	}
	public function del_test_authority($account){
		$this->load->database("default_m");
		$query = $this->db->query("delete from `tbl_gmlist` where `account`=".$this->db->escape($account));
		if (!$query) {
			return false;
		}
		return true;
	}
	public function del_all_test_authority($account){
		$this->load->database("default_m");
		$query = $this->db->query("delete from `tbl_gmlist` where `account` like '%\_%'");
		if (!$query) {
			return false;
		}
		return true;
	}
}
?>