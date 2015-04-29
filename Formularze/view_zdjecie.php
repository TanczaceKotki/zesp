<?php
	require 'common.php';
	require 'DB.php';
	top();
	$DB=dbconnect();
	if(isset($_POST['submitted'])){
		$send=False;
		$params=array();
		$sql='UPDATE Zdjecie SET';
		if($_POST['link']!==$_POST['old_link']){
			$sql.=' link=?';
			$params[]=$_POST['link'];
			$send=True;
		}
		if($_POST['sprzet']!==$_POST['old_sprzet']){
			if($send) $sql.=',';
			$sql.=' sprzet=?';
			$params[]=$_POST['sprzet'];
			$send=True;
		}
		if($send){
			$sql.=' WHERE id=?';
			$params[]=$_POST['id'];
			if($st=$DB->prepare($sql)){
				if($st->execute($params)) echo 'Zdjęcie zostało pomyślnie zmodyfikowane.<br /><br />';
				else echo 'Nastąpił błąd przy modyfikowaniu zdjęcia: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
			else echo 'Nastąpił błąd przy modyfikowaniu zdjęcia: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
	}
	if($st=$DB->prepare('SELECT * FROM Zdjecie WHERE id=?')){
		if($st->execute(array($_GET['id']))){
			if($row=$st->fetch(PDO::FETCH_ASSOC)){
				?><form action="index.php" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
					<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
					<input type="submit" name="del_zdjecie" value="Usuń" />
				</form>
				<form action="edit_zdjecie.php?=<?php echo $row['id']; ?>" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
					<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
					<input type="submit" value="Edytuj" />
				</form>
				<br />
				<table>
					<tbody>
						<tr>
							<td>Podgląd</td>
							<td><img src="uploads/<?php echo $row['link']; ?>" width="200" alt="" /></td>
						</tr>
						<tr>
							<td>Link</td>
							<td><?php echo $row['link']; ?></td>
						</tr>
						<tr>
							<td>Sprzęt</td>
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
			else echo 'Nastąpił błąd przy dodawaniu informacji o zdjęciu: '.implode(' ',$st->errorInfo()).'<br /><br />';
		}
		else echo 'Nastąpił błąd przy dodawaniu informacji o zdjęciu: '.implode(' ',$st->errorInfo()).'<br /><br />';
	}
	else echo 'Nastąpił błąd przy dodawaniu informacji o zdjęciu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
	?><br /><a href="index.php">Wróć do strony głównej.</a><?php
	bottom();
?>
