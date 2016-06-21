<?php
class Close_server_and_maintain_model extends CI_Model {
	var $COUNT_PER_PAGE = 10;
	var $SERVER_RUN_STATUS_LIST = array(
		LG_NORMAL => '0',
		LG_MAINTAIN => '2',
	);
	
	var $SERVER_FLUENCY_STATUS_LIST = array(
		LG_NEW_AREA => '0',
		LG_HOT => '1',
	);
	
	public function get_server_run_status_list()
	{
		return $this->SERVER_RUN_STATUS_LIST;	
	}
	
	public function get_server_fluency_status_list()
	{
		return $this->SERVER_FLUENCY_STATUS_LIST;	
	}
	
	public function set_servers_run_status($server_ids,$run_status) {//$server_ids格式为id1[,id2,...]
		if (empty($server_ids)) {
			return false;
		}
		if ( 0 != $run_status && 2 != $run_status) {
			return false;	
		}
		$db = $this->load->database("default_m",true);
		$update_sql = "update `tbl_server` set `run_status`=$run_status where `current_code` in ($server_ids)";
		return $db->query($update_sql);
	}
	
	public function set_servers_fluency_status($server_ids,$fluency_status) {//$server_ids格式为id1[,id2,...]
		if (empty($server_ids)) {
			return false;
		}
		if ( 0 != $fluency_status && 1 != $fluency_status) {
			return false;	
		}
		$db = $this->load->database("default_m",true);
		$update_sql = "update `tbl_server` set `fluency_status`=$fluency_status where `current_code` in ($server_ids)";
		return $db->query($update_sql);
	}
}
?>