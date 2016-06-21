<table border=1 align="center">
	<tr>
		<th><?php echo LG_ACCOUNT?></th><th><?php echo LG_NAME?></th><th><?php echo LG_PLAYER_ID?></th><th><?php echo LG_SERVER?></th><th><?php echo LG_LOGIN_PLATFORM?></th><th><?php echo LG_CREATE_TIME?></th>
	</tr>
	<?php
		foreach($result as $row){
			echo "<tr><td>{$row->account}</td><td>{$row->name}</td><td>{$row->id}</td><td>{$row->areaid}</td><td>{$row->platform}</td><td>{$row->activetime}</td></tr>";
		}
	?>
</table>