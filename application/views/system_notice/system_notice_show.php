<script type="text/javascript">
var xmlHttp;
function request(area){
	xmlHttp = GetXmlHttpObject();
	if(xmlHttp == null){
		return;
	}
	var dest = "/index.php/system_notice/execute/"+area;
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

function opt_delete(area_id, id) {
	var form = document.createElement("form");
	form.action = "/index.php/system_notice/execute_delete/_" + 
	area_id +"_/_" +
	id + "_/";
	form.method = "post";
	form.submit();
}

function opt_edit(area_id, id) {
	var form = document.createElement("form");
	form.action =  "/index.php/system_notice/show_edit_model/_" +
	area_id +"_/_" +
	id + "_/";
	form.method = "post";
	form.submit();
}

function opt_add(area_id) {
	var form = document.createElement("form");
	form.action = "/index.php/system_notice/show_add_model/"+area_id;
	form.method = "post";
	form.submit();
}

function add_server(){
	var area_id = document.getElementById("area").value;
	if(!area_id){
		return;
	}
	request(area_id);
}

window.onload = function(){
	value = <?php if (isset($area_id)) echo $area_id; else echo 0;?>;
	if(value > 0){
		request(value);
	} else {
		value = document.getElementById("area").value;
		request(value);
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
<select name="area" id="area">
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
<button type="button" onclick="add_server()"><?php echo LG_SELECT_SERVER?></button>
</td>
</tr>
</table>
<div id="result">
</div>