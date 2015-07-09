<ol class="breadcrumb">
  <li><a href="index.php">Start</a></li>
  <li><a href="index.php?menu=5">Zespoły</a></li>
  <li class="active">Szczegóły zespołu laboratoriów</li>
</ol>
<?php
	$DB=dbconnect();
	if($st=$DB->prepare('SELECT * FROM Zespol WHERE id=?')){
		if($st->execute(array($_GET['id']))){
			if($row=$st->fetch(PDO::FETCH_ASSOC)){
				?>
				<table class="table table-striped">
					<tbody>
						<tr>
							<td>Nazwa:</td>
							<td><?php echo $row['nazwa']; ?></td>
						</tr>
					</tbody>
				</table><?php
			}
			else echo 'Nie znaleziono zespołu o podanym identyfikatorze.<br /><br />';
		}
		else echo 'Nastąpił błąd przy odczytywaniu informacji o zespole.<br /><br />';
	}
	else echo 'Nastąpił błąd przy odczytywaniu informacji o zespole.<br /><br />';
?>
<a class="btn btn-warning" href="index.php?menu=5">Wróć do strony z zespołami</a>
