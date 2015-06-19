<?php
	function dbconnect(){
		try{
			$DB=new PDO('sqlite:sprzet_laboratoryjny.sqlite3');
			$DB->exec('PRAGMA foreign_keys = ON;');
		}
		catch(PDOException $e){
			echo 'Połączenie z bazą danych nie powiodło się.';
		}
		return $DB;
	}
?>
