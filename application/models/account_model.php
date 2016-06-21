<?php 
class Account_model extends CI_Model {
	public function __construct(){
		parent::__construct();
	}
	public function search($account){
		$this->load->database("default");
		$query = "select name,b.`id`,areaid,platform,activetime,account from tbl_user as a,tbl_idname as b where a.account = ".$this->db->escape($account)." and a.id = b.id";
		$sql = $this->db->query($query);
		$result = $sql->result();
		$this->db->close();
		return $result;
	}
	
}
?>