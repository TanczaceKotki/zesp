<?php
	session_start();
	if(user::isLogged()){
		$user = user::getData('', '');
		if(isset($_POST['id'])){
		
			if($st=$DB->prepare('SELECT * FROM Uzytkownicy WHERE id=?')){
				if($st->execute(array($_POST['id']))){
					$row=$st->fetch(PDO::FETCH_ASSOC);
?>

<?php
	$login = $_SESSION["login"];
	if($st=$DB->prepare('SELECT lvl FROM Uzytkownicy WHERE login=?'))
		if($st->execute(array($_SESSION["login"])))
			if($row=$st->fetch(PDO::FETCH_ASSOC)){
				if($row['lvl'] == 0) {
				
				?>
<form action="view_user.php?id=<?php echo $row['id']; ?>" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
	<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
	<input type="hidden" name="old_login" value="<?php echo $row['login']; ?>" />
	<input type="hidden" name="old_pass" value="<?php echo $row['pass']; ?>" />
	<input type="hidden" name="old_lvl" value="<?php echo $row['lvl']; ?>" />
	<div>
		<label for="login">Login<span class="color_red">*</span>: </label>
		<input type="text" name="login" id="login" value="<?php echo $row['login']; ?>" size="100" maxlength="512" required="required" />
		<span id="login_counter"></span>
	</div>
	<div>
		<label for="pass">Nowe hasło<span class="color_red">*</span>: </label>
		<input type="password" name="pass" id="pass" value="" size="100" maxlength="512" required="required" />
		<span id="pass_counter"></span>
	</div>
	<div>
		<label for="pass">Nowe hasło (powtórz)<span class="color_red">*</span>: </label>
		<input type="password" name="pass_v" id="pass_v" value="" size="100" maxlength="512" required="required" />
		<span id="pass_counter"></span>
	</div>
	<div>
		<label for="lvl">Poziom uprawnień<span class="color_red">*</span>: </label>
		<input type="radio" name="lvl" value="0"/>Administrator
		<input type="radio" name="lvl" value="1" />Moderator
		<input type="radio" name="lvl" value="2" />Osoba kontaktowa<br><br>
		<span id="lvl_counter"></span>
		<div id="lvl_error"></div>
	</div>
	<div>
		<input type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<span class="color_red">*</span> - wymagane pola.
<?php
					foreach(array('js/jquery-1.11.3.min.js','js/modernizr.js','js/js-webshim/minified/polyfiller.js','js/default_form.js','js/ask_db.js','js/remaining_char_counter.js','js/osoba_form_edit.js') as $script){
						echo '<script src="'.$script.'" type="text/javascript"></script>';
					}
				}
				else{
					echo 'Nie udało się pobrać danych z bazy danych: '.implode(' ',$st->errorInfo()).'<br /><br />';
					
				}
			}
			else{
				echo 'Nie udało się pobrać danych z bazy danych: '.implode(' ',$DB->errorInfo()).'<br /><br />';
				
			}
		}
		else{
			echo 'Nie podano osoby do edycji.';
			
		}
	}
	else {
		echo '<br>Nie jesteś zalogowany.<br />
		<a href="login.php">Zaloguj się</a><br><br> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
		bottom();
	}

}
				else {
					echo 'Dostęp do panelu administracyjnego dozwolony jest tylko z uprawnieniami administratora.<br /><br />';
					echo '<a href="index.php">Powrót do strony głównej</a><br><br><br>';
				}
			}
?>
