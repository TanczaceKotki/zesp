<?php
	$displayform=True;
	if(user::isLogged()){
		if($lvl<2){
			breadcrumbs('Nowe laboratorium w zakładzie');
			echo '<h1 class="font20">Nowe laboratorium w zakładzie</h1>';
			if(isset($_POST['submitted'])){
				if($st=$DB->prepare('INSERT INTO Laborat_w_zaklad VALUES(?,?)')){
					if($st->execute(array($_POST['zaklad'],$_POST['laboratorium']))){
						echo '<p>Informacja o laboratorium w zakładzie została pomyślnie wstawiona.</p><p><a href="index.php?menu=7">Wróć do strony zarządzania laboratorium.</a></p><p><a href="index.php?menu=66">Wróć do strony zarządzania zakładami.</a></p>';
						$displayform=False;
					}
					else{
						echo '<p>Nastąpił błąd przy dodawaniu informacji o laboratorium w zakładzie: '.implode(' ',$st->errorInfo()).'</p>';
					}
				}
				else{
					echo '<p>Nastąpił błąd przy dodawaniu informacji o laboratorium w zakładzie: '.implode(' ',$DB->errorInfo()).'</p>';
				}
			}
			if($displayform){
?>
<form action="index.php?menu=22" method="post" accept-charset="utf-8" enctype="application/x-www-form-urlencoded" onsubmit="return ajax_check()">
	<label for="laboratorium">Laboratorium:<span class="color_red">*</span>:</label>
	<select class="form-control" name="laboratorium" id="laboratorium" onchange="ask_db_middle_table('laborat_w_zaklad',this.value,$('#zaklad').val(),'Ta informacja o laboratorium w zakładzie jest już w bazie danych.','#laborat_w_zaklad_error')" required="required">
		<option value=""<?php if(!isset($_POST['laboratorium'])) echo ' selected="selected"'; ?>>-</option>
		<?php
			if($result=$DB->query('SELECT id,nazwa FROM Laboratorium ORDER BY nazwa')){
				if($rows=$result->fetchAll(PDO::FETCH_ASSOC)){
					$first_letter=$rows[0]['nazwa'][0];
					echo '<optgroup label="'.$first_letter.'">';
					foreach($rows as $row){
						if($first_letter!==$row['nazwa'][0]){
							$first_letter=$row['nazwa'][0];
							echo '</optgroup><optgroup label="'.$first_letter.'">';
						}
						echo '<option value="'.$row['id'].'"';
						if(isset($_POST['laboratorium'])){
							if($_POST['laboratorium']===$row['id']) echo ' selected="selected"';
						}
						echo '>'.$row['nazwa'].'</option>';
					}
					echo '</optgroup>';
				}
			}
		?>
	</select>
	<div class="margin_top_10">
		<label for="zaklad">Zakład:<span class="color_red">*</span>:</label>
		<select class="form-control" name="zaklad" id="zaklad" onchange="ask_db_middle_table('laborat_w_zaklad',$('#laboratorium').val(),this.value,'Ta informacja o laboratorium w zakładzie jest już w bazie danych.','#laborat_w_zaklad_error')" required="required">
			<option value=""<?php if(!isset($_POST['zaklad'])) echo ' selected="selected"'; ?>>-</option>
			<?php
				if($result=$DB->query('SELECT id,nazwa FROM Zaklad ORDER BY nazwa')){
					if($rows=$result->fetchAll(PDO::FETCH_ASSOC)){
						$first_letter=$rows[0]['nazwa'][0];
						echo '<optgroup label="'.$first_letter.'">';
						foreach($rows as $row){
							if($first_letter!==$row['nazwa'][0]){
								$first_letter=$row['nazwa'][0];
								echo '</optgroup><optgroup label="'.$first_letter.'">';
							}
							echo '<option value="'.$row['id'].'"';
							if(isset($_POST['zaklad'])){
								if($_POST['zaklad']===$row['id']) echo ' selected="selected"';
							}
							echo '>'.$row['nazwa'].'</option>';
						}
						echo '</optgroup>';
					}
				}
			?>
		</select>
	</div>
	<div id="laborat_w_zaklad_error"></div>
	<div class="margin_top_10">
		<input class="btn btn-warning" type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<p class="margin_top_10"><span class="color_red">*</span> - wymagane pola.</p>
<?php
				foreach(array('js/ask_db_middle_table.js','js/laborat_w_zaklad_form.js') as $script){
					echo '<script src="'.$script.'" type="text/javascript"></script>';
				}
			}
		}
		else require 'mod_cred_req.php';
	}
	else require 'not_logged_in.php';
?>
