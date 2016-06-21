<head>
<meta charset="utf-8">
<script src="<?php $this->load->helper('url');echo base_url("jquery-1.10.2.js");?>"></script>
<script src="<?php $this->load->helper('url');echo base_url("jquery-ui.js");?>"></script>

<script language="javascript" type="text/javascript" src="<?php $this->load->helper('url');echo base_url("My97DatePicker/WdatePicker.js");?>"></script>

<script>
$(function(){
	$("#submit").click(function(evt){
		var form = document.createElement("form");
		form.action = "/index.php/gem/execute/_" +
		 document.getElementById("area").value + "_/_" +
		 document.getElementById("start_date_time").value + "_/_" +
		 document.getElementById("end_date_time").value + "_/_" +
		 document.getElementById("player_id").value + "_/_" +
		 document.getElementById("desc").value + "_/_" +
		 document.getElementById("type").value + "_/";
		form.submit();
	});
}
);

</script>
</head>
<body>
<h1 align="center"><?php echo LG_GEM_GET_AND_USE?></h1>
<table align="center" width="60%">
<tr valign="top">
<td>
<?php echo LG_SELECT_SERVER?>
</td>
<td>
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
</tr>
<tr>
<td>
<?php echo LG_TIME_RANGE?>
</td>
<td>
<?php echo LG_TIME_FROM?><input type="text" class="Wdate" name="start_date_time" id="start_date_time" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'2013-01-01 00:00:00',maxDate:'2020-01-01 00:00:00'})" value="<?php echo $start_date_time;?>"/>
</td>
<td>
<?php echo LG_TIME_TO?><input type="text" class="Wdate" name="end_date_time" id="end_date_time" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'2013-01-01 00:00:00',maxDate:'2020-01-01 00:00:00'})" value="<?php echo $end_date_time;?>"/>
</td>
</tr>
<tr>
<td><?php echo LG_PLAYER_ID."(".LG_OPTIONAL.")"?></td>
<td><input type="text" id="player_id"></td>
</tr>
<tr>
<td><?php echo LG_DESCRIPTION."(".LG_OPTIONAL.")"?></td>
<td><input type="text" id="desc"></td>
</tr>
<tr>
<td><?php echo LG_TYPE?></td>
<td>
<select id="type">
<?php
	foreach($type as $row){
		echo "<option value=".$row["value"].">".$row["name"]."</option>";
	} 
?>
</select>
</td>
</tr>
<tr>
<td><?php echo LG_TOTAL?></td>
<td><?php echo (count($result) == 0? 0 : $result["total"])?></td>
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
	echo "<tr><td>id</td><td>".LG_NAME."</td><td>".LG_CONSUME."(".LG_NEGATIVE_NUMBER.")/".LG_GET."(".LG_POSITIVE_NUMBER.")"."</td><td>".LG_PUCHASE_TIME."</td></tr>";
	foreach($result["result"] as $row){
		echo "<tr><td>$row->player_id</td><td>$row->playername</td><td>$row->nchange</td><td>$row->activetime</td></tr>";
	} 
	$next = $result["next_page_url"];
	$previous = $result["previous_page_url"];
	echo "<tr>";
	if(strlen($previous) == 0){
		echo "<td></td><td></td>";
	} else{
		echo "<td><a href=$previous>".LG_LAST_PAGE."</a></td><td></td>";
	}
	if(strlen($next) == 0){
		echo "<td></td><td></td>";
	} else{
		echo "<td></td><td><a href=$next>".LG_Next_PAGE."</a></td>";
	}
	echo "</tr>";
?>
</table>
</div>
</td></tr>
</table>