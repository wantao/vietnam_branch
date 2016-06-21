<head>
<meta charset="utf-8">
<script src="<?php $this->load->helper('url');echo base_url("jquery-1.10.2.js");?>"></script>
<script src="<?php $this->load->helper('url');echo base_url("jquery-ui.js");?>"></script>

<script language="javascript" type="text/javascript" src="<?php $this->load->helper('url');echo base_url("My97DatePicker/WdatePicker.js");?>"></script>

<script>
$(function(){
	$("#add_award").click(function(evt){
		var award_type = document.getElementById("award_type").value;
		var id = 0;
		var param_4 = 0;
		var need_id = true
		var number = document.getElementById("number_id").value;
		if (4 == award_type){
			id = document.getElementById("pet_id").value;
			param_4 = document.getElementById("param_id").value;
		} else if (7 == award_type || 10 == award_type){
			id = document.getElementById("goods_id").value;
		} else if (8 == award_type || 9 == award_type || 14 == award_type || 15 == award_type){
			var select_dom = document.getElementById("other_id");
			var option = select_dom.options[select_dom.selectedIndex];
			param_4 = option.getAttribute("param");
			id = option.getAttribute("value");
		} else{
			need_id = false
		}
		var result = award_type.toString()+":"+id.toString()+":"+number.toString()+",";
		if (0 < param_4){
			result = award_type.toString()+":"+id.toString()+":"+number.toString()+":"+param_4.toString()+",";
		}
		document.getElementById("out_put").value += result;
		if (need_id && 0 == id){
			document.getElementById("out_put").value = "";
			document.getElementById("err_put").value = "wrong format, id can not be 0";
		}
	});

	$("#reset").click(function(evt){
		document.getElementById("pet_id").value = "";
		document.getElementById("goods_id").value = "";
		document.getElementById("other_id").value = 1;
		document.getElementById("number_id").value = 1;
		document.getElementById("param_id").value = "";
		document.getElementById("pet_name").value = "";
		document.getElementById("goods_name").value = "";
		document.getElementById("out_put").value = "";
		document.getElementById("err_put").value = "";
	});

	$("#pet_name_select").click(function(evt){
		var str_out_put = document.getElementById("out_put").value;
		for (i=0;i<str_out_put.length ;i++ )    
	    {    
			str_out_put = str_out_put.replace(",","_");     
	    }
		var form = document.createElement("form");
		form.action = "/index.php/award_detail/execute_pet_name_select_id/_" + 
		document.getElementById("area").value +"_/_" +
		document.getElementById("pet_name").value +"_/_" +
		str_out_put +"_/_" +
		4 + "_/";
		form.method = "post";
		form.submit();
	});
	
	$("#goods_name_select").click(function(evt){
		var type = 10
		var award_type = document.getElementById("award_type").value;
		if (7 == award_type){
			type = award_type;
		}
		var str_out_put = document.getElementById("out_put").value;
		for (i=0;i<str_out_put.length ;i++ )    
	    {    
			str_out_put = str_out_put.replace(",","_");     
	    }
		var form = document.createElement("form");
		form.action = "/index.php/award_detail/execute_goods_name_select_id/_" + 
		document.getElementById("area").value +"_/_" +
		document.getElementById("goods_name").value +"_/_" +
		str_out_put +"_/_" +
		type + "_/";
		form.method = "post";
		form.submit();
	});
}
);

function update_award_type(){
	var award_type = document.getElementById("award_type").value;

	var str_desc = document.getElementById("out_put").value;
	for (i=0;i<str_desc.length ;i++ )    
    {    
		str_desc = str_desc.replace(",","_");     
    }

	var form = document.createElement("form");
	form.action = "/index.php/award_detail/execute_change_type_select_id/_" + 
	document.getElementById("area").value +"_/_" +
	str_desc +"_/_" +
	award_type +"_/";
	form.method = "post";
	form.submit();
}

function run(){
	document.getElementById("pet_id").value = <?php echo $pet_id;?>;
	document.getElementById("goods_id").value = <?php echo $goods_id?>;
	document.getElementById("out_put").value = "<?php echo $out_put?>";	
}
onload = run;

</script>
</head>
<body>
<table align="center" width="60%">
<tr valign="top">
<td>
<?php echo LG_AWARD_TYPE?>
</td>
<td>
<select id="award_type"  onchange="update_award_type()">
<?php
	foreach($type as $row){
		if ($cur_type == $row['value']) {
			echo "<option value=".$row["value"]." selected=".selected.">".$row["name"]."</option>";
		}else {
			echo "<option value=".$row["value"].">".$row["name"]."</option>";
		}
	} 	
?>
</select>
</td>
<td>
<?php echo LG_SELECT_SERVER?>
</td>
<td>
<select name="area" id="area">
<?php 
	foreach($area_list as $area){
		if (1 == $area['selected']) {
			echo "<option value=". $area['id']." selected>".$area['name']."</option>";	
		} else {
			echo "<option value=". $area['id'].">".$area['name']."</option>";	
		}
	}
?>
</select>
</td>
</tr>
<tr>
<td><?php echo LG_PET_ID?></td>
<td><output type="text" id="pet_id"></td>
<td>
<button id="pet_name_select"><?php echo LG_PET_NAME_SELECT?></button>
</td>
<td><input type="text" id="pet_name" value="<?php echo $pet_name?>"></td>
</tr>
<tr>
<td><?php echo LG_GOODS_ID?></td>
<td><output type="text" id="goods_id"></td>
<td>
<button id="goods_name_select"><?php echo LG_GOODS_NAME_SELECT?></button>
</td>
<td><input type="text" id="goods_name" value="<?php echo $goods_name?>"></td>
</tr>
<tr>
<td><?php echo LG_OTHER_AWARD_TYPE_ID?></td>
<td>
<select  name="other" id="other_id" >
<?php
	foreach($other_type as $row){
		echo "<option value=".$row["value"]." param=". $row["param"] .">".$row["name"]."</option>";
	} 	
?>
</select>
</td>
</tr>
<tr>
<td><?php echo LG_NUMBER?></td>
<td><input type="text" id="number_id" value="1"></td>
</tr>
<tr>
<td><?php echo LG_PARAM4?></td>
<td><input type="text" id="param_id"></td>
</tr>
<tr>
<td>
<button id="add_award"><?php echo LG_ADD?></button>
</td>
<td>
<button id="reset"><?php echo LG_RESET?></button>
</td>
</tr>
<td></td>
<tr>
<td></td>
</tr>
<tr>
<td></td>
</tr>
<tr>
<td><?php echo LG_OUTPUT?></td>
<td><output type="text" id="out_put"></td>
</tr>
<tr>
<td><output type="text" id="in_put"></td>
<td><output type="text" id="err_put"></td>
</tr>
</table>