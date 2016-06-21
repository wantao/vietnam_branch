<table border=1 align="center">
		<?php
			echo "<tr>";
			foreach($property_name as $property => $name){
				echo "<th>$name</th>";
			}
			echo "</tr>";
			foreach($info as $entry){
				echo "<tr>";
				$number = 0;
				$idx = 0;
				foreach($property_name as $property => $name){
					$number += 1;
					if($number == 2){
						$idx = $entry->$property;
					}
					echo "<td>{$entry->$property}</td>";
				}
				$answer = "<button onclick=opt_edit($area_id,$idx)>".LG_MODIFY."</button><button onclick=opt_delete($area_id,$idx)>".LG_DELETE."</button>";
				echo "<td>$answer</td>";
				echo "</tr>";
			}
			echo "<tr>
			<td><button onclick=opt_add($area_id)>".LG_ADD."</button></td>
			</tr>";
		?>
</table>
