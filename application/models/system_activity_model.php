<?php 
class System_activity_model extends CI_Model {
	var $PROPERTY_NAMES = array(
		'id'            => LG_ACTIVE_ID,
		'type'          => LG_NOTICE_IDX,
		'begin_time'    => LG_BEGIN_TIME,
		'end_time'      => LG_END_TIME,
		'get_award_time'=> LG_GET_AWARD_TIME,
		'name'          => LG_ACTIVE_NAME,
		'desc'          => LG_ACTIVE_DESC,
		'award'         => LG_ACTIVE_AWARD,
		'value'         => LG_ACTIVE_VALUE,
		'is_open'       => LG_STATUS,
	);
	public function __construct(){
		parent::__construct();
	}
	
	public function get_one_time_limited_buying_info($area_id,$active_id) {
		$db = $this->load->database($area_id . "_game_db", true);
		$select_sql = "select * from `system_flag` where `flag_key`='system_global_json_data'";
		$sql = $db->query($select_sql);
		$result = $sql->result();
		$json_info = json_decode($result[0]->desc);
		$db->close();
		$ret_array = array();	
		$inventory_name = $active_id.'_inventory';
		$today_limit_buy_count_name = $active_id.'_today_limit_buy_count';
		$today_bought_count_name = $active_id.'_today_bought_count';
		if (!isset($json_info->$inventory_name)) {
			exit('not find key:'.$inventory_name);
		}	
		if (!isset($json_info->$today_limit_buy_count_name)) {
			exit('not find key:'.$today_limit_buy_count_name);
		}
		if (!isset($json_info->$today_bought_count_name)) {
			exit('not find key:'.$today_bought_count_name);
		}
		$ret_array[$active_id] = array($inventory_name=>$json_info->$inventory_name,
		$today_limit_buy_count_name=>$json_info->$today_limit_buy_count_name,$today_bought_count_name=>$json_info->$today_bought_count_name);
		return $ret_array;
	}
	
	public function get_time_limited_buying_info($area_id,$arry = array()) {
		$db = $this->load->database($area_id . "_game_db", true);
		$select_sql = "select * from `system_flag` where `flag_key`='system_global_json_data'";
		$sql = $db->query($select_sql);
		$result = $sql->result();
		$json_info = json_decode($result[0]->desc);
		$db->close();
		$ret_array = array();
		foreach ($arry as $active_id) {
			$inventory_name = $active_id.'_inventory';
			$today_limit_buy_count_name = $active_id.'_today_limit_buy_count';
			$today_bought_count_name = $active_id.'_today_bought_count';
			if (!isset($json_info->$inventory_name)) {
				exit('not find key:'.$inventory_name);
			}	
			if (!isset($json_info->$today_limit_buy_count_name)) {
				exit('not find key:'.$today_limit_buy_count_name);
			}
			if (!isset($json_info->$today_bought_count_name)) {
				exit('not find key:'.$today_bought_count_name);
			}
			$ret_array[$active_id] = array($inventory_name=>$json_info->$inventory_name,
			$today_limit_buy_count_name=>$json_info->$today_limit_buy_count_name,$today_bought_count_name=>$json_info->$today_bought_count_name);
		}
		return $ret_array;
	}

	public function get_system_activity_info($area_id, $type){
		$db = $this->load->database($area_id . "_game_db", true);
		$select_columns = array();
		foreach($this->get_system_activity_property_names() as $property => $name){
			$select_columns[] = "c_system_activity_copy.$property";
		}
		$select = implode(',', $select_columns);
		$query = "select $select from c_system_activity_copy where `type`=$type";
		$sql = $db->query($query);
		$result = $sql->result();
		$db->close();
	
		if (9 == $type) {
			$tmp = $result;
			$array_time_limited_buying_active_id = array();
			foreach($tmp  as $one_a){
				array_push($array_time_limited_buying_active_id,$one_a->id);		
			}
			$limit_buying_info = $this->get_time_limited_buying_info($area_id,$array_time_limited_buying_active_id);	
		}
		
		$i = 0;
		foreach($result  as $entry){
			foreach($this->get_system_activity_property_names() as $property => $name){
				if ("desc" == $property) {
					$order   = array("\r\n", "\n", "\r");
					$replace = '<br />';
					$str_desc = str_replace($order, $replace, $entry->$property);
					$entry->$property = $str_desc;
				}
				if ('is_open' == $property){
						if(0 == $entry->$property){
							$entry->$property = LG_CLOSE;
						}else{
							$entry->$property = LG_OPEN;
						} 
				}
			}
			if (9 == $type) {
				$result[$i]->inventory = $limit_buying_info[$entry->id][$entry->id.'_inventory'];	
				$result[$i]->today_limit_buy_count = $limit_buying_info[$entry->id][$entry->id.'_today_limit_buy_count'];	
				$result[$i]->today_bought_count = $limit_buying_info[$entry->id][$entry->id.'_today_bought_count'];	
				$i += 1;
			}
		}
		return $result;
	}
	
	public function get_one_system_activity_info($area_id, $id){
		$db = $this->load->database($area_id . "_game_db", true);
		$select_columns = array();
		foreach($this->get_system_activity_property_names() as $property => $name){
			$select_columns[] = "c_system_activity_copy.$property";
		}
		$select = implode(',', $select_columns);
		$query = "select $select from `c_system_activity_copy` where `id`=$id";
		$sql = $db->query($query);
		$result = $sql->result();
		$first_row = $sql->first_row();
		if ($first_row && 9 == $first_row->type) {
			$limit_buying_info = $this->get_one_time_limited_buying_info($area_id, $id);
			$result['inventory'] = $limit_buying_info[$first_row->id][$first_row->id.'_inventory'];	
			$result['today_limit_buy_count'] = $limit_buying_info[$first_row->id][$first_row->id.'_today_limit_buy_count'];	
			$result['today_bought_count'] = $limit_buying_info[$first_row->id][$first_row->id.'_today_bought_count'];	
		}
		$db->close();
		return $result;
	}
	
	public function get_types_system_activity_info($area_id){
		$db = $this->load->database($area_id . "_game_db", true);
		$select_columns = array();
		$query = "select `type` from `c_system_activity_copy` group by `type`";
		$sql = $db->query($query);
		$result = $sql->result();
		$db->close();
		
		$area_arry = array();
		if ($result){
			foreach($result as $row){
				$area_arry_tmp = array();
				$area_arry_tmp['type'] = $row->type;
				$area_arry_tmp['name'] = $this->get_type($row->type);
				array_push($area_arry, $area_arry_tmp);
			}
		}
		return $area_arry;
	}
	
	public function get_system_activity_property_names(){
		return $this->PROPERTY_NAMES;
	}
	
	public function edit_one_system_activity_active($area_id, $id, $type, $begin_time, $end_time, $get_award_time, $name, $desc, $award, $value, $is_open,$inventory=0,$today_limit_buy_count=0){
		$db = $this->load->database($area_id . "_game_db_m", true);
		$db->trans_begin();
		
		$query = "update `c_system_activity_copy` set `begin_time` = '$begin_time' ,`end_time` = '$end_time' ,`get_award_time` = '$get_award_time' ,
		`name` = ".$db->escape($name)." ,`award` = ".$db->escape($award)." ,`value`=".$db->escape($value).", `is_open` = '$is_open' ,
		`desc` = ".$db->escape($desc)." where `id` = $id";
		$result = $db->query($query);
		if (!$result || $db->trans_status() === FALSE){
			$db->trans_rollback();
			$db->close();
			return false;
		}
		
		if ($type > 1){
			$query = "update `c_system_activity_copy` set `begin_time` = '$begin_time' ,`end_time` = '$end_time' ,`get_award_time` = '$get_award_time'
			where `type` = $type";
			$result = $db->query($query);
		}

		if (!$result || $db->trans_status() === FALSE){
		    $db->trans_rollback();
			$db->close();
			return false;
		}
		
		if (9 == $type) {
			$this->load->model('main_model');
			$url = $this->main_model->get_server_url_by_areaid($area_id);
			if ($url != NULL){
				$this->load->model('common_model');	
				$curl_param = "type=gm&account=test1&cmd=setkvs%20$id"."_inventory:$inventory,$id"."_today_limit_buy_count:$today_limit_buy_count"."&psw=Niuwa@163.com";
				$this->common_model->curl_send($url,$curl_param);
			}		
		}
		
		
		$db->trans_commit();
		$db->close();
		
		
		return $result;
	}
	
	public function execute_active_take_effect($area_id){
		$db = $this->load->database($area_id . "_game_db_m", true);
		$db->trans_begin();
		
		$query = "delete from `c_system_activity` ";
		$result = $db->query($query);
		if (!$result || $db->trans_status() === FALSE){
			$db->trans_rollback();
			$db->close();
			return false;
		}
		
		$query = "insert into `c_system_activity` select * from `c_system_activity_copy` ";
		$result = $db->query($query);
		if (!$result || $db->trans_status() === FALSE){
			$db->trans_rollback();
			$db->close();
			return false;
		}

	    $db->trans_commit();
		$db->close();
		return true;
	}
	
	public function get_copy_system_activity_sql_data($area_id){
		$db = $this->load->database($area_id . "_game_db", true);
		$select_columns = array();
		$query = "select * from `c_system_activity_copy`";
		$sql = $db->query($query);
		$result = $sql->result();
	
		$area_arry = array();
		if ($result){ 
			foreach($result as $row){
				$sql = "INSERT INTO `c_system_activity_copy` VALUES (";
				$values = array();
   			    foreach ($row as $value) {
        	    	$values[] = $db->escape($value);
                }
                $sql .= implode(', ', $values) . ");";
                $sql .= "\n";
				$area_arry[] = $sql;
			}
		}
		#print_r($area_arry);
		$db->close();
		return $area_arry;
	}
	
	public function execute_new_system_activity_sql_data($area_id, $array_sql){
		$db = $this->load->database($area_id . "_game_db_m", true);
		$delete_sql = "delete from `c_system_activity_copy`;";
		$result = $db->query($delete_sql);
		if (!$result){
			return False;
		}
			
	    foreach ($array_sql as $query) {
			$sql = $db->query($query);
			if (!$sql){
				return False;
			}
        }
		$db->close();
		return True;
	}
	
	public function get_type($type){
		if ($type == 1){
			return LG_ACTIVE_EVERY_DAY;
		}else if($type == 2){
			return LG_ACTIVE_LOGIN;
		}else if($type == 3){
			return LG_ACTIVE_COST;
		}else if($type == 4){
			return LG_ACTIVE_UPGRADE;
		}else if($type == 5){
			return LG_ACTIVE_ZHAO_HUAN;
		}else if($type == 6){
			return LG_ACTIVE_CHONG_ZHI;
		}else if($type == 7){
			return LG_ACTIVE_PVP_RANK;
		}else if($type == 8){
			return LG_ACTIVE_INVEST_MENT;
		}else if($type == 9){
			return LG_TIME_LIMIT_BUYING;	
		}else if($type == 10){
			return LG_ACTIVE_Online;	
		}else if($type == 11){
			return LG_ACTIVE_EXCHANGE;
		}else if($type == 12){
			return LG_ACTIVE_SIGNLE_CHONGZHI;
		}else if($type == 13){
			return LG_ACTIVE_LUCK_STAR;
		}else if($type == 100){
			return LG_ACTIVE_ONLINE_CHECK;
		}else {
			return LG_NOTHING;
		}
	}
	
	public function get_state(){
		return array(
			array("name" => LG_CLOSE, "value" => 0, ),
			array("name" => LG_OPEN, "value" => 1, ),
		);
	}
}
?>