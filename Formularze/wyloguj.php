<?php
	session_start();

	require 'common.php';
	require 'DB.php';
	require 'user.class.php';
	top();

	session_destroy();
	$_SESSION = array ();
	echo 'Zostałeś wylogowany! <a href="login.php">Zaloguj się</a> ponownie.';
?>