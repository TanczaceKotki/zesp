<script src="../bootstrap/js/bootstrap.min.js"></script>
 <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
 <meta charset="utf-8">
 <ol class="breadcrumb">
  <li><a href="index.php">Start</a></li>
  <li><a href="index.php?menu=4">Aparatura</a></li>
  <li class="active">Szczegóły aparatura</li>
</ol>
<?php
	require 'common.php';
	require 'DB.php';
	
	$DB=dbconnect();
	if(isset($_POST['del_picture'])){
		if($st=$DB->prepare('DELETE FROM Zdjecie WHERE id=?')){
			if($st->execute(array($_POST['id']))) echo 'Zdjecie zostało usunięte.<br /><br />';
			else echo 'Nastąpił błąd przy usuwaniu zdjęcia: '.implode(' ',$st->errorInfo()).'<br /><br />';
		}
		else echo 'Nastąpił błąd przy usuwaniu zdjęcia: '.implode(' ',$DB->errorInfo()).'<br /><br />';
	}
	if(isset($_POST['del_tag'])){
		if($st=$DB->prepare('DELETE FROM Tagi_sprzetu WHERE sprzet=? AND tag=?')){
			if($st->execute(array($_POST['sprzet'],$_POST['tag']))) echo 'Tag został usunięty.<br /><br />';
			else echo 'Nastąpił błąd przy usuwaniu tagu: '.implode(' ',$st->errorInfo()).'<br /><br />';
		}
		else echo 'Nastąpił błąd przy usuwaniu tagu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
	}
	if(isset($_POST['del_kontakt'])){
		if($st=$DB->prepare('DELETE FROM Kontakt WHERE sprzet=? AND osoba=?')){
			if($st->execute(array($_POST['sprzet'],$_POST['osoba']))) echo 'Informacje kontaktowe zostały usunięte.<br /><br />';
			else echo 'Nastąpił błąd przy usuwaniu informacji kontaktowych: '.implode(' ',$st->errorInfo()).'<br /><br />';
		}
		else echo 'Nastąpił błąd przy usuwaniu informacji kontaktowych: '.implode(' ',$DB->errorInfo()).'<br /><br />';
	}

	if($st=$DB->prepare('SELECT * FROM Sprzet WHERE id=?')){
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
							<td>Data zakupu:</td>
							<td><?php echo $row['data_zakupu']; ?></td>
						</tr>
						<tr>
							<td>Data uruchomienia:</td>
							<td><?php if($row['data_uruchom']!=="") echo $row['data_uruchom']; ?></td>
						</tr>
						<tr>
							<td>Wartość:</td>
							<td><?php echo $row['wartosc']; ?></td>
						</tr>
						<tr>
							<td>Opis:</td>
							<td><?php echo $row['opis']; ?></td>
						</tr>
						<tr>
							<td>Projekt:</td>
							<td><?php
				if($row['projekt']!==""){
					if($result=$DB->prepare('SELECT nazwa FROM Projekt WHERE id=?')){
						if($result->execute(array($row['projekt']))){
							if($row2=$result->fetch(PDO::FETCH_ASSOC)) echo '<a href=view_projekt.php?id='.$row['projekt'].'>'.$row2['nazwa'].'</a>';
						}
						else echo 'Nie udało się pobrać danych z bazy danych.';
					}
					else echo 'Nie udało się pobrać danych z bazy danych.';
				}
							?></td>
						</tr>
						<tr>
							<td>Laboratorium:</td>
							<td><?php
				if($row['laboratorium']!==""){
					if($result=$DB->prepare('SELECT nazwa FROM Laboratorium WHERE id=?')){
						if($result->execute(array($row['laboratorium']))){
							if($row2=$result->fetch(PDO::FETCH_ASSOC)) echo $row2['nazwa'];
						}
						else echo 'Nie udało się pobrać danych z bazy danych.';
					}
					else echo 'Nie udało się pobrać danych z bazy danych.';
				}
							?></td>
						</tr>
						<tr>
							<td>Zdjęcia:</td>
							<td><?php
				if($result=$DB->prepare('SELECT id,link FROM Zdjecie WHERE sprzet=? ORDER BY link')){
					if($result->execute(array($row['id']))){
						while($row2=$result->fetch(PDO::FETCH_ASSOC)){
							?><img src="uploads/<?php echo $row2['link']; ?>" width="200" alt="" />
							<form action="view_sprzet.php?id=<?php echo $row['id']; ?>" method="post" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
								<input type="hidden" name="id" value="<?php echo $row2['id']; ?>" />
								<input type="submit" name="del_picture" value="Usuń" />
							</form>
							<br /><?php
						}
					}
					else echo 'Nie udało się pobrać danych z bazy danych.';
				}
				else echo 'Nie udało się pobrać danych z bazy danych.';
							?></td>
						</tr>
						<tr>
							<td>Tagi:</td>
							<td><?php
				if($result=$DB->prepare('SELECT tag FROM Tagi_sprzetu WHERE sprzet=? ORDER BY tag')){
					if($result->execute(array($row['id']))){
						while($row2=$result->fetch(PDO::FETCH_ASSOC)){
							if($result2=$DB->prepare('SELECT nazwa FROM Tag WHERE id=?')){
								if($result2->execute(array($row2['tag']))){
									if($row3=$result2->fetch(PDO::FETCH_ASSOC)){
										echo $row3['nazwa']; ?>
										<form action="view_sprzet.php?id=<?php echo $row['id']; ?>" method="post" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
											<input type="hidden" name="sprzet" value="<?php echo $row['id']; ?>" />
											<input type="hidden" name="tag" value="<?php echo $row2['tag']; ?>" />
											<input type="submit" name="del_tag" value="Usuń" />
										</form>
										<br /><?php
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
							?></td>
						</tr>
						<tr>
							<td>Kontakt:</td>
							<td><?php
				if($result=$DB->prepare('SELECT osoba FROM Kontakt WHERE sprzet=? ORDER BY osoba')){
					if($result->execute(array($row['id']))){
						while($row2=$result->fetch(PDO::FETCH_ASSOC)){
							if($result2=$DB->prepare('SELECT imie,nazwisko,email FROM Osoba WHERE id=?')){
								if($result2->execute(array($row2['osoba']))){
									if($row3=$result2->fetch(PDO::FETCH_ASSOC)){
										?><a href="view_osoba.php?id=<?php echo $row2['osoba']; ?>"><?php echo $row3['imie'].' '.$row3['nazwisko'].' ('.$row3['email'].')'; ?></a>
										<form action="view_sprzet.php?id=<?php echo $row['id']; ?>" method="post" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
											<input type="hidden" name="sprzet" value="<?php echo $row['id']; ?>" />
											<input type="hidden" name="osoba" value="<?php echo $row2['osoba']; ?>" />
											<input type="submit" name="del_kontakt" value="Usuń" />
										</form>
										<?php
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
							</td>
						</tr>
					</tbody>
				</table>
				<?php
			}
			else echo 'Nie udało się pobrać danych z bazy danych.';
		}
		else echo 'Nastąpił błąd przy pobieraniu informacji o sprzęcie: '.implode(' ',$st->errorInfo()).'<br /><br />';
	}
	else echo 'Nastąpił błąd przy pobieraniu informacji o sprzęcie: '.implode(' ',$DB->errorInfo()).'<br /><br />';
	?><a class="btn btn-warning" href="index.php?menu=8">Wróć do strony aparatura</a><?php
	
?>

