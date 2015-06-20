<?php
	session_start();
	require 'common.php';
	top();
	$displayform=True;
	if(isset($_POST['send'])){
		$login=$_POST['login'];
		$pass=$_POST['pass'];
		if ($login==="") {
			echo 'Wypełnij pole z loginem!<br /><br />';
		}
		if ($pass==="") {
			echo 'Wypełnij pole z hasłem!<br /><br />';
		}
		if($login!=="" && $pass!==""){
			require 'DB.php';
			$DB=dbconnect();
			if($st=$DB->prepare('SELECT * FROM Uzytkownicy WHERE login=?')){
				if($st->execute(array($login))){
					require 'user.class.php';
					$userExists = $st->fetch(PDO::FETCH_ASSOC);
					if (password_verify($pass, $userExists['pass'])) {

						//$user = user::getData();

						//$_SESSION['id'] = $id;
						$_SESSION['login'] = $login;
						$_SESSION['pass'] = $pass;

						echo 'Zostałeś zalogowany pomyślnie.<br /><br />Przejdź do <a href="index.php">strony głównej</a>.';
						$displayform=False;
						bottom();
					}
					else {
						echo 'Użytkownik o podanym loginie i haśle nie istnieje.<br /><br />';
					}
				}
				else{
					echo 'Nastąpił błąd przy pobieraniu danych z bazy danych: '.implode(' ',$st->errorInfo()).'<br /><br />';
				}
			}
			else{
				echo 'Nastąpił błąd przy pobieraniu danych z bazy danych: '.implode(' ',$DB->errorInfo()).'<br /><br />';
			}
		}
		else {
			echo 'Użytkownik o podanym loginie i haśle nie istnieje<br />';
			echo '<a href="login.php">Zaloguj ponownie</a>';
		}
	}
	if($displayform) {
?>
<form action="login.php" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
	<label for="login">Login<span class="color_red">*</span>: </label>
	<input type="text" name="login" id="login" value="" size="100" maxlength="254" required="required" />
	<span id="login_counter"></span>
	<br />
	<label for="pass">Hasło<span class="color_red">*</span>: </label>
	<input type="password" name="pass" id="pass" value="" size="100" maxlength="512" required="required" />
	<span id="pass_counter"></span>
	<br />
	<input type="submit" name="send" value="Zaloguj" />
</form>
<span class="color_red">*</span> - wymagane pola.
<?php
		bottom(array('https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js','js/js-webshim/minified/polyfiller.js','js/remaining_char_counter.js','js/default_form.js'));
	}
?>
