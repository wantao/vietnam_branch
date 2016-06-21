<head>
<meta charset="utf-8">
<script src="<?php $this->load->helper('url');echo base_url("jquery-1.10.2.js");?>"></script>
<script src="<?php $this->load->helper('url');echo base_url("jquery-ui.js");?>"></script>

<script language="javascript" type="text/javascript" src="<?php $this->load->helper('url');echo base_url("My97DatePicker/WdatePicker.js");?>"></script>

<script>
$(function(){
	$("#submit").click(function(evt){
		var form = document.createElement("form");
		var string_bnurl = document.getElementById("bn_url").value
		for (i=0;i<string_bnurl.length ;i++ )    
	    {    
			string_bnurl = string_bnurl.replace("/","_");     
	    } 
		var string_area_no = document.getElementById("area_no").value
		for (i=0;i<string_area_no.length ;i++ )    
	    {    
			string_area_no = string_area_no.replace(",","_");     
	    } 
		var string_award = document.getElementById("award").value
		for (i=0;i<string_award.length ;i++ )    
	    {    
			string_award = string_award.replace(",","_"); 
	    } 
		string_award = encodeURIComponent(string_award);
		
		var str_desc = document.getElementById("desc").value;
		for (i=0;i<str_desc.length ;i++ )    
	    {    
			str_desc = str_desc.replace("/","_");     
	    }
		str_desc = encodeURIComponent(str_desc);
		
		var str_title = document.getElementById("title").value;
		for (i=0;i<str_title.length ;i++ )    
	    {    
			str_title = str_title.replace("/","_");     
	    }
		str_title = encodeURIComponent(str_title);
		
		
		form.action = "/index.php/cdkey/execute_edit/_" +
		<?php echo $id?> +"_/_" + 
		string_area_no +"_/_" +
		str_title +"_/_" +
		str_desc +"_/_" +
		string_bnurl +"_/_" +
		document.getElementById("begin_time").value +"_/_" +
		document.getElementById("end_time").value +"_/_" +
		document.getElementById("level").value +"_/_" +
		string_award +  "_/";
		form.method = "post";
		form.submit();
	});
	
	$("#cancle").click(function(evt){
		var form = document.createElement("form");
		form.action = "/index.php/cdkey/show";
		form.method = "get";
		form.submit();
	});
}
);

</script>
</head>
<body>
<table align="center" width="60%">
<tr valign="top">
<td width="50%">
</tr>
<tr>
<td><?php echo LG_ACTIVITY_ID?></td>
<td><?php echo $id?></td>
</tr>
<tr>
<td><?php echo LG_AREA_NUMBER . "（区号之间用,作为分隔符）" ?></td>
<td>
<input type="text" id="area_no" value=<?php echo $area_no?>></td>
</tr>
<tr>
<td><?php echo LG_TITLE?></td>
<td><textarea id="title" ><?php echo $title?></textarea></td>
</tr>
<tr>
<td><?php echo LG_DESCRIPTION?></td>
<td><textarea id="desc" ><?php echo $desc ?></textarea></td>
</tr>
<tr>
<td><?php echo LG_PICTURE_URL?></td>
<td><input type="text" id="bn_url" value=<?php echo $bn_url?>></td>
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
</tr
<tr>
<td><?php echo LG_MIN_LEVEL?></td>
<td><input type="text" id="level" value=<?php echo $level?>></td>
</tr>
<tr>
<td><?php echo LG_AWARD . "（格式：礼包编号:{奖励内容,}-礼包编号:{奖励内容,}-）" ?></td>
<td><input type="text" id="award" value=<?php echo $award?>></td>
</tr>>
<tr>
<td>
<button id="submit"><?php echo LG_EXECUTE?></button>
<button id="cancle"><?php echo LG_CANCEL?></button>
</td>
</tr>
</table>
