<?php
	session_start();
	require_once 'user.class.php';
	require 'common.php';
	require 'DB.php';
	$DB=dbconnect();
	if (user::isLogged()) {
		$user = user::getData('', '');
		if(isset($_POST['del_sprzet'])){
			if($st=$DB->prepare('DELETE FROM Sprzet WHERE id=?')){
				if($st->execute(array($_POST['id']))) echo 'Sprzęt został usunięty.<br /><br />';
				else echo 'Nastąpił błąd przy usuwaniu sprzętu: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
			else echo 'Nastąpił błąd przy usuwaniu sprzętu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
		if(isset($_POST['del_osoba'])){
			if($st=$DB->prepare('DELETE FROM Osoba WHERE id=?')){
				if($st->execute(array($_POST['id']))) echo 'Osoba została usunięta.<br /><br />';
				else echo 'Nastąpił błąd przy usuwaniu osoby: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
			else echo 'Nastąpił błąd przy usuwaniu osoby: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
		if(isset($_POST['del_tag'])){
			if($st=$DB->prepare('DELETE FROM Tag WHERE id=?')){
				if($st->execute(array($_POST['id']))) echo 'Tag został usunięty.<br /><br />';
				else echo 'Nastąpił błąd przy usuwaniu tagu: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
			else echo 'Nastąpił błąd przy usuwaniu tagu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
		if(isset($_POST['del_projekt'])){
			if($st=$DB->prepare('DELETE FROM Projekt WHERE id=?')){
				if($st->execute(array($_POST['id']))) echo 'Projekt został usunięty.<br /><br />';
				else echo 'Nastąpił błąd przy usuwaniu projektu: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
			else echo 'Nastąpił błąd przy usuwaniu projektu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
		if(isset($_POST['del_lab'])){
			if($st=$DB->prepare('DELETE FROM Laboratorium WHERE id=?')){
				if($st->execute(array($_POST['id']))) echo 'Laboratorium zostało usunięte.<br /><br />';
				else echo 'Nastąpił błąd przy usuwaniu laboratorium: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
			else echo 'Nastąpił błąd przy usuwaniu laboratorium: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
		if(isset($_POST['del_zespol'])){
			if($st=$DB->prepare('DELETE FROM Zespol WHERE id=?')){
				if($st->execute(array($_POST['id']))) echo 'Zespół został usunięty.<br /><br />';
				else echo 'Nastąpił błąd przy usuwaniu zespołu: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
			else echo 'Nastąpił błąd przy usuwaniu zespołu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
		if(isset($_POST['del_zaklad'])){
			if($st=$DB->prepare('DELETE FROM Zaklad WHERE id=?')){
				if($st->execute(array($_POST['id']))) echo 'Zakład został usunięty.<br /><br />';
				else echo 'Nastąpił błąd przy usuwaniu zakładu: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
			else echo 'Nastąpił błąd przy usuwaniu zakładu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
		if(isset($_POST['del_zdjecie'])){
			if($st=$DB->prepare('DELETE FROM Zdjecie WHERE id=?')){
				if($st->execute(array($_POST['id']))) echo 'Zdjęcie zostało usunięte.<br /><br />';
				else echo 'Nastąpił błąd przy usuwaniu zdjęcia: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
			else echo 'Nastąpił błąd przy usuwaniu zdjęcia: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
?>
<a href="wyloguj.php">Wyloguj</a><br />

<?php
	$login = $_SESSION["login"];
	if($st=$DB->prepare('SELECT lvl FROM Uzytkownicy WHERE login=?'))
				if($st->execute(array($_SESSION["login"])))
					if($row=$st->fetch(PDO::FETCH_ASSOC)){
						if($row['lvl'] == 0) {
							
							?>
							<a href="panel.php">Panel administracyjny</a><br /><br />
						<?php }
						else echo "<br />";
					}
?>
<a href="add_sprzet.php">Dodaj sprzęt</a><br />
<a href="add_osoba.php">Dodaj osoba</a><br />
<a href="add_tag.php">Dodaj tag</a><br />
<a href="add_zespol.php">Dodaj zespół</a><br />
<a href="add_lab.php">Dodaj laboratorium</a><br />
<a href="add_zaklad.php">Dodaj zakład</a><br />
<a href="add_projekt.php">Dodaj projekt</a><br />
<a href="add_zdjecie.php">Dodaj zdjęcie</a><br />
<a href="add_kontakt.php">Dodaj informację kontaktową</a><br />
<a href="add_tagi_sprzetu.php">Dodaj informację o tagu sprzętu</a><br />
<a href="add_laborat_w_zaklad.php">Dodaj informację o laboratorium w zakładzie</a>
<br /><br />
<table><tr><td colspan="2">Sprzęt</td></tr>
	<?php
		if($result=$DB->query('SELECT id,nazwa FROM Sprzet ORDER BY nazwa')){
			while($row=$result->fetch(PDO::FETCH_ASSOC)){
				?>
				<tr>
					<td>
						<a href="view_sprzet.php?id=<?php echo $row['id']; ?>"><?php echo $row['nazwa']; ?></a>
					</td>
					<td>
						<form action="index.php" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
							<input type="submit" name="del_sprzet" value="Usuń" />
						</form>
					</td>
				</tr><?php
			}
		}
	?>
	</table><br /><br /><table><tr><td colspan="2">Osoby</td></tr>
	<?php
		if($result=$DB->query('SELECT id,imie,nazwisko FROM Osoba ORDER BY nazwisko')){
			while($row=$result->fetch(PDO::FETCH_ASSOC)){
				?>
				<tr>
					<td>
						<a href="view_osoba.php?id=<?php echo $row['id']; ?>"><?php echo $row['imie'].' '.$row['nazwisko']; ?></a>
					</td>
					<td>
						<form action="index.php" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
							<input type="submit" name="del_osoba" value="Usuń" />
						</form>
					</td>
				</tr><?php
			}
		}
	?>
	</table><br /><br /><table><tr><td colspan="2">Tagi</td></tr>
	<?php
		if($result=$DB->query('SELECT * FROM Tag ORDER BY nazwa')){
			while($row=$result->fetch(PDO::FETCH_ASSOC)){
				?>
				<tr>
					<td>
						<a href="view_tag.php?id=<?php echo $row['id']; ?>"><?php echo $row['nazwa']; ?></a>
					</td>
					<td>
						<form action="index.php" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
							<input type="submit" name="del_tag" value="Usuń" />
						</form>
					</td>
				</tr><?php
			}
		}
	?>
	</table><br /><br /><table><tr><td colspan="2">Projekty</td></tr>
	<?php
		if($result=$DB->query('SELECT id,nazwa FROM Projekt ORDER BY nazwa')){
			while($row=$result->fetch(PDO::FETCH_ASSOC)){
				?>
				<tr>
					<td>
						<a href="view_projekt.php?id=<?php echo $row['id']; ?>"><?php echo $row['nazwa']; ?></a>
					</td>
					<td>
						<form action="index.php" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
							<input type="submit" name="del_projekt" value="Usuń" />
						</form>
					</td>
				</tr><?php
			}
		}
	?>
	</table><br /><br /><table><tr><td colspan="2">Laboratoria</td></tr>
	<?php
		if($result=$DB->query('SELECT id,nazwa FROM Laboratorium ORDER BY nazwa')){
			while($row=$result->fetch(PDO::FETCH_ASSOC)){
				?><tr>
					<td>
						<a href="view_lab.php?id=<?php echo $row['id']; ?>"><?php echo $row['nazwa']; ?></a>
					</td>
					<td>
						<form action="index.php" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
							<input type="submit" name="del_lab" value="Usuń" />
						</form>
					</td>
				</tr><?php
			}
		}
	?>
	</table><br /><br /><table><tr><td colspan="2">Zespoły</td></tr>
	<?php
		if($result=$DB->query('SELECT * FROM Zespol ORDER BY nazwa')){
			while($row=$result->fetch(PDO::FETCH_ASSOC)){
				?><tr>
					<td>
						<a href="view_zespol.php?id=<?php echo $row['id']; ?>"><?php echo $row['nazwa']; ?></a>
					</td>
					<td>
						<form action="index.php" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
							<input type="submit" name="del_zespol" value="Usuń" />
						</form>
					</td>
				</tr><?php
			}
		}
	?>
	</table><br /><br /><table><tr><td colspan="2">Zakłady</td></tr>
	<?php
		if($result=$DB->query('SELECT * FROM Zaklad ORDER BY nazwa')){
			while($row=$result->fetch(PDO::FETCH_ASSOC)){
				?><tr>
					<td>
						<a href="view_zaklad.php?id=<?php echo $row['id']; ?>"><?php echo $row['nazwa']; ?></a>
					</td>
					<td>
						<form action="index.php" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
							<input type="submit" name="del_zaklad" value="Usuń" />
						</form>
					</td>
				</tr><?php
			}
		}
	?>
	</table><br /><br /><table><tr><td colspan="2">Zdjęcia</td></tr>
	<?php
		if($result=$DB->query('SELECT id,link FROM Zdjecie ORDER BY link')){
			while($row=$result->fetch(PDO::FETCH_ASSOC)){
				?><tr>
					<td>
						<a href="view_zdjecie.php?id=<?php echo $row['id']; ?>"><img src="uploads/<?php echo $row['link']; ?>" width="200" alt="" /></a>
					</td>
					<td>
						<form action="index.php" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
							<input type="submit" name="del_zdjecie" value="Usuń" />
						</form>
					</td>
				</tr><?php
			}
		}
	?>
</table>
<?php
	}
	else {
		echo '<br />Nie jesteś zalogowany.<br />
		<a href="login.php">Zaloguj się</a><br /><br /> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
	}
	bottom();
?>
