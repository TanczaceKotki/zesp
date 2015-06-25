<?php
	session_start();
	require_once 'user.class.php';
	top();
	$DB=dbconnect();
	if (user::isLogged()) {
		$user = user::getData('', '');
		if(isset($_POST['del_osoba'])){
			if($st=$DB->prepare('SELECT email FROM Osoba WHERE id=?')){
				if($st->execute(array($_POST['id']))){
					if($row=$st->fetch(PDO::FETCH_ASSOC)){
						if($st=$DB->prepare('DELETE FROM Uzytkownicy WHERE login=?')){
							if($st->execute(array($row['email']))) echo 'Osoba została usunięta.<br /><br />';
							else echo 'Nastąpił błąd przy usuwaniu osoby: '.implode(' ',$st->errorInfo()).'<br /><br />';
						}
					}
				}
			}
		}
?>

<a href="add_osoba.php">Dodaj osoba</a><br />

	<table><tr><td colspan="2">Osoby</td></tr>
	<?php
		if($result=$DB->query('SELECT id,imie,nazwisko FROM Osoba ORDER BY nazwisko')){
			while($row=$result->fetch(PDO::FETCH_ASSOC)){
				?>
				<tr>
					<td>
						<a href="view_osoba.php?id=<?php echo $row['id']; ?>"><?php echo $row['imie'].' '.$row['nazwisko']; ?></a>
					</td>
					<td>
						<form action="index.php?menu=100" method="post" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
							<input type="submit" name="del_osoba" value="Usuń" />
						</form>
					</td>
				</tr><?php
			}
		}
	?>
	</table><br /><br />
<?php
	}
	else {
		echo '<br />Nie jesteś zalogowany.<br />
		<a href="login.php">Zaloguj się</a><br /><br /> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
	}
	bottom();
?>
