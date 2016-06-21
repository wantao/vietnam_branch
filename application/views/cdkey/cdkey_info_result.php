<table border=1 align="center">
		<?php
			echo "<tr>";
			foreach($property_name as $property => $name){
				echo "<th>$name</th>";
			}
			echo "</tr>";
			foreach($info as $entry){
				echo "<tr>";
				$id = 0;
				foreach($property_name as $property => $name){
					if ($id == 0){
						$id = $entry->$property;
					}
					echo "<td>{$entry->$property}</td>";
				}
				$answer = "<button onclick=opt_edit($id)>".LG_MODIFY."</button><button onclick=opt_delete($id)>".LG_DELETE."</button>";
				echo "<td>$answer</td>";
				echo "</tr>";
			}
			echo "<tr>
			<td><button onclick=opt_add()>".LG_ADD."</button></td>
			</tr>";
		?>
</table>
