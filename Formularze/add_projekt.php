<?php
	require 'common.php';
	if(isset($_POST['submitted'])){
		require 'DB.php';
		$DB=dbconnect();
		top();
		$params=array($_POST['nazwa'],$_POST['data_rozp']);
		$sql='INSERT INTO Projekt VALUES(NULL,?,?,';
		if($_POST['data_zakoncz']===""){
			$sql.='NULL,?,?)';
		}
		else{
			$sql.='?,?,?)';
			$params[]=$_POST['data_zakoncz'];
		}
		$params[]=$_POST['opis'];
		$params[]=$_POST['logo'];
		if($st=$DB->prepare($sql)){
			if($st->execute($params)){
				echo 'Projekt został pomyślnie wstawiony.<br /><br />';
			}
			else{
				echo 'Nastąpił błąd przy dodawaniu projektu: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
		}
		else{
			echo 'Nastąpił błąd przy dodawaniu projektu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
		bottom();
	}
	else{
		top(array('https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css'));
?>
<form action="add_projekt.php" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
	<div>
		<label for="nazwa">Nazwa: </label>
		<input type="text" name="nazwa" id="nazwa" value="" size="16" maxlength="64" required />
	</div>
	<div>
			<label for="data_rozp">Data rozpoczęcia: </label>
			<input type="text" name="data_rozp" id="data_rozp" value="<?php echo date('Y-m-d'); ?>" size="10" maxlength="10" required />
	</div>
	<div>
		<label for="data_zakoncz">Data zakończenia: </label>
		<input type="text" name="data_zakoncz" id="data_zakoncz" value="<?php echo date('Y-m-d'); ?>" size="10" maxlength="10" />
	</div>
	<div>
		<label for="opis">Opis: </label>
		<textarea name="opis" id="opis" rows="20" cols="100" maxlength="166666666" required></textarea>
	</div>
	<div>
		<label for="logo">Logo: </label>
		<input type="text" name="logo" id="logo" value="" size="16" maxlength="128" required />
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
?>
