<?php
	require 'common.php';
	require 'DB.php';
	$DB=dbconnect();
	top();
	if(isset($_POST['submitted'])){
		if($_POST['zdjecie']==='new'){
			$link='uploads/'.$_FILES['plik']['name'];
			move_uploaded_file($_FILES['plik']['tmp_name'],$link);
		}
		elseif($_POST['zdjecie']==='link') $link=$_POST['link'];
		if($st=$DB->prepare('INSERT INTO Zdjecie VALUES(NULL,?,?)')){
			if($st->execute(array($_POST['sprzet'],$link))){
				echo 'Zdjęcie zostało pomyślnie wstawione.<br /><br />';
			}
			else{
				echo 'Nastąpił błąd przy dodawaniu zdjęcia: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
		}
		else{
			echo 'Nastąpił błąd przy dodawaniu zdjęcia: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
		bottom();
	}
	else{
?>
<form action="add_zdjecie.php" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
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
		<input type="radio" name="zdjecie" value="new" id="picture_new" checked required onchange="toggleDisplay(this.value)" /> Wstaw nowe zdjęcie
		<span id="new_picture_form">
			<br />
			<label for="plik">Plik: </label>
			<input type="file" name="plik" id="plik" value="" />
		</span>
	</div>
	<div>
		<input type="radio" name="zdjecie" value="link" id="picture_link" required onchange="toggleDisplay(this.value)" /> Podaj link do zdjęcia
		<span id="picture_link_form">
			<br />
			<label for="link">Link: </label>
			<input type="text" name="link" id="link" value="" size="128" maxlength="128" />
		</span>
	</div>
	<div>
		<input type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<?php
		bottom(array('js/zdjecie_js.js'));
	}
?>
