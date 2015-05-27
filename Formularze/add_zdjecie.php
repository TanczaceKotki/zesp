<?php
	session_start();
	require 'user.class.php';
	require 'common.php';
	require 'DB.php';
	top();
	$DB=dbconnect();
	$displayform=True;
	if(user::isLogged()){
		$user = user::getData('', '');
		if(isset($_POST['submitted'])){
			$link='z_'.$_FILES['plik']['name'];
			move_uploaded_file($_FILES['plik']['tmp_name'],'uploads/'.$link);
			if($st=$DB->prepare('INSERT INTO Zdjecie VALUES(NULL,?,?)')){
				if($st->execute(array($_POST['sprzet'],$link))){
					echo 'Zdjęcie zostało pomyślnie wstawione.<br /><br /><a href="index.php">Wróć do strony głównej.</a>';
					$displayform=False;
					bottom();
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
		if($displayform){
?>
<form action="add_zdjecie.php" method="POST" accept-charset="UTF-8" enctype="multipart/form-data" onsubmit="return image_check()">
	<div>
		<label for="sprzet">Sprzęt<span class="color_red">*</span>: </label>
		<select name="sprzet" id="sprzet" required="required">
			<option value=""<?php if(!isset($_POST['sprzet'])) echo ' selected="selected"'; ?>>-</option>
			<?php
				if($result=$DB->query('SELECT id,nazwa FROM Sprzet ORDER BY nazwa')){
					if($rows=$result->fetchAll(PDO::FETCH_ASSOC)){
						$first_letter=$rows[0]['nazwa'][0];
						echo '<optgroup label="'.strtoupper($first_letter).'">';
						foreach($rows as $row){
							if($first_letter!==$row['nazwa'][0]){
								$first_letter=$row['nazwa'][0];
								echo '</optgroup><optgroup label="'.strtoupper($first_letter).'">';
							}
							echo '<option value="'.$row['id'].'"';
							if(isset($_POST['sprzet'])){
								if($_POST['sprzet']===$row['id']) echo ' selected="selected"';
							}
							echo '>'.$row['nazwa'].'</option>';
						}
						echo '</optgroup>';
					}
				}
			?>
		</select>
	</div>
	<div>
		<label for="plik">Plik<span class="color_red">*</span>: </label>
		<input type="file" name="plik" id="plik" onchange="process_image()" required="required" />
	</div>
	<div id="img_msg"></div>
	<img src="#" id="podglad" onerror="img_error()" style="display:none" alt="" />
	<div>
		<input type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<span class="color_red">*</span> - wymagane pola.
<?php
			bottom(array('https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js','js/js-webshim/minified/polyfiller.js','js/zdjecie_form.js'));
		}
	}
	else {
		echo '<br>Nie jesteś zalogowany.<br />
		<a href="login.php">Zaloguj się</a><br><br> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
		bottom();
	}
?>
