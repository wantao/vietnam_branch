<?php 
class Server_state_model extends CI_Model {
	var $PROPERTY_NAMES = array(
		'id'                 => LG_AREA_NUMBER,
		'game_server_time'   => LG_GAME_SERVER,
		'login_server_time'  => LG_LOGIN_SERVER,
	);
	public function __construct(){
		parent::__construct();
	}

	public function get_server_state_info(){
		$this->load->database("default");
		$select_columns = array();
		foreach($this->get_server_state_property_names() as $property => $name){
			$select_columns[] = "tbl_server_state.$property";
		}
		$select = implode(',', $select_columns);
		$query = "select $select from tbl_server_state";
		$sql = $this->db->query($query);
		$result = $sql->result();
		$t_now = time() ;//+ 8*3600;
		foreach($result as $row){
			$this->set_server_state($t_now, $row->game_server_time);
			$this->set_server_state($t_now, $row->login_server_time);
		}
		$this->db->close();
		return $result;
	}
	
	public function get_server_state_property_names(){
		return $this->PROPERTY_NAMES;
	}
	
	public function set_server_state($t_now, &$server){
		$t_server = strtotime($server);
		if($t_now - $t_server > 120){
			$server = LG_CLOSE;
		}else{
			$server = LG_OPEN;
		}
		return $server;
	}
}
?>