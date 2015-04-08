<?php
	require 'common.php';
	if(isset($_POST['id'])){
		require 'DB.php';
		$DB=dbconnect();
		if($st=$DB->prepare('SELECT * FROM Sprzet WHERE id=?')){
			if($st->execute(array($_POST['id']))){
				$row=$st->fetch(PDO::FETCH_ASSOC);
				top(array('https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css'));
?>
<form action="view_sprzet.php?id=<?php echo $row['id']; ?>" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
	<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
	<input type="hidden" name="old_nazwa" value="<?php echo $row['nazwa']; ?>" />
	<input type="hidden" name="old_data_zakupu" value="<?php echo $row['data_zakupu']; ?>" />
	<input type="hidden" name="old_data_uruchom" value="<?php echo $row['data_uruchom']; ?>" />
	<input type="hidden" name="old_wartosc" value="<?php echo $row['wartosc']; ?>" />
	<input type="hidden" name="old_opis" value="<?php echo $row['opis']; ?>" />
	<input type="hidden" name="old_projekt" value="<?php echo $row['projekt']; ?>" />
	<input type="hidden" name="old_laboratorium" value="<?php echo $row['laboratorium']; ?>" />
	<div>
		<label for="nazwa">Nazwa: </label>
		<input type="text" name="nazwa" id="nazwa" value="<?php echo $row['nazwa']; ?>" size="10" maxlength="512" spellcheck="true" required />
	</div>
	<div>
		<label for="data_zakupu">Data zakupu: </label>
		<input type="text" name="data_zakupu" id="data_zakupu" value="<?php echo $row['data_zakupu']; ?>" size="10" maxlength="10" required />
	</div>
	<div>
		<label for="data_uruchom">Data uruchomienia: </label>
		<input type="text" name="data_uruchom" id="data_uruchom" value="<?php echo $row['data_uruchom']; ?>" size="10" maxlength="10" />
	</div>
	<div>
		<label for="wartosc">Wartość: </label>
		<input type="text" name="wartosc" id="wartosc" value="<?php echo $row['wartosc']; ?>" size="10" maxlength="10" required />gr
	</div>
	<div>
		<label for="opis">Opis: </label>
		<textarea name="opis" id="opis" rows="20" cols="100" maxlength="166666666" spellcheck="true" required><?php echo $row['opis']; ?></textarea>
	</div>
	<div>
		<label for="projekt">Projekt: </label>
		<select name="projekt" id="projekt">
			<?php
				if($row['projekt']==="") echo '<option value="" selected>-</option>';
				else echo '<option value="">-</option>';
				if($result=$DB->query("SELECT id,nazwa FROM Projekt ORDER BY nazwa")){
					while($row2=$result->fetch(PDO::FETCH_ASSOC)){
						if($row['projekt']===$row2['id']) echo '<option value="'.$row2['id'].'" selected>'.$row2['nazwa'].'</option>';
						else echo '<option value="'.$row2['id'].'">'.$row2['nazwa'].'</option>';
					}
				}
			?>
		</select>
	</div>
	<div>
		<label for="laboratorium">Laboratorium: </label>
		<select name="laboratorium" id="laboratorium">
			<?php
				if($row['laboratorium']==="") echo '<option value="" selected>-</option>';
				else echo '<option value="">-</option>';
				if($result=$DB->query("SELECT id,nazwa FROM Laboratorium ORDER BY nazwa")){
					while($row2=$result->fetch(PDO::FETCH_ASSOC)){
						if($row['laboratorium']===$row2['id']) echo '<option value="'.$row2['id'].'" selected>'.$row2['nazwa'].'</option>';
						else echo '<option value="'.$row2['id'].'">'.$row2['nazwa'].'</option>';
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
	var date_fields=["data_zakupu","data_uruchom"];
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
		echo 'Nie podano sprzętu do edycji.';
		bottom();
	}
?>
