<?php
	require 'common.php';
	require 'DB.php';
	$DB=dbconnect();
	top();
	if(isset($_POST['del_tag'])){
		if($st=$DB->prepare('DELETE FROM Tagi_sprzetu WHERE sprzet=? AND tag=?')){
			if($st->execute(array($_POST['sprzet'],$_POST['tag']))) echo 'Tag został usunięty.<br /><br />';
			else echo 'Nastąpił błąd przy usuwaniu tagu: '.implode(' ',$st->errorInfo()).'<br /><br />';
		}
		else echo 'Nastąpił błąd przy usuwaniu tagu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
	}
	if(isset($_POST['submitted'])){
		if($_POST['nazwa']!==$_POST['old_nazwa']){
			if($st=$DB->prepare('UPDATE Tag SET nazwa=? WHERE id=?')){
				if($st->execute(array($_POST['nazwa'],$_POST['id']))) echo 'Tag został pomyślnie zmodyfikowany.<br /><br />';
				else echo 'Nastąpił błąd przy modyfikowaniu tagu: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
			else echo 'Nastąpił błąd przy modyfikowaniu tagu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
	}
	if($st=$DB->prepare('SELECT * FROM Tag WHERE id=?')){
		if($st->execute(array($_GET['id']))){
			if($row=$st->fetch(PDO::FETCH_ASSOC)){
				?><form action="index.php" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
					<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
					<input type="submit" name="del_tag" value="Usuń" />
				</form>
				<form action="edit_tag.php?=<?php echo $row['id']; ?>" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
					<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
					<input type="submit" value="Edytuj" />
				</form>
				<br />
				<table>
					<tbody>
						<tr>
							<td>Nazwa</td>
							<td><?php echo $row['nazwa']; ?></td>
						</tr>
						<tr>
							<td>Sprzet</td>
							<td><?php
				if($result=$DB->prepare('SELECT sprzet FROM Tagi_sprzetu WHERE tag=? ORDER BY sprzet')){
					if($result->execute(array($row['id']))){
						while($row2=$result->fetch(PDO::FETCH_ASSOC)){
							if($result2=$DB->prepare('SELECT nazwa FROM Sprzet WHERE id=?')){
								if($result2->execute(array($row2['sprzet']))){
									if($row3=$result2->fetch(PDO::FETCH_ASSOC)){
										?><a href="view_sprzet.php?id=<?php echo $row2['sprzet']; ?>"><?php echo $row3['nazwa']; ?></a>
										<form action="view_tag.php?id=<?php echo $row['id']; ?>" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
											<input type="hidden" name="tag" value="<?php echo $row['id']; ?>" />
											<input type="hidden" name="sprzet" value="<?php echo $row2['sprzet']; ?>" />
											<input type="submit" name="del_tag" value="Usuń" />
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
				echo '</tbody></table>';
			}
			else echo 'Nastąpił błąd przy dodawaniu informacji o tagu sprzętu: '.implode(' ',$st->errorInfo()).'<br /><br />';
		}
		else echo 'Nastąpił błąd przy dodawaniu informacji o tagu sprzętu: '.implode(' ',$st->errorInfo()).'<br /><br />';
	}
	else echo 'Nastąpił błąd przy dodawaniu informacji o tagu sprzętu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
	?><br /><a href="index.php">Wróć do strony głównej.</a><?php
	bottom();
?>
