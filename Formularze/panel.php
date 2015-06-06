<?php
	session_start();
	require_once 'user.class.php';
	require 'common.php';
	require 'DB.php';
	top();
	$DB=dbconnect();
?>

	<table><tr>
	<td colspan="2">Użytkownik</td>
	<td colspan="2">Poziom uprawnień</td>
	<td colspan="2">Akcja</td>
	</tr>
	<?php
	if (user::isLogged()) {
		if($result=$DB->query('SELECT id, login, lvl FROM Uzytkownicy')){
		
			echo '<h1>Jesteś zalogowany jako: '.$_SESSION['login'].'</h1>';
		
			while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			?>
				<tr>
					<td colspan="2">
						<?php echo $row['login']; ?>
					</td>
					<td colspan="2">
						<?php 
							if($row['lvl'] == 0) echo "Administrator";
							elseif($row['lvl'] == 1) echo "Moderator";
							elseif($row['lvl'] == 2) echo "Osoba kontaktowa"; 
						?>
					</td>
					<td>
						<form action="view_user.php" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
							<input type="submit" value="Pokaż" />
						</form>
						<form action="panel.php" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
							<input type="submit" name="del_uzytkownika" value="Usuń" />
						</form>
					</td>
				</tr><?php
			}
			
			if(isset($_POST['del_uzytkownika'])){
				if($st=$DB->prepare('DELETE FROM Uzytkownicy WHERE id=?')){
					if($st->execute(array($_POST['id']))){ 
						echo 'Użytkownik został usunięty.<br />';
						echo '<a href="panel.php">Odśwież panel</a><br /><br />';
					}
					else echo 'Nastąpił błąd przy usuwaniu użytkownika: '.implode(' ',$st->errorInfo()).'<br /><br />';
				}
				else echo 'Nastąpił błąd przy usuwaniu użytkownika: '.implode(' ',$DB->errorInfo()).'<br /><br />';
			}
		}
		?></table><?php
		echo '<br><a href="rejestracja.php">Rejestracja nowego użytkownika</a><br>';
		echo '<a href="index.php">Powrót do strony głównej</a><br><br><br>';
	}
	else {
		echo '<br>Nie jesteś zalogowany.<br />
		<a href="login.php">Zaloguj się</a><br><br> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
	}
	bottom();
?>
