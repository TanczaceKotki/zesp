<?php
	require 'common.php';
	require 'DB.php';
	top();
	$DB=dbconnect();
	if($st=$DB->prepare('SELECT * FROM Zdjecie WHERE id=?')){
		if($st->execute(array($_GET['id']))){
			if($row=$st->fetch(PDO::FETCH_ASSOC)){
				?><form action="index_panel_admina.php" method="post" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
					<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
					<input type="submit" name="del_zdjecie" value="Usuń" />
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
			else echo 'Nie znaleziono zdjęcia o podanym identyfikatorze.<br /><br />';
		}
		else echo 'Nastąpił błąd przy odczytywaniu informacji o zdjęciu: '.implode(' ',$st->errorInfo()).'<br /><br />';
	}
	else echo 'Nastąpił błąd przy odczytywaniu informacji o zdjęciu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
	?><br /><a href="index_panel_admina.php">Wróć do strony głównej.</a><?php
	bottom();
?>
