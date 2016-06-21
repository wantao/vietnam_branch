<?php
	require_once 'constants.php';
	
	function writeLog($msg,$log_dir){
		if (!file_exists($log_dir) && !mkdir($log_dir)){
			$err_logFile = date('Y-m-d').'.log';
 			$msg = date('H:i:s').': '.' mkdir '."$log_dir"." error"."\r\n";
 			file_put_contents($logFile,$msg,FILE_APPEND);	

 			$logFile = 'log-'.date('Y-m-d').'.log';
 			$msg = date('H:i:s').': '.$msg."\r\n";
 			file_put_contents($logFile,$msg,FILE_APPEND);
 			return;
		}
 		$logFile = "$log_dir".'/'.date('Y-m-d').'.log';
 		$msg = date('H:i:s').': '.$msg."\r\n";
 		file_put_contents($logFile,$msg,FILE_APPEND);
	}

	if($_SERVER['REQUEST_METHOD'] == 'GET'){
		
	}else if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(!array_key_exists('id', $_POST) || !array_key_exists('area_ids', $_POST) || !array_key_exists('content', $_POST)
				|| !array_key_exists('title', $_POST) || !array_key_exists('activity_title', $_POST)
				|| !array_key_exists('activity_content', $_POST)){
			return;
		}
	}
	
	function safe_string_escape($str) 
	{ 
	   $len=strlen($str); 
	    $escapeCount=0; 
	    $targetString=''; 
	    for($offset=0;$offset<$len;$offset++) { 
	        switch($c=$str{$offset}) { 
	            case "'": 
	            // Escapes this quote only if its not preceded by an unescaped backslash 
	                    if($escapeCount % 2 == 0) $targetString.="\\"; 
	                    $escapeCount=0; 
	                    $targetString.=$c; 
	                    break; 
	            case '"': 
	            // Escapes this quote only if its not preceded by an unescaped backslash 
	                    if($escapeCount % 2 == 0) $targetString.="\\"; 
	                    $escapeCount=0; 
	                    $targetString.=$c; 
	                    break; 
	            case '\\': 
	                    $escapeCount++; 
	                    $targetString.=$c; 
	                    break; 
	            default: 
	                    $escapeCount=0; 
	                    $targetString.=$c; 
	        } 
	    } 
	    return $targetString; 
	} 
	
	if($_SERVER['REQUEST_METHOD'] == 'GET'){
		echo '<meta http-equiv="content-type" content="text/html;charset=utf8" />';
		echo "<form method=\"post\"><table>";
		echo "<tr><td><a>id</a></td><td> </td></tr>";
		echo "<tr><td><a>".NT_SERVER_CODE_LIST."</a></td><td><textarea name=\"area_ids\" row=1 col=20></textarea></td></tr>";
		echo "<tr><td><a>".NT_TITLE."</a></td><td><textarea name=\"title\" row=1 col=20></textarea></td></tr>";
		echo "<tr><td><a>".NT_CONTENT."</a></td><td><textarea name=\"content\" row=10 col=20></textarea></td></tr>";
		echo "<tr><td><a>".NT_ACTIVITY_TITLE."</a></td><td><textarea name=\"activity_title\" row=10 col=20></textarea></td></tr>";
		echo "<tr><td><a>".NT_ACTIVITY_CONTENT."</a></td><td><textarea name=\"activity_content\" row=10 col=20></textarea></td></tr>";
		echo "</table><input type=hidden name=\"id\" value=0 /><input type=submit value=".NT_SUBMIT."><a href=\"index.php\">      ".NT_CANCEL."</a></form>";
		return;
	}else if($_SERVER['REQUEST_METHOD'] == 'POST'){
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
		
		$insert_sql = "insert into `$table` set `area_ids` = '$area_ids', `title` = '$title', `content` = '$content', `activity_title`='$activity_title',`activity_content`='$activity_content'";
		//$search_result = mysql_query("insert into `$table` set `area_ids` = '$area_ids', `title` = '$title', `content` = '$content' ") or die("Invalid ".mysql_error());
		//$insert_sql = safe_string_escape("select * from `tbl_notice` where id='';DELETE from `tbl_notice` where id='10';'';");
		//writeLog($insert_sql,"error-log");
		$search_result = mysql_query($insert_sql);
		header('Location:index.php');
	}
?>


