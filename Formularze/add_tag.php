<?php
	$displayform=True;
	if(user::isLogged()){
		if(isset($_POST['submitted'])){
			require 'walidacja_danych_php/walidacja.php';
			$walidacja = true;
			if( valid_length($_POST['nazwa'], 32) == false ){
				$walidacja = false;
				echo 'Błędne dane w polu nazwa.<br />';
			}
			if($walidacja and $st=$DB->prepare('INSERT INTO Tag VALUES(NULL,?)')){
				if($st->execute(array($_POST['nazwa']))){
					echo 'Słowo kluczowe zostało pomyślnie wstawione.<br /><br /><a href="index.php">Wróć do strony głównej.</a>';
					$displayform=False;
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
<form action="index.php?menu=33" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded" onsubmit="return ajax_check()">
	<div>
		<label for="nazwa">Słowo kluczowe<span class="color_red">*</span>: </label>
		<input class="form-control" type="text" name="nazwa" id="nazwa" value="<?php if(isset($_POST['nazwa'])) echo $_POST['nazwa']; ?>" size="32" maxlength="32" spellcheck="true" onchange="check_tag()" required="required" />
		<span id="nazwa_counter"></span>
	</div>
	<div><br />
		<input class="btn btn-warning" type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<span class="color_red">*</span> - wymagane pola.
<?php
			foreach(array('js/ask_db.js','js/remaining_char_counter.js','js/check_tag.js','js/tag_form.js') as $script){
				echo '<script src="'.$script.'" type="text/javascript"></script>';
			}
		}
	}
	else{
		echo '<br />Nie jesteś zalogowany.<br />
		<a href="login.php">Zaloguj się</a><br /><br /> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
	}
?>
