<?php
	require 'common.php';
	require 'DB.php';
	$DB=dbconnect();
	top();
	if(isset($_POST['submitted'])){
		if($st=$DB->prepare('INSERT INTO Laborat_w_zaklad VALUES(?,?)')){
			if($st->execute(array($_POST['laboratorium'],$_POST['zaklad']))){
				echo 'Informacja o laboratorium w zakładzie została pomyślnie wstawiona.<br /><br />';
			}
			else{
				echo 'Nastąpił błąd przy dodawaniu informacji o laboratorium w zakładzie: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
		}
		else{
			echo 'Nastąpił błąd przy dodawaniu informacji o laboratorium w zakładzie: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
	}
	else{
?>
<form action="add_laborat_w_zaklad.php" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
	<div>
		<label for="laboratorium">Laboratorium: </label>
		<select name="laboratorium" id="laboratorium" required>
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
		<label for="zaklad">Zakład: </label>
		<select name="zaklad" id="zaklad" required>
			<option value="" selected>-</option>
			<?php
				if($result=$DB->query("SELECT id,nazwa FROM Zaklad ORDER BY nazwa")){
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
<?php
	}
	bottom();
?>
