<?php
	require 'DB.php';
	$DB=dbconnect();
	if($st=$DB->prepare('SELECT zaklad,laboratorium FROM Laborat_w_zaklad WHERE zaklad=? AND laboratorium=?')){
		if($st->execute(array($_POST['q1'],$_POST['q2']))){
			if($row=$st->fetch(PDO::FETCH_ASSOC)) echo '1';
			else echo '0';
		}
	}
?>
