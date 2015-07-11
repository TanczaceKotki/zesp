 <?php
	if(user::isLogged()){
?>
<ol class="breadcrumb">
	<li><a href="index.php">Start</a></li>
	<li><a href="index.php?menu=17">Zarządzaj projektami</a></li>
	<li class="active">Szczegóły projekt</li>
</ol>
 <?php
	if($st=$DB->prepare('SELECT * FROM Projekt WHERE id=?')){
		if($st->execute(array($_GET['id']))){
			if($row=$st->fetch(PDO::FETCH_ASSOC)){
				?>
				<br />
				<table class="table table-striped">
					<tbody>
						<tr>
							<th>Nazwa:</th>
							<td> <?php echo $row['nazwa']; ?></td>
						</tr>
						<tr>
							<th>Data rozpoczęcia:</th>
							<td> <?php echo $row['data_rozp']; ?></td>
						</tr>
						<tr>
							<th>Data Zakończenia:</th>
							<td> <?php echo $row['data_zakoncz']; ?></td>
						</tr>
						<tr>
							<th>Opis:</th>
							<td> <?php echo htmlspecialchars($row['opis'],ENT_QUOTES|ENT_HTML5,'UTF-8',false); ?></td>
						</tr>
						<tr>
							<th>Logo:</th>
							<td><a href=" <?php echo $row['logo']; ?>"><img src=" <?php echo $row['logo']; ?>" width="200" alt="" /></a></td>
						</tr>
					</tbody>
				</table> <?php
			}
		}
		else echo 'Nastąpił błąd przy pobieraniu informacji o projekcie: '.implode(' ',$st->errorInfo()).'<br /><br />';
	}
	else echo 'Nastąpił błąd przy pobieraniu informacji o projekcie: '.implode(' ',$DB->errorInfo()).'<br /><br />';
	?>
<a class="btn btn-warning" href="index.php?menu=17">Wróć do strony zarządzania projektami</a>
 <?php
	}
	else echo '<br />Nie jesteś zalogowany.<br /><a href="index.php?menu=10">Zaloguj się</a><br /><br /> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
?>
