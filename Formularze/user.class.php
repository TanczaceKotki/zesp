<?php

class user {

    public static $user = array();

    public function getData ($login, $pass) {
        if ($login == '') $login = $_SESSION['login'];
        if ($pass == '') $pass = $_SESSION['pass'];
		
		$DB=dbconnect();
		if($st=$DB->prepare("SELECT * FROM Uzytkownicy WHERE login=? AND pass=? LIMIT 1;")) {
			if($st->execute(array($_POST['login'],$_POST['pass']))){
				self::$user = $st->fetch(PDO::FETCH_ASSOC);
			}
		}
        return self::$user;
    }

    public function getDataById ($id) {
		$DB=dbconnect();
		if($st=$DB->prepare("SELECT * FROM Uzytkownicy WHERE id='$id' LIMIT 1;")){
		}		
        $user = $st->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    public function isLogged () {
     if (empty($_SESSION['login']) || empty($_SESSION['pass'])) {
		return false;
     }
     else {
		return true;
     }
    }
}