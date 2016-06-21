<script type="text/javascript">
function add_server(){
	var select_dom = document.getElementById("area_list");
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

function close_server_and_maintain(){
	index = 0;
	cmd = "shutdowngs";//document.getElementById("cmd").value;
	arg = document.getElementById("time_left").value;
	ac = document.getElementById("ac").value;
	pwd = document.getElementById("pwd").value;
	selected = document.getElementById("selected_servers");
	server_doms = selected.getElementsByTagName("div");
	length = server_doms.length;
	close_server_and_maintain_one(index);
}

function close_server_and_maintain_one(i){
	if(index >= length){
		return;
	}
	var server_info = server_doms[i];
	var url = server_info.childNodes[0].getAttribute("value");
	document.getElementById("result").innerHTML += ("<?php echo LG_QUERY_PROMPT?>" + server_info.childNodes[0].innerHTML + "<br>");
	request(url, cmd, arg, ac, pwd);
}

function get_server_ids() {
	selected = document.getElementById("selected_servers");
	server_doms = selected.getElementsByTagName("div");
	length = server_doms.length;
	var server_ids = "";
	for (var i = 0; i < length; ++i) {
		if (0 == i) {
			server_ids += server_doms[i].getAttribute("id");
			continue;
		} 
		server_ids += ",";
		server_ids += server_doms[i].getAttribute("id");
	}
	return server_ids;
}

function set_server_run_status() {
	server_run_status = document.getElementById("server_run_status_list").value;
	var server_ids = get_server_ids();
	request_set_server_run_status(server_ids, server_run_status);
}
	
var cmd, arg, ac, pwd, selected, server_doms,time_left,server_run_status;
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
		if (length > 0) {
			var server_ids = get_server_ids();
			request_set_server_run_status(server_ids, 2);
		}
		return;
	}
	var server_info = server_doms[i];
	var url = server_info.childNodes[0].getAttribute("value");
	document.getElementById("result").innerHTML += ("<?php echo LG_QUERY_PROMPT?>" + server_info.childNodes[0].innerHTML + "<br>");
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
	var dest = "/index.php/close_server_and_maintain/excute_close_server_and_maintain/_"+encodeURIComponent(url)+"_/_"+encodeURIComponent(cmd)+"_/_"+encodeURIComponent(arg)+"_/_"+encodeURIComponent(ac)+"_/_"+encodeURIComponent(pwd)+"_";
	xmlHttp.onreadystatechange = stateChanged;
	xmlHttp.open("get", dest, true);//true：异步方式  false：同步方式
	xmlHttp.send(null);
}

function request_set_server_run_status(server_ids, server_run_status){
	xmlHttp = GetXmlHttpObject();
	if(xmlHttp == null){
		return;
	}
	ac = document.getElementById("ac").value;
	pwd = document.getElementById("pwd").value;
	var dest = "/index.php/close_server_and_maintain/excute_set_servers_run_status/_"+encodeURIComponent(server_ids)+"_/_"+encodeURIComponent(server_run_status)+"_/_"+encodeURIComponent(ac)+"_/_"+encodeURIComponent(pwd)+"_";
	xmlHttp.onreadystatechange = server_run_status_state_changed;
	xmlHttp.open("get", dest, true);//true：异步方式  false：同步方式
	xmlHttp.send(null);
}

function server_run_status_state_changed()
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
		document.getElementById("result").innerHTML += xmlHttp.responseText + "<br>";
	}
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

function server_run_status_state_changed()
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
		document.getElementById("result").innerHTML += xmlHttp.responseText + "<br>";
	}
}

function server_fluency_status_state_changed()
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
		document.getElementById("result").innerHTML += xmlHttp.responseText + "<br>";
	}
}

function set_server_fluency_status() {
	var server_fluency_status = document.getElementById("server_fluency_status_list").value;
	var server_ids = get_server_ids();
	request_set_server_fluency_status(server_ids, server_fluency_status);	
}

function request_set_server_fluency_status(server_ids, server_fluency_status){
	xmlHttp = GetXmlHttpObject();
	if(xmlHttp == null){
		return;
	}
	ac = document.getElementById("ac").value;
	pwd = document.getElementById("pwd").value;
	var dest = "/index.php/close_server_and_maintain/excute_set_servers_fluency_status/_"+encodeURIComponent(server_ids)+"_/_"+encodeURIComponent(server_fluency_status)+"_/_"+encodeURIComponent(ac)+"_/_"+encodeURIComponent(pwd)+"_";
	xmlHttp.onreadystatechange = server_fluency_status_state_changed;
	xmlHttp.open("get", dest, true);//true：异步方式  false：同步方式
	xmlHttp.send(null);
}

</script>
<head>
</head>
<body>
<h1 align="center"><?php echo LG_STOP_FOR_REPAIR?></h1>
<table align="center" width="60%">
<tr valign="top">
<td width="20%">
<?php echo LG_SELECT_SERVER?>
<select id="area_list">
<?php 
	/*foreach($area_list as $area){
		if (1 == $area['selected']) {
			echo "<option value=". $area['id']." selected>".$area['name']."</option>";	
		} else {
			echo "<option value=". $area['id'].">".$area['name']."</option>";	
		}
	}*/
	foreach($area_list as $server_info){
		$url = $server_info->url;
		$length = strlen($url);
		while($url{$length - 1} == '/'){
			$length --;
			$url = substr($url, 0, $length);
		}
		$server_status_str = "";
		if ($server_info->run_status == 2) {
			$server_status_str = LG_MAINTAIN;
		} else {
			if ($server_info->fluency_status == 0) {
				$server_status_str = LG_NEW_AREA;	
			} else {
				$server_status_str = LG_HOT;		
			}
		}
		
		echo "<option server_id=". $server_info->id ." server_url=".$url.":". $server_info->port .">".$server_info->name."(".$server_status_str.")"."</option>";
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
<?php echo LG_GM_ACCOUNT?><input type="text" name="username" id="ac"><br>
</td>
</tr>

<tr>
<td>
<?php echo LG_GM_PASSWORD?><input type="text" name="password" id="pwd"><br>
</td>
</tr>

<tr>
<td>
<input type="text" name="time_left" id="time_left"><?php echo LG_MINUTES_LATER?><button type="button" onclick="close_server_and_maintain()"><?php echo LG_CLOSE_SERVER?></button>
</td>
</tr>


<tr>
<td>
<select id="server_run_status_list">
<?php 
	foreach($server_run_status_list as $key=>$value){
		/*if (1 == $area['selected']) {
			echo "<option value=". $area['id']." selected>".$area['name']."</option>";	
		} else {*/
			echo "<option value=". $value.">".$key."</option>";	
		//}
	}
?>
</select>
<button type="button" onclick="set_server_run_status()"><?php echo LG_SET_RUN_STATUS?></button>
</td>
</tr>

<tr>
<td>
<select id="server_fluency_status_list">
<?php 
	foreach($server_fluency_status_list as $key=>$value){
		/*if (1 == $area['selected']) {
			echo "<option value=". $area['id']." selected>".$area['name']."</option>";	
		} else {*/
			echo "<option value=". $value.">".$key."</option>";	
		//}
	}
?>
</select>
<button type="button" onclick="set_server_fluency_status()"><?php echo LG_SET_Fluency_STATUS?></button>
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