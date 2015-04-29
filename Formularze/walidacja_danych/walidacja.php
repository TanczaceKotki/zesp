<?php

	function valid_email( $email ){
		$arg = strtolower( $email );
		// $expression = '/^[a-z]{1}[a-z0-9\.]*@\.[a-z]+$/';
		$expression = '/^[a-z][a-z0-9\._]*@[a-z\.]+\.[a-z\.]+$/';

		if( preg_match( $expression, $arg ) ){
			return true;
		}

		return false;
	}

?>