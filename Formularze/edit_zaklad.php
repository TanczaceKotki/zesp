<?php
	if(user::isLogged()){
		if($lvl<2){
			$msg="";
			if(isset($_POST['submitted'])){
				if($_POST['nazwa']!==$_POST['old_nazwa']){
					if($st=$DB->prepare('UPDATE Zaklad SET nazwa=? WHERE id=?')){
						if($st->execute(array($_POST['nazwa'],$_POST['id']))){
							header('Location:index.php?menu=61&id='.$_POST['id']);
							die();
						}
						else $msg='<p>Nastąpił błąd przy modyfikowaniu zakładu: '.implode(' ',$st->errorInfo()).'</p>';
					}
					else $msg='<p>Nastąpił błąd przy modyfikowaniu zakładu: '.implode(' ',$DB->errorInfo()).'</p>';
				}
			}
			if(isset($_POST['id'])){
				if($st=$DB->prepare('SELECT * FROM Zaklad WHERE id=?')){
					if($st->execute(array($_POST['id']))){
						if($row=$st->fetch(PDO::FETCH_ASSOC)){
							breadcrumbs('Edytowanie zakładu',array('index.php?menu=66' => 'Zarządzanie zakładami',"index.php?menu=61&amp;id=$_POST[id]" => 'Szczegóły zakładu'));
							echo "<h1 class=\"font20\">Edytowanie słowa kluczowego</h1>$msg";
?>
<form action="index.php?menu=48" method="post" accept-charset="utf-8" enctype="application/x-www-form-urlencoded">
	<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
	<input type="hidden" name="old_nazwa" value="<?php echo $row['nazwa']; ?>" />
	<label>Nazwa<span class="color_red">*</span>:</label>
	<input class="form-control" type="text" name="nazwa" id="nazwa" value="<?php echo $row['nazwa']; ?>" size="64" maxlength="64" spellcheck="true" required="required" />
	<div id="nazwa_counter"></div>
	<div class="margin_top_10">
		<input class="btn btn-warning" type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<p class="margin_top_10"><span class="color_red">*</span> - wymagane pola.</p>
<script src="js/remaining_char_counter.js" type="text/javascript"></script>
<?php
						}
						else{
							breadcrumbs('Edytowanie zakładu',array('index.php?menu=66' => 'Zarządzanie zakładami'));
							echo '<h1 class="font20">Błąd</h1><p>Nie znaleziono zakładu o podanym identyfikatorze.</p>';
						}
					}
					else{
						breadcrumbs('Edytowanie zakładu',array('index.php?menu=66' => 'Zarządzanie zakładami'));
						echo '<h1 class="font20">Błąd</h1><p>Nie udało się pobrać danych z bazy danych: '.implode(' ',$st->errorInfo()).'</p>';
					}
				}
				else{
					breadcrumbs('Edytowanie zakładu',array('index.php?menu=66' => 'Zarządzanie zakładami'));
					echo '<h1 class="font20">Błąd</h1><p>Nie udało się pobrać danych z bazy danych: '.implode(' ',$DB->errorInfo()).'</p>';
				}
			}
			else{
				breadcrumbs('Edytowanie zakładu',array('index.php?menu=66' => 'Zarządzanie zakładami'));
				echo '<h1 class="font20">Błąd</h1><p>Nie podano zakładu do edycji.</p>';
			}
		}
		else require 'mod_cred_req.php';
	}
	else require 'not_logged_in.php';
?>
