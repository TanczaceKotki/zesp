<?php
	
	function valid_length( $arg, $max_length ){
		return ( strlen( $arg ) <= $max_length );
	}

	function valid_email( $email, $max_length){
		if( valid_length($email, $max_length) == false ){
			return false;
		}

		$arg = strtolower( $email );
		$expression = '/^[a-z][a-z0-9\._]*@[a-z\.]+\.[a-z\.]+$/';

		return preg_match( $expression, $arg );
	}

	function valid_first_name( $name, $max_length ){
		if( valid_length( $name, $max_length ) == false ){
			return false;
		}

		$expression = '/^[A-Z][a-zęółśążźćń]+$/';
		return preg_match( $expression, $name );
	}

	function valid_second_name( $name, $max_length ){
		if( valid_length( $name, $max_length ) == false ){
			return false;
		}

		$expression = '/^[A-ZŁŚŹĆŻ][a-zęółśążźćń]*(-[A-ZŁŚŹĆŻ][a-zęółśążźćń]*){0,1}$/';
		return preg_match( $expression, $name );
	}

	function valid_date( $date ){
		$date = explode( "-", $date );
		$day = intval( $date[0] );
		$month = intval( $date[1] );
		$year = intval( $date[2] );

		if( $day == 0 or $month == 0 or $month>12 or $year == 0 ){
			return false;
		}

		$days_in_month = cal_days_in_month( CAL_GREGORIAN, $month, $year );

		if( $day <= $days_in_month ){
			return true;
		}
		return false;
	}

?>