<script src="../bootstrap/js/bootstrap.min.js"></script>
 <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
 <meta charset="utf-8">
  <ol class="breadcrumb">
  <li><a href="index.php">Start</a></li>
  <li><a href="index.php?menu=3">Laboratoria</a></li>
  <li class="active">Szczegóły laboratorium</li>
</ol>
<?php
	require 'common.php';
	require 'DB.php';
		$DB=dbconnect();
	
	if($st=$DB->prepare('SELECT * FROM Laboratorium WHERE id=?')){
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
							<td>Zespół:</td>
							<td><?php
				if($row['zespol']!==""){
					if($result=$DB->prepare('SELECT nazwa FROM Zespol WHERE id=?')){
						if($result->execute(array($row['zespol']))){
							if($row2=$result->fetch(PDO::FETCH_ASSOC)) echo $row2['nazwa'];
							else echo 'Nie udało się pobrać danych z bazy danych.';
						}
						else echo 'Nie udało się pobrać danych z bazy danych.';
					}
					else echo 'Nie udało się pobrać danych z bazy danych.';
				}
							?></td>
						</tr>
					</tbody>
				</table><?php
			}
			else echo 'Nie znaleziono laboratorium o podanym identyfikatorze.<br /><br />';
		}
		else echo 'Nastąpił błąd przy pobieraniu informacji o laboratorium: '.implode(' ',$st->errorInfo()).'<br /><br />';
	}
	else echo 'Nastąpił błąd przy pobieraniu informacji o laboratorium: '.implode(' ',$DB->errorInfo()).'<br /><br />';
	?><a class="btn btn-warning" href="index.php?menu=7">Wróć do strony labolatoriów</a><?php
	
?>

