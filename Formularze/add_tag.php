<?php
	$displayform=True;
	if(user::isLogged()){
		if($lvl<2){
			breadcrumbs('Nowe słowo kluczowe',array('index.php?menu=67' => 'Zarządzanie słowami kluczowymi'));
			echo '<h1 class="font20">Nowe słowo kluczowe</h1>';
			if(isset($_POST['submitted'])){
				require 'walidacja_danych_php/walidacja.php';
				$walidacja=true;
				$err_msg='<section><h2 class="font17">W przesłanych danych wystąpiły następujące błędy:</h2><ul class="error_list">';
				if( valid_length($_POST['nazwa'], 32) == false ){
					$walidacja=false;
					$err_msg.='<li>Błędne dane w polu nazwa.</li>';
				}
				if($walidacja){
					if($st=$DB->prepare('INSERT INTO Tag VALUES(NULL,?)')){
						if($st->execute(array($_POST['nazwa']))){
							echo '<p>Słowo kluczowe zostało pomyślnie wstawione.</p><p><a href="index.php?menu=67">Wróć do strony zarządzania słowami kluczowymi.</a></p>';
							$displayform=False;
						}
						else echo '<p>Nastąpił błąd przy dodawaniu słowa kluczowego: '.implode(' ',$st->errorInfo()).'</p>';
					}
					else echo '<p>Nastąpił błąd przy dodawaniu słowa kluczowego: '.implode(' ',$DB->errorInfo()).'</p>';
				}
				else echo "$err_msg</ul></section>";
			}
			if($displayform){
?>
<form action="index.php?menu=33" method="post" accept-charset="utf-8" enctype="application/x-www-form-urlencoded" onsubmit="return ajax_check()">
	<label for="nazwa">Słowo kluczowe<span class="color_red">*</span>: </label>
	<input class="form-control" type="text" name="nazwa" id="nazwa" value="<?php if(isset($_POST['nazwa'])) echo $_POST['nazwa']; ?>" size="32" maxlength="32" spellcheck="true" onchange="check_tag()" required="required" />
	<div id="nazwa_counter"></div>
	<div class="margin_top_10">
		<input class="btn btn-warning" type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<p class="margin_top_10"><span class="color_red">*</span> - wymagane pola.</p>
<?php
				foreach(array('js/ask_db.js','js/remaining_char_counter.js','js/check_tag.js','js/tag_form.js') as $script){
					echo '<script src="'.$script.'" type="text/javascript"></script>';
				}
			}
		}
		else require 'mod_cred_req.php';
	}
	else require 'not_logged_in.php';
?>
