<?php

	//开区数据库配置
	$global_db = array(
		//全局数据库z_all
		'default' => array(
			'hostname' => '127.0.0.1',
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
			'hostname' => '127.0.0.1',
			'username' => 'root',
			'password' => '123456',
			'database' => 'z_gamedb',
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
			'hostname' => '127.0.0.1',
			'username' => 'root',
			'password' => '123456',
			'database' => 'z_gamelog',
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
		
		//2区game_db和game_db//begin
		'2_game_db' => array(
			'hostname' => '127.0.0.1',
			'username' => 'root',
			'password' => '123456',
			'database' => 'z1_gamedb',
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
		'2_game_log' => array(
			'hostname' => '127.0.0.1',
			'username' => 'root',
			'password' => '123456',
			'database' => 'z1_gamelog',
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
		//2区game_db和game_db//end
		//....
	);

	//开区服务器相关配置
	/*$server_list = array(
		//区号 =>区信息,
		//区信息各字段说明，belong_to:0:android区，1:ios区，current_code:当前区号current_code:当前区号，name:区名,login_server_ip：登陆服务器ip，login_server_port：登陆服务器端口
		//udp_server_ip:udp 服务器ip，udp_server_port：登陆服务器端口，"status":服务器状态（运维人员可以设定该值，让该区显示相应的状态），0：新区，1：爆满,2:维护
		1 => array("belong_to"=>"0","current_code"=>"1", "name"=>"亞洲1區", "login_server_ip"=>"54.65.229.66","login_server_port"=>"10001",
		"udp_server_ip"=>"54.65.229.66", "udp_server_port"=>"11009", "udp_key"=>"43D5B17B19E9D1AA75589962D065C18D","status"=>"0"),	
			
		2 => array("current_code"=>"2", "name"=>"二区", "login_server_ip"=>"210.66.186.86","login_server_port"=>"10002",
		"udp_server_ip"=>"210.66.186.86", "udp_server_port"=>"11010", "udp_key"=>"43D5B17B19E9D1AA75589962D065C18D","status"=>"2"),
		
		
		
		2 => array("belong_to"=>"1","current_code"=>"2", "name"=>"亞洲1區", "login_server_ip"=>"54.65.229.66","login_server_port"=>"10002",
		"udp_server_ip"=>"54.65.229.66", "udp_server_port"=>"11010", "udp_key"=>"43D5B17B19E9D1AA75589962D065C18D","status"=>"2"),	
			
		10002 => array("current_code"=>"10002", "name"=>"亞洲2區", "login_server_ip"=>"54.65.229.66","login_server_port"=>"10002",
		"udp_server_ip"=>"54.65.229.66", "udp_server_port"=>"11010", "udp_key"=>"43D5B17B19E9D1AA75589962D065C18D","status"=>"0"),
		
	
	);*/
	
	//公告内容配置
	//title:公告标题，content：公告内容，下面已配了两条样板内容，如果要新增一条，只需样板再加一条即可
	/*$notice_content = array('title'=>'最新公告','content'=>array(
		array('title'=>'新功能上线', 'content'=>array( array('sub_content'=>'1.全新龙族系统上线'),
													   array('sub_content'=>'2.好友增加喂龙系统'),
													 )
			  ),
		array('title'=>'本周/春节活动介绍', 'content'=>array(array('sub_content'=>'1.每日登陆额外送xxx金币'),
													 		array('sub_content'=>'2.春节累计登陆一天'),											 
													       )
			  ),
																)
	);*/
	
	
	
	
	
	
	require_once 'self_common.php';

?>

