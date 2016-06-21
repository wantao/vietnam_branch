<?php
 /**
  * PHP Library for weibo.com
  * @form 乱炖 (http://levi.cg.am/)
  */
require_once 'CMysql.php';

class pailie3
{
    function __construct($src_data_path=NULL,$db_host,$db_name,$db_user,$db_pass,$tbl_name)
    {
    	$this->_db_host = $db_host;
        $this->_db_name = $db_name;
        $this->_db_user = $db_user;
        $this->_db_pass = $db_pass;
        $this->_tbl_name = $tbl_name; 
        $this->_ob_mysql = new CMysql();
    	$this->_ob_mysql->connect($db_host, $db_user, $db_pass, $db_name, 1);
    	if (NULL != $src_data_path) {
    		 $this->_src_data_path = $src_data_path;	
    		 $this->_parse_data_to_db();
    	}
    }
    
    private function _parse_data_to_db() {    	
    	$file_handle = fopen($this->_src_data_path, "r");
    	while (!feof($file_handle)) {
    		$buffer = fgets($file_handle,4096);
    		$arr_tmp = explode(',', $buffer);
    		$this->_ob_mysql->insert($this->_tbl_name,array('qihao' => trim($arr_tmp[0]),
    														'haoma' => trim($arr_tmp[1])
    														)
    		);
    	}
    	fclose($file_handle);
    }
  
    function get_same_haoma() {
    	$select_sql = "SELECT * from $this->_tbl_name INNER join  ( SELECT `haoma` from $this->_tbl_name GROUP BY `haoma` HAVING COUNT(*)>1) as tab2 USING(`haoma`)";
    	return $this->_ob_mysql->get_all($select_sql);	
    }
}
?>