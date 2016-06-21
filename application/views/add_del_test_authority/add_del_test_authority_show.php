<script type="text/javascript">
var xmlHttp;
function request(account,type){
	xmlHttp = GetXmlHttpObject();
	if(xmlHttp == null){
		return;
	}
	account = encodeURI(account);
	var dest = "/index.php/add_del_test_authority/execute/"+account+"/"+type;
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

function add_execute(){
	var account = document.getElementById("add_account").value;
	if(!account){
		return;
	}
	request(account,0);
}
function del_execute(){
	var account = document.getElementById("del_account").value;
	if(!account){
		return;
	}
	request(account,1);
}
function del_all_execute(){
	//无用的account，占位用
	var account = '1_as';
	request(account,2);
}
</script>
<head>
</head>
<body>
<br></br>
<div align="center">
<a><?php echo LG_ADD_TEST_AUTHORITY.'  '.LG_ACCOUNT?></a><input type="text" id="add_account" value=""></input><button type="button" onclick="add_execute()"><?php echo LG_EXECUTE?></button>
</div>
<br></br>
<div align="center">
<a><?php echo LG_DEL_TEST_AUTHORITY.'  '.LG_ACCOUNT?></a><input type="text" id="del_account" value=""></input><button type="button" onclick="del_execute()"><?php echo LG_EXECUTE?></button>
</div>
<br></br>
<div align="center">
<a><?php echo LG_DEL_ALL_TEST_AUTHORITY.'  '.LG_ACCOUNT?></a><button type="button" onclick="del_all_execute()"><?php echo LG_EXECUTE?></button>
</div>
<div id="result"></div>