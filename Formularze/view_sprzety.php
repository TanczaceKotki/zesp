Aparatura
	<?php

	session_start();
	require_once 'user.class.php';
	top();
	$DB=dbconnect();
	
		if($result=$DB->query('SELECT id,nazwa FROM Sprzet ORDER BY nazwa')){
			while($row=$result->fetch(PDO::FETCH_ASSOC)){
				?>
				<p class="listowanie">
					
						<a href="view_sprzet.php?id=<?php echo $row['id']; ?>"><?php echo $row['nazwa']; ?></a>
					</p>
					
				<?php
			}
		}
	?>
