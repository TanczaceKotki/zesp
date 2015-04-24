<?php
session_start();

require 'common.php';
require 'DB.php';
require_once 'user.class.php';
top();


$login = $_POST['login'];
$pass = $_POST['pass'];

if ($_POST['send'] == 1) {
    
	if (!$login or empty($login)) {
        echo 'Wypełnij pole z loginem!<br />';
		echo '<a href="login.php">Zaloguj ponownie</a>';
    }
    if (!$pass or empty($pass)) {
        echo 'Wypełnij pole z hasłem!<br />';
		echo '<a href="login.php">Zaloguj ponownie</a>';
    }
    
	$DB=dbconnect();
	if($st=$DB->prepare("SELECT * FROM Uzytkownicy WHERE login=?")){	
		if($st->execute(array($_POST['login']))){
		$userExists = $st->fetch(PDO::FETCH_ASSOC);
		
		if (password_verify($pass, $userExists['pass'])) {
			
			$user = user::getData($id, $login, $pass);

			$_SESSION['id'] = $id;
			$_SESSION['login'] = $login;
			$_SESSION['pass'] = $pass;

			echo 'Zostałeś zalogowany pomyślnie.';
			echo 'Przejdź do <a href="index.php">strony głównej</a>.';
		}
		else {
			echo 'Użytkownik o podanym loginie i haśle nie istnieje<br />';
			echo '<a href="login.php">Zaloguj ponownie</a>';
		}
	}}
	else {
		echo 'Użytkownik o podanym loginie i haśle nie istnieje<br />';
		echo '<a href="login.php">Zaloguj ponownie</a>';
	}
}

else {
    /**
     * FORMULARZ LOGOWANIA
     */
?>

 <form method="post" action="">
  <label for="login">Login:</label>
  <input type="text" name="login" id="login" /><br />

  <label for="pass">Hasło:</label>
  <input type="password" name="pass" id="pass" /><br />

  <input type="hidden" name="send" value="1" />
  <input type="submit" value="Zaloguj" />
 </form>

<?php
}
	bottom();
?>
