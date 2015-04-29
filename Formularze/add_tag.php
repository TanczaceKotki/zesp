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
			if($st=$DB->prepare('INSERT INTO Tag VALUES(NULL,?)')){
				if($st->execute(array($_POST['nazwa']))){
					echo 'Tag został pomyślnie wstawiony.<br /><br /><a href="index.php">Wróć do strony głównej.</a>';
					$displayform=False;
					bottom();
				}
				else{
					echo 'Nastąpił błąd przy dodawaniu tagu: '.implode(' ',$st->errorInfo()).'<br /><br />';
				}
			}
			else{
				echo 'Nastąpił błąd przy dodawaniu tagu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
			}
		}
		if($displayform){
?>
<form action="add_tag.php" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded" onsubmit="return ajax_check()">
	<div>
		<label for="nazwa">Nazwa<span class="color_red">*</span>: </label>
		<input type="text" name="nazwa" id="nazwa" value="<?php if(isset($_POST['nazwa'])) echo $_POST['nazwa']; ?>" size="32" maxlength="32" spellcheck="true" onchange="check_tag()" required="required" />
		<span id="nazwa_counter"></span>
		<div id="tag_error"></div>
	</div>
	<div>
		<input type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<span class="color_red">*</span> - wymagane pola.
<?php
			bottom(array('https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js','js/js-webshim/minified/polyfiller.js','js/ask_db.js','js/remaining_char_counter.js','js/tag_form.js'));
		}
	}
	else {
		echo '<br>Nie jesteś zalogowany.<br />
		<a href="login.php">Zaloguj się</a><br><br> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
		bottom();
	}
?>
