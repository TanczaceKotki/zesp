<?php
	session_start();
	require_once 'user.class.php';
	require 'common.php';
	require 'DB.php';
	top();
	
	if (user::isLogged()) {
		$user = user::getData('', '');
		if(isset($_POST['submitted'])){
			if($st=$DB->prepare('INSERT INTO Laboratorium VALUES(NULL,?,?)')){
				if($st->execute(array($_POST['nazwa'],$_POST['zespol']))){
					echo 'Laboratorium zostało pomyślnie wstawione.<br /><br />';
				}
				else{
					echo 'Nastąpił błąd przy dodawaniu laboratorium: '.implode(' ',$st->errorInfo()).'<br /><br />';
				}
			}
			else{
				echo 'Nastąpił błąd przy dodawaniu laboratorium: '.implode(' ',$DB->errorInfo()).'<br /><br />';
			}
		}
	else{
?>
	<form action="add_laboratorium.php" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
		<div>
			<label for="nazwa">Nazwa: </label>
			<input type="text" name="nazwa" id="nazwa" value="" size="16" maxlength="16" required />
		</div>
		<div>
			<label for="zespol">Zespół: </label>
			<select name="zespol" id="zespol" required>
				<option value="" selected>-</option>
				<?php
					if($result=$DB->query("SELECT id,nazwa FROM Zespol ORDER BY nazwa")){
						while($row=$result->fetch(PDO::FETCH_ASSOC)){
							echo '<option value="'.$row['id'].'">'.$row['nazwa'].'</option>';
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
