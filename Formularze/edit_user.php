<?php
	session_start();
	require 'user.class.php';
	require 'common.php';
	require 'DB.php';
	top();
	if(user::isLogged()){
		$user = user::getData('', '');
		if(isset($_POST['id'])){
			$DB=dbconnect();
			if($st=$DB->prepare('SELECT * FROM Uzytkownicy WHERE id=?')){
				if($st->execute(array($_POST['id']))){
					$row=$st->fetch(PDO::FETCH_ASSOC);
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
		<input type="radio" name="lvl" value="1" />Moderator<br><br>
		<span id="lvl_counter"></span>
		<div id="lvl_error"></div>
	</div>
	<div>
		<input type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<span class="color_red">*</span> - wymagane pola.
<?php
					bottom(array('https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js','js/js-webshim/minified/polyfiller.js','js/ask_db.js','js/remaining_char_counter.js','js/osoba_form_edit.js'));
				}
				else{
					echo 'Nie udało się pobrać danych z bazy danych: '.implode(' ',$st->errorInfo()).'<br /><br />';
					bottom();
				}
			}
			else{
				echo 'Nie udało się pobrać danych z bazy danych: '.implode(' ',$DB->errorInfo()).'<br /><br />';
				bottom();
			}
		}
		else{
			echo 'Nie podano osoby do edycji.';
			bottom();
		}
	}
	else {
		echo '<br>Nie jesteś zalogowany.<br />
		<a href="login.php">Zaloguj się</a><br><br> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
		bottom();
	}
?>
