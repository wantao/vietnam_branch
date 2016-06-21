<table border=1 align="center">
	<tr>
		<th><?php echo LG_PLAYER_ID?></th><th><?php echo LG_EMAIL_TYPE?></th><th><?php echo LG_EMAIL_TITLE?></th><th><?php echo LG_EMAIL_CONTENT?></th><th><?php echo LG_EMAIL_AWARDS?></th><th><?php echo LG_EMAIL_AWARD_SEND_TIME?></th>
	</tr>
	<?php
		foreach($result as $row){
			echo "<tr><td>{$row->digitid}</td><td>{$row->msg_type}</td><td>{$row->title}</td><td>{$row->content}</td><td>{$row->award}</td><td>{$row->currenttime}</td></tr>";
		}
	?>
</table>