<head>
<meta charset="utf-8">
<script src="<?php $this->load->helper('url');echo base_url("jquery-1.10.2.js");?>"></script>
<script src="<?php $this->load->helper('url');echo base_url("jquery-ui.js");?>"></script>

<script language="javascript" type="text/javascript" src="<?php $this->load->helper('url');echo base_url("My97DatePicker/WdatePicker.js");?>"></script>

<script>
$(function(){
	$("#submit").click(function(evt){
		var form = document.createElement("form");
		form.action = "/index.php/online/execute/_" +
		 document.getElementById("area").value + "_/_" +
		 document.getElementById("start_date_time").value + "_/_" +
		 document.getElementById("end_date_time").value + "_/"; 
		form.submit();
	});
}
);

</script>
</head>
<body>
<h1 align="center"><?php echo LG_ONLINE_NUMBER?></h1>
<table align="center" width="60%">
<tr valign="top">
<td width="50%">
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
</tr>
<tr>
<td>
<?php echo LG_TIME_RANGE?>
<?php echo LG_TIME_FROM?><input type="text" class="Wdate" name="start_date_time" id="start_date_time" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'2013-01-01 00:00:00',maxDate:'2020-01-01 00:00:00'})" value="<?php echo $start_date_time;?>"/>
</td>
<td>
<?php echo LG_TIME_TO?><input type="text" class="Wdate" name="end_date_time" id="end_date_time" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'2013-01-01 00:00:00',maxDate:'2020-01-01 00:00:00'})" value="<?php echo $end_date_time;?>"/>
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
	echo "<tr><td>".LG_ACTIVE_NUMBER."</td><td>".LG_ONLINE_NUMBER."</td><td>".LG_TIME."</td></tr>";
	foreach($result["result"] as $row){
		echo "<tr><td>$row->playernumber</td><td>$row->sessionnumber</td><td>$row->logtime</td></tr>";
	} 
	$next = $result["next_page_url"];
	$previous = $result["previous_page_url"];
	echo "<tr>";
	if(strlen($previous) == 0){
		echo "<td></td>";
	} else{
		echo "<td><a href=$previous>".LG_LAST_PAGE."</a></td>";
	}
	if(strlen($next) == 0){
		echo "<td></td>";
	} else{
		echo "<td><a href=$next>".LG_Next_PAGE."</a></td>";
	}
	echo "</tr>";
?>
</table>
</div>
</td></tr>
</table>