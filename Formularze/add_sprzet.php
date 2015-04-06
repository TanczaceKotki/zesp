<?php
	require 'common.php';
	require 'DB.php';
	$DB=dbconnect();
	if(isset($_POST['submitted'])){
		top();
		$params=array($_POST['nazwa'],$_POST['data_zakupu']);
		$sql='INSERT INTO Sprzet VALUES(NULL,?,?,';
		if($_POST['data_uruchomienia']===""){
			$sql.='NULL,?,?,';
		}
		else{
			$sql.='?,?,?,';
			$params[]=$_POST['data_uruchomienia'];
		}
		$params[]=$_POST['wartosc'];
		$params[]=$_POST['opis'];
		if($_POST['projekt']==='-'){
			$sql.='NULL,';
		}
		else{
			$sql.='?,';
			$params[]=$_POST['projekt'];
		}
		if($_POST['laboratorium']==='-'){
			$sql.='NULL)';
		}
		else{
			$sql.='?);';
			$params[]=$_POST['laboratorium'];
		}
		if($st=$DB->prepare($sql)){
			if($st->execute($params)){
				echo 'Sprzęt został pomyślnie wstawiony.<br /><br />';
			}
			else{
				echo 'Nastąpił błąd przy dodawaniu sprzętu: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
		}
		else{
			echo 'Nastąpił błąd przy dodawaniu sprzętu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
		bottom();
	}
	else{
		top(array('https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css'));
?>
<form action="add_sprzet.php" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
	<div>
		<label for="nazwa">Nazwa: </label>
		<input type="text" name="nazwa" id="nazwa" value="" size="10" maxlength="512" spellcheck="true" required />
	</div>
	<div>
		<label for="data_zakupu">Data zakupu: </label>
		<input type="text" name="data_zakupu" id="data_zakupu" value="<?php echo date('Y-m-d'); ?>" size="10" maxlength="10" required />
	</div>
	<div>
		<label for="data_uruchomienia">Data uruchomienia: </label>
		<input type="text" name="data_uruchomienia" id="data_uruchomienia" value="<?php echo date('Y-m-d'); ?>" size="10" maxlength="10" />
	</div>
	<div>
		<label for="wartosc">Wartość: </label>
		<input type="text" name="wartosc" id="wartosc" value="" size="10" maxlength="10" required />gr
	</div>
	<div>
		<label for="opis">Opis: </label>
		<textarea name="opis" id="opis" rows="20" cols="100" maxlength="166666666" spellcheck="true" required></textarea>
	</div>
	<div>
		<label for="projekt">Projekt: </label>
		<select name="projekt" id="projekt">
			<option value="" selected>-</option>
			<?php
				if($result=$DB->query("SELECT id,nazwa FROM Projekt ORDER BY nazwa")){
					while($row=$result->fetch(PDO::FETCH_ASSOC)){
						echo '<option value="'.$row['id'].'">'.$row['nazwa'].'</option>';
					}
				}
			?>
		</select>
	</div>
	<div>
		<label for="laboratorium">Laboratorium: </label>
		<select name="laboratorium" id="laboratorium">
			<option value="" selected>-</option>
			<?php
				if($result=$DB->query("SELECT id,nazwa FROM Laboratorium ORDER BY nazwa")){
					while($row=$result->fetch(PDO::FETCH_ASSOC)){
						echo '<option value="'.$row['id'].'">'.$row['nazwa'].'</option>';
					}
				}
			?>
		</select>
	</div>
	<div>
		<input type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<script type="text/javascript">
	var date_fields=["data_zakupu","data_uruchomienia"];
</script>
<?php
		bottom(array('https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js','https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js','js/datepicker.js'));
	}
?>
