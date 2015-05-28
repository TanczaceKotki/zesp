<?php
	session_start();
	require 'user.class.php';
	require 'common.php';
	require 'DB.php';
	top();
	$displayform=True;
	$DB=dbconnect();
	if(user::isLogged()){
		$user = user::getData('', '');
		if(isset($_POST['submitted'])){
			$walidacja = true;
			if( valid_length($_POST['nazwa'], 64) ){
				$walidacja = false;
				echo 'Błędne dane w polu nazwa.<br/>';
			}
			if($walidacja and $st=$DB->prepare('INSERT INTO Laboratorium VALUES(NULL,?,?)')){
				if($st->execute(array($_POST['nazwa'],$_POST['zespol']))){
					echo 'Laboratorium zostało pomyślnie wstawione.<br /><br /><a href="index.php">Wróć do strony głównej.</a>';
					$displayform=False;
					bottom();
				}
				else{
					echo 'Nastąpił błąd przy dodawaniu laboratorium: '.implode(' ',$st->errorInfo()).'<br /><br />';
				}
			}
			else{
				echo 'Nastąpił błąd przy dodawaniu laboratorium: '.implode(' ',$DB->errorInfo()).'<br /><br />';
			}
		}
		if($displayform){
?>
<form action="add_lab.php" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
	<div>
		<label for="nazwa">Nazwa<span class="color_red">*</span>: </label>
		<input type="text" name="nazwa" id="nazwa" value="<?php if(isset($_POST['nazwa'])) echo $_POST['nazwa']; ?>" size="64" maxlength="64" spellcheck="true" required="required" />
		<span id="nazwa_counter"></span>
	</div>
	<div>
		<label for="zespol">Zespół: </label>
		<select name="zespol" id="zespol">
			<option value=""<?php if(!isset($_POST['zespol'])) echo ' selected="selected"'; ?>>-</option>
			<?php
				if($result=$DB->query('SELECT id,nazwa FROM Zespol ORDER BY nazwa')){
					if($rows=$result->fetchAll(PDO::FETCH_ASSOC)){
						$first_letter=$rows[0]['nazwa'][0];
						echo '<optgroup label="'.strtoupper($first_letter).'">';
						foreach($rows as $row){
							if($first_letter!==$row['nazwa'][0]){
								$first_letter=$row['nazwa'][0];
								echo '</optgroup><optgroup label="'.strtoupper($first_letter).'">';
							}
							echo '<option value="'.$row['id'].'"';
							if(isset($_POST['zespol'])){
								if($_POST['zespol']===$row['id']) echo ' selected="selected"';
							}
							echo '>'.$row['nazwa'].'</option>';
						}
						echo '</optgroup>';
					}
				}
			?>
		</select>
	</div>
	<div>
		<input type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<span class="color_red">*</span> - wymagane pola.
<?php
			bottom(array('https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js','js/js-webshim/minified/polyfiller.js','js/remaining_char_counter.js','js/default_form.js'));
		}
	}
	else {
		echo '<br>Nie jesteś zalogowany.<br />
		<a href="login.php">Zaloguj się</a><br><br> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
		bottom();
	}
?>
