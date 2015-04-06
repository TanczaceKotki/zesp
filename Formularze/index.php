<?php
	require 'common.php';
	top();
	require 'DB.php';
	$DB=dbconnect();
	if(isset($_POST['del'])){
		if($st=$DB->prepare('DELETE FROM Sprzet where id=?')){
			if($st->execute(array($_POST['id']))){
				echo 'Sprzęt został usunięty.<br /><br />';
			}
			else{
				echo 'Nastąpił błąd przy usuwaniu sprzętu: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
		}
		else{
			echo 'Nastąpił błąd przy usuwaniu sprzętu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
	}
?>
<a href="add_sprzet.php">Dodaj sprzęt</a> <a href="add_osoba.php">Dodaj osoba</a> <a href="add_tag.php">Dodaj tag</a> <a href="add_zespol.php">Dodaj zespół</a> <a href="add_laboratorium.php">Dodaj laboratorium</a> <a href="add_zaklad.php">Dodaj zakład</a> <a href="add_projekt.php">Dodaj projekt</a> <a href="add_zdjecie.php">Dodaj zdjęcie</a> <a href="add_kontakt.php">Dodaj informację kontaktową</a> <a href="add_tagi_sprzetu.php">Dodaj informację o tagu sprzętu</a> <a href="add_laborat_w_zaklad.php">Dodaj informację o laboratorium w zakładzie</a>
<table>
	<?php
		if($result=$DB->query("SELECT id,nazwa FROM Sprzet ORDER BY nazwa")){
			while($row=$result->fetch(PDO::FETCH_ASSOC)){
				echo '<tr><td><a href="view_sprzet.php?id='.$row['id'].'">'.$row['nazwa'].'</a></td><td><form action="index.php" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded"><input type="hidden" name="id" value="'.$row['id'].'" /><input type="submit" name="del" value="Usuń" /></form></td></tr>';
			}
		}
	?>
</table>
<?php
	bottom();
?>
