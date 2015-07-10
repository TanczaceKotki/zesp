<?php
	if(user::isLogged()){
		if(isset($_POST['id'])){
			if($st=$DB->prepare('SELECT * FROM Zaklad WHERE id=?')){
				if($st->execute(array($_POST['id']))){
					if($row=$st->fetch(PDO::FETCH_ASSOC){
?>
<ol class="breadcrumb">
	<li><a href="index.php">Start</a></li>
	<li><a href="index.php?menu=61&amp;id=<?php echo $_POST['id']; ?>">Szczegóły zakładu</a></li>
	<li class="active">Edytuj zakład</li>
</ol>
<form action="view_zaklad.php?id=<?php echo $row['id']; ?>" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
	<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
	<input type="hidden" name="old_nazwa" value="<?php echo $row['nazwa']; ?>" />
	<div>
		<label for="nazwa">Nazwa<span class="color_red">*</span>: </label>
		<input type="text" name="nazwa" id="nazwa" value="<?php echo $row['nazwa']; ?>" size="64" maxlength="64" spellcheck="true" required="required" />
		<span id="nazwa_counter"></span>
	</div>
	<div>
		<input class="btn btn-primary" type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<span class="color_red">*</span> - wymagane pola.
<?php
						foreach(array('js/remaining_char_counter.js') as $script){
							echo '<script src="'.$script.'" type="text/javascript"></script>';
						}
					}
					else echo 'Nie znaleziono zakładu o podanym identyfikatorze.<br /><br />';
				}
				else echo 'Nie udało się pobrać danych z bazy danych: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
			else echo 'Nie udało się pobrać danych z bazy danych: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
		else echo 'Nie podano zakładu do edycji.';
	}
	else echo '<br />Nie jesteś zalogowany.<br /><a href="login.php">Zaloguj się</a><br /><br /> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
?>
