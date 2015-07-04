<?php
	require 'common.php';
	require 'DB.php';
	top();
	$DB=dbconnect();
	if(isset($_POST['del_kontakt'])){
		if($st=$DB->prepare('DELETE FROM Kontakt WHERE sprzet=? AND osoba=?')){
			if($st->execute(array($_POST['sprzet'],$_POST['osoba']))) echo 'Informacje kontaktowe zostały usunięte.<br /><br />';
			else echo 'Nastąpił błąd przy usuwaniu informacji kontaktowych: '.implode(' ',$st->errorInfo()).'<br /><br />';
		}
		else echo 'Nastąpił błąd przy usuwaniu informacji kontaktowych: '.implode(' ',$DB->errorInfo()).'<br /><br />';
	}
	if(isset($_POST['submitted'])){
		$send=False;
		$params=array();
		$sql='UPDATE Osoba SET';
		if($_POST['imie']!==$_POST['old_imie']){
			$sql.=' imie=?';
			$params[]=$_POST['imie'];
			$send=True;
		}
		if($_POST['nazwisko']!==$_POST['old_nazwisko']){
			if($send) $sql.=',';
			$sql.=' nazwisko=?';
			$params[]=$_POST['nazwisko'];
			$send=True;
		}
		if($_POST['email']!==$_POST['old_email']){
			if($st=$DB->prepare('UPDATE Uzytkownicy SET login=? WHERE login=?')){
				if($st->execute(array($_POST['email'],$_POST['old_email']))){
					if(!$send) echo 'Osoba została pomyślnie zmodyfikowana.<br /><br />';
				}
				else{
					echo 'Nastąpił błąd przy modyfikowaniu osoby: '.implode(' ',$st->errorInfo()).'<br /><br />';
				}
			}
			else echo 'Nastąpił błąd przy modyfikowaniu osoby: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
		if($send){
			$sql.=' WHERE id=?';
			$params[]=$_POST['id'];
			if($st=$DB->prepare($sql)){
				if($st->execute($params)){
					echo 'Osoba została pomyślnie zmodyfikowana.<br /><br />';
				}
				else echo 'Nastąpił błąd przy modyfikowaniu osoby: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
			else echo 'Nastąpił błąd przy modyfikowaniu osoby: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
	}
	if($st=$DB->prepare('SELECT * FROM Osoba WHERE id=?')){
		if($st->execute(array($_GET['id']))){
			if($row=$st->fetch(PDO::FETCH_ASSOC)){
				?><form action="index_panel_admina.php" method="post" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
					<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
					<input type="submit" name="del_osoba" value="Usuń" />
				</form>
				<form action="edit_osoba.php" method="post" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
					<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
					<input type="submit" value="Edytuj" />
				</form><br />
				<table>
					<tbody>
						<tr>
							<td>Imię</td>
							<td><?php echo $row['imie']; ?></td>
						</tr>
						<tr>
							<td>Nazwisko</td>
							<td><?php echo $row['nazwisko']; ?></td>
						</tr>
						<tr>
							<td>Email</td>
							<td><a href="mailto:<?php echo $row['email']; ?>"><?php echo $row['email']; ?></a></td>
						</tr>
						<tr>
							<td>Kontakt</td>
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
	?><br /><a href="index_panel_admina.php">Wróć do strony głównej.</a><?php
	bottom();
?>
