<?php
	require 'common.php';
	require 'DB.php';
	top();
	$DB=dbconnect();
	if(isset($_POST['submitted'])){
		if($_POST['nazwa']!==$_POST['old_nazwa']){
			if($st=$DB->prepare('UPDATE Zespol SET nazwa=? WHERE id=?')){
				if($st->execute(array($_POST['nazwa'],$_POST['id']))) echo 'Zespół został pomyślnie zmodyfikowany.<br /><br />';
				else echo 'Nastąpił błąd przy modyfikowaniu zespołu: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
			else echo 'Nastąpił błąd przy modyfikowaniu zespołu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
	}
	if($st=$DB->prepare('SELECT * FROM Zespol WHERE id=?')){
		if($st->execute(array($_GET['id']))){
			if($row=$st->fetch(PDO::FETCH_ASSOC)){
				?><form action="index.php" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
					<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
					<input type="submit" name="del_zespol" value="Usuń" />
				</form>
				<form action="edit_zespol.php?=<?php echo $row['id']; ?>" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
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
					</tbody>
				</table><?php
			}
			else echo 'Nie znaleziono zespołu o podanym identyfikatorze.<br /><br />';
		}
		else echo 'Nastąpił błąd przy odczytywaniu informacji o zespole: '.implode(' ',$st->errorInfo()).'<br /><br />';
	}
	else echo 'Nastąpił błąd przy odczytywaniu informacji o zespole: '.implode(' ',$DB->errorInfo()).'<br /><br />';
	?><br /><a href="index.php">Wróć do strony głównej.</a><?php
	bottom();
?>
