<table border=1 align="center">
		<?php
			foreach($property_name as $property => $name){
				foreach($info as $entry){
					$value = $entry->$property;
					echo "<tr><td> $name </td><td> $value </td></tr>";
				}
			} 
		?>
</table>
