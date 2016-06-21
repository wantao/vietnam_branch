<head>
<meta charset="utf-8">
<script src="<?php $this->load->helper('url');echo base_url("jquery-1.10.2.js");?>"></script>
<script src="<?php $this->load->helper('url');echo base_url("jquery-ui.js");?>"></script>

<script language="javascript" type="text/javascript" src="<?php $this->load->helper('url');echo base_url("My97DatePicker/WdatePicker.js");?>"></script>

<script>
$(function(){
	$("#submit").click(function(evt){
		var form = document.createElement("form");
		form.action = "/index.php/channel_detail/execute/_" +
		 document.getElementById("start_date").value + "_/_" +
		 document.getElementById("end_date").value + "_/";
		form.submit();
	});
}
);

</script>
</head>
<body>
<h1 align="center"><?php echo LG_CHANNEL_DETAIL?></h1>
<table align="center" width="60%">
<tr valign="top">
</tr>
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
	echo "<tr><td>".LG_CHANNEL."</td><td>".LG_TOTAL_AMOUNT_OF_RECHARGE."</td></tr>";
	foreach($result as $row){
		echo "<tr>";
		echo "<td>".get_channel($row->app_id)."</td>";
		echo "<td>".$row->total_money."</td>";
		echo "<tr>";
	} 
?>
</table>
</div>
</td></tr>
</table>