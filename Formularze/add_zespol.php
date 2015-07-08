<?php
	session_start();
	require 'walidacja_danych_php/walidacja.php';
	$displayform=True;
	if(user::isLogged()){
		$user = user::getData('', '');
		if(isset($_POST['submitted'])){
			$DB=dbconnect();
			$walidacja = true;
			if( valid_length($_POST['nazwa'], 128) == false ){
				$walidacja = false;
				echo 'Błędne dane w polu nazwa.<br />';
			}
			if($walidacja and $st=$DB->prepare('INSERT INTO Zespol VALUES(NULL,?)')){
				if($st->execute(array($_POST['nazwa']))){
					echo 'Zespół został pomyślnie wstawiony.<br /><br /><a href="index.php?menu=9">Wróć do listy zespołów.</a>';
					$displayform=False;
					
				}
				else{
					echo 'Nastąpił błąd przy dodawaniu zespołu: '.implode(' ',$st->errorInfo()).'<br /><br />';
				}
			}
			else{
				echo 'Nastąpił błąd przy dodawaniu zespołu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
			}
		}
		if($displayform){
?>
  <ol class="breadcrumb">
  <li><a href="index.php">Start</a></li>
  <li><a href="index.php?menu=9">Zarządzaj zespołami</a></li>
    <li class="active">Dodaj zespół</li>
</ol>
<form action="index.php?menu=30" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
	<div>
		<label for="nazwa">Nazwa:<span class="color_red">*</span>: </label>
		<input class="form-control" type="text" name="nazwa" id="nazwa" value="<?php if(isset($_POST['nazwa'])) echo $_POST['nazwa']; ?>" size="100" maxlength="128" spellcheck="true" required="required" />
		<span id="nazwa_counter"></span>
	</div>
	<div><br>
		<input type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<span class="color_red">*</span> - wymagane pola.
<?php
			foreach(array('js/jquery-1.11.3.min.js','js/modernizr.js','js/js-webshim/minified/polyfiller.js','js/default_form.js','js/remaining_char_counter.js') as $script){
				echo '<script src="'.$script.'" type="text/javascript"></script>';
			}
		}
	}
	else{
		echo '<br />Nie jesteś zalogowany.<br />
		<a href="login.php">Zaloguj się</a><br /><br /> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
		
	}
?>
