    Labolatoria
	<?php
	top();
	$DB=dbconnect();
		if($result=$DB->query('SELECT id,nazwa FROM Laboratorium ORDER BY nazwa')){
			while($row=$result->fetch(PDO::FETCH_ASSOC)){
				?>
				<p class="listowanie">
					
						<a href="view_lab.php?id=<?php echo $row['id']; ?>"><?php echo $row['nazwa']; ?></a>
					
					</p>
				<?php
			}
		}
	?>
