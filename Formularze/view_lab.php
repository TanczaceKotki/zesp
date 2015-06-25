<?php
	require 'common.php';
	require 'DB.php';
	top();
	$DB=dbconnect();
	if(isset($_POST['submitted'])){
		$send=False;
		$params=array();
		$sql='UPDATE Laboratorium SET';
		if($_POST['nazwa']!==$_POST['old_nazwa']){
			$sql.=' nazwa=?';
			$params[]=$_POST['nazwa'];
			$send=True;
		}
		if($_POST['zespol']!==$_POST['old_zespol']){
			if($send) $sql.=',';
			if($_POST['zespol']==="") $sql.=' zespol=NULL';
			else{
				$sql.=' zespol=?';
				$params[]=$_POST['zespol'];
			}
			$send=True;
		}
		if($send){
			$sql.=' WHERE id=?';
			$params[]=$_POST['id'];
			if($st=$DB->prepare($sql)){
				if($st->execute($params)) echo 'Laboratorium zostało pomyślnie zmodyfikowane.<br /><br />';
				else echo 'Nastąpił błąd przy modyfikowaniu laboratorium: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
			else echo 'Nastąpił błąd przy modyfikowaniu laboratorium: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
	}
	if($st=$DB->prepare('SELECT * FROM Laboratorium WHERE id=?')){
		if($st->execute(array($_GET['id']))){
			if($row=$st->fetch(PDO::FETCH_ASSOC)){
				?><form action="index_panel_admina.php" method="post" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
					<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
					<input type="submit" name="del_lab" value="Usuń" />
				</form>
				<form action="edit_lab.php?=<?php echo $row['id']; ?>" method="post" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
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
							<td>Zespół</td>
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
	?><br /><a href="index_panel_admina.php">Wróć do strony głównej.</a><?php
	bottom();
?>
