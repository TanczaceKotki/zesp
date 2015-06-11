<?php
	session_start();
	require 'user.class.php';
	require 'common.php';
	require 'DB.php';
	top();
	$displayform=True;
	$DB=dbconnect();
	if(user::isLogged()){
		$user = user::getData('', '');
		if(isset($_POST['submitted'])){
			if($st=$DB->prepare('INSERT INTO Laborat_w_zaklad VALUES(?,?)')){
				if($st->execute(array($_POST['laboratorium'],$_POST['zaklad']))){
					echo 'Informacja o laboratorium w zakładzie została pomyślnie wstawiona.<br /><br /><a href="index.php">Wróć do strony głównej.</a>';
					$displayform=False;
					bottom();
				}
				else{
					echo 'Nastąpił błąd przy dodawaniu informacji o laboratorium w zakładzie: '.implode(' ',$st->errorInfo()).'<br /><br />';
				}
			}
			else{
				echo 'Nastąpił błąd przy dodawaniu informacji o laboratorium w zakładzie: '.implode(' ',$DB->errorInfo()).'<br /><br />';
			}
		}
		if($displayform){
?>
<form action="add_laborat_w_zaklad.php" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded" onsubmit="return ajax_check()">
	<div>
		<label for="laboratorium">Laboratorium<span class="color_red">*</span>: </label>
		<select name="laboratorium" id="laboratorium" onchange="ask_db_middle_table('laborat_w_zaklad',this.value,$('#zaklad').val(),'Ta informacja o laboratorium w zakładzie jest już w bazie danych.','#laborat_w_zaklad_error')" required="required">
			<option value=""<?php if(!isset($_POST['laboratorium'])) echo ' selected="selected"'; ?>>-</option>
			<?php
				if($result=$DB->query('SELECT id,nazwa FROM Laboratorium ORDER BY nazwa')){
					if($rows=$result->fetchAll(PDO::FETCH_ASSOC)){
						sort($rows);
						$first_letter=$rows[0]['nazwa'][0];
						echo '<optgroup label="'.strtoupper($first_letter).'">';
						foreach($rows as $row){
							if($first_letter!==$row['nazwa'][0]){
								$first_letter=$row['nazwa'][0];
								echo '</optgroup><optgroup label="'.strtoupper($first_letter).'">';
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
	</div>
	<div>
		<label for="zaklad">Zakład<span class="color_red">*</span>: </label>
		<select name="zaklad" id="zaklad" onchange="ask_db_middle_table('laborat_w_zaklad',$('#laboratorium').val(),this.value,'Ta informacja o laboratorium w zakładzie jest już w bazie danych.','#laborat_w_zaklad_error')" required="required">
			<option value=""<?php if(!isset($_POST['zaklad'])) echo ' selected="selected"'; ?>>-</option>
			<?php
				if($result=$DB->query('SELECT id,nazwa FROM Zaklad ORDER BY nazwa')){
					if($rows=$result->fetchAll(PDO::FETCH_ASSOC)){
						sort($rows);
						$first_letter=$rows[0]['nazwa'][0];
						echo '<optgroup label="'.strtoupper($first_letter).'">';
						foreach($rows as $row){
							if($first_letter!==$row['nazwa'][0]){
								$first_letter=$row['nazwa'][0];
								echo '</optgroup><optgroup label="'.strtoupper($first_letter).'">';
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
	<div>
		<input type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<span class="color_red">*</span> - wymagane pola.
<?php
			bottom(array('https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js','js/js-webshim/minified/polyfiller.js','js/ask_db_middle_table.js','js/laborat_w_zaklad_form.js'));
		}
	}
	else {
		echo '<br />Nie jesteś zalogowany.<br />
		<a href="login.php">Zaloguj się</a><br /><br /> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
		bottom();
	}
?>
