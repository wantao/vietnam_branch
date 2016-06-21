<script type="text/javascript">
var xmlHttp;
function request(area, type){
	xmlHttp = GetXmlHttpObject();
	if(xmlHttp == null){
		return;
	}
	var dest = "/index.php/system_activity/execute/_"+
	area +"_/_" +
	type + "_/";;
	xmlHttp.onreadystatechange = stateChanged;
	xmlHttp.open("get", dest, true);//true：异步方式  false：同步方式
	xmlHttp.send(null);
	document.getElementById("result").innerHTML = "<?php echo LG_QUERY_PROMPT?>";
}

function stateChanged(){
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
		document.getElementById("result").innerHTML = xmlHttp.responseText + "<br>";
	}
}

function GetXmlHttpObject()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 // Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}

function opt_edit(area_id, id) {
	var form = document.createElement("form");
	form.action =  "/index.php/system_activity/show_edit_model/_" +
	area_id +"_/_" +
	id + "_/";
	form.method = "post";
	form.submit();
}

function add_server(){
	var area_id = document.getElementById("area").value;
	if(!area_id){
		return;
	}
	var type_id = document.getElementById("type").value;
	if(!type_id){
		return;
	}
	request(area_id, type_id);
}

function take_effect(){
	var form = document.createElement("form");
	form.action = "/index.php/system_activity/execute_take_effect/_" + 
	document.getElementById("area").value +"_/_" +
	document.getElementById("type").value + "_/";
	form.method = "post";
	form.submit();
}

function input_file(){
	form_input.action = "/index.php/system_activity/execute_input_file/" + 
	document.getElementById("area").value;
	form_input.method = "post";
	form_input.submit();
}

function output_file(){
	var form = document.createElement("form");
	form.action = "/index.php/system_activity/execute_output_file/" + 
	document.getElementById("area").value;
	form.method = "post";
	form.submit();
}

function change_area_id(){
	var form = document.createElement("form");
	form.action = "/index.php/system_activity/execute_change_select_id/" + 
	document.getElementById("area").value;
	form.method = "post";
	form.submit();
}

window.onload = function(){
	value = <?php if (isset($area_id)) echo $area_id; else echo 0;?>;
	if(value > 0){
		type = <?php if (isset($cur_type)) echo $cur_type; else echo 1;?>;
		if(type > 0)
			request(value, type);
	}
}
</script>
<meta http-equiv="content-type" content="text/html;charset=utf8" />
<head>
</head>
<body>
<table align="center">
<tr valign="top">
<td>
<select name="area" id="area" onchange="change_area_id()">
<?php 
	foreach($area_list as $area){
		if ($area_id == $area['id']) {
			echo "<option value=". $area['id']." selected=".selected.">".$area['name']."</option>";	
		} else {
			echo "<option value=". $area['id'].">".$area['name']."</option>";	
		}	
	}
?>
</select>
<select name="type" id="type">
<?php 
	foreach($type_list as $type){
		if ($cur_type == $type['type']) {
			echo "<option value=". $type['type']." selected>".$type['name']."</option>";	
		} else {
			echo "<option value=". $type['type'].">".$type['name']."</option>";	
		}
	}
?>
</select>
<button type="button" onclick="add_server()"><?php echo LG_SELECT_SERVER?></button>
<button type="button" onclick="take_effect()"><?php echo LG_EXECUTE?></button>
<style>
.clear{clear:both;}
.ehdel_upload_show input{float:left; margin-top:10px;}
.ehdel_upload_show button{float:right; margin-top:10px;}
.ehdel_upload{float:left;margin-top:-20px; *margin-top:-40px; filter:alpha(opacity=0);-moz-opacity:0;opacity:0;}
</style>
<form  enctype="multipart/form-data" id="form_input" >
<div class="ehdel_upload_show">
<input id="ehdel_upload_text" type="text" name="txt" />
<input id="ehdel_upload_btn" type="button"  value=<?php echo LG_ACTIVE_INPUT_CHOOSE_FIL?> />
<span style="font-size:12px;">&nbsp&nbsp&nbsp</span>
<button type="button" onclick="output_file()"><?php echo LG_ACTIVE_OUTPUT_SQL_FIL?></button>
<button type="button" onclick="input_file()"><?php echo LG_ACTIVE_INPUT_SQL_FIL?></button>
</div>
<div class="clear"></div>
<input type="file" name="up_file"  onchange="ehdel_upload_text.value=this.value" class="ehdel_upload" />
</form>
</td>
<td><?php echo $execut_msg; ?></td>
</tr>
</table>
<div id="result">
</div>