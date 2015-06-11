<?php
	session_start();
	require 'user.class.php';
	require 'common.php';
	require 'DB.php';
	require 'walidacja_danych_php/walidacja.php';
	require 'send_email.php';

	top();
	$displayform=True;
	if(user::isLogged()){
		$user = user::getData('', '');
		if(isset($_POST['submitted'])){
			$DB=dbconnect();
			$walidacja = true;
			if( valid_length($_POST['imie'], 16) == false ){
				$walidacja = false;
				echo 'Błędne dane w polu imię.<br/>';
			}
			if( valid_length($_POST['nazwisko'], 32) == false ){
				$walidacja = false;
				echo 'Błędne dane w polu nazwisko.<br/>';
			}
			if( valid_email($_POST['email'], 254) == false ){
				$walidacja = false;
				echo 'Błędne dane w polu email.<br/>';
			}
			if($walidacja and $st=$DB->prepare('INSERT INTO Osoba VALUES(NULL,?,?,?)')){
				if($st->execute(array($_POST['imie'],$_POST['nazwisko'],$_POST['email']))){
					echo 'Osoba została pomyślnie wstawiona. Login i hasło zostały wysłane do niej poprzez pocztę elektroniczną.<br /><br /><a href="index.php">Wróć do strony głównej.</a>';
					$displayform=False;
					bottom();
				}
				else{
					echo 'Nastąpił błąd1 przy dodawaniu osoby: '.implode(' ',$st->errorInfo()).'<br /><br />';
				}
			}
			else{
				echo 'Nastąpił błąd2 przy dodawaniu osoby: '.implode(' ',$DB->errorInfo()).'<br /><br />';
			}

			$pass = generuj_haslo();
			$pass_hash = password_hash($pass, PASSWORD_DEFAULT);
			$login = $_POST['email'];
			$lvl = 2;
			if($st=$DB->prepare('INSERT INTO Uzytkownicy VALUES(NULL,?,?,?)')){
				if($st->execute(array($login,$pass_hash,$lvl))){
					wyslij_wiadomosc_z_haslem( $login, $pass );
					$displayform=False;
					bottom();
				}
				else{
					echo 'Nastąpił błąd przy dodawaniu użytkownika: '.implode(' ',$st->errorInfo()).'<br /><br />';
				}
			}
			else{
				echo 'Nastąpił błąd przy dodawaniu użytkownika: '.implode(' ',$DB->errorInfo()).'<br /><br />';
			}

		}
		if($displayform){
?>
<form action="add_osoba.php" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded" onsubmit="return ajax_check()">
	<div>
		<label for="imie">Imię<span class="color_red">*</span>: </label>
		<input type="text" name="imie" id="imie" value="<?php if(isset($_POST['imie'])) echo $_POST['opis']; ?>" size="16" maxlength="16" required="required" />
		<span id="imie_counter"></span>
	</div>
	<div>
		<label for="nazwisko">Nazwisko<span class="color_red">*</span>: </label>
		<input type="text" name="nazwisko" id="nazwisko" value="<?php if(isset($_POST['nazwisko'])) echo $_POST['opis']; ?>" size="32" maxlength="32" required="required" />
		<span id="nazwisko_counter"></span>
	</div>
	<div>
		<label for="email">Adres e-mail<span class="color_red">*</span>: </label>
		<input type="email" name="email" id="email" value="<?php if(isset($_POST['email'])) echo $_POST['opis']; ?>" size="100" maxlength="254" onchange="check_email()" required="required" />
		<span id="email_counter"></span>
		<div id="email_error"></div>
	</div>
	<div>
		<input type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<span class="color_red">*</span> - wymagane pola.
<?php
			bottom(array('https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js','js/js-webshim/minified/polyfiller.js','js/ask_db.js','js/remaining_char_counter.js','js/osoba_form.js'));
		}
	}
	else {
		echo '<br>Nie jesteś zalogowany.<br />
		<a href="login.php">Zaloguj się</a><br><br> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
		bottom();
	}
?>
