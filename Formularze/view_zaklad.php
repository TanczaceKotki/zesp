<ol class="breadcrumb">
  <li><a href="index.php">Start</a></li>
  <li class="active">Szczegóły zakład</li>
</ol>
<?php
	$DB=dbconnect();
	if(isset($_POST['del_lab'])){
		if($st=$DB->prepare('DELETE FROM Laborat_w_zaklad WHERE laboratorium=? AND zaklad=?')){
			if($st->execute(array($_POST['laboratorium'],$_POST['zaklad']))) echo 'Laboratorium zostało usunięte.<br /><br />';
			else echo 'Nastąpił błąd przy usuwaniu laboratorium: '.implode(' ',$st->errorInfo()).'<br /><br />';
		}
		else echo 'Nastąpił błąd przy usuwaniu laboratorium: '.implode(' ',$DB->errorInfo()).'<br /><br />';
	}
	if(isset($_POST['submitted'])){
		if($_POST['nazwa']!==$_POST['old_nazwa']){
			if($st=$DB->prepare('UPDATE Zaklad SET nazwa=? WHERE id=?')){
				if($st->execute(array($_POST['nazwa'],$_POST['id']))) echo 'Zakład został pomyślnie zmodyfikowany.<br /><br />';
				else echo 'Nastąpił błąd przy modyfikowaniu zakładu: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
			else echo 'Nastąpił błąd przy modyfikowaniu zakładu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
	}
	if($st=$DB->prepare('SELECT * FROM Zaklad WHERE id=?')){
		if($st->execute(array($_GET['id']))){
			if($row=$st->fetch(PDO::FETCH_ASSOC)){
				?><br />
				<table class="table table-striped">
					<tbody>
						<tr>
							<td>Nazwa</td>
							<td><?php echo $row['nazwa']; ?></td>
						</tr>
						<tr>
							<td>Laboratoria</td>
							<td>
							<?php
				if($result=$DB->prepare('SELECT * FROM Laborat_w_zaklad WHERE zaklad=? ORDER BY laboratorium')){
					if($result->execute(array($row['id']))){
						while($row2=$result->fetch(PDO::FETCH_ASSOC)){
							if($result2=$DB->prepare('SELECT nazwa FROM Laboratorium WHERE id=?')){
								if($result2->execute(array($row2['laboratorium']))){
									if($row3=$result2->fetch(PDO::FETCH_ASSOC)){
										?><a href="index.php?menu=57&amp;id=<?php echo $row2['laboratorium']; ?>"><?php echo $row3['nazwa']; ?>
										<form action="index.php?menu=61&amp;id=<?php echo $row['id']; ?>" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
											<input type="hidden" name="zaklad" value="<?php echo $row['id']; ?>" />
											<input type="hidden" name="laboratorium" value="<?php echo $row2['laboratorium']; ?>" />
											<input type="submit" name="del_lab" value="Usuń" />
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
					</tbody>
				</table><?php
			}
			else echo 'Nie znaleziono zakładu o podanym identyfikatorze.<br /><br />';
		}
		else echo 'Nastąpił błąd przy pobieraniu informacji o zakładzie: '.implode(' ',$st->errorInfo()).'<br /><br />';
	}
	else echo 'Nastąpił błąd przy pobieraniu informacji o zakładzie: '.implode(' ',$DB->errorInfo()).'<br /><br />';
?>
