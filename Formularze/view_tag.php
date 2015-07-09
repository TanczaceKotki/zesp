<ol class="breadcrumb">
  <li><a href="index.php">Start</a></li>
  <li class="active">Szczegóły tag</li>
</ol>
<?php
	$DB=dbconnect();
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
				?>
				<br />
				<table class="table table-striped">
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
										?><a href="index.php?menu=52&amp;id=<?php echo $row2['sprzet']; ?>"><?php echo $row3['nazwa']; ?></a>
										<form action="index.php?menu=60&amp;id=<?php echo $row['id']; ?>" method="post" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
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
			else echo 'Nie znaleziono tagu o podanym identyfikatorze.<br /><br />';
		}
		else echo 'Nastąpił błąd przy pobieraniu informacji o tagu: '.implode(' ',$st->errorInfo()).'<br /><br />';
	}
	else echo 'Nastąpił błąd przy pobieraniu informacji o tagu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
?>
