<head>
<meta charset="utf-8">
<script src="<?php $this->load->helper('url');echo base_url("jquery-1.10.2.js");?>"></script>
<script src="<?php $this->load->helper('url');echo base_url("jquery-ui.js");?>"></script>

<script language="javascript" type="text/javascript" src="<?php $this->load->helper('url');echo base_url("My97DatePicker/WdatePicker.js");?>"></script>

<script>
$(function(){
	$("#submit").click(function(evt){
		var form = document.createElement("form");
		form.action = "/index.php/player_equipment/execute/_" +
		 document.getElementById("player_id").value + "_/";
		form.submit();
	});
}
);

</script>
</head>
<body>
<h1 align="center"><?php echo LG_PLAYER_EQUIPMENT?></h1>
<table align="center">
<td>
<?php echo LG_PLAYER_ID.' '?><input type="text" id="player_id" value="<?php echo $player_id;?>"></input>
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
	echo "<tr><td>".LG_UNIQUE_ID."</td><td>".LG_EQUIPMENT_ID."</td><td>".LG_RESOURCE_NAME."</td><td>".LG_EXP."</td><td>".LG_LEVEL.
	"</td><td>".LG_HOLE1."</td><td>".LG_HOLE2."</td><td>".LG_HOLE3."</td><td>".LG_BELONG_TO_PET_ID."</td><tr>";
	foreach($result as $equipment_info){
		echo "<tr>";
		echo "<td>".$equipment_info->id."</td>";
		echo "<td>".$equipment_info->goods_id."</td>";
		echo "<td>".$equipment_info->name."</td>";
		echo "<td>".$equipment_info->exp."</td>";
		echo "<td>".$equipment_info->level."</td>";
		echo "<td>".$equipment_info->hole_1."</td>";
		echo "<td>".$equipment_info->hole_2."</td>";
		echo "<td>".$equipment_info->hole_3."</td>";
		echo "<td>".$equipment_info->pet_id."</td>";
		echo "<tr>";
	} 
?>
</table>
</div>
</td></tr>
</table>