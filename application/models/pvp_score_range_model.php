<?php

		/*<item id="1" score="0"      win_base="10" lose_base="5" award="2:0:5000,18:0:5" name="召唤师学徒"/> 
		<item id="2" score="200"    win_base="20" lose_base="5" award="2:0:8000,3:0:5,18:0:15" name="见习召唤师"/> 
		<item id="3" score="1200"   win_base="25" lose_base="5" award="2:0:12000,3:0:10,18:0:25" name="初级召唤师"/> 
		<item id="4" score="2450"   win_base="30" lose_base="5" award="2:0:15000,3:0:15,18:0:40" name="中级召唤师"/> 
	   <item id="5" score="4850"   win_base="35" lose_base="5" award="2:0:18000,3:0:20,18:0:55" name="高级召唤师"/> 
		<item id="6" score="7650"   win_base="40" lose_base="5" award="2:0:21000,3:0:25,18:0:70" name="召唤大师"/> 
		<item id="7" score="11650"  win_base="50" lose_base="5" award="2:0:25000,3:0:30,18:0:90" name="灰袍召唤师"/> 
		<item id="8" score="16650"  win_base="60" lose_base="5" award="2:0:30000,3:0:50,18:0:120" name="绿袍召唤师"/> 
		<item id="9" score="23850"  win_base="70" lose_base="5" award="2:0:36000,3:0:80,18:0:150" name="白袍召唤师"/> 
		<item id="10" score="32250" win_base="80" lose_base="5" award="2:0:48000,3:0:100,18:0:200" name="皇家召唤师"/> 
		<item id="11" score="41850" win_base="100" lose_base="5" award="2:0:64000,3:0:120,18:0:250" name="奇迹召唤师"/> 
		<item id="12" score="59850" win_base="120" lose_base="5" award="2:0:82000,3:0:180,18:0:300" name="传奇召唤师"/> */
class Pvp_score_range_model extends CI_Model {
	var $COUNT_PER_PAGE = 10;
	var $range_count = 12;//总共有12个段位
	public function search($area_id){
		$this->load->database($area_id."_game_db");
		$query = $this->db->query("select `id`, count(`score`) as `count` from `player_pvp`  group by `id`;");
		$result = $query->result();
		$this->db->close();
		return $this->make_pvp_range_name($result);
	}
	
	public function get_pvp_range_name($index){
		if (1 == $index) {
			return LG_SUMMONER_TRAINEE.'[0,200)';
		}
		if (2 == $index) {
			return LG_TRAINEE_SUMMONER.'[200,1200)';
		}
		if (3 == $index) {
			return LG_JUNIOR_SUMMONER.'[1200,2450)';
		}
		if (4 == $index) {
			return LG_MIDDLE_SUMMONER.'[2450,4850)';
		}
		
		if (5 == $index) {
			return LG_SENIOR_SUMMONER.'[4850,7650)';
		}
		if (6 == $index) {
			return LG_MASTER_SUMMONER.'[7650,11650)';
		}
		if (7 == $index) {
			return LG_GREY_ROBE_SUMMONER.'[11650,16650)';
		}
		if (8 == $index) {
			return LG_GREEN_ROBE_SUMMONER.'[16650,23850)';
		}
		
		if (9 == $index) {
			return LG_WHITE_ROBE_SUMMONER.'[23850,32250)';
		}
		if (10 == $index) {
			return LG_ROYAL_SUMMONER.'[32250,41850)';
		}
		if (11 == $index) {
			return LG_MIRACLE_SUMMONER.'[41850,59850)';
		}
		if (12 == $index) {
			return LG_LEGEND_SUMMONER.'[59850,+∞)';
		}
		
		return '';
	}
	
	private function push_record($start_index,$ret_result,$count){
		$tmp_arry = array();
		$tmp_arry['pvp_score_range_name'] = $this->get_pvp_range_name($start_index);
		$tmp_arry['count'] = $count;
		array_push($ret_result, $tmp_arry);
		return $ret_result;
	}
	
	private function make_pvp_range_name($result){
		if(0 == count($result)){
			$ret_result = array();
			for ($i = 1; $i <= $this->range_count; $i++) {
				$ret_result = $this->push_record($i,$ret_result,0);	
			}
			return $ret_result;
		}
		$ret_result = array();
		foreach($result as $row){
			$ret_result = $this->push_record($row->id,$ret_result,$row->count);
		} 
		return $ret_result;	
	}
}
?>