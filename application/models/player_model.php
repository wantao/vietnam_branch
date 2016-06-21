<?php 
class Player_model extends CI_Model {
	var $PROPERTY_NAMES = array(//对应表里必须含有Digitid列才可使用该结构进行查询
		'player_base' => array(
			'account'         => LG_ACCOUNT,
			'digitid'         => LG_PLAYER_ID,
			'playername'      => LG_NAME,
			'sex'         => LG_SEX,
			'create_time' => LG_CREATE_TIME
		),
		'player_exp'  => array(
			'level'       => LG_LEVEL,
			'exp'         => LG_EXP
		),
		'player_yuanbao'  => array(
			'yuanbao'          => LG_AWARD_YUANBAO,
		    'viplevel'         => LG_VIP_LEVEL,
		    'leijichongzhi'    => LG_LEIJICHONGZHI
		),
		'player_info' => array(
			'gold'        => LG_GOLD,
			'action_count'=> LG_ACTION_COUNT,
			'head_pic_id' => LG_HEAD_PIC_ID,
			'guidestep'   => LG_GUIDE_STEP,
			'first_enter_game' => LG_FLAG_FIRST_ENTER_GAME,
			'cur_queue_id'=> LG_CUR_QUEUE_ID,
			'pet_number'  => LG_PET_MAX_NUMBER,
			'friend_ship'  => LG_FRIEND_SHIP,
			'cant_ask'      => LG_ADD_FRIEND_BY_OTHER,
			'zh_free_time'  => LG_NEXT_SUMMON_FREE_TIME,
			'today_fight_counts'      => LG_TODAY_FIGHT_COUNTS,
			'toady_archemy_counts'      => LG_TODAY_ARCHEMY_COUNTS
		)
	);
	public function __construct(){
		parent::__construct();
	}
	public function get_player_area($name){
		$database = $this->load->database("default", true);
		$query = "select a.areaid from `tbl_user` as a, `tbl_idname` as b where b.name = ".$database->escape($name)." and a.id = b.id";
		$sql = $database->query($query);
		$result = $sql->result();
		$database->close();
		foreach($result as $row){
			return $row->areaid;
		}
		return;
	}
	public function get_player_info($name){
		$area = $this->get_player_area($name);
		if(!$area){
			return;
		}
		$this->load->database($area . "_game_db");
		$query = $this->get_sql_query($name);//可在该文件顶部数组内添加其他查询项目
		$sql = $this->db->query($query);
		$result = $sql->result();
		$this->db->close();
		return $result;
	}
	public function get_sql_query($playername){
		$select_columns = array();
		$tables = array();
		foreach($this->PROPERTY_NAMES as $table => $property_names){
			$tables[] = $table;
			foreach($property_names as $property => $name){
				if('leijichongzhi' == $property){
					$select_columns[] = 'player_yuanbao.leijichongzhi + player_yuanbao.leijixiaofei/20 as leijichongzhi';
				}else{
					$select_columns[] = "$table.$property";	
				}
			}
		}
		$select = implode(',', $select_columns);
		$from = implode(',', $tables);
		$where = "";
		for($i = 0; $i < count($tables) - 1; ++$i){
			if(count($tables) - 2 == $i){
				$where .= "{$tables[$i]}.digitid = {$tables[$i+1]}.digitid";
			}else{
				$where .= "{$tables[$i]}.digitid = {$tables[$i+1]}.digitid and ";
			}
		}
		$sql = "select $select from $from where $where and player_base.playername = ".$this->db->escape($playername).";";
		return $sql;
	}
	public function get_property_names(){
		return $this->PROPERTY_NAMES;
	}
}
?>