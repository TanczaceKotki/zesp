<?php
	require 'common.php';
	top();
	if(isset($_POST['id'])){
		require 'DB.php';
		$DB=dbconnect();
		if($st=$DB->prepare('SELECT * FROM Osoba WHERE id=?')){
			if($st->execute(array($_POST['id']))){
				$row=$st->fetch(PDO::FETCH_ASSOC);
?>
<form action="view_osoba.php?id=<?php echo $row['id']; ?>" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
	<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
	<input type="hidden" name="old_imie" value="<?php echo $row['imie']; ?>" />
	<input type="hidden" name="old_nazwisko" value="<?php echo $row['nazwisko']; ?>" />
	<input type="hidden" name="old_email" value="<?php echo $row['email']; ?>" />
	<div>
		<label for="imie">Imię: </label>
		<input type="text" name="imie" id="imie" value="<?php echo $row['imie']; ?>" size="16" maxlength="16" required />
	</div>
	<div>
		<label for="nazwisko">Nazwisko: </label>
		<input type="text" name="nazwisko" id="nazwisko" value="<?php echo $row['nazwisko']; ?>" size="32" maxlength="32" required />
	</div>
	<div>
		<label for="email">Adres e-mail: </label>
		<input type="text" name="email" id="email" value="<?php echo $row['email']; ?>" size="32" maxlength="254" required />
	</div>
	<div>
		<input type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<?php
			}
			else echo 'Nie udało się pobrać danych z bazy danych: '.implode(' ',$st->errorInfo()).'<br /><br />';
		}
		else echo 'Nie udało się pobrać danych z bazy danych: '.implode(' ',$DB->errorInfo()).'<br /><br />';
	}
	else echo 'Nie podano osoby do edycji.';
	bottom();
?>
