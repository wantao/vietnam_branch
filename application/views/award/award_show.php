<head>
<meta charset="utf-8"> 
<script src="<?php $this->load->helper('url');echo base_url("jquery-1.10.2.js");?>"></script>
<script src="<?php $this->load->helper('url');echo base_url("jquery-ui.js");?>"></script>
<script language="javascript" type="text/javascript"></script>

<script>
$(function(){
	$("#submit").click(function(evt){

		var div_id;
		var mode;
		var modes = document.getElementsByName("mode");
		for(var i = 0; i < modes.length; i++){
			if(modes[i].checked){
				mode = modes[i].value;
				div_id = "mode" + mode;
				break;
			}
		}
		if(!div_id)
			return;
		var div = document.getElementById(div_id);
		//var value = escape(div.getElementsByTagName("input")[1].value);
		var value = div.getElementsByTagName("input")[1].value;
		//去掉左右两边的空格
		var value = value.replace(/(^\s*)|(\s*$)/g, "");
		var server_select = document.getElementById("server_list");
		var server = escape(server_select.options[server_select.selectedIndex].getAttribute("server_id"));

		var msg_type_select = document.getElementById("sys_msg_type_list");
		var msg_type = escape(msg_type_select.options[msg_type_select.selectedIndex].getAttribute("sys_msg_type_id"));
		if (0 == msg_type.length) {
			return;
		}
		//var msg_type = escape(document.getElementById("msg_type").value);
		//去掉字符串前后两端的空格
		var msg_title = document.getElementById("msg_title").value;
		var msg_title = msg_title.replace(/(^\s*)|(\s*$)/g, "");
		if (0 == msg_title.length) {
			return;
		}
		var msg_title = encodeURI(msg_title);
		//var msg_title = encodeURI(document.getElementById("msg_title").value);
		//去掉字符串前后两端的空格
		var msg_content = document.getElementById("msg_content").value;
		var msg_content = msg_content.replace(/(^\s*)|(\s*$)/g, "");
		if (0 == msg_content.length) {
			return;
		}
		var msg_content = encodeURI(msg_content);
		//var msg_content = encodeURI(document.getElementById("msg_content").value);
		var award = document.getElementById("award").value;
		var award = escape(award.replace(/(^\s*)|(\s*$)/g, ""));
		value = escape(value.replace(/(^\s*)|(\s*$)/g, ""));
		if(!value || (mode == 2 && !server)){
			return;
		}
		
		if (award == '') {
			award = '%20';
		} 
		var form = document.createElement("form");
		form.action = "/index.php/award/execute/_" +
		 mode + "_/_" + value + "_/_" + msg_type + "_/_" + msg_title +
		 "_/_" + msg_content + "_/_" + encodeURI(award) + "_/_" + server + "_/";
		form.submit();
	});
}
);
</script>
</head>
<body>
<h1 align="center"><?php echo LG_SEND_AWARD?></h1>
<div align="center">

<div>
<?php echo LG_SELECT_SERVER?><select id="server_list">
<?php 
	foreach($server_list as $server_info){
		if (1 == $server_info['selected']) {
			echo "<option server_id=". $server_info['id'] ." server_url=".$server_info['url'].":". $server_info['port'] ." selected>".$server_info['name']."</option>";	
		} else {
			echo "<option server_id=". $server_info['id'] ." server_url=".$server_info['url'].":". $server_info['port'] .">".$server_info['name']."</option>";	
		}
	}
?>
</select>
</div>

<div id="mode1">
<input type="radio" name="mode" value="1" checked><?php echo LG_SEND_TO_A_SINGLE_PLAYER.' '.LG_PLAYER_ID?><input type="text" name="value" value=""><br>
</div>

	
<div id="mode2">
<input type="radio" name="mode" value="2"><?php echo LG_SEND_TO_MULTIPLE_PLAYERS?>  ids(id1:id2:id3...(count_max:100))<input type="text" name="value" value=""><br>
</div>

<div id="mode3">
<input type="radio" name="mode" value="3"><?php echo LG_SEND_TO_ABOVE_THE_LEVEL_INCLUDE.' '.LG_PLAYER_LEVEL?><input type="text" name="value" value=""><br>
</div>

<div>
<?php echo LG_EMAIL_TYPE?><select id="sys_msg_type_list">
<?php 
	foreach($sys_msg_type_list as $sys_msg_type_info){
		echo "<option sys_msg_type_id=". $sys_msg_type_info['id'] .">".$sys_msg_type_info['name']."</option>";
	}
?>
</select>
</div>
<div>
<?php echo LG_EMAIL_TITLE?><textarea id="msg_title" type="text" name="detail" value=""></textarea>
</div>
<div><?php echo LG_EMAIL_CONTENT?><textarea id="msg_content" type="text" name="detail" value=""></textarea>
</div>

<div>
<?php echo LG_AWARD_DESCRIPTION?><input id="award" type="text" name="detail" value=""><a><?php echo LG_FORMATE?>：type:id:number[,type:id:number]...</a><br>
<button type="button" id="submit" ><?php echo LG_EXECUTE?></button><br>
<?php echo LG_STATUS.':'?><div id="send_status"><?php echo $send_status?></div>
</div>

<h1 align="center"><?php echo LG_RECENT_SEND_RECORD?></h1>
<div id="recent_record">
<table border=1 align="center">
	<tr>
		<th><?php echo LG_EXECUTE_ACCOUNT?></th><th><?php echo LG_EXECUTE_IP?></th><th><?php echo LG_EMAIL_TYPE?></th><th><?php echo LG_RECIEVE_TYPE?></th><th>
		<?php echo LG_RECIEVERS?></th><th><?php echo LG_EMAIL_TITLE?></th><th><?php echo LG_EMAIL_CONTENT?></th><th><?php echo LG_EMAIL_AWARDS?></th><th><?php echo LG_EMAIL_AWARD_SEND_TIME?></th>
	</tr>
	<?php
		foreach($recent_record as $row){
			echo "<tr><td>{$row->execute_account}</td><td>{$row->execute_ip}</td><td>{$row->msg_type}</td><td>{$row->recieve_type}</td><td>{$row->reciever}</td><td>{$row->title}</td><td>{$row->content}</td><td>{$row->award}</td><td>{$row->currenttime}</td></tr>";
		}
	?>
</table>
</div>