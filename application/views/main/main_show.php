<script type="text/javascript">
function add_server(){
	var select_dom = document.getElementById("server_list");
	var option = select_dom.options[select_dom.selectedIndex];
	var server_id = option.getAttribute("server_id");
	var server_url = option.getAttribute("server_url");
	var server_name = option.innerText;
	var selected = document.getElementById("selected_servers");
	if(selected.childElementCount != 0){
		var childNodes = selected.childNodes;
		for(var i = 1; i < childNodes.length; i++){
			if(childNodes[i].getAttribute('id') == server_id){
				return;
			}
		}
	}
	selected.innerHTML += "<div class=server id=" + server_id + " ><a value=" + server_url + ">" + server_name + "</a><button type=button onclick=delete_selected(" + server_id + ")>delete</button></div>";
}

function delete_selected(id){
	var server = document.getElementById(id);
	if(server != null)
		server.parentNode.removeChild(server);
}

	
var cmd, arg, ac, pwd, selected, server_doms;
var index, length;

function execute(){
	index = 0;
	cmd = document.getElementById("cmd").value;
	arg = document.getElementById("arg").value;
	ac = document.getElementById("ac").value;
	pwd = document.getElementById("pwd").value;
	selected = document.getElementById("selected_servers");
	server_doms = selected.getElementsByTagName("div");
	length = server_doms.length;
	execute_one(index);
}
function execute_one(i){
	if(index >= length){
		return;
	}
	var server_info = server_doms[i];
	var url = server_info.childNodes[0].getAttribute("value");
	document.getElementById("result").innerHTML += ("<?php echo LG_REQUESTING?>" + server_info.childNodes[0].innerHTML + "<br>");
	request(url, cmd, arg, ac, pwd);
}

function execute_next(){
	index++;
	execute_one(index);
}

var xmlHttp;
function request(url, cmd, arg, ac, pwd){
	xmlHttp = GetXmlHttpObject();
	if(xmlHttp == null){
		return;
	}
	var cmd_tmp = cmd;
	cmd_tmp = cmd_tmp.split("(");
	var dest = "/index.php/main/execute/_"+encodeURIComponent(url)+"_/_"+encodeURIComponent(cmd_tmp[0])+"_/_"+encodeURIComponent(arg)+"_/_"+encodeURIComponent(ac)+"_/_"+encodeURIComponent(pwd)+"_";
	xmlHttp.onreadystatechange = stateChanged;
	xmlHttp.open("get", dest, true);//true：异步方式  false：同步方式
	xmlHttp.send(null);
}

function stateChanged(){
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
		document.getElementById("result").innerHTML += xmlHttp.responseText + "<br>";
		execute_next();
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

function update_description(){
	var cmd_list = document.getElementById("cmd");
	if(cmd_list.options.length != 0){
		cmd = cmd_list.options[cmd_list.selectedIndex];
		document.getElementById("cmd_description").innerHTML = cmd.getAttribute("description");
	}
}
onload = update_description;
</script>
<head>
</head>
<body>
<h1 align="center"><?php echo LG_GM?></h1>
<table align="center" width="60%">
<tr valign="top">
<td width="40%">
<?php echo LG_SELECT_SERVER?>
<select id="server_list">
<?php 
	foreach($server_list as $server_info){
		$url = $server_info->url;
		$length = strlen($url);
		while($url{$length - 1} == '/'){
			$length --;
			$url = substr($url, 0, $length);
		}
		
		echo "<option server_id=". $server_info->id ." server_url=".$url.":". $server_info->port .">".$server_info->name."</option>";
	}
?>
</select>
<button type="button" onclick="add_server()"><?php echo LG_SELECT?></button>
<br>
<?php echo LG_CURRENCT_SELECTED?>
<div id="selected_servers">
</div>
</td>
<td>
<table>
<tr>
<td>
<?php echo LG_SELECT_CMD?></td><td>
<select id="cmd" onchange="update_description()">
<?php
	foreach($gmcommand_list as $gmcommand){
		echo "<option description=\"" . $gmcommand->description . "\">" .  $gmcommand->command . "(".$gmcommand->detail .")"."</option>";
	} 
?>
</select>
</td>
</tr>
<tr>
<td>
<?php echo LG_CMD_DESCRIPTION.':'?></td><td><a id="cmd_description"></a><br>
</td>
</tr>
<tr>
<td>
<?php echo LG_INPUT_CMD_PARAMS?></td><td> <input type="text" name="command" id="arg"><br>
</td>
</tr>
<tr>
<td>
<?php echo LG_GM_ACCOUNT?></td><td><input type="text" name="username" id="ac"><br>
</td>
</tr>
<tr>
<td>
<?php echo LG_GM_PASSWORD?></td><td><input type="text" name="password" id="pwd"><br>
</td>
</tr>
<tr>
<td>
<button type="button" onclick="execute()"><?php echo LG_EXECUTE?></button>
</td>
</tr>
</table>
</td>
</tr>
</table>
<table align="center" width="60%">
<tr><td>
<div id="result">
</div>
</td></tr>
</table>