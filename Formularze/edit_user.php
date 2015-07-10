<?php
	if(user::isLogged()){
		if($st=$DB->prepare('SELECT lvl FROM Uzytkownicy WHERE login=?'))
		if($st->execute(array($_SESSION['login'])))
		if($row=$st->fetch(PDO::FETCH_ASSOC)){
			if($row['lvl']==='0'){
				if(isset($_POST['id'])){
					if($st=$DB->prepare('SELECT id,login,lvl FROM Uzytkownicy WHERE id=?')){
						if($st->execute(array($_POST['id']))){
							if($row=$st->fetch(PDO::FETCH_ASSOC)){
?>
<ol class="breadcrumb">
	<li><a href="index.php">Start</a></li>
	<li><a href="index.php?menu=13">Zarządzanie użytkownikami</a></li>
	<li class="active">Edytuj użytkownika</li>
</ol>
<form action="index.php?menu=118&amp;id=<?php echo $row['id']; ?>" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
	<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
	<input type="hidden" name="old_login" id="old_login" value="<?php echo $row['login']; ?>" />
	<input type="hidden" name="old_lvl" value="<?php echo $row['lvl']; ?>" />
	<?php
		if($row['lvl']==='2'){
			if($st2=$DB->prepare('SELECT imie,nazwisko FROM Osoba WHERE email=?')){
				if($st2->execute(array($row['login']))){
					$row2=$st2->fetch(PDO::FETCH_ASSOC);
					?>
					<input type="hidden" name="old_imie" value="<?php echo $row2['imie']; ?>" />
					<input type="hidden" name="old_nazwisko" value="<?php echo $row2['nazwisko']; ?>" />
					<?php
				}
			}
		}
	?>
	<div>
		<label for="login" id="login_label">Login<span class="color_red">*</span>: </label>
		<input type="text" name="login" id="login" value="<?php echo $row['login']; ?>" size="100" maxlength="254" required="required" onchange="check_login_edit()" />
		<span id="login_counter"></span>
	</div>
	<div>
		<label for="pass">Nowe hasło: </label>
		<input type="password" name="pass" id="pass" value="" size="100" maxlength="512" onchange="compare_pass()" />
		<span id="pass_counter"></span>
		<br />
		Zostaw to pole puste aby nie zmieniać hasła.
	</div>
	<div>
		<label for="pass">Nowe hasło (powtórz): </label>
		<input type="password" name="pass_v" id="pass_v" value="" size="100" maxlength="512" onchange="compare_pass()" />
		<span id="pass_v_counter"></span>
		<br />
		Zostaw to pole puste aby nie zmieniać hasła.
	</div>
		<fieldset>
			<legend>Poziom uprawnień<span class="color_red">*</span></legend>
			<label><input type="radio" name="lvl" value="0" onchange="not_level_2()"<?php if($row['lvl']==='0') echo ' checked="checked"'; ?> required="required" /> Administrator</label>
			<br />
			<label><input type="radio" name="lvl" value="1" onchange="not_level_2()"<?php if($row['lvl']==='1') echo ' checked="checked"'; ?> required="required" /> Moderator</label>
			<br />
			<label><input type="radio" name="lvl" id="kont" onchange="level_2()" value="2"<?php if($row['lvl']==='2') echo ' checked="checked"'; ?> required="required" /> Osoba kontaktowa</label>
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
	<div>
		<input class="btn btn-primary" type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<span class="color_red">*</span> - wymagane pola.
<?php
								foreach(array('js/ask_db.js','js/check_email.js','js/remaining_char_counter.js','js/user_form_edit.js','js/user_lib.js') as $script){
									echo '<script src="'.$script.'" type="text/javascript"></script>';
								}
							}
							else echo 'Nie znaleziono użytkownika o podanym identyfikatorze.<br /><br />';
						}
						else echo 'Nie udało się pobrać danych z bazy danych: '.implode(' ',$st->errorInfo()).'<br /><br />';
					}
					else echo 'Nie udało się pobrać danych z bazy danych: '.implode(' ',$DB->errorInfo()).'<br /><br />';
				}
				else echo 'Nie podano użytkownika do edycji.';
			}
			else echo 'Dostęp do panelu administracyjnego dozwolony jest tylko z uprawnieniami administratora.<br /><br /><a href="index.php">Powrót do strony głównej</a><br /><br /><br />';
		}
	}
	else echo '<br />Nie jesteś zalogowany.<br /><a href="login.php">Zaloguj się</a><br /><br />Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
?>
