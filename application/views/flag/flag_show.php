<head>
<meta charset="utf-8">
<script src="<?php $this->load->helper('url');echo base_url("jquery-1.10.2.js");?>"></script>
<script>
$(function(){
	$("#submit").click(function(evt){
		var form = document.createElement("form");
		form.action = "/index.php/flag/execute/_" + document.getElementById("area").value + "_/";
		form.submit();
	});
});

</script>
</head>
<body>
<h1 align="center"><?php echo LG_SYSTEM_GLOBAL?></h1>
<table align="center">
<tr valign="top">
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
	echo "<tr><td>flag_key</td><td>int_val1</td><td>activetime</td><td>desc</td></tr>";
	foreach($result as $row){
		echo "<tr><td>$row->flag_key</td><td>$row->int_val1</td><td>$row->activetime</td><td>$row->desc</td></tr>";
	} 
?>
</table>
</div>
</td></tr>
</table>