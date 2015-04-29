<?php
	require 'DB.php';
	$DB=dbconnect();
	if($st=$DB->prepare('SELECT id FROM Tag WHERE nazwa=?')){
		if($st->execute(array($_POST['q']))){
			if($row=$st->fetch(PDO::FETCH_ASSOC)) echo '1';
			else echo '0';
		}
	}
?>
