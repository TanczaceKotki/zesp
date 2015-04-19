<?php
	session_start();
	require_once 'user.class.php';
	require 'common.php';
	require 'DB.php';
	top();
	
	if (user::isLogged()) {
		$user = user::getData('', '');
	
		$DB=dbconnect();
		if(isset($_POST['submitted'])){
			if($st=$DB->prepare('INSERT INTO Kontakt VALUES(?,?)')){
				if($st->execute(array($_POST['sprzet'],$_POST['osoba']))){
					echo 'Informacja kontaktowa została pomyślnie wstawiona.<br /><br />';
				}
				else{
					echo 'Nastąpił błąd przy dodawaniu informacji kontaktowej: '.implode(' ',$st->errorInfo()).'<br /><br />';
				}
			}
			else{
				echo 'Nastąpił błąd przy dodawaniu informacji kontaktowej: '.implode(' ',$DB->errorInfo()).'<br /><br />';
			}
		}
		else{
?>
	<form action="add_kontakt.php" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
		<div>
			<label for="sprzet">Sprzęt: </label>
			<select name="sprzet" id="sprzet" required>
				<option value="" selected>-</option>
				<?php
					if($result=$DB->query("SELECT id,nazwa FROM Sprzet ORDER BY nazwa")){
						while($row=$result->fetch(PDO::FETCH_ASSOC)){
							echo '<option value="'.$row['id'].'">'.$row['nazwa'].'</option>';
						}
					}
				?>
			</select>
		</div>
		<div>
			<label for="osoba">Osoba: </label>
			<select name="osoba" id="osoba" required>
				<option value="" selected>-</option>
				<?php
					if($result=$DB->query("SELECT id,imie,nazwisko FROM Osoba ORDER BY nazwisko")){
						while($row=$result->fetch(PDO::FETCH_ASSOC)){
							echo '<option value="'.$row['id'].'">'.$row['imie'].' '.$row['nazwisko'].'</option>';
						}
					}
				?>
			</select>
		</div>
		<div>
			<input type="submit" name="submitted" value="Prześlij" />
		</div>
	</form>
<?php
		}
	}
	else {
		echo '<br>Nie jesteś zalogowany.<br />
		<a href="login.php">Zaloguj się</a><br><br> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
	}
	bottom();
?>
