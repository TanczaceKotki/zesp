<?php
	
	function valid_length( $arg, $max_length ){
		return strlen($arg)<=$max_length;
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

	function valid_date( $date ){ //funkcja sprawdza czy data podana jest w odpowiednim formacie
		$date=explode('-',$date);
		if(ctype_digit($date[2])){
			$year=intval($date[2]);
			if($year>0){
				if($date[1]!==""){
					if(ctype_digit($date[1])){
						$month=intval($date[1]);
						if($month>0 && $month<=12){
							if($date[0]!==""){
								if(ctype_digit($date[0])){
									$day=intval($date[0]);
									if($day>0 && $day<=cal_days_in_month(CAL_GREGORIAN,$month,$year)) return true;
									else return false;
								}
								else return false;
							}
							else return true;
						}
						else return false;
					}
					else return false;
				}
				else return true;
			}
			else return false;
		}
		return false;
	}
	function valid_image($img_path){ //funkcja sprawdza czy dany plik jest obrazkiem
		$img_size=getimagesize($img_path);
		$width=intval($img_size[0]);
		$height=intval($img_size[1]);
		if($width===0 || $height===0) return 1;
		if($width<800 || $height<600) return 2;
		return 0;
	}
	function resize_image($img_path,$min_width,$min_height){
		list($width,$height)=getimagesize($img_path);
		$new_height=round((float)$height*(800.0/(float)$width));
		$src=imagecreatefromjpeg($img_path);
		$dst=imagecreatetruecolor(800,$new_height);
		imagecopyresampled($dst, $src, 0, 0, 0, 0, 800, $new_height, $width, $height);
		imagejpeg( $dst, $img_path );
	}

?>