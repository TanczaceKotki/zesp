<?php
	session_start();
	require 'user.class.php';
	require 'common.php';
	require 'DB.php';
	top();
	$displayform=True;
	if(user::isLogged()){
		$user = user::getData('', '');
		if(isset($_POST['submitted'])){
			$DB=dbconnect();
			if($st=$DB->prepare('INSERT INTO Zaklad VALUES(NULL,?)')){
				if($st->execute(array($_POST['nazwa']))){
					echo 'Zakład został pomyślnie wstawiony.<br /><br /><a href="index.php">Wróć do strony głównej.</a>';
					$displayform=False;
					bottom();
				}
				else{
					echo 'Nastąpił błąd przy dodawaniu zakładu: '.implode(' ',$st->errorInfo()).'<br /><br />';
				}
			}
			else{
				echo 'Nastąpił błąd przy dodawaniu zakładu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
			}
		}
		if($displayform){
?>
<form action="add_zaklad.php" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
	<div>
		<label for="nazwa">Nazwa<span class="color_red">*</span>: </label>
		<input type="text" name="nazwa" id="nazwa" value="<?php if(isset($_POST['nazwa'])) echo $_POST['nazwa']; ?>" size="64" maxlength="64" spellcheck="true" required="required" />
		<span id="nazwa_counter"></span>
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
