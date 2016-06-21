<?php
class Remain_model extends CI_Model {
	// 留存率显示

	//当天创建角色数量
	public function get_dnu($area_id, $date){
		$db = $this->load->database("default", true);
		$area_cond = '';
		if ($area_id != 0) {
			$area_cond = " `areaid`=$area_id AND ";
		}
		//echo $date . "</p>";
		$sql = "SELECT DATE_FORMAT(activetime, '%Y-%m-%d') as ymd, count(*) as DNU FROM `tbl_user` WHERE $area_cond DATEDIFF(activetime, '$date')>=0 and DATEDIFF(activetime, '$date')<30 GROUP BY ymd ;"; 
		$query = $db->query($sql);
		//echo $sql . "</p>";
		
		$map = array();
		
		$result = $query->result();
		foreach($result as $row){
			$_date = $row->ymd;
			$_DNU = $row->DNU;
			if(isset($map[$_date])){
				$map[$_date]['DNU'] = $_DNU;
			}else{
				$map[$_date] = array();
				$map[$_date]['DNU'] = $_DNU;
			}
		}
		
		// dru1
		$sql = "SELECT DATE_FORMAT(activetime, '%Y-%m-%d') as ymd, count(*) as dru1 FROM `tbl_user` 
				WHERE $area_cond DATEDIFF(activetime, '$date')>=0 and DATEDIFF(activetime, '$date')<30 and `tbl_user`.dru1=1  GROUP BY ymd;"; 
		$query = $db->query($sql);
		$r1 = $query->result();
		//echo $sql . "</p>";
		//print_r($r1);
		foreach($r1 as $row){
			$map[$row->ymd]['dru1'] = $row->dru1;
		}
		
		// dru3
		$sql = "SELECT DATE_FORMAT(activetime, '%Y-%m-%d') as ymd, count(*) as dru3 FROM `tbl_user` 
				WHERE $area_cond DATEDIFF(activetime, '$date')>=0 and DATEDIFF(activetime, '$date')<30 and `tbl_user`.dru3=1  GROUP BY ymd;"; 
		$query = $db->query($sql);
		$r3 = $query->result();
		//print_r($r3);
		foreach($r3 as $row){
			$map[$row->ymd]['dru3'] = $row->dru3;
		}
		
		// dru7
		$sql = "SELECT DATE_FORMAT(activetime, '%Y-%m-%d') as ymd, count(*) as dru7 FROM `tbl_user` 
				WHERE $area_cond DATEDIFF(activetime, '$date')>=0 and DATEDIFF(activetime, '$date')<30 and `tbl_user`.dru7=1  GROUP BY ymd;"; 
		$query = $db->query($sql);
		$r7 = $query->result();
		//print_r($r7);
		foreach($r7 as $row){
			$map[$row->ymd]['dru7'] = $row->dru7;
		}
		
		// dru15
		$sql = "SELECT DATE_FORMAT(activetime, '%Y-%m-%d') as ymd, count(*) as dru15 FROM `tbl_user` 
				WHERE $area_cond DATEDIFF(activetime, '$date')>=0 and DATEDIFF(activetime, '$date')<30 and `tbl_user`.dru15=1  GROUP BY ymd;"; 
		$query = $db->query($sql);
		$r15 = $query->result();
		//print_r($r15);
		foreach($r15 as $row){
			$map[$row->ymd]['dru15'] = $row->dru15;
		}
		
		// dru30
		$sql = "SELECT DATE_FORMAT(activetime, '%Y-%m-%d') as ymd, count(*) as dru30 FROM `tbl_user` 
				WHERE $area_cond DATEDIFF(activetime, '$date')>=0 and DATEDIFF(activetime, '$date')<30 and `tbl_user`.dru30=1  GROUP BY ymd;"; 
		$query = $db->query($sql);
		$r30 = $query->result();
		//print_r($r30);
		foreach($r30 as $row){
			$map[$row->ymd]['dru30'] = $row->dru30;
		}
		
		$db->close();
		
		//print_r($map);
		return $map;
	}
	
	
}
?>