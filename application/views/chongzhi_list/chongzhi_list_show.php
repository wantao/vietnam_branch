<head>
<meta charset="utf-8">
<script src="<?php $this->load->helper('url');echo base_url("jquery-1.10.2.js");?>"></script>
<script src="<?php $this->load->helper('url');echo base_url("jquery-ui.js");?>"></script>

<script language="javascript" type="text/javascript" src="<?php $this->load->helper('url');echo base_url("My97DatePicker/WdatePicker.js");?>"></script>

<script>
$(function(){
	$("#submit").click(function(evt){
		var form = document.createElement("form");
		form.action = "/index.php/chongzhi_list/execute/_" +
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
<h1 align="center"><?php echo LG_RECHARGE_RANK?></h1>
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
<?php echo LG_DATETIME?>
</td>
<td>
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
	echo "<tr><td>".LG_ITEM_ID."</td><td>".LG_COUNT."</td><td>".LG_SUM."</td></tr>";
	foreach($result as $row){
		echo "<tr>";
		echo "<td>".$row["item_id"]."</td>";
		echo "<td>".$row["count"]."</td>";
		echo "<td>".$row["sum"]."</td>";
		echo "<tr>";
	} 
?>
</table>
</div>
</td></tr>
</table>