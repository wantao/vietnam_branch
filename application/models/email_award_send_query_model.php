<?php 
class Email_award_send_query_model extends CI_Model {
	public function __construct(){
		parent::__construct();
	}
	
	public function search($id,$area){	
		$db = $this->load->database($area . "_game_db",true);
		$sql = "select * from `player_sysmsg_gm_tool` where digitid = $id;";
		$query_result = $db->query($sql);
		$result = $query_result->result();
		if (0 >= count($result)) {
			$db->close();
			return false;	
		}
		$db->close();
		return $result;	
	}
	
}
?>