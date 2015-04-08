<?php
	require 'common.php';
	if(isset($_POST['id'])){
		require 'DB.php';
		$DB=dbconnect();
		if($st=$DB->prepare('SELECT * FROM Projekt WHERE id=?')){
			if($st->execute(array($_POST['id']))){
				$row=$st->fetch(PDO::FETCH_ASSOC);
				top(array('https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css'));
?>
<form action="view_projekt.php?id=<?php echo $row['id']; ?>" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
	<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
	<input type="hidden" name="old_nazwa" value="<?php echo $row['nazwa']; ?>" />
	<input type="hidden" name="old_data_rozp" value="<?php echo $row['data_rozp']; ?>" />
	<input type="hidden" name="old_data_zakoncz" value="<?php echo $row['data_zakoncz']; ?>" />
	<input type="hidden" name="old_opis" value="<?php echo $row['opis']; ?>" />
	<input type="hidden" name="old_logo" value="<?php echo $row['logo']; ?>" />
	<div>
		<label for="nazwa">Nazwa: </label>
		<input type="text" name="nazwa" id="nazwa" value="<?php echo $row['nazwa']; ?>" size="10" maxlength="64" spellcheck="true" required />
	</div>
	<div>
		<label for="data_rozp">Data rozpoczęcia: </label>
		<input type="text" name="data_rozp" id="data_rozp" value="<?php echo $row['data_rozp']; ?>" size="10" maxlength="10" required />
	</div>
	<div>
		<label for="data_zakoncz">Data zakończenia: </label>
		<input type="text" name="data_zakoncz" id="data_zakoncz" value="<?php echo $row['data_zakoncz']; ?>" size="10" maxlength="10" />
	</div>
	<div>
		<label for="opis">Opis: </label>
		<textarea name="opis" id="opis" rows="20" cols="100" maxlength="166666666" spellcheck="true" required><?php echo $row['opis']; ?></textarea>
	</div>
	<div>
		<label for="logo">Logo: </label>
		<input type="text" name="logo" id="logo" value="<?php echo $row['logo']; ?>" size="10" maxlength="1700" required />
	</div>
	<div>
		<input type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<script type="text/javascript">
	var date_fields=["data_rozp","data_zakoncz"];
</script>
<?php
				bottom(array('https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js','https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js','js/datepicker.js'));
			}
			else{
				top();
				echo 'Nie udało się pobrać danych z bazy danych: '.implode(' ',$st->errorInfo()).'<br /><br />';
				bottom();
			}
		}
		else{
			top();
			echo 'Nie udało się pobrać danych z bazy danych: '.implode(' ',$DB->errorInfo()).'<br /><br />';
			bottom();
		}
	}
	else{
		top();
		echo 'Nie podano projektu do edycji.';
		bottom();
	}
?>
