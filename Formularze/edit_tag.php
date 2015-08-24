<?php
	if(user::isLogged()){
		if($lvl<2){
			$msg="";
			if(isset($_POST['submitted'])){
				if($_POST['nazwa']!==$_POST['old_nazwa']){
					if($st=$DB->prepare('UPDATE Tag SET nazwa=? WHERE id=?')){
						if($st->execute(array($_POST['nazwa'],$_POST['id']))){
							header('Location:index.php?menu=60&id='.$_POST['id']);
							die();
						}
						else $msg='<p>Nastąpił błąd przy modyfikowaniu słowa kluczowego: '.implode(' ',$st->errorInfo()).'</p>';
					}
					else $msg='<p>Nastąpił błąd przy modyfikowaniu słowa kluczowego: '.implode(' ',$DB->errorInfo()).'</p>';
				}
			}
			if(isset($_POST['id'])){
				if($st=$DB->prepare('SELECT * FROM Tag WHERE id=?')){
					if($st->execute(array($_POST['id']))){
						if($row=$st->fetch(PDO::FETCH_ASSOC)){
							breadcrumbs('Edytowanie słowa kluczowego',array('index.php?menu=67' => 'Zarządzanie słowami kluczowymi',"index.php?menu=60&amp;id=$_POST[id]" => 'Szczegóły słowa kluczowego'));
							echo "<h1 class=\"font20\">Edytowanie słowa kluczowego</h1>$msg";
?>
<form action="index.php?menu=46" method="post" accept-charset="utf-8" enctype="application/x-www-form-urlencoded" onsubmit="return ajax_check()">
	<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
	<input type="hidden" name="old_nazwa" id="old_nazwa" value="<?php echo $row['nazwa']; ?>" />
	<label for="nazwa">Nazwa<span class="color_red">*</span>: </label>
	<input class="form-control" type="text" name="nazwa" id="nazwa" value="<?php echo $row['nazwa']; ?>" size="32" maxlength="32" spellcheck="true" onchange="check_tag_2()" required="required" />
	<div id="nazwa_counter"></div>
	<div class="margin_top_10">
		<input class="btn btn-primary" type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<p class="margin_top_10"><span class="color_red">*</span> - wymagane pola.</p>
<?php
							foreach(array('js/ask_db.js','js/remaining_char_counter.js','js/check_tag.js','js/tag_form_edit.js') as $script){
								echo '<script src="'.$script.'" type="text/javascript"></script>';
							}
						}
						else{
							breadcrumbs('Edytowanie słowa kluczowego',array('index.php?menu=67' => 'Zarządzanie słowami kluczowymi'));
							echo '<h1 class="font20">Błąd</h1><p>Nie znaleziono słowa kluczowego o podanym identyfikatorze.</p>';
						}
					}
					else{
						breadcrumbs('Edytowanie słowa kluczowego',array('index.php?menu=67' => 'Zarządzanie słowami kluczowymi'));
						echo '<h1 class="font20">Błąd</h1><p>Nie udało się pobrać danych z bazy danych: '.implode(' ',$st->errorInfo()).'</p>';
					}
				}
				else{
					breadcrumbs('Edytowanie słowa kluczowego',array('index.php?menu=67' => 'Zarządzanie słowami kluczowymi'));
					echo '<h1 class="font20">Błąd</h1><p>Nie udało się pobrać danych z bazy danych: '.implode(' ',$DB->errorInfo()).'</p>';
				}
			}
			else{
				breadcrumbs('Edytowanie słowa kluczowego',array('index.php?menu=67' => 'Zarządzanie słowami kluczowymi'));
				echo '<h1 class="font20">Błąd</h1><p>Nie podano słowa kluczowego do edycji.</p>';
			}
		}
		else require 'mod_cred_req.php';
	}
	else require 'not_logged_in.php';
?>
