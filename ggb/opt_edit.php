<?php
	require_once 'constants.php';
	
	if($_SERVER['REQUEST_METHOD'] == 'GET'){
		if(!array_key_exists('id', $_GET)){
			return;
		}
	}else if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(!array_key_exists('id', $_POST) || !array_key_exists('area_ids', $_POST) || !array_key_exists('content', $_POST)
				|| !array_key_exists('title', $_POST) || !array_key_exists('activity_title', $_POST)
				|| !array_key_exists('activity_content', $_POST)){
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
	
	if($_SERVER['REQUEST_METHOD'] == 'GET'){
		$id = $_GET['id'];
		$search_result = mysql_query("select * from $table where `id` = $id") or die("Invalid ".mysql_error());
		
		if($row = mysql_fetch_array($search_result, MYSQL_ASSOC)){
			$id = $row['id'];
			$area_id = $row['area_ids'];
			$title = $row['title'];
			$content = $row['content'];
			$activity_title = $row['activity_title'];
			$activity_content = $row['activity_content'];
			
			echo '<meta http-equiv="content-type" content="text/html;charset=utf8" />';
			echo "<form method=\"post\"><table>";
			echo "<tr><td><a>id</a></td><td>$id</td></tr>";
			echo "<tr><td><a>".NT_SERVER_CODE_LIST."</a></td><td><textarea name=\"area_ids\" row=1 col=20>$area_id</textarea></td></tr>";
			echo "<tr><td><a>".NT_TITLE."</a></td><td><textarea name=\"title\" row=1 col=20>$title</textarea></td></tr>";
			echo "<tr><td><a>".NT_CONTENT."</a></td><td><textarea name=\"content\" row=10 col=20>$content</textarea></td></tr>";
			echo "<tr><td><a>".NT_ACTIVITY_TITLE."</a></td><td><textarea name=\"activity_title\" row=10 col=20>$activity_title</textarea></td></tr>";
			echo "<tr><td><a>".NT_ACTIVITY_CONTENT."</a></td><td><textarea name=\"activity_content\" row=10 col=20>$activity_content</textarea></td></tr>";
			echo "</table><input type=hidden name=\"id\" value=$id /><input type=submit value=".NT_SUBMIT."><a href=\"index.php\">      ".NT_CANCEL."</a></form>";
			return;
		}
	}else if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$id = $_POST['id'];
		$area_ids = $_POST['area_ids'];
		$area_ids = mysql_escape_string($area_ids);
		$title = $_POST['title'];
		$title = mysql_escape_string($title);
		$content = $_POST['content'];
		$content = mysql_escape_string($content);
		
		$activity_title = $_POST['activity_title'];
		$activity_title = mysql_escape_string($activity_title);
		$activity_content = $_POST['activity_content'];
		$activity_content = mysql_escape_string($activity_content);
		
		$sql = "update `$table` set `area_ids` = '$area_ids', `title` = '$title', `content` = '$content',`activity_title`='$activity_title',`activity_content`='$activity_content' where `id` = '$id'";
		//echo $sql;
		$search_result = mysql_query($sql) or die("Invalid ".mysql_error());
		header('Location:index.php');
	}
?>
