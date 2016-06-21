<head>
<meta charset="utf-8">
<script src="<?php $this->load->helper('url');echo base_url("jquery-1.10.2.js");?>"></script>
<script src="<?php $this->load->helper('url');echo base_url("jquery-ui.js");?>"></script>

<script language="javascript" type="text/javascript" src="<?php $this->load->helper('url');echo base_url("My97DatePicker/WdatePicker.js");?>"></script>

<script>
$(function(){
	$("#submit").click(function(evt){
		var form = document.createElement("form");
		form.action = "/index.php/total/execute/_" +
		 document.getElementById("start_date").value + "_/_" +
		 document.getElementById("end_date").value + "_/";
		form.submit();
	});
	$("#reset").click(function(evt){
		var form = document.createElement("form");
		form.action = "/index.php/total/execute_reset/_" +
		 document.getElementById("start_date").value + "_/_" +
		 document.getElementById("end_date").value + "_/";
		form.submit();
	});
	$("#export").click(function(evt){
		var form = document.createElement("form");
		form.action = "/index.php/total/execute_export/_" +
		 document.getElementById("start_date").value + "_/_" +
		 document.getElementById("end_date").value + "_/";
		form.submit();
	});
}
);

</script>
</head>
<body>
<h1 align="center"><?php echo LG_EVERY_AREA_GATHER?></h1>
<table align="center" width="60%">
<tr>
<td>
<?php echo LG_TIME_RANGE?>
</td>
<td>
<?php echo LG_TIME_FROM?><input type="text" class="Wdate" name="start_date" id="start_date" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'2013-01-01',maxDate:'2020-01-01'})" value="<?php echo $start_date;?>"/>
</td>
<td>
<?php echo LG_TIME_TO?><input type="text" class="Wdate" name="end_date" id="end_date" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'2013-01-01',maxDate:'2020-01-01'})" value="<?php echo $end_date;?>"/>
</td>
</tr>
<tr>
<td>
<button id="submit"><?php echo LG_EXECUTE?></button>
<!--<button id="reset">重置</button>
<button id="export">导出</button>
--></td>
</tr>
</table>

<tr><td>
<div id="result">
<table align="center" border="true">
<?php
	if(count($result) == 0){
		return;
	}
	echo "<tr><td>".LG_AREA_NUMBER."</td><td>".LG_TOTAL_NUMBER_OF_PLAYER."</td><td>".LG_MAX_NUMBER_ONLINE.
	"</td><td>".LG_THE_NUMBER_OF_RECHARGE."</td><td>".LG_RECHARGE_TIMES."</td><td>".LG_TOTAL_AMOUNT_OF_RECHARGE.
	"</td><td>".LG_AVERAGE_DAILY_AMOUNT_OF_RECHARGE."</td><td>".LG_AVERAGE_DAILY_ARPRU."</td><td>".LG_AVERAGE_DAILY_ARPPU."</td><td>".LG_AVERAGE_DAILY_PR."</td></tr>";
	foreach($result as $row){
		echo "<tr>";
		echo "<td>".$row["area_id"]."</td>";
		echo "<td>".$row["player_count"]."</td>";
		echo "<td>".$row["max_online"]."</td>";
		echo "<td>".$row["charge_player"]."</td>";
		echo "<td>".$row["charge_times"]."</td>";
		echo "<td>".$row["charge_money"]."</td>";
		echo "<td>".$row["charge_money_per_day"]."</td>";
		echo "<td>".$row["arpru_per_day"]."</td>";
		echo "<td>".$row["arppu_per_day"]."</td>";
		echo "<td>".$row["pr_per_day"]."</td>";
		echo "</tr>";
	} 
?>
</table>
</div>
</td></tr>
</table>