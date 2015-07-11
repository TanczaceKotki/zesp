<?php
	if(user::isLogged()){
		if(isset($_POST['submitted'])){
			if($_POST['nazwa']!==$_POST['old_nazwa']){
				if($st=$DB->prepare('UPDATE Zespol SET nazwa=? WHERE id=?')){
					if($st->execute(array($_POST['nazwa'],$_POST['id']))){
						header('Location:index.php?menu=53&id='.$_POST['id']);
						die();
					}
					else echo 'Nastąpił błąd przy modyfikowaniu zespołu: '.implode(' ',$st->errorInfo()).'<br /><br />';
				}
				else echo 'Nastąpił błąd przy modyfikowaniu zespołu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
			}
		}
		if(isset($_POST['id'])){
			if($st=$DB->prepare('SELECT * FROM Zespol WHERE id=?')){
				if($st->execute(array($_POST['id']))){
					if($row=$st->fetch(PDO::FETCH_ASSOC)){
?>
<ol class="breadcrumb">
	<li><a href="index.php">Start</a></li>
	<li><a href="index.php?menu=9">Zarządzanie zespołami laboratoriów</a></li>
	<li><a href="index.php?menu=53&amp;id=<?php echo $_POST['id']; ?>">Szczegóły zespołu laboratoriów</a></li>
	<li class="active">Edytuj zespół laboratoriów</li>
</ol>
<form action="index.php?menu=47" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
	<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
	<input type="hidden" name="old_nazwa" value="<?php echo $row['nazwa']; ?>" />
	<div>
		<label for="nazwa">Nazwa<span class="color_red">*</span>: </label>
		<input class="form-control" type="text" name="nazwa" id="nazwa" value="<?php echo $row['nazwa']; ?>" size="100" maxlength="128" spellcheck="true" required="required" />
		<span id="nazwa_counter"></span>
	</div>
	<div><br />
		<input class="btn btn-warning" type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<span class="color_red">*</span> - wymagane pola.
<script src="js/remaining_char_counter.js" type="text/javascript"></script>
<?php
					}
					else echo 'Nie znaleziono zespołu o podanym identyfikatorze.<br /><br />';
				}
				else echo 'Nie udało się pobrać danych z bazy danych: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
			else echo 'Nie udało się pobrać danych z bazy danych: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
		else echo 'Nie podano zespołu do edycji.';
	}
	else echo '<br />Nie jesteś zalogowany.<br /><a href="index.php?menu=10">Zaloguj się</a><br /><br /> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
?>
