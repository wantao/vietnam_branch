<head>
<meta charset="utf-8">
<script src="<?php $this->load->helper('url');echo base_url("jquery-1.10.2.js");?>"></script>
<script src="<?php $this->load->helper('url');echo base_url("jquery-ui.js");?>"></script>

<script language="javascript" type="text/javascript" src="<?php $this->load->helper('url');echo base_url("My97DatePicker/WdatePicker.js");?>"></script>

<script>
$(function(){
	$("#submit").click(function(evt){
		var form = document.createElement("form");
		form.action = "/index.php/yuanbao_trace/execute/_" +
		 document.getElementById("player_id").value + "_/_" +
		 document.getElementById("start_date").value + "_/";
		form.submit();
	});
}
);

</script>
</head>
<body>
<h1 align="center"><?php echo LG_YUANBAO_TRACE?></h1>
<table align="center">
<td>
<?php echo LG_PLAYER_ID.' '?><input type="text" id="player_id" value="<?php echo $player_id;?>"></input>
</td>
<tr>
<td>
<?php echo LG_SELECT_DATE_TIME?>
<input type="text" class="Wdate" name="start_date" id="start_date" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'2013-01-01',maxDate:'2020-01-01'})" value="<?php echo $start_date;?>"/>
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
	echo "<tr><td>".LG_PLAYER_ID."</td><td>".LG_YUANBAO_CHANGE."</td><td>".LG_BEFORE_CHANGE."</td><td>".LG_AFTER_CHANGE.
	"</td><td>".LG_CHANGE_REASON."</td><td>".LG_CHANGE_TIME."</td><tr>";
	foreach($result as $trace_info){
		echo "<tr>";
		echo "<td>".$trace_info->player_id."</td>";
		echo "<td>".$trace_info->nchange."</td>";
		echo "<td>".$trace_info->res1."</td>";
		echo "<td>".$trace_info->res2."</td>";
		echo "<td>".$trace_info->strDesc."</td>";
		echo "<td>".$trace_info->activetime."</td>";
		echo "<tr>";
	} 
?>
</table>
</div>
</td></tr>
</table>