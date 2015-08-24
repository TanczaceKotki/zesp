<?php
	$displayform=True;
	if(user::isLogged()){
		if($lvl<2){
			breadcrumbs('Nowa osoba kontakowa',array('index.php?menu=100' => 'Zarządzanie osobami kontaktowymi'));
			echo '<h1 class="font20">Nowa osoba kontakowa</h1>';
			if(isset($_POST['submitted'])){
				require 'walidacja_danych_php/walidacja.php';
				require 'send_email.php';
				$walidacja=true;
				$err_msg='<section><h2 class="font17">W przesłanych danych wystąpiły następujące błędy:</h2><ul class="error_list">';
				if( valid_length($_POST['imie'], 16) == false ){
					$walidacja = false;
					$err_msg.='<li>Błędne dane w polu imię.</li>';
				}
				if( valid_length($_POST['nazwisko'], 32) == false ){
					$walidacja = false;
					$err_msg.='<li>Błędne dane w polu nazwisko.</li>';
				}
				if( valid_email($_POST['email'], 254) == false ){
					$walidacja = false;
					$err_msg.='<li>Błędne dane w polu email.</li>';
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
									echo '<p>Osoba została pomyślnie wstawiona. Login i hasło zostały wysłane do niej poprzez pocztę elektroniczną.</p><p><a href="index.php?menu=100">Wróć do strony zarządzania osobami kontaktowymi.</a></p>';
									wyslij_wiadomosc_z_haslem( $login, $pass );
									$displayform=False;
								}
								else echo '<p>Nastąpił błąd przy dodawaniu osoby: '.implode(' ',$st->errorInfo()).'</p>';
							}
							else echo '<p>Nastąpił błąd przy dodawaniu osoby: '.implode(' ',$DB->errorInfo()).'</p>';
						}
						else echo '<p>Nastąpił błąd przy dodawaniu osoby: '.implode(' ',$st->errorInfo()).'</p>';
					}
					else echo '<p>Nastąpił błąd przy dodawaniu osoby: '.implode(' ',$DB->errorInfo()).'</p>';
				}
				else echo "$err_msg</ul></section>";
			}
			if($displayform){
?>
<form action="index.php?menu=23" method="post" accept-charset="utf-8" enctype="application/x-www-form-urlencoded" onsubmit="return ajax_check()">
	<label for="imie">Imię<span class="color_red">*</span>:</label>
	<input class="form-control" type="text" name="imie" id="imie" value="<?php if(isset($_POST['imie'])) echo $_POST['imie']; ?>" size="16" maxlength="16" required="required" />
	<div id="imie_counter"></div>
	<div class="margin_top_10">
		<label for="nazwisko">Nazwisko<span class="color_red">*</span>:</label>
		<input class="form-control" type="text" name="nazwisko" id="nazwisko" value="<?php if(isset($_POST['nazwisko'])) echo $_POST['nazwisko']; ?>" size="32" maxlength="32" required="required" />
		<div id="nazwisko_counter"></div>
	</div>
	<div class="margin_top_10">
		<label for="email">Adres e-mail<span class="color_red">*</span>:</label>
		<input class="form-control" type="email" name="email" id="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" size="100" maxlength="254" onchange="check_email()" required="required" />
		<div id="email_counter"></div>
	</div>
	<div class="margin_top_10">
		<input class="btn btn-warning" type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<p class="margin_top_10"><span class="color_red">*</span> - wymagane pola.</p>
<?php
				foreach(array('js/ask_db.js','js/remaining_char_counter.js','js/check_email.js','js/osoba_form.js') as $script){
					echo '<script src="'.$script.'" type="text/javascript"></script>';
				}
			}
		}
		else require 'mod_cred_req.php';
	}
	else require 'not_logged_in.php';
?>
