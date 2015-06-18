<?php
	require 'DB.php';
	$DB=dbconnect();
	if($st=$DB->prepare('SELECT sprzet FROM Kontakt WHERE sprzet=? AND osoba=?')){
		if($st->execute(array($_POST['q1'],$_POST['q2']))){
			if($row=$st->fetch(PDO::FETCH_ASSOC)) echo '1';
			else echo '0';
		}
	}
?>
