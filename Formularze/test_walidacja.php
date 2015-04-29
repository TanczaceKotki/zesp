<?php
	require 'walidacja.php';

	$email1 = "jan.kowalski@gmail.com";
	$email2 = "1jankowalski@o2.pl";
	$email3 = "moj_adres@com";
	$email4 = "jakub.braz@uj.edu.pl";
	
	echo (valid_email( $email1 ) == true).PHP_EOL;
	echo (valid_email( $email2 ) == false).PHP_EOL;
	echo (valid_email( $email3 ) == false).PHP_EOL;
	echo (valid_email( $email4 ) == true).PHP_EOL;
?>