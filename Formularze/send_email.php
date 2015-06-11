<?php
	require '../PHPMailer-master/PHPMailerAutoload.php';

	function losuj_znak( $arg ){ // funkcja do losowania znaku, mozliwe argumenty - "cyfra", "wielka_litera", "mala_litera"
		if( $arg == "cyfra" ){
			return chr( rand( 48, 57 ) );
		}
		else if( $arg == "wielka_litera" ){
			return chr( rand( 65, 90 ) );
		}
		else{ //domyslanie losuje mala litere
			return chr( rand( 97, 122 ) );
		}
	}

	function generuj_haslo(){
		$haslo = "";
		$dlugosc_hasla = rand( 6, 12 );
		for( $i = 0; $i < $dlugosc_hasla; $i++ ){
			$rodzaj = rand( 1, 3 );
			switch( $rodzaj ){
				case 1:
					$rodzaj = "cyfra";
					break;
				case 2:
					$rodzaj = "wielka_litera";
					break;
				case 3:
					$rodzaj = "mala_litera";
					break;
			}
			$znak = losuj_znak( $rodzaj );
			$haslo = $haslo.$znak;
		}
		return $haslo;
	}

	function wyslij_wiadomosc($od_kogo, $do_kogo, $temat, $tresc){
		$mail = new PHPMailer;

		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'testuj123456@gmail.com';                 // SMTP username
		$mail->Password = 'a12345678B';                           // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;                                    // TCP port to connect to

		$mail->From = $od_kogo;
		$mail->FromName = 'Projekt UJ';
		$mail->addAddress( $do_kogo );     // Add a recipient

		$mail->Subject = $temat;
		$mail->Body    = $tresc;

		if(!$mail->send()) {
		    echo 'Wiadomosc nie moze zostac wyslana do użytkownika.'.PHP_EOL;
		    echo 'Blad wyslania wiadomosci: ' . $mail->ErrorInfo.PHP_EOL;
		}
		// else {
		//     echo 'Konto użytkownika zostało utworzone, wiadomość email z wygenerownym hasłem została wysłana do użytkownika.'.PHP_EOL;
		// }
	}

	function wyslij_wiadomosc_z_haslem( $adres_email, $haslo ){
		$autor = "jakub.braz@student.uj.edu.pl";
		$temat = "Automatyczne generowanie kont dla uzytkownikow.";
		$tresc = "System automatycznie wygenerowal konto uzytkownika.\r\nlogin: ".$adres_email."\r\nhaslo: ".$haslo."\r\n";
		wyslij_wiadomosc( $autor, $adres_email, $temat, $tresc );
	}

	// $haslo = generuj_haslo();
	// echo "HASLO: ".$haslo;
	// $to = 'jakub.braz@student.uj.edu.pl';
	// wyslij_wiadomosc_z_haslem( $to, $haslo );
?>