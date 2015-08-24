<?php
	$displayform=True;
	if(user::isLogged()){
		if($lvl<2){
			breadcrumbs('Nowy tag sprzętu',array());
			echo '<h1 class="font20">Nowy tag sprzętu</h1>';
			if(isset($_POST['submitted'])){
				if($st=$DB->prepare('INSERT INTO Tagi_sprzetu VALUES(?,?)')){
					if($st->execute(array($_POST['sprzet'],$_POST['tag']))){
						echo '<p>Informacja o słowie kluczowym aparatury została pomyślnie wstawiona</p><p><a href="index.php?menu=8">Wróć do strony zarządzania aparaturą</a></p>';
						$displayform=False;
					}
					else echo '<p>Nastąpił błąd przy dodawaniu informacji o tagu sprzętu: '.implode(' ',$st->errorInfo()).'</p>';
				}
				else echo '<p>Nastąpił błąd przy dodawaniu informacji o tagu sprzętu: '.implode(' ',$DB->errorInfo()).'</p>';
			}
			if($displayform){
?>
<form action="index.php?menu=32" method="post" accept-charset="utf-8" enctype="application/x-www-form-urlencoded" onsubmit="return ajax_check()">
	<label for="sprzet">Aparatura<span class="color_red">*</span>:</label>
	<select class="form-control" name="sprzet" id="sprzet" onchange="ask_db_middle_table('tagi_sprzetu','#tag','#sprzet','Ta informacja o słowie kluczowym sprzętu jest już w bazie danych.')" required="required">
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
		<label for="tag">Słowo kluczowe<span class="color_red">*</span>:</label>
		<select class="form-control" name="tag" id="tag" onchange="ask_db_middle_table('tagi_sprzetu','#tag','#sprzet','Ta informacja o słowie kluczowym sprzętu jest już w bazie danych.')" required="required">
			<option value=""<?php if(!isset($_POST['tag'])) echo ' selected="selected"'; ?>>-</option>
			<?php
				if($result=$DB->query('SELECT id,nazwa FROM Tag ORDER BY nazwa')){
					if($rows=$result->fetchAll(PDO::FETCH_ASSOC)){
						$first_letter=$rows[0]['nazwa'][0];
						echo '<optgroup label="'.$first_letter.'">';
						foreach($rows as $row){
							if($first_letter!==$row['nazwa'][0]){
								$first_letter=$row['nazwa'][0];
								echo '</optgroup><optgroup label="'.$first_letter.'">';
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
	<div class="margin_top_10">
		<input class="btn btn-warning" type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<p class="margin_top_10"><span class="color_red">*</span> - wymagane pola.</p>
<?php
				foreach(array('js/ask_db_middle_table.js','js/tagi_sprzetu_form.js') as $script){
					echo '<script src="'.$script.'" type="text/javascript"></script>';
				}
			}
		}
		else require 'mod_cred_req.php';
	}
	else require 'not_logged_in.php';
?>
