<table border=1 align="center">
		<?php
			$first_line = true;
			foreach($info as $entry){
				if($first_line){
					echo "<tr>";
					foreach($property_name as $property => $name){
						echo "<th>$name</th>";
					}
					echo "</tr>";
					$first_line = false;
				}
				echo "<tr>";
				foreach($property_name as $property => $name){
					echo "<td>{$entry->$property}</td>";
				}
				echo "</tr>";
			} 
		?>
</table>
