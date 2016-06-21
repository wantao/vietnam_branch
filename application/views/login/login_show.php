<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<script type="text/javascript">
</script>
<head>
</head>
<body>
<form action="/index.php/login/check" method="post">
<h1 align="center"><?php echo LG_BACKSTAGE_MANAGEMENT_SYSTEM?></h1>
<table align="center">
	<tr>
	<td><?php echo LG_LOGIN_ACCOUNT?></td>
	<td><input type="text" name="username"></td>
	</tr>
	<tr>
	<td><?php echo LG_LOGIN_PASSWORD?></td>
	<td><input type="text" name="password"></td>
	</tr>
	<tr>
	<td><?php echo LG_VERIFICATION_CODE?></td>
	<td><input type="text" name="checkcode"></td>
	<td><img src="/index.php/login/checkcode"?></td>
	</tr>
	<?php if($error == 1){
	echo "<tr><td>".LG_ERROR_VERIFICATION_CODE."</td></tr>";
	}?>
	<?php if($error == 2){
	echo "<tr><td>".LG_ERROR_ACCOUNT_OR_PASSWORD."</td></tr>";
	}?>
	<?php if($error == 3){
	echo "<tr><td>".LG_INVALID_GM_ACCOUNT."</td></tr>";
	}?>
</table>
<div align="center">
<input type="submit" name="submit" value="submit">
</div>
</form>
</body>
</html>