<script type="text/javascript">
var xmlHttp;
function request(){
	xmlHttp = GetXmlHttpObject();
	if(xmlHttp == null){
		return;
	}
	var dest = "/index.php/cdkey/execute";
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

function opt_delete(id) {
	var form = document.createElement("form");
	form.action = "/index.php/cdkey/execute_delete/"+id;
	form.method = "post";
	form.submit();
}

function opt_edit(id) {
	var form = document.createElement("form");
	form.action =  "/index.php/cdkey/show_edit_model/"+id;
	form.method = "post";
	form.submit();
}

function opt_add() {
	var form = document.createElement("form");
	form.action = "/index.php/cdkey/show_add_model";
	form.method = "post";
	form.submit();
}


window.onload = function(){
	request();
}
</script>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf8" />
<head>
</head>
<body>
<div id="result">
</div>
</body>
</html>