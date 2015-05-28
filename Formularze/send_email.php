<?php
	$to = "jakubbr@gmail.com";
	$subject = "TEMAT EMAILA";
	$message = "Tu jest tekst wiadomosci";
	$headers = "FROM: test@test.com";
	$is_send = mail( $to, $subject, $message, $headers );
	if( $is_send ){
		echo "Email wyslany poprawnie.".PHP_EOL;
	}
	else{
		echo "Blad podczas wysylania emaila.";
	}
?>