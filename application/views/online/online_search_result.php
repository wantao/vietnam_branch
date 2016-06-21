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
<h1 align="center">实时在线</h1>
<table align="center" width="60%">
<tr valign="top">
<td width="50%">
选择区
<select name="area" id="area">
<?php 
	foreach($area_list as $area){
		echo "<option value=". $area->id.">".$area->name."</option>";
	}
?>
</select>
</td>
</tr>
<tr>
<td>
时间范围
从<input type="text" class="Wdate" name="start_date_time" id="start_date_time" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'2013-01-01 00:00:00',maxDate:'2020-01-01 00:00:00'})" value="<?php echo $start_date_time;?>"/>
</td>
<td>
到<input type="text" class="Wdate" name="end_date_time" id="end_date_time" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'2013-01-01 00:00:00',maxDate:'2020-01-01 00:00:00'})" value="<?php echo $end_date_time;?>"/>
</td>
</tr>
<tr>
<td>
<button id="submit">提交</button>
</td>
</tr>
</table>
<table align="center" width="60%">
<tr><td>
<div id="result">
<table>
<?php
	foreach($result as $row){
		echo "<tr><td>$row->playernumber</td><td>$row->logtime</td></tr>";
	} 
?>
</table>
</div>
</td></tr>
</table>