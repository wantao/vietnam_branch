<?php
class Channel_detail_model extends CI_Model {
	var $COUNT_PER_PAGE = 10;
	//当天创建角色数量
	public function get_channel_charge_info($start_date,$end_date){
		$this->load->database("default");
		$sql = "select `app_id`,sum(money) as total_money from `tbl_all_recharge` where `successtime` >= ".$this->db->escape($start_date." 00:00:00")." and `successtime` <= ".$this->db->escape($end_date." 23:59:59")." group by `app_id`";
		$query = $this->db->query($sql);
		$result = $query->result();
		$this->db->close();
		return $result;
	}
}
?>