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
			if($st=$DB->prepare('SELECT * FROM Osoba WHERE id=?')){
				if($st->execute(array($_POST['id']))){
					$row=$st->fetch(PDO::FETCH_ASSOC);
?>
<form action="view_osoba.php?id=<?php echo $row['id']; ?>" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded" onsubmit="return ajax_check()">
	<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
	<input type="hidden" name="old_imie" value="<?php echo $row['imie']; ?>" />
	<input type="hidden" name="old_nazwisko" value="<?php echo $row['nazwisko']; ?>" />
	<input type="hidden" name="old_email" id="old_email" value="<?php echo $row['email']; ?>" />
	<div>
		<label for="imie">Imię<span class="color_red">*</span>: </label>
		<input type="text" name="imie" id="imie" value="<?php echo $row['imie']; ?>" size="16" maxlength="16" required="required" />
		<span id="imie_counter"></span>
	</div>
	<div>
		<label for="nazwisko">Nazwisko<span class="color_red">*</span>: </label>
		<input type="text" name="nazwisko" id="nazwisko" value="<?php echo $row['nazwisko']; ?>" size="32" maxlength="32" required="required" />
		<span id="nazwisko_counter"></span>
	</div>
	<div>
		<label for="email">Adres e-mail<span class="color_red">*</span>: </label>
		<input type="email" name="email" id="email" value="<?php echo $row['email']; ?>" size="32" maxlength="254" onchange="check_email_2()" required="required" />
		<span id="email_counter"></span>
	</div>
	<div>
		<input type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<span class="color_red">*</span> - wymagane pola.
<?php
					bottom(array('https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js','js/js-webshim/minified/polyfiller.js','js/ask_db.js','js/remaining_char_counter.js','js/check_email.js','js/default_form.js','js/osoba_form_edit.js'));
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
