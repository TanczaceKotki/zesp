 <?php
    $displayform=True;
	if(user::isLogged()){
		if($lvl<2){
			breadcrumbs('Nowe laboratorium',array('index.php?menu=7' => 'Zarządzanie laboratoriami'));
			echo '<h1 class="font20">Nowe laboratorium</h1>';
			if(isset($_POST['submitted'])){
				require 'walidacja_danych_php/walidacja.php';
				$walidacja=true;
				$err_msg='<section><h2 class="font17">W przesłanych danych wystąpiły następujące błędy:</h2><ul class="error_list">';
				if( valid_length($_POST['nazwa'], 64) == false ){
					$walidacja = false;
					echo '<li>Błędne dane w polu nazwa.</li>';
				}
				if($walidacja){
					if($st=$DB->prepare('INSERT INTO Laboratorium VALUES(NULL,?,?)')){
						if($st->execute(array($_POST['nazwa'],$_POST['zespol']))){
							echo '<p>Laboratorium zostało pomyślnie wstawione.</p><p><a href="index.php?menu=7">Wróć do strony zarządzania laboratoriami.</a></p>';
							$displayform=False;
						}
						else{
							echo '<p>Nastąpił błąd przy dodawaniu laboratorium: '.implode(' ',$st->errorInfo()).'</p>';
						}
					}
					else{
						echo '<p>Nastąpił błąd przy dodawaniu laboratorium: '.implode(' ',$DB->errorInfo()).'</p>';
					}
				}
				else echo "$err_msg</ul></section>";
			}
			if($displayform){
?>
<form action="index.php?menu=21" method="post" accept-charset="utf-8" enctype="application/x-www-form-urlencoded">
	<label for="nazwa">Nazwa:<span class="color_red">*</span>: </label>
	<input class="form-control" type="text" name="nazwa" id="nazwa" value=" <?php if(isset($_POST['nazwa'])) echo $_POST['nazwa']; ?>" size="64" maxlength="64" spellcheck="true" required="required" />
	<div id="nazwa_counter"></div>
	<div class="margin_top_10">
		<label for="zespol">Zespół: </label>
		<select class="form-control" name="zespol" id="zespol">
			<option value="" <?php if(!isset($_POST['zespol'])) echo ' selected="selected"'; ?>>-</option>
			 <?php
				if($result=$DB->query('SELECT id,nazwa FROM Zespol ORDER BY nazwa')){
					if($rows=$result->fetchAll(PDO::FETCH_ASSOC)){
						$first_letter=$rows[0]['nazwa'][0];
						echo '<optgroup label="'.$first_letter.'">';
						foreach($rows as $row){
							if($first_letter!==$row['nazwa'][0]){
								$first_letter=$row['nazwa'][0];
								echo '</optgroup><optgroup label="'.$first_letter.'">';
							}
							echo '<option value="'.$row['id'].'"';
							if(isset($_POST['zespol'])){
								if($_POST['zespol']===$row['id']) echo ' selected="selected"';
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
<script src="js/remaining_char_counter.js" type="text/javascript"></script>
 <?php
			}
		}
		else require 'mod_cred_req.php';
	}
	else require 'not_logged_in.php';
?>
