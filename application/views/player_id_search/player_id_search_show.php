<script type="text/javascript">
var xmlHttp;
function request(player_id){
	xmlHttp = GetXmlHttpObject();
	if(xmlHttp == null){
		return;
	}
	var dest = "/index.php/player_id_search/execute/"+player_id;
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

function execute(){
	var player_id = document.getElementById("player_id").value;
	if(!player_id){
		return;
	}
	request(player_id);
}
</script>
<head>
</head>
<body>
<div align="center">
<a><?php echo LG_PLAYER_ID?></a><input type="text" id="player_id" value=""></input><button type="button" onclick="execute()"><?php echo LG_EXECUTE?></button>
</div>
<div id="result"></div>