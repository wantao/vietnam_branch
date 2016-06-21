<?php 
	$db = array(
		//全局数据库z_all
		'default' => array(
			'hostname' => '127.0.0.1:3306',
			'username' => 'root',
			'password' => '123456',
			'database' => 'z_all',
			'dbdriver' => 'mysql',
			'dbprefix' => '',
			'pconnect' => FALSE,
			'db_debug' => TRUE,
			'cache_on' => FALSE,
			'cachedir' => '',
			'char_set' => 'utf8',
			'dbcollat' => 'utf8_general_ci',
			'swap_pre' => '',
			'autoinit' => TRUE,
			'stricton' => FALSE
		),
		//1区game_db和game_db//begin
		'1_game_db' => array(
			'hostname' => '127.0.0.1:3306',
			'username' => 'root',
			'password' => '123456',
			'database' => 'z_gamedb_1',
			'dbdriver' => 'mysql',
			'dbprefix' => '',
			'pconnect' => FALSE,
			'db_debug' => TRUE,
			'cache_on' => FALSE,
			'cachedir' => '',
			'char_set' => 'utf8',
			'dbcollat' => 'utf8_general_ci',
			'swap_pre' => '',
			'autoinit' => TRUE,
			'stricton' => FALSE
		),
		'1_game_log' => array(
			'hostname' => '127.0.0.1:3306',
			'username' => 'root',
			'password' => '123456',
			'database' => 'z_gamelog_1',
			'dbdriver' => 'mysql',
			'dbprefix' => '',
			'pconnect' => FALSE,
			'db_debug' => TRUE,
			'cache_on' => FALSE,
			'cachedir' => '',
			'char_set' => 'utf8',
			'dbcollat' => 'utf8_general_ci',
			'swap_pre' => '',
			'autoinit' => TRUE,
			'stricton' => FALSE
		),
		//1区game_db和game_db//end
	);
?>