  <ol class="breadcrumb">
  <li><a href="index.php">Start</a></li>
    <li class="active">Aparatura</li>
</ol>
<table class="table table-striped" >
	<?php

	session_start();
	require_once 'user.class.php';
	$DB=dbconnect();
	
		if($result=$DB->query('SELECT id,nazwa FROM Sprzet ORDER BY nazwa')){
			while($row=$result->fetch(PDO::FETCH_ASSOC)){
				?>
				<tr><td>
					
						<a href="index.php?menu=56&amp;id=<?php echo $row['id']; ?>"><?php echo $row['nazwa']; ?></a>
					</td></tr>
					
				<?php
			}
		}
	?>	</table> 
