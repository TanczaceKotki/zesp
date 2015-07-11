<?php
	session_start();
	session_destroy();
	$_SESSION = array ();
	echo 'Zostałeś wylogowany! <a href="index.php?menu=10"><br>Zaloguj się</a> ponownie.';
?>
