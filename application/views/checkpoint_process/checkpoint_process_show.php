<head>
<meta charset="utf-8">
<script src="<?php $this->load->helper('url');echo base_url("jquery-1.10.2.js");?>"></script>
<script src="<?php $this->load->helper('url');echo base_url("jquery-ui.js");?>"></script>

<script language="javascript" type="text/javascript" src="<?php $this->load->helper('url');echo base_url("My97DatePicker/WdatePicker.js");?>"></script>

<script>
$(function(){
	$("#submit").click(function(evt){
		var form = document.createElement("form");
		form.action = "/index.php/checkpoint_process/execute/_" +
		document.getElementById("area").value + "_/_" +
		document.getElementById("type").value + "_/";
		form.submit();
	});
}
);

</script>
</head>
<body>
<h1 align="center"><?php echo LG_CHECKPOINT_PROCESS?></h1>
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
<?php echo LG_CHECKPOINT_TYPE?>
<select name="type" id="type">
<?php 
	foreach($type_list as $type){
		if (1 == $type['selected']) {
			echo "<option value=". $type['id']." selected>".$type['name']."</option>";	
		} else {
			echo "<option value=". $type['id'].">".$type['name']."</option>";	
		}
	}
?>
</select>
</td>
</tr>

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
	echo "<tr><td>".LG_CHAPTER_ID."</td><td>".LG_CHECKPOINT_ID."</td><td>".LG_PEOPLE_TOTAL_NUMBER."</td><tr>";
	foreach($result as $info){
		echo "<tr>";
		echo "<td>".$info->chapter."</td>";
		echo "<td>".$info->checkpoint."</td>";
		echo "<td>".$info->count."</td>";
		echo "<tr>";
	} 
?>
</table>
</div>
</td></tr>
</body>