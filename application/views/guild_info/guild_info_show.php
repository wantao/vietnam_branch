<head>
<meta charset="utf-8">
<script src="<?php $this->load->helper('url');echo base_url("jquery-1.10.2.js");?>"></script>
<script src="<?php $this->load->helper('url');echo base_url("jquery-ui.js");?>"></script>

<script language="javascript" type="text/javascript" src="<?php $this->load->helper('url');echo base_url("My97DatePicker/WdatePicker.js");?>"></script>

<script>
$(function(){
	$("#submit").click(function(evt){
		var form = document.createElement("form");
		form.action = "/index.php/guild_info/execute/_" +
		document.getElementById("area").value + "_/";
		form.submit();
	});
}
);

</script>
</head>
<body>
<h1 align="center"><?php echo LG_GUILD_INFO?></h1>
<table align="center">
<td>
<?php echo LG_SELECT_SERVER?>
<select name="area" id="area">
<?php 
	foreach($area_list as $area){
		if (1 == $area['selected']) {
			echo "<option value=". $area['id']." selected>".$area['name']."</option>";	
		} else {
			echo "<option value=". $area['id'].">".$area['name']."</option>";	
		}
	}
?>
</select>
</td>
<tr>
<td>
<button id="submit"><?php echo LG_EXECUTE?></button>
</td>
</tr>
</table>

<tr><td>
<div id="result">
<table align="center" border="true">
<?php
	if(count($result) == 0){
		return;
	}
	echo "<tr><td>".LG_LIANMENG_ID."</td><td>".LG_LIANMENG_NAME."</td><td>".LG_LIANMENG_LEVEL."</td><td>".LG_LIANMENG_MEMBER."</td><tr>";
	foreach($result as $info){
		echo "<tr>";
		echo "<td>".$info->lianmeng_id."</td>";
		echo "<td>".$info->name."</td>";
		echo "<td>".$info->level."</td>";
		echo "<td>".$info->lianmeng_member."</td>";
		echo "<tr>";
	} 
?>
</table>
</div>
</td></tr>
</body>