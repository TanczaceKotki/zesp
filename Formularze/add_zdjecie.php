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
			$no_error=True;
			if($st=$DB->prepare('INSERT INTO Zdjecie VALUES(NULL,?,?)')){
				for($i=0;$i<count($_FILES['pliki']['name']);++$i){
					$link='z2_'.$_FILES['pliki']['name'][$i];
					move_uploaded_file($_FILES['pliki']['tmp_name'][$i],'uploads/'.$link);
					if($st->execute(array($_POST['sprzet'],$link))){
						echo 'Wstawiono zdjęcie '.$_FILES['pliki']['name'][$i].'<br /><br />';
					}
					else{
						echo 'Nastąpił błąd przy dodawaniu zdjęcia: '.implode(' ',$st->errorInfo()).'<br /><br />';
						$no_error=False;
					}
				}
			}
			else{
				echo 'Nastąpił błąd przy dodawaniu zdjęcia: '.implode(' ',$DB->errorInfo()).'<br /><br />';
				$no_error=False;
			}
			if($no_error){
				echo 'Wszystkie zdjęcia zostały pomyślnie wstawione.<br /><br /><a href="index.php">Wróć do strony głównej.</a>';
				$displayform=False;
				bottom();
			}
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
		<label for="pliki">Pliki<span class="color_red">*</span>: </label>
		<input type="file" name="pliki[]" id="pliki" onchange="process_images()" multiple="multiple" required="required" />
	</div>
	<div id="img_msg_view"></div>
	<div>
		<input type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<span class="color_red">*</span> - wymagane pola.
<?php
			bottom(array('https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js','js/js-webshim/minified/polyfiller.js','js/zdjecie_form.js'));
		}
	}
	else{
		echo '<br />Nie jesteś zalogowany.<br />
		<a href="login.php">Zaloguj się</a><br /><br /> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
		bottom();
	}
?>
