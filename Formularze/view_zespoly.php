	  <ol class="breadcrumb">
  <li><a href="index.php">Start</a></li>
    <li class="active">Zespoły</li>
</ol>
	<table class="table table-striped">
	<?php
	$DB=dbconnect();
		if($result=$DB->query('SELECT id,nazwa FROM Zespol ORDER BY nazwa')){
			while($row=$result->fetch(PDO::FETCH_ASSOC)){
				?>
				<tr><td>
					
						<a href="index.php?menu=58&amp;id=<?php echo $row['id']; ?>"><?php echo $row['nazwa']; ?></a>
					</td></tr>
					
				<?php
			}
		}
	?></table>
