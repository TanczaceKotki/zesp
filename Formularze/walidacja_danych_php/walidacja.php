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

	function valid_date( $date ){ //funkcja sprawdza czy data podana jest w odpowiednim formacie
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

	function valid_image( $img_path ){ //funkcja sprawdza czy dany plik jest obrazkiem
		$img_size = getimagesize( $img_path );
		$width = intval( $img_size[0] );
		$height = intval( $img_size[1] );

		if( $width == 0 or $height == 0 ){
			return false;
		}

		return true;
	}

	function resize_image( $img_path, $minimal_width, $minimal_height ){ //funkcja przeksztalca obraz do zadanych rozmiarow, zwraca obraz w zadanym rozmiarze
		list( $width, $height ) = getimagesize( $img_path );
		
		if( $width < $minimal_width or $height < $minimal_height ){
			$scale_factor = min( $width/$minimal_width, $height/$minimal_height );
			$new_width = $width / $scale_factor;
			$new_height = $height / $scale_factor;

			$src = imagecreatefromjpeg($img_path);
			$dst = imagecreatetruecolor($new_width, $new_height);
			imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
			
			// imagejpeg( $dst, "test.jpg" );
			return $dst;

			// imagedestroy( $src );
			// imagedestroy( $dst );
		}
	}

?>