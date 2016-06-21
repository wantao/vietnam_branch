<head>
<meta charset="utf-8">
<script src="<?php $this->load->helper('url');echo base_url("jquery-1.10.2.js");?>"></script>
<script src="<?php $this->load->helper('url');echo base_url("jquery-ui.js");?>"></script>

<script language="javascript" type="text/javascript" src="<?php $this->load->helper('url');echo base_url("My97DatePicker/WdatePicker.js");?>"></script>

<script>
$(function(){
	$("#submit").click(function(evt){
		var form = document.createElement("form");
		form.action = "/index.php/payment_behavior/execute/_" +
		document.getElementById("area").value + "_/_" +
		document.getElementById("start_date").value + "_/";
		form.submit();
	});
}
);

</script>
</head>
<body>
<h1 align="center"><?php echo LG_PAYMENT_BEHAVIOR?></h1>
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
<?php echo LG_SELECT_DATE_TIME?>
<input type="text" class="Wdate" name="start_date" id="start_date" onfocus="WdatePicker({dateFmt:'yyyy-MM',minDate:'2013-01',maxDate:'2020-01'})" value="<?php echo $start_date;?>"/>
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
	echo "<tr><td>".LG_BEHAVIOR_DESC."</td><td>".LG_BEHAVIOR_COUNT."</td><td>".LG_TOTAL_PAYMENT."</td><tr>";
	foreach($result as $payment_info){
		echo "<tr>";
		echo "<td>".$payment_info->strDesc."</td>";
		echo "<td>".$payment_info->count."</td>";
		echo "<td>".$payment_info->nchanges."</td>";
		echo "<tr>";
	} 
?>
</table>
</div>
</td></tr>
</body>