<?php
	session_start();
	
	
	if(user::isLogged()){
		$displayform=True;
		if(isset($_POST['send'])){
			// Zabezpiecz dane z formularza przed kodem HTML i ewentualnymi atakami SQL Injection
			if(!isset($_POST['login']) || !isset($_POST['pass']) || !isset($_POST['pass_v'])) echo 'Musisz wypełnić wszystkie pola<br /><br />';
			else{
				$login = $_POST['login'];
				$pass = $_POST['pass'];
				$pass_v = $_POST['pass_v'];
				$lvl = $_POST['lvl']; // Poziom uprawnień uzytkownika. 0 - administrator, 1 - moderator, 2 - konto osoby kontaktowej - Mateusz
				$errors = ''; // Zmienna przechowująca listę błędów które wystąpiły
				// Sprawdź, czy nie wystąpiły błędy
				if(!$login || !$pass || !$pass_v) $errors .= '- Musisz wypełnić wszystkie pola<br /><br />';
				if($lvl == 2) {
					if(!filter_var($login, FILTER_VALIDATE_EMAIL)) $errors .= '- Podaj poprawny email osoby kontaktowej<br /><br />';
				}
				$DB=dbconnect();
				if($st=$DB->prepare('SELECT login FROM Uzytkownicy WHERE login=?')){
					if($st->execute(array($login))){
						if($row=$st->fetch(PDO::FETCH_ASSOC)){
							$errors .= '- Ten login jest zajęty<br /><br />';
						}
					}
				}
				if ($pass !== $pass_v)  $errors .= '- Hasła się nie zgadzają<br /><br />';

				/**
				* Jeśli wystąpiły jakieś błędy, to je pokaż
				*/
				if ($errors !== ''){
					echo 'Rejestracja nie powiodła się, popraw następujące błędy:<br />'.$errors.'';
				}
				else{
					$pass = password_hash($pass, PASSWORD_DEFAULT);
					if($st=$DB->prepare('INSERT INTO Uzytkownicy VALUES(NULL,?,?,?)')){
						if($st->execute(array($login,$pass,$lvl))){
							if($lvl==='2'){
								if($st=$DB->prepare('INSERT INTO Osoba VALUES(NULL,?,?,?)')){
									if($st->execute(array($_POST['imie'],$_POST['nazwisko'],$login))){
										echo 'Użytkownik został pomyślnie wstawiony.<br /><br />';
										echo 'Powrót do <a href="index.php">strony głównej</a>.<br /><br />';
										$displayform=false;
										
									}
									else echo 'Nastąpił błąd przy dodawaniu użytkownika: '.implode(' ',$st->errorInfo()).'<br /><br />';
								}
								else echo 'Nastąpił błąd przy dodawaniu użytkownika: '.implode(' ',$DB->errorInfo()).'<br /><br />';
							}
							else echo 'Użytkownik został pomyślnie wstawiony.<br /><br />';
						}
						else echo 'Nastąpił błąd przy dodawaniu użytkownika: '.implode(' ',$st->errorInfo()).'<br /><br />';
					}
					else echo 'Nastąpił błąd przy dodawaniu użytkownika: '.implode(' ',$DB->errorInfo()).'<br /><br />';
				}
			}
		}
		if($displayform){
?>
<form  action="index.php?menu=14" id="register_form" method="post" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded" onsubmit="return ajax_check()">
	<label for="login" id="login_label">Login<span class="color_red">*</span>:</label>
	<input type="text" name="login" id="login" value="<?php if(isset($_POST['login'])) echo $_POST['login']; ?>" maxlength="254" required="required" onchange="check_login()" />
	<span id="login_counter"></span>
	<br />
	<label for="pass">Hasło<span class="color_red">*</span>:</label>
	<input type="password" name="pass" id="pass" value="" maxlength="512" required="required" onchange="compare_pass()" />
	<span id="pass_counter"></span>
	<br />
	<label for="pass_v">Powtórz Hasło<span class="color_red">*</span>:</label>
	<input type="password" name="pass_v" id="pass_v" value="" maxlength="512" required="required" onchange="compare_pass()" />
	<span id="pass_v_counter"></span>
	<br />
	<fieldset>
		<legend>Poziom uprawnień<span class="color_red">*</span></legend>
		<input type="radio" name="lvl" id="admin" value="0" required="required" onchange="not_level_2()" <?php if(isset($_POST['lvl'])){ if($_POST['lvl']==='0') echo 'checked="checked"'; } ?> />
		<label for="admin">Administrator</label>
		<br />
		<input type="radio" name="lvl" id="mod" value="1" required="required" onchange="not_level_2()" <?php if(isset($_POST['lvl'])){ if($_POST['lvl']==='1') echo 'checked="checked"'; } else echo 'checked="checked"'; ?> />
		<label for="mod">Moderator</label>
		<br />
		<input type="radio" name="lvl" id="kont" value="2" required="required" onchange="level_2()" <?php if(isset($_POST['lvl'])){ if($_POST['lvl']==='2') echo 'checked="checked"'; } ?> />
		<label for="kont">Osoba kontaktowa</label>
	</fieldset>
	<fieldset id="kont_inputs">
		<legend>Dane osoby kontaktowej<span class="color_red">*</span></legend>
		<label for="imie">Imię<span class="color_red">*</span>: </label>
		<input type="text" name="imie" id="imie" value="<?php if(isset($_POST['imie'])) echo $_POST['imie']; ?>" size="16" maxlength="16" />
		<span id="imie_counter"></span>
		<br />
		<label for="nazwisko">Nazwisko<span class="color_red">*</span>: </label>
		<input type="text" name="nazwisko" id="nazwisko" value="<?php if(isset($_POST['nazwisko'])) echo $_POST['nazwisko']; ?>" size="32" maxlength="32" />
		<span id="nazwisko_counter"></span>
	</fieldset>
	<span class="color_red">*</span> - wymagane pola.
	<br /><br />
	<input class="btn btn-warning" type="submit" name="send" value="Zarejestruj" />
</form>
<br />

<?php
			#bottom(array('js/jquery-1.11.3.min.js','js/modernizr.js','js/js-webshim/minified/polyfiller.js','js/default_form.js','js/ask_db.js','js/check_email.js','js/remaining_char_counter.js','js/register.js'));
		}
	}
	else{
		echo '<br />Nie jesteś zalogowany.<br />
		<a href="login.php">Zaloguj się</a><br /><br /> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
		
	}
?>
