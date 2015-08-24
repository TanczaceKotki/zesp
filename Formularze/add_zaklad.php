<?php
	$displayform=True;
	if(user::isLogged()){
		if($lvl<2){
			breadcrumbs('Nowy zakład',array('index.php?menu=66' => 'Zarządzanie zakładami'));
			echo '<h1 class="font20">Nowy zakład</h1>';
			if(isset($_POST['submitted'])){
				require 'walidacja_danych_php/walidacja.php';
				$walidacja=true;
				$err_msg='<section><h2 class="font17">W przesłanych danych wystąpiły następujące błędy:</h2><ul class="error_list">';
				if( valid_length($_POST['nazwa'], 64) == false ){
					$walidacja = false;
					$err_msg.='<li>Błędne dane w polu nazwa.</li>';
				}
				if($walidacja){
					if($st=$DB->prepare('INSERT INTO Zaklad VALUES(NULL,?)')){
						if($st->execute(array($_POST['nazwa']))){
							echo '<p>Zakład został pomyślnie wstawiony.</p><p><a href="index.php?menu=66">Wróć do strony zarządzania zakładami.</a></p>';
							$displayform=False;
						}
						else echo '<p>Nastąpił błąd przy dodawaniu zakładu: '.implode(' ',$st->errorInfo()).'</p>';
					}
					else echo '<p>Nastąpił błąd przy dodawaniu zakładu: '.implode(' ',$DB->errorInfo()).'</p>';
				}
				else echo "$err_msg</ul></section>";
			}
			if($displayform){
?>
<form action="index.php?menu=28" method="post" accept-charset="utf-8" enctype="application/x-www-form-urlencoded">
	<label for="nazwa">Nazwa<span class="color_red">*</span>: </label>
	<input type="text" name="nazwa" id="nazwa" value="<?php if(isset($_POST['nazwa'])) echo $_POST['nazwa']; ?>" size="64" maxlength="64" spellcheck="true" required="required" />
	<div id="nazwa_counter"></div>
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
