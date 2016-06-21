<?php 
class Login_model extends CI_Model {
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
}
?>