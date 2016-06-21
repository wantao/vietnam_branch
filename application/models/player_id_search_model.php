<?php 
class Player_id_search_model extends CI_Model {
	public function __construct(){
		parent::__construct();
	}
	public function search($id){
		$this->load->database("default");
		$query = "select a.id,name,areaid,platform,activetime,account from tbl_user as a,tbl_idname as b where a.id = ".$this->db->escape($id)." and a.id = b.id";
		$sql = $this->db->query($query);
		$result = $sql->result();
		$this->db->close();
		return $result;
	}
	
}
?>