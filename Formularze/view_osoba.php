<script src="../bootstrap/js/bootstrap.min.js"></script>
 <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
 <meta charset="utf-8">
  <ol class="breadcrumb">
  <li><a href="index.php">Start</a></li>
  <li><a href="index.php?menu=100">Zarządzaj użytkownikami</a></li>
  <li class="active">Szczegóły użytkownik</li>
</ol>
<?php
	require 'common.php';
	require 'DB.php';
	$DB=dbconnect();
	
	if($st=$DB->prepare('SELECT * FROM Osoba WHERE id=?')){
		if($st->execute(array($_GET['id']))){
			if($row=$st->fetch(PDO::FETCH_ASSOC)){
				?>
				<table class="table table-striped">
					<tbody>
						<tr>
							<td>Imię:</td>
							<td><?php echo $row['imie']; ?></td>
						</tr>
						<tr>
							<td>Nazwisko:</td>
							<td><?php echo $row['nazwisko']; ?></td>
						</tr>
						<tr>
							<td>Email:</td>
							<td><a href="mailto:<?php echo $row['email']; ?>"><?php echo $row['email']; ?></a></td>
						</tr>
						<tr>
							<td>Kontakt:</td>
							<td><?php
				if($result=$DB->prepare('SELECT sprzet FROM Kontakt WHERE osoba=? ORDER BY sprzet')){
					if($result->execute(array($row['id']))){
						while($row2=$result->fetch(PDO::FETCH_ASSOC)){
							if($result2=$DB->prepare('SELECT nazwa FROM Sprzet WHERE id=?')){
								if($result2->execute(array($row2['sprzet']))){
									if($row3=$result2->fetch(PDO::FETCH_ASSOC)){
										?><a href="view_sprzet.php?id=<?php echo $row2['sprzet']; ?>"><?php echo $row3['nazwa']; ?></a>
										<form action="view_osoba.php?id=<?php echo $row['id']; ?>" method="post" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
											<input type="hidden" name="osoba" value="<?php echo $row['id']; ?>" />
											<input type="hidden" name="sprzet" value="<?php echo $row2['sprzet']; ?>" />
											<input type="submit" name="del_kontakt" value="Usuń" />
										</form><?php
									}
								}
								else echo 'Nie udało się pobrać danych z bazy danych.';
							}
							else echo 'Nie udało się pobrać danych z bazy danych.';
						}
					}
					else echo 'Nie udało się pobrać danych z bazy danych.';
				}
				else echo 'Nie udało się pobrać danych z bazy danych.';
				?>
					</tbody>
				</table><?php 
			}
			else echo 'Nie znaleziono osoby o podanym identyfikatorze.<br /><br />';
		}
		else echo 'Nastąpił błąd przy pobieraniu informacji o osobie: '.implode(' ',$st->errorInfo()).'<br /><br />';
	}
	else echo 'Nastąpił błąd przy pobieraniu informacji o osobie: '.implode(' ',$DB->errorInfo()).'<br /><br />';
	?><a class="btn btn-warning" href="index.php?menu=100">Wróć do strony zarządzania użytkownikami</a><?php
	
?>
