<?php
	session_start();
	require 'walidacja_danych_php/walidacja.php';
	require 'send_email.php';
	$displayform=True;
	if(user::isLogged()){
		$user = user::getData('', '');
		if(isset($_POST['submitted'])){
			$DB=dbconnect();
			$walidacja = true;
			if( valid_length($_POST['imie'], 16) == false ){
				$walidacja = false;
				echo 'Błędne dane w polu imię.<br />';
			}
			if( valid_length($_POST['nazwisko'], 32) == false ){
				$walidacja = false;
				echo 'Błędne dane w polu nazwisko.<br />';
			}
			if( valid_email($_POST['email'], 254) == false ){
				$walidacja = false;
				echo 'Błędne dane w polu email.<br />';
			}
			if($walidacja){
				$pass = generuj_haslo();
				$pass_hash = password_hash($pass, PASSWORD_DEFAULT);
				$login = $_POST['email'];
				$lvl = 2;
				if($st=$DB->prepare('INSERT INTO Uzytkownicy VALUES(NULL,?,?,?)')){
					if($st->execute(array($login,$pass_hash,$lvl))){
						if($st=$DB->prepare('INSERT INTO Osoba VALUES(NULL,?,?,?)')){
							if($st->execute(array($_POST['imie'],$_POST['nazwisko'],$_POST['email']))){
								echo 'Osoba została pomyślnie wstawiona. Login i hasło zostały wysłane do niej poprzez pocztę elektroniczną.<br /><br /><a href="index.php?menu=100">Wróć do listy użytkowników.</a>';
								wyslij_wiadomosc_z_haslem( $login, $pass );
								$displayform=False;
															}
							else{
								echo 'Nastąpił błąd1 przy dodawaniu osoby: '.implode(' ',$st->errorInfo()).'<br /><br />';
							}
						}
						else{
							echo 'Nastąpił błąd2 przy dodawaniu osoby: '.implode(' ',$DB->errorInfo()).'<br /><br />';
						}
					}
					else{
						echo 'Nastąpił błąd1 przy dodawaniu osoby: '.implode(' ',$st->errorInfo()).'<br /><br />';
					}
				}
				else{
					echo 'Nastąpił błąd2 przy dodawaniu osoby: '.implode(' ',$DB->errorInfo()).'<br /><br />';
				}
			}
		}
		if($displayform){
?>
  <ol class="breadcrumb">
  <li><a href="index.php">Start</a></li>
  <li><a href="index.php?menu=100">Zarządzaj użytkownikami</a></li>
    <li class="active">Dodaj użytkownika</li>
</ol>
<form action="index.php?menu=23" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded" onsubmit="return ajax_check()">
	<div><br>
		<label for="imie">Imię:<span class="color_red">*</span>: </label>
		<input class="form-control" type="text" name="imie" id="imie" value="<?php if(isset($_POST['imie'])) echo $_POST['imie']; ?>" size="16" maxlength="16" required="required" />
		<span id="imie_counter"></span>
	</div>
	<div><br>
		<label for="nazwisko">Nazwisko:<span class="color_red">*</span>: </label>
		<input class="form-control" type="text" name="nazwisko" id="nazwisko" value="<?php if(isset($_POST['nazwisko'])) echo $_POST['nazwisko']; ?>" size="32" maxlength="32" required="required" />
		<span id="nazwisko_counter"></span>
	</div>
	<div><br>
		<label for="email">Adres e-mail:<span class="color_red">*</span>: </label>
		<input class="form-control" type="email" name="email" id="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" size="100" maxlength="254" onchange="check_email()" required="required" />
		<span id="email_counter"></span>
	</div>
	<div><br>
		<input class="btn btn-warning" type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<span class="color_red">*</span> - wymagane pola.
<?php
			foreach(array('js/ask_db.js','js/remaining_char_counter.js','js/check_email.js','js/osoba_form.js') as $script){
				echo '<script src="'.$script.'" type="text/javascript"></script>';
			}
		}
	}
	else{
		echo '<br />Nie jesteś zalogowany.<br />
		<a href="login.php">Zaloguj się</a><br /><br /> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
			}
?>
