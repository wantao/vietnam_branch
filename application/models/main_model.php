<?php 
#$CI =&get_instance();
#$CI->config->item('base_url');
#$lg = $CI->config->item('language');
#print_r($lg['en']['gm']);
#print_r(LG_GM);
#print_r(LG_SEND_AWARD);
class Main_model extends CI_Model {
	var $PAGES = array(
		'5' => array(
			array('title' => LG_GM, 'url' => "/index.php/main/show"),
			array('title' => LG_SEND_AWARD, 'url' => "/index.php/award/show"),
			array('title' => LG_EMAIL_AWARD_SEND_QUERY, 'url' => "/index.php/email_award_send_query/show"),
			array('title' => LG_AWARD_DESCRIBE, 'url' => "/index.php/award_detail/show"),
			array('title' => LG_SEARCH_BY_ACCOUNT, 'url' => "/index.php/account/show"),
			array('title' => LG_SEARCH_BY_ID, 'url' => "/index.php/player_id_search/show"),
			array('title' => LG_PLAYER_BASE, 'url' => "/index.php/player/show"),
			array('title' => LG_PET_INFO, 'url' => "/index.php/pet/show"),
			array('title' => LG_PLAYER_EQUIPMENT, 'url' => "/index.php/player_equipment/show"),
			array('title' => LG_PLAYER_GOODS, 'url' => "/index.php/player_goods/show"),
			array('title' => LG_ONLINE_NUMBER, 'url' => "/index.php/online/show"),
			array('title' => LG_LEVEL_SPREAD, 'url' => "/index.php/level/show"),
			array('title' => LG_PLAYER_GUIDE_STEP, 'url' => "/index.php/guide_step/show"),
			array('title' => LG_SYSTEM_GLOBAL, 'url' => "/index.php/flag/show"),
			array('title' => LG_GEM_GET_AND_USE, 'url' => "/index.php/gem/show"),
			array('title' => LG_RECHARGE_LOG, 'url' => "/index.php/charge/show"),
			array('title' => LG_EVERY_AREA_GATHER, 'url' => "/index.php/total/show"),
			array('title' => LG_EVERY_AREA_DETAIL, 'url' => "/index.php/detail/show"),
			array('title' => LG_CHANNEL_DETAIL, 'url' => "/index.php/channel_detail/show"),
			array('title' => LG_EVERY_AREA_LOG, 'url' => "/index.php/log/show"),
			array('title' => LG_SERVICES_STATE, 'url' => "/index.php/server_state/show"),
			array('title' => LG_RETENTION_RATE, 'url' => "/index.php/remain/show"),
			array('title' => LG_BUY_RANK, 'url' => "/index.php/props_purchase_list/show"),
			array('title' => LG_RECHARGE_RANK, 'url' => "/index.php/chongzhi_list/show"),
			array('title' => LG_STOP_FOR_REPAIR, 'url' => "/index.php/close_server_and_maintain/show"),
			array('title' => LG_CDKEY_ACTIVE, 'url' => "/index.php/cdkey/show"),
			array('title' => LG_SYSTEM_ACTIVITY, 'url' => "/index.php/system_activity/show"),
			array('title' => LG_GUILD_LEVEL_SPREAD, 'url' => "/index.php/guild_level/show"),
			array('title' => LG_VIP_LEVEL_SPREAD, 'url' => "/index.php/vip_level/show"),
			array('title' => LG_PVP_SCORE_RANGE_SPREAD, 'url' => "/index.php/pvp_score_range/show"),
			array('title' => LG_ADD_DEL_TEST_AUTHORITY, 'url' => "/index.php/add_del_test_authority/show"),
			array('title' => LG_SYSTEM_NOTICE, 'url' => "/index.php/system_notice/show"),
			array('title' => LG_YUANBAO_TRACE, 'url' => "/index.php/yuanbao_trace/show"),
			array('title' => LG_PAYMENT_BEHAVIOR, 'url' => "/index.php/payment_behavior/show"),
			array('title' => LG_CHECKPOINT_PROCESS, 'url' => "/index.php/checkpoint_process/show"),
			array('title' => LG_GUILD_INFO, 'url' => "/index.php/guild_info/show"),
			array('title' => LG_PLYAER_LOGIN_IP, 'url' => "/index.php/login_ip/show"),
		),
		'4' => array(
			array('title' => LG_GM, 'url' => "/index.php/main/show"),
			array('title' => LG_SEND_AWARD, 'url' => "/index.php/award/show"),
			array('title' => LG_EMAIL_AWARD_SEND_QUERY, 'url' => "/index.php/email_award_send_query/show"),
			array('title' => LG_AWARD_DESCRIBE, 'url' => "/index.php/award_detail/show"),
			array('title' => LG_SEARCH_BY_ACCOUNT, 'url' => "/index.php/account/show"),
			array('title' => LG_SEARCH_BY_ID, 'url' => "/index.php/player_id_search/show"),
			array('title' => LG_PLAYER_BASE, 'url' => "/index.php/player/show"),
			array('title' => LG_PET_INFO, 'url' => "/index.php/pet/show"),
			array('title' => LG_PLAYER_EQUIPMENT, 'url' => "/index.php/player_equipment/show"),
			array('title' => LG_PLAYER_GOODS, 'url' => "/index.php/player_goods/show"),
			array('title' => LG_ONLINE_NUMBER, 'url' => "/index.php/online/show"),
			array('title' => LG_LEVEL_SPREAD, 'url' => "/index.php/level/show"),
			array('title' => LG_PLAYER_GUIDE_STEP, 'url' => "/index.php/guide_step/show"),
			array('title' => LG_SYSTEM_GLOBAL, 'url' => "/index.php/flag/show"),
			array('title' => LG_GEM_GET_AND_USE, 'url' => "/index.php/gem/show"),
			array('title' => LG_RECHARGE_LOG, 'url' => "/index.php/charge/show"),
			array('title' => LG_EVERY_AREA_GATHER, 'url' => "/index.php/total/show"),
			array('title' => LG_EVERY_AREA_DETAIL, 'url' => "/index.php/detail/show"),
			array('title' => LG_CHANNEL_DETAIL, 'url' => "/index.php/channel_detail/show"),
			array('title' => LG_EVERY_AREA_LOG, 'url' => "/index.php/log/show"),
			array('title' => LG_CDKEY_ACTIVE, 'url' => "/index.php/cdkey/show"),
			array('title' => LG_SYSTEM_NOTICE, 'url' => "/index.php/system_notice/show"),
			array('title' => LG_SYSTEM_ACTIVITY, 'url' => "/index.php/system_activity/show"),
			array('title' => LG_SERVICES_STATE, 'url' => "/index.php/server_state/show"),
			array('title' => LG_RETENTION_RATE, 'url' => "/index.php/remain/show"),
			array('title' => LG_BUY_RANK, 'url' => "/index.php/props_purchase_list/show"),
			array('title' => LG_RECHARGE_RANK, 'url' => "/index.php/chongzhi_list/show"),
			array('title' => LG_STOP_FOR_REPAIR, 'url' => "/index.php/close_server_and_maintain/show"),
			array('title' => LG_GUILD_LEVEL_SPREAD, 'url' => "/index.php/guild_level/show"),
			array('title' => LG_VIP_LEVEL_SPREAD, 'url' => "/index.php/vip_level/show"),
			array('title' => LG_PVP_SCORE_RANGE_SPREAD, 'url' => "/index.php/pvp_score_range/show"),
			array('title' => LG_ADD_DEL_TEST_AUTHORITY, 'url' => "/index.php/add_del_test_authority/show"),
			array('title' => LG_YUANBAO_TRACE, 'url' => "/index.php/yuanbao_trace/show"),
			array('title' => LG_PAYMENT_BEHAVIOR, 'url' => "/index.php/payment_behavior/show"),
			array('title' => LG_CHECKPOINT_PROCESS, 'url' => "/index.php/checkpoint_process/show"),
			array('title' => LG_GUILD_INFO, 'url' => "/index.php/guild_info/show"),
			array('title' => LG_PLYAER_LOGIN_IP, 'url' => "/index.php/login_ip/show"),
		),
		'3' => array(
			array('title' => LG_GM, 'url' => "/index.php/main/show"),
			//array('title' => LG_SEND_AWARD, 'url' => "/index.php/award/show"),
			//array('title' => LG_EMAIL_AWARD_SEND_QUERY, 'url' => "/index.php/email_award_send_query/show"),
			array('title' => LG_AWARD_DESCRIBE, 'url' => "/index.php/award_detail/show"),
			array('title' => LG_SEARCH_BY_ACCOUNT, 'url' => "/index.php/account/show"),
			array('title' => LG_SEARCH_BY_ID, 'url' => "/index.php/player_id_search/show"),
			array('title' => LG_PLAYER_BASE, 'url' => "/index.php/player/show"),
			array('title' => LG_PET_INFO, 'url' => "/index.php/pet/show"),
			array('title' => LG_PLAYER_EQUIPMENT, 'url' => "/index.php/player_equipment/show"),
			array('title' => LG_PLAYER_GOODS, 'url' => "/index.php/player_goods/show"),
			array('title' => LG_ONLINE_NUMBER, 'url' => "/index.php/online/show"),
			array('title' => LG_LEVEL_SPREAD, 'url' => "/index.php/level/show"),
			array('title' => LG_PLAYER_GUIDE_STEP, 'url' => "/index.php/guide_step/show"),
			array('title' => LG_SYSTEM_GLOBAL, 'url' => "/index.php/flag/show"),
			array('title' => LG_GEM_GET_AND_USE, 'url' => "/index.php/gem/show"),
			array('title' => LG_RECHARGE_LOG, 'url' => "/index.php/charge/show"),
			/*array('title' => LG_EVERY_AREA_GATHER, 'url' => "/index.php/total/show"),
			array('title' => LG_EVERY_AREA_DETAIL, 'url' => "/index.php/detail/show"),
			array('title' => LG_CHANNEL_DETAIL, 'url' => "/index.php/channel_detail/show"),
			array('title' => LG_EVERY_AREA_LOG, 'url' => "/index.php/log/show"),
			array('title' => LG_SERVICES_STATE, 'url' => "/index.php/server_state/show"),
			array('title' => LG_RETENTION_RATE, 'url' => "/index.php/remain/show"),
			array('title' => LG_BUY_RANK, 'url' => "/index.php/props_purchase_list/show"),
			array('title' => LG_RECHARGE_RANK, 'url' => "/index.php/chongzhi_list/show"),
			array('title' => LG_STOP_FOR_REPAIR, 'url' => "/index.php/close_server_and_maintain/show"),
			array('title' => LG_GUILD_LEVEL_SPREAD, 'url' => "/index.php/guild_level/show"),
			array('title' => LG_VIP_LEVEL_SPREAD, 'url' => "/index.php/vip_level/show"),
			array('title' => LG_PVP_SCORE_RANGE_SPREAD, 'url' => "/index.php/pvp_score_range/show"),
			array('title' => LG_ADD_DEL_TEST_AUTHORITY, 'url' => "/index.php/add_del_test_authority/show"),*/
			array('title' => LG_YUANBAO_TRACE, 'url' => "/index.php/yuanbao_trace/show"),
			//array('title' => LG_PAYMENT_BEHAVIOR, 'url' => "/index.php/payment_behavior/show"),
			//array('title' => LG_CHECKPOINT_PROCESS, 'url' => "/index.php/checkpoint_process/show"),
			//array('title' => LG_GUILD_INFO, 'url' => "/index.php/guild_info/show"),
		),
		'2' => array(
			array('title' => LG_GM, 'url' => "/index.php/main/show"),
			//array('title' => LG_SEND_AWARD, 'url' => "/index.php/award/show"),
			//array('title' => LG_EMAIL_AWARD_SEND_QUERY, 'url' => "/index.php/email_award_send_query/show"),
			array('title' => LG_SEARCH_BY_ACCOUNT, 'url' => "/index.php/account/show"),
			array('title' => LG_SEARCH_BY_ID, 'url' => "/index.php/player_id_search/show"),
			array('title' => LG_PLAYER_BASE, 'url' => "/index.php/player/show"),
			array('title' => LG_PET_INFO, 'url' => "/index.php/pet/show"),
			array('title' => LG_PLAYER_EQUIPMENT, 'url' => "/index.php/player_equipment/show"),
			array('title' => LG_PLAYER_GOODS, 'url' => "/index.php/player_goods/show"),
			array('title' => LG_ONLINE_NUMBER, 'url' => "/index.php/online/show"),
			array('title' => LG_LEVEL_SPREAD, 'url' => "/index.php/level/show"),
			array('title' => LG_PLAYER_GUIDE_STEP, 'url' => "/index.php/guide_step/show"),
			/*array('title' => LG_SYSTEM_GLOBAL, 'url' => "/index.php/flag/show"),
			array('title' => LG_GEM_GET_AND_USE, 'url' => "/index.php/gem/show"),
			array('title' => LG_RECHARGE_LOG, 'url' => "/index.php/charge/show"),
			array('title' => LG_EVERY_AREA_GATHER, 'url' => "/index.php/total/show"),
			array('title' => LG_EVERY_AREA_DETAIL, 'url' => "/index.php/detail/show"),
			array('title' => LG_CHANNEL_DETAIL, 'url' => "/index.php/channel_detail/show"),
			array('title' => LG_EVERY_AREA_LOG, 'url' => "/index.php/log/show"),
			array('title' => LG_SERVICES_STATE, 'url' => "/index.php/server_state/show"),
			array('title' => LG_RETENTION_RATE, 'url' => "/index.php/remain/show"),
			array('title' => LG_BUY_RANK, 'url' => "/index.php/props_purchase_list/show"),
			array('title' => LG_RECHARGE_RANK, 'url' => "/index.php/chongzhi_list/show"),
			array('title' => LG_STOP_FOR_REPAIR, 'url' => "/index.php/close_server_and_maintain/show"),
			array('title' => LG_GUILD_LEVEL_SPREAD, 'url' => "/index.php/guild_level/show"),
			array('title' => LG_VIP_LEVEL_SPREAD, 'url' => "/index.php/vip_level/show"),
			array('title' => LG_PVP_SCORE_RANGE_SPREAD, 'url' => "/index.php/pvp_score_range/show"),
			array('title' => LG_ADD_DEL_TEST_AUTHORITY, 'url' => "/index.php/add_del_test_authority/show"),*/
			array('title' => LG_YUANBAO_TRACE, 'url' => "/index.php/yuanbao_trace/show"),
			//array('title' => LG_PAYMENT_BEHAVIOR, 'url' => "/index.php/payment_behavior/show"),
			//array('title' => LG_CHECKPOINT_PROCESS, 'url' => "/index.php/checkpoint_process/show"),
			//array('title' => LG_GUILD_INFO, 'url' => "/index.php/guild_info/show"),
		),
		'1' => array(
			array('title' => LG_GM, 'url' => "/index.php/main/show"),
			//array('title' => LG_SEND_AWARD, 'url' => "/index.php/award/show"),
			//array('title' => LG_EMAIL_AWARD_SEND_QUERY, 'url' => "/index.php/email_award_send_query/show"),
			array('title' => LG_SEARCH_BY_ACCOUNT, 'url' => "/index.php/account/show"),
			array('title' => LG_SEARCH_BY_ID, 'url' => "/index.php/player_id_search/show"),
			array('title' => LG_PLAYER_BASE, 'url' => "/index.php/player/show"),
			/*array('title' => LG_PET_INFO, 'url' => "/index.php/pet/show"),
			array('title' => LG_PLAYER_EQUIPMENT, 'url' => "/index.php/player_equipment/show"),
			array('title' => LG_PLAYER_GOODS, 'url' => "/index.php/player_goods/show"),
			array('title' => LG_ONLINE_NUMBER, 'url' => "/index.php/online/show"),
			array('title' => LG_LEVEL_SPREAD, 'url' => "/index.php/level/show"),
			array('title' => LG_PLAYER_GUIDE_STEP, 'url' => "/index.php/guide_step/show"),
			array('title' => LG_SYSTEM_GLOBAL, 'url' => "/index.php/flag/show"),
			array('title' => LG_GEM_GET_AND_USE, 'url' => "/index.php/gem/show"),
			array('title' => LG_RECHARGE_LOG, 'url' => "/index.php/charge/show"),
			array('title' => LG_EVERY_AREA_GATHER, 'url' => "/index.php/total/show"),
			array('title' => LG_EVERY_AREA_DETAIL, 'url' => "/index.php/detail/show"),
			array('title' => LG_CHANNEL_DETAIL, 'url' => "/index.php/channel_detail/show"),
			array('title' => LG_EVERY_AREA_LOG, 'url' => "/index.php/log/show"),
			array('title' => LG_SERVICES_STATE, 'url' => "/index.php/server_state/show"),
			array('title' => LG_RETENTION_RATE, 'url' => "/index.php/remain/show"),
			array('title' => LG_BUY_RANK, 'url' => "/index.php/props_purchase_list/show"),
			array('title' => LG_RECHARGE_RANK, 'url' => "/index.php/chongzhi_list/show"),
			array('title' => LG_STOP_FOR_REPAIR, 'url' => "/index.php/close_server_and_maintain/show"),
			array('title' => LG_GUILD_LEVEL_SPREAD, 'url' => "/index.php/guild_level/show"),
			array('title' => LG_VIP_LEVEL_SPREAD, 'url' => "/index.php/vip_level/show"),
			array('title' => LG_PVP_SCORE_RANGE_SPREAD, 'url' => "/index.php/pvp_score_range/show"),*/
			//array('title' => LG_YUANBAO_TRACE, 'url' => "/index.php/yuanbao_trace/show"),
			//array('title' => LG_PAYMENT_BEHAVIOR, 'url' => "/index.php/payment_behavior/show"),
			//array('title' => LG_CHECKPOINT_PROCESS, 'url' => "/index.php/checkpoint_process/show"),
			//array('title' => LG_GUILD_INFO, 'url' => "/index.php/guild_info/show"),
		),
		'0' => array(
			array('title' => LG_GM, 'url' => "/index.php/main/show"),
			//array('title' => LG_SEND_AWARD, 'url' => "/index.php/award/show"),
			//array('title' => LG_EMAIL_AWARD_SEND_QUERY, 'url' => "/index.php/email_award_send_query/show"),
			/*array('title' => LG_SEARCH_BY_ACCOUNT, 'url' => "/index.php/account/show"),
			array('title' => LG_SEARCH_BY_ID, 'url' => "/index.php/player_id_search/show"),
			array('title' => LG_PLAYER_BASE, 'url' => "/index.php/player/show"),
			array('title' => LG_PET_INFO, 'url' => "/index.php/pet/show"),
			array('title' => LG_PLAYER_EQUIPMENT, 'url' => "/index.php/player_equipment/show"),
			array('title' => LG_PLAYER_GOODS, 'url' => "/index.php/player_goods/show"),
			array('title' => LG_ONLINE_NUMBER, 'url' => "/index.php/online/show"),
			array('title' => LG_LEVEL_SPREAD, 'url' => "/index.php/level/show"),
			array('title' => LG_PLAYER_GUIDE_STEP, 'url' => "/index.php/guide_step/show"),
			array('title' => LG_SYSTEM_GLOBAL, 'url' => "/index.php/flag/show"),
			array('title' => LG_GEM_GET_AND_USE, 'url' => "/index.php/gem/show"),
			array('title' => LG_RECHARGE_LOG, 'url' => "/index.php/charge/show"),
			array('title' => LG_EVERY_AREA_GATHER, 'url' => "/index.php/total/show"),
			array('title' => LG_EVERY_AREA_DETAIL, 'url' => "/index.php/detail/show"),
			array('title' => LG_CHANNEL_DETAIL, 'url' => "/index.php/channel_detail/show"),
			array('title' => LG_EVERY_AREA_LOG, 'url' => "/index.php/log/show"),
			array('title' => LG_SERVICES_STATE, 'url' => "/index.php/server_state/show"),
			array('title' => LG_RETENTION_RATE, 'url' => "/index.php/remain/show"),
			array('title' => LG_BUY_RANK, 'url' => "/index.php/props_purchase_list/show"),
			array('title' => LG_RECHARGE_RANK, 'url' => "/index.php/chongzhi_list/show"),
			array('title' => LG_STOP_FOR_REPAIR, 'url' => "/index.php/close_server_and_maintain/show"),
			array('title' => LG_GUILD_LEVEL_SPREAD, 'url' => "/index.php/guild_level/show"),
			array('title' => LG_VIP_LEVEL_SPREAD, 'url' => "/index.php/vip_level/show"),
			array('title' => LG_PVP_SCORE_RANGE_SPREAD, 'url' => "/index.php/pvp_score_range/show"),
			array('title' => LG_ADD_DEL_TEST_AUTHORITY, 'url' => "/index.php/add_del_test_authority/show"),*/
			//array('title' => LG_YUANBAO_TRACE, 'url' => "/index.php/yuanbao_trace/show"),
			//array('title' => LG_PAYMENT_BEHAVIOR, 'url' => "/index.php/payment_behavior/show"),
			//array('title' => LG_CHECKPOINT_PROCESS, 'url' => "/index.php/checkpoint_process/show"),
			//array('title' => LG_GUILD_INFO, 'url' => "/index.php/guild_info/show"),
		),
	);
	public function __construct(){
		parent::__construct();
	}
	public function get_account($username, $password){
		$this->load->database("default");
		$query = $this->db->get_where("tbl_gmaccount",array('account'=>$username, 'password'=>$password));
		$ary = $query->result();
		$this->db->close();
		return $ary;
	}
	public function get_serverlist(){
		$db = $this->load->database("default",true);
		$query = $db->get('tbl_server');	
		$ary = $query->result();
		$db->close();
		return $ary;
	}
	public function get_gmcmdlist(){
		$this->load->database("default");
		$query = $this->db->get('tbl_gmcommand');
		$ary = $query->result();
		$this->db->close();
		return $ary;
	}
	public function get_pages($gm_level){
		if (!isset($this->PAGES[$gm_level])) {
			return;	
		}
		return $this->PAGES[$gm_level]; 
	}
	
	public function get_server_url_by_areaid($area)
	{
		$db = $this->load->database("default",true);
		$sql = "select * from tbl_server where id='$area'";
		$query_result = $db->query($sql);
		$result = $query_result->result();
		foreach ($result as $row) {
			return "$row->url:$row->port";
		}
		$db->close();
		return NULL;
	}
	
	public function get_server_id_by_name($server_name) {
		$db = $this->load->database("default",true);
		$sql = "select * from tbl_server where name='$server_name'";
		$query_result = $db->query($sql);
		$server_list = $query_result->result();
		foreach ($server_list as $server) {
			if ($server->name == $server_name) {
				$db->close();
				return $server->id;	
			}
		}	
		$db->close();
		return NULL;
	}
}
?>