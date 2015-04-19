<?php
	session_start();
	require_once 'user.class.php';
	require 'common.php';
	top();
	
	if (user::isLogged()) {
	$user = user::getData('', '');
	if(isset($_POST['id'])){
		require 'DB.php';
		$DB=dbconnect();
		if($st=$DB->prepare('SELECT * FROM Zaklad WHERE id=?')){
			if($st->execute(array($_POST['id']))){
				$row=$st->fetch(PDO::FETCH_ASSOC);
?>
<form action="view_zaklad.php?id=<?php echo $row['id']; ?>" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
	<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
	<input type="hidden" name="old_nazwa" value="<?php echo $row['nazwa']; ?>" />
	<div>
		<label for="nazwa">Nazwa: </label>
		<input type="text" name="nazwa" id="nazwa" value="<?php echo $row['nazwa']; ?>" size="16" maxlength="64" required />
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
	else echo 'Nie podano zakładu do edycji.';
	}
	else {
		echo '<br>Nie jesteś zalogowany.<br />
		<a href="login.php">Zaloguj się</a><br><br> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
	}
	bottom();
?>
