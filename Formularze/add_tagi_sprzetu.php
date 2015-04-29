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
			if($st=$DB->prepare('INSERT INTO Tagi_sprzetu VALUES(?,?)')){
				if($st->execute(array($_POST['sprzet'],$_POST['tag']))){
					echo 'Informacja o tagu sprzętu w zakładzie została pomyślnie wstawiona.<br /><br /><a href="index.php">Wróć do strony głównej.</a>';
					$displayform=False;
					bottom();
				}
				else{
					echo 'Nastąpił błąd przy dodawaniu informacji o tagu sprzętu: '.implode(' ',$st->errorInfo()).'<br /><br />';
				}
			}
			else{
				echo 'Nastąpił błąd przy dodawaniu informacji o tagu sprzętu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
			}
		}
		if($displayform){
?>
<form action="add_tagi_sprzetu.php" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded" onsubmit="return ajax_check()">
	<div>
		<label for="sprzet">Sprzęt<span class="color_red">*</span>: </label>
		<select name="sprzet" id="sprzet" onchange="ask_db_middle_table('tagi_sprzetu',this.value,$('#tag').val(),'Ta informacja o tagu sprzętu jest już w bazie danych.','#tag_error')" required="required">
			<option value=""<?php if(!isset($_POST['sprzet'])) echo ' selected="selected"'; ?>>-</option>
			<?php
				if($result=$DB->query('SELECT id,nazwa FROM Sprzet ORDER BY nazwa')){
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
		<label for="tag">Tag<span class="color_red">*</span>: </label>
		<select name="tag" id="tag" onchange="ask_db_middle_table('tagi_sprzetu',$('#sprzet').val(),this.value,'Ta informacja o tagu sprzętu jest już w bazie danych.','#tag_error')" required="required">
			<option value=""<?php if(!isset($_POST['tag'])) echo ' selected="selected"'; ?>>-</option>
			<?php
				if($result=$DB->query('SELECT id,nazwa FROM Tag ORDER BY nazwa')){
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
							if(isset($_POST['tag'])){
								if($_POST['tag']===$row['id']) echo ' selected="selected"';
							}
							echo '>'.$row['nazwa'].'</option>';
						}
						echo '</optgroup>';
					}
				}
			?>
		</select>
	</div>
	<div id="tag_error"></div>
	<div>
		<input type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<span class="color_red">*</span> - wymagane pola.
<?php
			bottom(array('https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js','js/js-webshim/minified/polyfiller.js','js/ask_db_middle_table.js','js/tagi_sprzetu_form.js'));
		}
	}
	else {
		echo '<br>Nie jesteś zalogowany.<br />
		<a href="login.php">Zaloguj się</a><br><br> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
		bottom();
	}
?>
