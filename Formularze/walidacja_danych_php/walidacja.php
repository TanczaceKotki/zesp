<?php
	
	function valid_length( $arg, $max_length ){
		return ( strlen( $arg ) <= $max_length );
	}

	function valid_email( $email, $max_length){
		if( valid_length($email, $max_length) == false ){
			return false;
		}

		$arg = strtolower( $email );
		// $expression = '/^[a-z][a-z0-9\._]*@[a-z\.]+\.[a-z\.]+$/';
		$expression = '/^([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22))*\x40([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d))*$/';

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

		if( strpos( $date[0], "." ) != 0 or strpos( $date[1], "." ) != 0 or strpos( $date[2], "." ) != 0){
			return false;
		}

		if( count( $date ) != 3 ){
			return false;
		}

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

	function resize_image( $img_path, $min_width, $min_height ){ //funkcja sprawdza czy obraz nie jest za maly, zwraca zwiekszony obraz
		list( $width, $height ) = getimagesize( $img_path );
		
		if( $width < $min_width or $height < $min_height ){
			// $scale_factor = min( $width/$min_width, $height/$min_height );
			// $new_width = $width / $scale_factor;
			// $new_height = $height / $scale_factor;
			$new_width = max($min_width, $width);
			$new_height = max($min_height, $height);

			$src = imagecreatefromjpeg($img_path);
			$dst = imagecreatetruecolor($new_width, $new_height);
			imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
			
			imagejpeg( $dst, $img_path );
			// return $dst;
		}
		// return imagecreatefromjpeg($img_path);
		imagejpeg( imagecreatefromjpeg($img_path), $img_path );
	}

?>