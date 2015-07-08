  <ol class="breadcrumb">
  <li><a href="index.php">Start</a></li>
  <li><a href="index.php?menu=9">Zarządzaj zespołami</a></li>
    <li class="active">Edytuj zespół</li>
</ol>
<?php
if(isset($_POST['submitted'])){
		if($_POST['nazwa']!==$_POST['old_nazwa']){
			if($st=$DB->prepare('UPDATE Zespol SET nazwa=? WHERE id=?')){
				if($st->execute(array($_POST['nazwa'],$_POST['id']))) echo 'Zespół został pomyślnie zmodyfikowany.<br /><br />';
				else echo 'Nastąpił błąd przy modyfikowaniu zespołu: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
			else echo 'Nastąpił błąd przy modyfikowaniu zespołu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
	}
		if(isset($_POST['id'])){
			if($st=$DB->prepare('SELECT * FROM Zespol WHERE id=?')){
			if($st->execute(array($_POST['id']))){
				$row=$st->fetch(PDO::FETCH_ASSOC);
?>

<form action="index.php?menu=47" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
	<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
	<input type="hidden" name="old_nazwa" value="<?php echo $row['nazwa']; ?>" />
	<div>
		<label for="nazwa">Nazwa<span class="color_red">*</span>: </label>
		<input class="form-control" type="text" name="nazwa" id="nazwa" value="<?php echo $row['nazwa']; ?>" size="100" maxlength="128" spellcheck="true" required="required" />
		<span id="nazwa_counter"></span>
	</div>
	<div><br>
		<input class="btn btn-primary" type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<span class="color_red">*</span> - wymagane pola.
<?php
				foreach(array('js/jquery-1.11.3.min.js','js/modernizr.js','js/js-webshim/minified/polyfiller.js','js/default_form.js','js/remaining_char_counter.js') as $script){
					echo '<script src="'.$script.'" type="text/javascript"></script>';
				}
			}
			else{
				echo 'Nie udało się pobrać danych z bazy danych: '.implode(' ',$st->errorInfo()).'<br /><br />';
				
			}
		}
		else{
			echo 'Nie udało się pobrać danych z bazy danych: '.implode(' ',$DB->errorInfo()).'<br /><br />';
			
		}
	}
	else{
		echo 'Nie podano zespołu do edycji.';
		
	}
?>
