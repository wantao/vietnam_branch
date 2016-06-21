<head>
<meta charset="utf-8">
<script src="<?php $this->load->helper('url');echo base_url("jquery-1.10.2.js");?>"></script>
<script src="<?php $this->load->helper('url');echo base_url("jquery-ui.js");?>"></script>

<script language="javascript" type="text/javascript" src="<?php $this->load->helper('url');echo base_url("My97DatePicker/WdatePicker.js");?>"></script>

<script>
$(function(){
	$("#submi").click(function(evt){
		var str_desc = document.getElementById("content").value;
		for (i=0;i<str_desc.length ;i++ )    
	    {    
			str_desc = str_desc.replace("/","_");     
	    }
		str_desc = encodeURIComponent(str_desc);
		var form = document.createElement("form");
		form.action = "/index.php/system_notice/execute_add/_" + 
		<?php echo $area_id;?> +"_/_" +
		document.getElementById("idx").value +"_/_" +
		document.getElementById("begin_time").value +"_/_" +
		document.getElementById("end_time").value +"_/_" +
		document.getElementById("frequency").value +"_/_" +
		document.getElementById("delay_begin").value +"_/_" +
		str_desc +"_/";
		form.method = "post";
		form.submit();
	});
	
	$("#cancle").click(function(evt){
		var form = document.createElement("form");
		form.action = "/index.php/system_notice/show";
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
<td><?php echo LG_NOTICE_IDX?></td>
<td><input type="text" id="idx"></td>
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
<td><?php echo LG_FREQUENCY?></td>
<td><input type="text" id="frequency"></td>
</tr>
<tr>
<td><?php echo LG_DELAY_BEGIN?></td>
<td><input type="text" id="delay_begin"></td>
</tr>
<tr>
<td><?php echo LG_CONTENT?></td>
<td><textarea id="content" ><?php  if (isset($content)) echo $content; ?></textarea></td>
</tr>
<tr>
<td>
<button id="submi"><?php echo LG_EXECUTE?></button>
<button id="cancle"><?php echo LG_CANCEL?></button>
</td>
</tr>
</table>
