<?php
	require_once 'constants.php';
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
	
	$search_result = mysql_query("select * from $table") or die("Invalid ".mysql_error());

	echo "<table align=center border=1>";
	echo "<tr><td>id</td><td>".NT_SERVER_CODE_LIST."</td><td>".NT_TITLE."</td><td>".NT_CONTENT."</td><td>".NT_ACTIVITY_TITLE."</td><td>".NT_ACTIVITY_CONTENT."</td><td>".NT_OPERATE."</td></tr>";
	while($row = mysql_fetch_array($search_result, MYSQL_ASSOC)){
		$id = $row['id'];
		$area_id = $row['area_ids'];
		$title = $row['title'];
		$content = $row['content'];
		$activity_title = $row['activity_title'];
		$activity_content = $row['activity_content'];
		$answer = "<button onclick=opt_edit($id)>".NT_MODIFY."</button><button onclick=opt_delete($id)>".NT_DELETE."</button>";
		$content = str_replace(chr(13),'<br>',$content);
		echo "<tr>
			<td>$id</td>
			<td>$area_id</td>
			<td>$title</td>
			<td>$content</td>
			<td>$activity_title</td>
			<td>$activity_content</td>
			<td>$answer</td>
		</tr>";

	}
	echo "<tr>
	<td><button onclick=opt_add()>".NT_ADD."</button></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	</tr>";
	echo "</table>";
?>