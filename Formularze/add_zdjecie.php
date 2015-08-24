<?php
	$displayform=True;
	if(user::isLogged()){
		if($lvl<2){
			breadcrumbs('Nowe zdjęcia',array('index.php?menu=12' => 'Zarządzanie zdjęciami'));
			echo '<h1 class="font20">Nowe zdjęcia</h1>';
			if(isset($_POST['submitted'])){
				$no_error=True;
				require 'walidacja_danych_php/walidacja.php';
				$walidacja=true;
				$err_msg='<section><h2 class="font17">W przesłanych danych wystąpiły następujące błędy:</h2><ul class="error_list">';
				$zdj_count=count($_FILES['pliki']['name']);
				for($i=0;$i<$zdj_count;++$i){
					$path = $_FILES['pliki']['tmp_name'][$i];
					if(valid_image($path)===0){
						resize_image($path,800,600);
					}
					else if(valid_image($path)===1){
						$walidacja=False;
						$err_msg.='<li>Plik '.$_FILES['pliki']['name'][$i].' nie jest poprawnym zdjęciem.</li>';
					}
					else if(valid_image($path)===2){
						$walidacja=False;
						$err_msg.='<li>Zdjęcie w pliku '.$_FILES['pliki']['name'][$i].' jest za małe. Minimalna rozdzielczość: 800x600.</li>';
					}
				}
				if($walidacja){
					if($st=$DB->prepare('INSERT INTO Zdjecie VALUES(NULL,?,?)')){
						for($i=0;$i<$zdj_count;++$i){
							$link='z2_'.$_FILES['pliki']['name'][$i];
							move_uploaded_file($_FILES['pliki']['tmp_name'][$i],'uploads/'.$link);
							if($st->execute(array($_POST['sprzet'],$link))){
								echo '<p>Wstawiono zdjęcie '.$_FILES['pliki']['name'][$i].'</p>';
							}
							else{
								echo '<p>Nastąpił błąd przy dodawaniu zdjęcia '.$_FILES['pliki']['name'][$i].': '.implode(' ',$st->errorInfo()).'</p>';
								$no_error=False;
							}
						}
					}
					else{
						echo '<p>Nastąpił błąd przy dodawaniu zdjęć: '.implode(' ',$DB->errorInfo()).'</p>';
						$no_error=False;
					}
				}
				else{
					echo "$err_msg</ul></section>";
					$no_error=False;
				}
				if($no_error){
					echo '<p>Wszystkie zdjęcia zostały pomyślnie wstawione.</p><p><a href="index.php?menu=12">Wróć do strony zarządzania zdjęciami.</a></p>';
					$displayform=False;
				}
			}
			if($displayform){
?>
<form action="index.php?menu=29" method="post" accept-charset="utf-8" enctype="multipart/form-data" onsubmit="return image_check()">
	<label for="sprzet">Sprzęt<span class="color_red">*</span>:</label>
	<select class="form-control" name="sprzet" id="sprzet" required="required">
		<option value=""<?php if(!isset($_POST['sprzet'])) echo ' selected="selected"'; ?>>-</option>
		<?php
			if($result=$DB->query('SELECT id,nazwa FROM Sprzet ORDER BY nazwa')){
				if($rows=$result->fetchAll(PDO::FETCH_ASSOC)){
					$first_letter=$rows[0]['nazwa'][0];
					echo '<optgroup label="'.$first_letter.'">';
					foreach($rows as $row){
						if($first_letter!==$row['nazwa'][0]){
							$first_letter=$row['nazwa'][0];
							echo '</optgroup><optgroup label="'.$first_letter.'">';
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
	<div class="margin_top_10">
		<label for="pliki">Pliki<span class="color_red">*</span>: </label>
		<input type="file" name="pliki[]" id="pliki" onchange="process_images()" multiple="multiple" required="required" />
	</div>
	<div id="img_msg_view"></div>
	<div class="margin_top_10">
		<input class="btn btn-warning" type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<p class="margin_top_10"><span class="color_red">*</span> - wymagane pola.</p>
<script src="js/zdjecie_form.js" type="text/javascript"></script>
<?php
			}
		}
		else require 'mod_cred_req.php';
	}
	else require 'not_logged_in.php';
?>
