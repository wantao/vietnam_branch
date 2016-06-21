<head>
<meta charset="utf-8">
<script src="<?php $this->load->helper('url');echo base_url("jquery-1.10.2.js");?>"></script>
<script src="<?php $this->load->helper('url');echo base_url("jquery-ui.js");?>"></script>

<script language="javascript" type="text/javascript" src="<?php $this->load->helper('url');echo base_url("My97DatePicker/WdatePicker.js");?>"></script>

<script>
$(function(){
	$("#submit").click(function(evt){
		var form = document.createElement("form");
		form.action = "/index.php/remain/execute/_" +
		 document.getElementById("area").value + "_/_" +
		 document.getElementById("start_date").value + "_/";
		form.submit();
	});
}
);

</script>
</head>
<body>
<h1 align="center"><?php echo LG_RETENTION_RATE?></h1>
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
<?php echo LG_SELECT_DATE_TIME?>
</td>
<td>
<?php echo LG_TIME_FROM?><input type="text" class="Wdate" name="start_date" id="start_date" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'2013-01-01',maxDate:'2020-01-01'})" value="<?php echo $start_date;?>"/>
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
	echo "<tr><td>".LG_DATETIME."</td><td>".LG_DNU."</td><td>".LG_DRU_1."</td><td>".LG_DRU_3.
	"</td><td>".LG_DRU_7."</td><td>".LG_DRU_15."</td><td>".LG_DRU_30."</td><tr>";
	
	//print_r($result);
	
	foreach($result as $date => $value){
		echo "<tr>";
		echo "<td>".$date."</td>";
		echo "<td>".$value["DNU"]."</td>";
		if (isset($value["dru1"])) echo "<td>".$value["dru1"]."</td>"; else echo "<td>"."0"."</td>";
		if (isset($value["dru3"])) echo "<td>".$value["dru3"]."</td>"; else echo "<td>"."0"."</td>";
		if (isset($value["dru7"])) echo "<td>".$value["dru7"]."</td>"; else echo "<td>"."0"."</td>";
		if (isset($value["dru15"])) echo "<td>".$value["dru15"]."</td>"; else echo "<td>"."0"."</td>";
		if (isset($value["dru30"])) echo "<td>".$value["dru30"]."</td>"; else echo "<td>"."0"."</td>";
		echo "<tr>";
	} 
?>
</table>
</div>
</td></tr>
</table>