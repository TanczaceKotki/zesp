<?php
	if(user::isLogged()){
		if($lvl===0){
			breadcrumbs('Zarejestruj nowego użytkownika',array('index.php?menu=13' => 'Zarządzanie użytkownikami'));
			echo '<h1 class="font20">Zarejestruj nowego użytkownika</h1>';
			$displayform=True;
			if(isset($_POST['send'])){
				// Zabezpiecz dane z formularza przed kodem HTML i ewentualnymi atakami SQL Injection
				if(!isset($_POST['login']) || !isset($_POST['pass']) || !isset($_POST['pass_v'])) echo '<p>Musisz wypełnić wszystkie pola</p>';
				else{
					$login = $_POST['login'];
					$pass = $_POST['pass'];
					$pass_v = $_POST['pass_v'];
					$new_lvl = $_POST['lvl']; // Poziom uprawnień uzytkownika. 0 - administrator, 1 - moderator, 2 - konto osoby kontaktowej - Mateusz
					$errors = ''; // Zmienna przechowująca listę błędów które wystąpiły
					// Sprawdź, czy nie wystąpiły błędy
					require 'walidacja_danych_php/walidacja.php';
					require 'send_email.php';
					if(!$login || !$pass || !$pass_v) $errors .= '<li>Musisz wypełnić wszystkie pola.</li>';
					if($new_lvl==='2') {
						if( valid_email($login, 254) == false ){
							$errors .= '<li>Podaj poprawny adres email osoby kontaktowej.</li>';
						}
					}
					if($st=$DB->prepare('SELECT login FROM Uzytkownicy WHERE login=?')){
						if($st->execute(array($login))){
							if($row=$st->fetch(PDO::FETCH_ASSOC)){
								$errors .= '<li>Ten login jest zajęty.</li>';
							}
						}
					}
					if ($pass !== $pass_v)  $errors .= '<li>Hasła się nie zgadzają</li>';

					/**
					* Jeśli wystąpiły jakieś błędy, to je pokaż
					*/
					if ($errors !== ''){
						echo "<section><h2 class=\"font17\">Rejestracja nie powiodła się, popraw następujące błędy:</h2><ul class=\"error_list\">$errors</ul></section>";
					}
					else{
						$pass = password_hash($pass, PASSWORD_DEFAULT);
						if($st=$DB->prepare('INSERT INTO Uzytkownicy VALUES(NULL,?,?,?)')){
							if($st->execute(array($login,$pass,$new_lvl))){
								if($new_lvl==='2'){
									if($st=$DB->prepare('INSERT INTO Osoba VALUES(NULL,?,?,?)')){
										if($st->execute(array($_POST['imie'],$_POST['nazwisko'],$login))){
											echo '<p>Użytkownik został pomyślnie wstawiony.</p><p><a href="index.php?menu=13">Wróć do strony zarządzania użytkownikami</a>.</p>';
											wyslij_wiadomosc_z_haslem( $login, $pass );
											$displayform=false;
											
										}
										else echo '<p>Nastąpił błąd przy dodawaniu użytkownika: '.implode(' ',$st->errorInfo()).'</p>';
									}
									else echo '<p>Nastąpił błąd przy dodawaniu użytkownika: '.implode(' ',$DB->errorInfo()).'</p>';
								}
								else{
									echo '<p>Użytkownik został pomyślnie wstawiony.</p><p><a href="index.php?menu=13">Wróć do strony zarządzania użytkownikami</a>.</p>';
									$displayform=false;
								}
							}
							else echo '<p>Nastąpił błąd przy dodawaniu użytkownika: '.implode(' ',$st->errorInfo()).'</p>';
						}
						else echo '<p>Nastąpił błąd przy dodawaniu użytkownika: '.implode(' ',$DB->errorInfo()).'</p>';
					}
				}
			}
			if($displayform){
?>
<form action="index.php?menu=14" id="register_form" method="post" accept-charset="utf-8" enctype="application/x-www-form-urlencoded" onsubmit="return ajax_check()">
	<label for="login" id="login_label">Login<span class="color_red">*</span>:</label>
	<input class="form-control" type="text" name="login" id="login" value="<?php if(isset($_POST['login'])) echo $_POST['login']; ?>" maxlength="254" required="required" onchange="check_login()" />
	<div id="login_counter"></div>
	<div class="margin_top_10">
		<label for="pass">Hasło<span class="color_red">*</span>:</label>
		<input class="form-control" type="password" name="pass" id="pass" value="" maxlength="512" required="required" onchange="compare_pass()" />
		<div id="pass_counter"></div>
	</div>
	<div class="margin_top_10">
		<label for="pass_v">Powtórz Hasło<span class="color_red">*</span>:</label>
		<input class="form-control" type="password" name="pass_v" id="pass_v" value="" maxlength="512" required="required" onchange="compare_pass()" />
		<div id="pass_v_counter"></div>
	</div>
	<fieldset class="margin_top_10">
		<legend class="group_label font15">Poziom uprawnień<span class="color_red">*</span></legend>
		<label><input type="radio" name="lvl" id="admin" value="0" required="required" onchange="not_level_2()" <?php if(isset($_POST['lvl'])){ if($_POST['lvl']==='0') echo 'checked="checked"'; } ?> /> Administrator</label>
		<div class="margin_top_10">
			<label><input type="radio" name="lvl" id="mod" value="1" required="required" onchange="not_level_2()" <?php if(isset($_POST['lvl'])){ if($_POST['lvl']==='1') echo 'checked="checked"'; } else echo 'checked="checked"'; ?> /> Moderator</label>
		</div>
		<div class="margin_top_10">
			<label><input type="radio" name="lvl" id="kont" value="2" required="required" onchange="level_2()" <?php if(isset($_POST['lvl'])){ if($_POST['lvl']==='2') echo 'checked="checked"'; } ?> /> Osoba kontaktowa</label>
		</div>
	</fieldset>
	<fieldset id="kont_inputs" class="margin_top_10">
		<legend class="group_label font15">Dane osoby kontaktowej<span class="color_red">*</span></legend>
		<label for="imie">Imię<span class="color_red">*</span>:</label>
		<input class="form-control" type="text" name="imie" id="imie" value="<?php if(isset($_POST['imie'])) echo $_POST['imie']; ?>" size="16" maxlength="16" />
		<div id="imie_counter"></div>
		<div class="margin_top_10">
			<label for="nazwisko">Nazwisko<span class="color_red">*</span>:</label>
			<input class="form-control" type="text" name="nazwisko" id="nazwisko" value="<?php if(isset($_POST['nazwisko'])) echo $_POST['nazwisko']; ?>" size="32" maxlength="32" />
			<div id="nazwisko_counter"></div>
		</div>
	</fieldset>
	<div class="margin_top_10">
		<input class="btn btn-warning" type="submit" name="send" value="Zarejestruj" />
	</div>
</form>
<p class="margin_top_10"><span class="color_red">*</span> - wymagane pola.</p>
<?php
				foreach(array('js/ask_db.js','js/check_email.js','js/remaining_char_counter.js','js/user_lib.js') as $script) echo '<script src="'.$script.'" type="text/javascript"></script>';
			}
		}
		else require 'admin_cred_req.php';
	}
	else require 'not_logged_in.php';
?>
