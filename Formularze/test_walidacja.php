<?php
	require 'walidacja.php';

	$email1 = "jan.kowalski@gmail.com";
	$email2 = "1jankowalski@o2.pl";
	$email3 = "moj_adres@com";
	
	echo (valid_email( $email1 ) == true).PHP_EOL;
	echo (valid_email( $email2 ) == false).PHP_EOL;
	echo (valid_email( $email3 ) == false).PHP_EOL;
?>