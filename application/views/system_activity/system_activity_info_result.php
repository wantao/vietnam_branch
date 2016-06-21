<table border=1 align="center">
		<?php
			echo "<tr>";
			foreach($property_name as $property => $name){
				if ('type' == $property)continue;
				if (($type != 7 && $type !=8) && 'get_award_time' == $property )continue;
				echo "<th>$name</th>";
			}
			if (9 == $type) {
				echo "<th>".LG_INVENTORY."</th>";
				echo "<th>".LG_TODAY_LIMIT_BUY_COUNT."</th>";
				echo "<th>".LG_TODAY_BOUGHT_COUNT."</th>";	
			}
			echo "</tr>";
			foreach($info as $entry){
				echo "<tr>";
				$id = 0;
				foreach($property_name as $property => $name){
					if ('type' == $property)continue;
					if (($type != 7 && $type !=8) && 'get_award_time' == $property )continue;
					if($id == 0){
						$id = $entry->$property;
					}
					echo "<td>{$entry->$property}</td>";
				}
				if (9 == $type) {
					echo "<td>{$entry->inventory}</td>";
					echo "<td>{$entry->today_limit_buy_count}</td>";
					echo "<td>{$entry->today_bought_count}</td>";	
				}
				$answer = "<button onclick=opt_edit($area_id,$id)>".LG_MODIFY."";
				echo "<td>$answer</td>";
				echo "</tr>";
			}
		?>
</table>
