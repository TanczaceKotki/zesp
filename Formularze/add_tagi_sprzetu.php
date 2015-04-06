<?php
	require 'common.php';
	require 'DB.php';
	$DB=dbconnect();
	top();
	if(isset($_POST['submitted'])){
		if($st=$DB->prepare('INSERT INTO Tagi_sprzetu VALUES(?,?)')){
			if($st->execute(array($_POST['sprzet'],$_POST['tag']))){
				echo 'Informacja o tagu sprzętu w zakładzie została pomyślnie wstawiona.<br /><br />';
			}
			else{
				echo 'Nastąpił błąd przy dodawaniu informacji o tagu sprzętu: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
		}
		else{
			echo 'Nastąpił błąd przy dodawaniu informacji o tagu sprzętu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
	}
	else{
?>
<form action="add_tagi_sprzetu.php" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
	<div>
		<label for="sprzet">Sprzęt: </label>
		<select name="sprzet" id="sprzet" required>
			<option value="" selected>-</option>
			<?php
				if($result=$DB->query("SELECT id,nazwa FROM Sprzet ORDER BY nazwa")){
					while($row=$result->fetch(PDO::FETCH_ASSOC)){
						echo '<option value="'.$row['id'].'">'.$row['nazwa'].'</option>';
					}
				}
			?>
		</select>
	</div>
	<div>
		<label for="tag">Tag: </label>
		<select name="tag" id="tag" required>
			<option value="" selected>-</option>
			<?php
				if($result=$DB->query("SELECT id,nazwa FROM Tag ORDER BY nazwa")){
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
