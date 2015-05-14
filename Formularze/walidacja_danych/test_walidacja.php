<?php
	require 'walidacja.php';

	function test_equal( $val1, $val2 ){
		$is_equal = ( $val1 == $val2 );
		if( $is_equal == true ){
			echo "TEST OK".PHP_EOL;
		}
		else{
			echo "TEST ERROR".PHP_EOL;
		}
	}

	echo "TESTY FUNKCJI valid_length"."\n";
	$max_length = 10;
	$napis = "abc";
	test_equal( valid_length( $napis, $max_length ), true );
	$napis = "abcdefghij";
	test_equal( valid_length( $napis, $max_length ), true );
	$napis = "abcdefghijk";
	test_equal( valid_length( $napis, $max_length ), false );

	echo "TEST FUNKCJI valid_email"."\n";
	$max_length = 50;
	$email1 = "jan.kowalski@gmail.com";
	$email2 = "1jankowalski@o2.pl";
	$email3 = "moj_adres@com";
	$email4 = "jakub.braz@uj.edu.pl";
	$email5 = "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa@uj.edu.pl";
	test_equal( valid_email( $email1, $max_length ), true );
	test_equal( valid_email( $email2, $max_length ), false );
	test_equal( valid_email( $email3, $max_length ), false );
	test_equal( valid_email( $email4, $max_length ), true );
	test_equal( valid_email( $email5, $max_length ), false );

	echo "TEST FUNKCJI valid_first_name\n";
	$max_length = 20;
	$name = "Kuba";
	test_equal( valid_first_name( $name, $max_length ), true );
	$name = "kuba";
	test_equal( valid_first_name( $name, $max_length ), false );
	$name = "Coś";
	test_equal( valid_first_name( $name, $max_length ), true );
	$name = "Ściana";
	test_equal( valid_first_name( $name, $max_length ), false );
	$name = "Kubaaaaaaaaaaaaaaaaaa";
	test_equal( valid_first_name( $name, $max_length ), false );
	$name = "Ku_ba";
	test_equal( valid_first_name( $name, $max_length ), false );
	$name = "K";
	test_equal( valid_first_name( $name, $max_length ), false );

	echo "TEST FUNKCI valid_second_name\n";
	$max_length = 20;
	$name = "Brąz";
	test_equal( valid_second_name( $name, $max_length ), true );
	$name = "Brąz-Kowalski";
	test_equal( valid_second_name( $name, $max_length ), true );
	$name = "Kowalski_Nowak";
	test_equal( valid_second_name( $name, $max_length ), false );
	$name = "Nowakowski";
	// test_equal( valid_second_name( $name, $max_length ), true );
	// $name = "Ściana";
	test_equal( valid_second_name( $name, $max_length ), true );
	$name = "kowalski";
	test_equal( valid_second_name( $name, $max_length ), false );
	$name = "Jan-Maria";
	test_equal( valid_second_name( $name, $max_length ), true );

	echo "TEST FUNKCJI valid_date\n";
	$date = "20-05-2015";
	test_equal( valid_date( $date ), true );
	$date = "32-05-2015";
	test_equal( valid_date( $date ), false );
	$date = "31-05-2015";
	test_equal( valid_date( $date ), true );
	$date = "20-5-2015";
	test_equal( valid_date( $date ), true );
	$date = "20-15-2015";
	test_equal( valid_date( $date ), false );
	$date = "abc-5-2015";
	test_equal( valid_date( $date ), false );
	$date = "20-a-2015";
	test_equal( valid_date( $date ), false );
	$date = "asdf";
	test_equal( valid_date( $date ), false );
?>