<ol class="breadcrumb">
	<li><a href="index.php">Start</a></li>
	<li><a href="index.php?menu=107">Projekty</a></li>
	<li class="active">Szczegóły projekt</li>
</ol>
<?php
	$DB=dbconnect();
	if($st=$DB->prepare('SELECT * FROM Projekt WHERE id=?')){
		if($st->execute(array($_GET['id']))){
			if($row=$st->fetch(PDO::FETCH_ASSOC)){
				?>
				<br />
				<table class="table table-striped">
					<tbody>
						<tr>
							<td>Nazwa:</td>
							<td><?php echo $row['nazwa']; ?></td>
						</tr>
						<tr>
							<td>Data rozpoczęcia:</td>
							<td><?php echo $row['data_rozp']; ?></td>
						</tr>
						<tr>
							<td>Data Zakończenia:</td>
							<td><?php echo $row['data_zakoncz']; ?></td>
						</tr>
						<tr>
							<td>Opis:</td>
							<td><?php echo $row['opis']; ?></td>
						</tr>
						<tr>
							<td>Logo:</td>
							<td><img src="<?php echo $row['logo']; ?>" width="200" alt="" /></td>
						</tr>
					</tbody>
				</table><?php
			}
			else echo 'Nie znaleziono projektu o podanym identyfikatorze.<br /><br />';
		}
		else echo 'Nastąpił błąd przy pobieraniu informacji o projekcie.<br /><br />';
	}
	else echo 'Nastąpił błąd przy pobieraniu informacji o projekcie.<br /><br />';
?>
<br />
<a class="btn btn-warning" href="index.php?menu=107">Wróć do strony z projektami</a>
