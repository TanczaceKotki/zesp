<ol class="breadcrumb">
  <li><a href="index.php">Start</a></li>
    <li><a href="index.php?menu=66">Zarządzanie zakładami</a></li>
    <li class="active">Dodaj zakład</li>
</ol>
<?php
	$displayform=True;
	if(user::isLogged()){
		if(isset($_POST['submitted'])){
			require 'walidacja_danych_php/walidacja.php';
			$walidacja = true;
			if( valid_length($_POST['nazwa'], 64) == false ){
				$walidacja = false;
				echo 'Błędne dane w polu nazwa.<br />';
			}
			if($walidacja and $st=$DB->prepare('INSERT INTO Zaklad VALUES(NULL,?)')){
				if($st->execute(array($_POST['nazwa']))){
					echo 'Zakład został pomyślnie wstawiony.<br /><br /><a href="index.php?menu=66">Wróć do strony zarządzania zakładami</a>';
					$displayform=False;
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
<form action="index.php?menu=28" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
	<div>
		<label for="nazwa">Nazwa<span class="color_red">*</span>: </label>
		<input type="text" name="nazwa" id="nazwa" value="<?php if(isset($_POST['nazwa'])) echo $_POST['nazwa']; ?>" size="64" maxlength="64" spellcheck="true" required="required" />
		<span id="nazwa_counter"></span>
	</div>
	<div><br />
		<input class="btn btn-warning" type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<span class="color_red">*</span> - wymagane pola.
<?php
			foreach(array('js/remaining_char_counter.js') as $script){
				echo '<script src="'.$script.'" type="text/javascript"></script>';
			}
		}
	}
	else{
		echo '<br />Nie jesteś zalogowany.<br />
		<a href="login.php">Zaloguj się</a><br /><br /> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
		bottom();
	}
?>
