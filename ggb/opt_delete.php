<?php
	require_once 'constants.php';
	
	if($_SERVER['REQUEST_METHOD'] == 'GET'){
		if(!array_key_exists('id', $_GET)){
			return;
		}
	}
	require_once("config.php");
	$url = $MY_DB_CONFIG['url'];
	$user = $MY_DB_CONFIG['user'];
	$password = $MY_DB_CONFIG['psw'];
	$database = $MY_DB_CONFIG['dbname'];
	$table = $MY_DB_CONFIG['table'];
	
	$link = mysql_connect($url, $user, $password) or die("can't" . mysql_error());
	mysql_query("set charset utf8");
	mysql_query("set names utf8");
	mysql_select_db($database) or die("can't select database");
	
	$id = $_GET['id'];
	$sql = "delete from $table where `id`=$id ";
	$search_result = mysql_query($sql) or die("Invalid ".mysql_error());
	
	header('Location:index.php');
?>
