<ol class="breadcrumb">
	<li><a href="index.php">Start</a></li>
	<li class="active">Projekty</li>
</ol>
<table class="table table-striped">
	<?php
		if($result=$DB->query('SELECT id,nazwa FROM Projekt ORDER BY nazwa')){
			while($row=$result->fetch(PDO::FETCH_ASSOC)){
				?><tr>
					<td>
						<a href="index.php?menu=59&amp;id=<?php echo $row['id']; ?>"><?php echo $row['nazwa']; ?></a>
					</td>
				</tr><?php
			}
		}
	?>
</table>
<br /><br />
