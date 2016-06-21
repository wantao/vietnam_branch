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
		form.action = "/index.php/cdkey/execute_add/_" + 
		string_area_no +"_/_" +
		document.getElementById("title").value +"_/_" +
		document.getElementById("desc").value +"_/_" +
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
<td><?php echo LG_AREA_NUMBER?></td>
<td><input type="text" id="area_no"></td>
</tr>
<tr>
<td><?php echo LG_TITLE?></td>
<td><textarea id="title" ></textarea></td>
</tr>
<tr>
<td><?php echo LG_DESCRIPTION?></td>
<td><textarea id="desc" ><?php  if (isset($desc)) echo $desc; ?></textarea></td>
</tr>
<tr>
<td><?php echo LG_PICTURE_URL?></td>
<td><input type="text" id="bn_url"></td>
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
<td><input type="text" id="level"></td>
</tr>
<tr>
<td><?php echo LG_AWARD?></td>
<td><input type="text" id="award"></td>
</tr>>
<tr>
<td>
<button id="submit"><?php echo LG_EXECUTE?></button>
<button id="cancle"><?php echo LG_CANCEL?></button>
</td>
</tr>
</table>
