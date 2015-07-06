 <script src="../bootstrap/js/bootstrap.min.js"></script>
 <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
 <meta charset="utf-8">
 <ol class="breadcrumb">
  <li><a href="index.php">Start</a></li>
  <li><a href="index.php?menu=3">Zarządzanie zdjęciami</a></li>
  <li class="active">Zdjęcia</li>
</ol>
<?php
	require 'common.php';
	require 'DB.php';
	
	$DB=dbconnect();
	if($st=$DB->prepare('SELECT * FROM Zdjecie WHERE id=?')){
		if($st->execute(array($_GET['id']))){
			if($row=$st->fetch(PDO::FETCH_ASSOC)){
				?>
				<br />
				<table class="table table-striped">
					<tbody>
						<tr>
							<td>Podgląd:</td>
							<td><img src="uploads/<?php echo $row['link']; ?>" width="200" alt="" /></td>
						</tr>
						<tr>
							<td>Link:</td>
							<td><?php echo $row['link']; ?></td>
						</tr>
						<tr>
							<td>Sprzęt:</td>
							<td><?php
				if($result=$DB->prepare('SELECT nazwa FROM Sprzet WHERE id=?')){
					if($result->execute(array($row['sprzet']))){
						if($row2=$result->fetch(PDO::FETCH_ASSOC)) echo $row2['nazwa'];
					}
					else echo 'Nie udało się pobrać danych z bazy danych.';
				}
				else echo 'Nie udało się pobrać danych z bazy danych.';
							?></td>
						</tr>
					</tbody>
				</table><?php
			}
			else echo 'Nie znaleziono zdjęcia o podanym identyfikatorze.<br /><br />';
		}
		else echo 'Nastąpił błąd przy odczytywaniu informacji o zdjęciu: '.implode(' ',$st->errorInfo()).'<br /><br />';
	}
	else echo 'Nastąpił błąd przy odczytywaniu informacji o zdjęciu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
	?><br /><a class="btn btn-warning" href="index.php">Wróć do strony zarządzania zdjęciami</a><?php
	
?>
