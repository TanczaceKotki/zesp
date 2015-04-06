<?php
	require 'common.php';
	top();
	if(isset($_POST['submitted'])){
		require 'DB.php';
		$DB=dbconnect();
		if($st=$DB->prepare('INSERT INTO Osoba VALUES(NULL,?,?,?)')){
			if($st->execute(array($_POST['imie'],$_POST['nazwisko'],$_POST['email']))){
				echo 'Osoba została pomyślnie wstawiona.<br /><br />';
			}
			else{
				echo 'Nastąpił błąd przy dodawaniu osoby: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
		}
		else{
			echo 'Nastąpił błąd przy dodawaniu osoby: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
	}
	else{
?>
<form action="add_osoba.php" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
	<div>
		<label for="imie">Imię: </label>
		<input type="text" name="imie" id="imie" value="" size="16" maxlength="16" required />
	</div>
	<div>
		<label for="nazwisko">Nazwisko: </label>
		<input type="text" name="nazwisko" id="nazwisko" value="" size="32" maxlength="32" required />
	</div>
	<div>
		<label for="email">Adres e-mail: </label>
		<input type="text" name="email" id="email" value="" size="32" maxlength="254" required />
	</div>
	<div>
		<input type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<?php
	}
	bottom();
?>
