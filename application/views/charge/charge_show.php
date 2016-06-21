<head>
<meta charset="utf-8"> 

<script src="<?php $this->load->helper('url');echo base_url("jquery-1.10.2.js");?>"></script>
<script src="<?php $this->load->helper('url');echo base_url("jquery-ui.js");?>"></script>

<script language="javascript" type="text/javascript" src="<?php $this->load->helper('url');echo base_url("My97DatePicker/WdatePicker.js");?>"></script>
<script>
$(function(){
	$("#submit").click(function(evt){
		var form = document.createElement("form");
		form.action = "/index.php/charge/execute/_" +
		 document.getElementById("area").value + "_/_" +
		 document.getElementById("start_date_time").value + "_/_" +
		 document.getElementById("end_date_time").value + "_/_" +
		 document.getElementById("order_id").value + "_/_" +
		 document.getElementById("player_name").value + "_/";
		form.submit();
	});
	
	$("#reset").click(function(evt){
		var form = document.createElement("form");
		form.action = "/index.php/charge/execute_reset/_" +
		 document.getElementById("area").value + "_/_" +
		 document.getElementById("start_date_time").value + "_/_" +
		 document.getElementById("end_date_time").value + "_/_" +
		 document.getElementById("player_name").value + "_/";
		form.submit();
	});

	$("#export").click(function(evt){
		var form = document.createElement("form");
		form.action = "/index.php/charge/execute_export/_" +
		 document.getElementById("area").value + "_/_" +
		 document.getElementById("start_date_time").value + "_/_" +
		 document.getElementById("end_date_time").value + "_/_" +
		 document.getElementById("order_id").value + "_/_" +
		 document.getElementById("player_name").value + "_/";
		form.submit();
	});
}
);

</script>
</head>
<body>
<h1 align="center"><?php echo LG_RECHARGE_LOG?></h1>
<table align="center" width="60%">
<tr valign="top">
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
<td></td>
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
<td><?php echo LG_NAME."(".LG_OPTIONAL.")"?>
<input type="text" id="player_name" value=<?php echo $player_name?>></td>
<td><?php echo LG_CURRENT_PAGE?>
<input type="text" value=<?php echo $cur_page?>></td>
</tr>
<tr>
<td><?php echo LG_PLAYER_TOTAL_AMOUNT_OF_RECHARGE?>
<input type="text" value=<?php echo $player_chongzhi_total_money?>></td>
<td><?php echo LG_PLAYER_TOTAL_NUMBER_OF_RECHARGE?>
<input type="text" value=<?php echo $player_chongzhi_total_times?>></td>
</tr>
<tr>
<td><?php echo LG_PLAT_FORM_TRANS_ID."(".LG_OPTIONAL.")"?>
<input type="text" id="order_id" value=<?php echo $order_id?>></td>
</tr>
<tr>
<td>
<button id="submit"><?php echo LG_EXECUTE?></button>
<!--<button id="reset">重置</button>-->
<button id="export">导出</button>
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
	echo "<tr><td>".LG_AREA_NUMBER."</td><td>".LG_NAME."</td><td>".LG_MONEY."</td><td>".LG_GEMSTONE."</td><td>".LG_RECHARGE_TIME."</td><td>".LG_STATUS."</td><td>".LG_ADD_TO_GAME_TIME."</td><td>".LG_TRANSACTION_ID."</td><td>".LG_CHANNEL."</td></tr>";
	foreach($result["result"] as $row){
		echo "<tr><td>$row->area_no</td><td>$row->name</td><td>$row->money</td><td>$row->yuanbao</td><td>$row->activetime</td><td>$row->has_add_to_game</td><td>$row->successtime</td><td>$row->orderid</td><td>".get_channel($row->app_id)."</td></tr>";
	} 
	$next = $result["next_page_url"];
	$previous = $result["previous_page_url"];
	echo "<tr>";
	if(strlen($previous) == 0){
		echo "<td></td><td></td><td></td><td></td><td></td>";
	} else{
		echo "<td><a href=$previous>".LG_LAST_PAGE."</a></td><td></td><td></td><td></td><td></td>";
	}
	if(strlen($next) == 0){
		echo "<td></td><td></td><td></td><td></td><td></td>";
	} else{
		echo "<td></td><td></td><td></td><td></td><td><a href=$next>".LG_Next_PAGE."</a></td>";
	}
	echo "</tr>";
?>
</table>
</div>
</td></tr>
</table>