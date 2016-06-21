<head>
<meta charset="utf-8">
<script src="<?php $this->load->helper('url');echo base_url("jquery-1.10.2.js");?>"></script>
<script src="<?php $this->load->helper('url');echo base_url("jquery-ui.js");?>"></script>

<script language="javascript" type="text/javascript" src="<?php $this->load->helper('url');echo base_url("My97DatePicker/WdatePicker.js");?>"></script>

<script>
$(function(){
	$("#submit").click(function(evt){
		var str_desc = document.getElementById("desc").value;
		for (i=0;i<str_desc.length ;i++ )    
	    {    
			str_desc = str_desc.replace("/","_");     
	    }
		str_desc = encodeURIComponent(str_desc);
		var str_name = document.getElementById("name").value;
		for (i=0;i<str_name.length ;i++ )    
	    {    
			str_name = str_name.replace(",","_");     
	    }
		str_name = encodeURIComponent(str_name);
		var str_award = document.getElementById("award").value;
		for (i=0;i<str_award.length ;i++ )    
	    {    
			str_award = str_award.replace(",","_");     
	    }
		str_award = encodeURIComponent(str_award);
		var str_value = document.getElementById("value").value;
		for (i=0;i<str_value.length ;i++ )    
	    {    
			str_value = str_value.replace(",","%");     
	    }
		str_value = encodeURIComponent(str_value);
		var form = document.createElement("form");
		form.action = "/index.php/system_activity/execute_edit/_" +
		<?php echo $area_id?> +"_/_" + 
		<?php echo $id?> +"_/_" +
		<?php echo $type?> +"_/_" +
		document.getElementById("begin_time").value +"_/_" +
		document.getElementById("end_time").value +"_/_" +
		document.getElementById("get_award_time").value +"_/_" +
		str_name +"_/_" +
		str_desc +"_/_" +
		str_award +"_/_" +
		str_value +"_/_" +
		document.getElementById("state_id").value+"_/";
		if (9 == <?php echo $type?>) {
			str_inventory = document.getElementById("inventory").value;
			str_today_limit_buy_count = document.getElementById("today_limit_buy_count").value;
			if (isNaN(str_inventory) || isNaN(str_today_limit_buy_count)) {
				return;
			}
			form.action = form.action + "_" + str_inventory + "_/_" + str_today_limit_buy_count + "_/";
		}
		form.method = "post";
		form.submit();
	});
	
	$("#cancle").click(function(evt){
		var form = document.createElement("form");
		form.action = "/index.php/system_activity/show";
		form.method = "get";
		form.submit();
	});
}
);

</script>
</head>
<body>
<table align="center">
<tr valign="top">
<td>
</tr>
<tr>
<td><?php echo LG_ACTIVE_ID?></td>
<td><?php echo $id?></td>
</tr>
<tr>
<td><?php echo LG_BEGIN_TIME?></td>
<td>
<input type="text" class="Wdate" name="begin_time" id="begin_time" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'2013-01-01 00:00:00',maxDate:'2020-01-01 00:00:00'})" value="<?php echo $begin_time;?>"/>
</td>
</tr>
<tr>
<td><?php echo LG_END_TIME?></td>
<td>
<input type="text" class="Wdate" name="end_time" id="end_time" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'2013-01-01 00:00:00',maxDate:'2020-01-01 00:00:00'})" value="<?php echo $end_time;?>"/>
</td>
</tr>
<tr>
<td><output type="text" id="get_award_time_text"></td>
<td>
<input type="text" class="Wdate" name="get_award_time" id="get_award_time" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'2013-01-01 00:00:00',maxDate:'2020-01-01 00:00:00'})" value="<?php echo $get_award_time;?>"/>
</td>
</tr>
<tr>
<td><?php echo LG_ACTIVE_NAME?></td>
<td><textarea id="name" ><?php echo $name?></textarea></td>
</tr>
<tr>
<td><?php echo LG_ACTIVE_DESC?></td>
<td><textarea id="desc"><?php echo $desc ?></textarea></td>
</tr>
<tr>
<td><?php echo LG_ACTIVE_AWARD?></td>
<td><textarea id="award"><?php echo $award?></textarea></td>
</tr>
<tr>
<td><?php echo LG_ACTIVE_VALUE?></td>
<td><textarea id="value"><?php echo $value?></textarea></td>
</tr>
<tr>
<td><?php echo LG_STATUS?></td>
<td>
<select  name="state" id="state_id" >
<?php
	foreach($states as $state){
		if ($is_open == $state['value']) {
			echo "<option value=". $state['value']." selected>".$state['name']."</option>";	
		} else {
			echo "<option value=". $state['value'].">".$state['name']."</option>";	
		}
	} 	
?>
</select>
</td>
</tr>


<?php 
	if (9 == $type) {
		echo "<tr>";
		echo "<td>".LG_INVENTORY."</td>";
		echo "<td><textarea id=\"inventory\" >".$inventory."</textarea></td>";
		echo "</tr>";	
		echo "<tr>";
		echo "<td>".LG_TODAY_LIMIT_BUY_COUNT."</td>";
		echo "<td><textarea id=\"today_limit_buy_count\" >".$today_limit_buy_count."</textarea></td>";
		echo "</tr>";	
	}
?>


<tr>
<td>
<button id="submit"><?php echo LG_EXECUTE?></button>
<button id="cancle"><?php echo LG_CANCEL?></button>
</td>
</tr>
</table>
<script>
function run(){
	type = <?php echo $type?>;
	if (7 == type || 8 == type){
		document.all.get_award_time.style.visibility = "visible";
		document.getElementById("get_award_time_text").value="<?php echo LG_GET_AEARD_TIME?>";
	}else{
		document.all.get_award_time.style.visibility = "hidden";
		document.getElementById("get_award_time_text").value="";
	} 
	if (9 != type) {
		document.all.inventory.style.visibility = "hidden";
		document.getElementById("inventory").value="";
		document.all.today_limit_buy_count.style.visibility = "hidden";
		document.getElementById("today_limit_buy_count").value="";
	} 
}
run();
</script>