<?php
	session_start();
	if(user::isLogged()){
		$user = user::getData('', '');
		if(isset($_POST['id'])){
			$DB=dbconnect();
			if($st=$DB->prepare('SELECT * FROM Osoba WHERE id=?')){
				if($st->execute(array($_POST['id']))){
					$row=$st->fetch(PDO::FETCH_ASSOC);
?>
 <ol class="breadcrumb">
  <li><a href="index.php">Start</a></li>
  <li><a href="index.php?menu=100">Zarządzaj użytkownikami</a></li>
    <li class="active">Edytuj użytkownika</li>
</ol>
<form action="index.php?menu=54&amp;id=<?php echo $row['id']; ?>" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded" onsubmit="return ajax_check()">
	<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
	<input type="hidden" name="old_imie" value="<?php echo $row['imie']; ?>" />
	<input type="hidden" name="old_nazwisko" value="<?php echo $row['nazwisko']; ?>" />
	<input type="hidden" name="old_email" id="old_email" value="<?php echo $row['email']; ?>" />
	<div>
		<label for="imie">Imię<span class="color_red">*</span>: </label>
		<input class="form-control" type="text" name="imie" id="imie" value="<?php echo $row['imie']; ?>" size="16" maxlength="16" required="required" />
		<span id="imie_counter"></span>
	</div>
	<div><br>
		<label for="nazwisko">Nazwisko<span class="color_red">*</span>: </label>
		<input class="form-control" type="text" name="nazwisko" id="nazwisko" value="<?php echo $row['nazwisko']; ?>" size="32" maxlength="32" required="required" />
		<span id="nazwisko_counter"></span>
	</div>
	<div><br>
		<label for="email">Adres e-mail<span class="color_red">*</span>: </label>
		<input class="form-control" type="email" name="email" id="email" value="<?php echo $row['email']; ?>" size="32" maxlength="254" onchange="check_email_2()" required="required" />
		<span id="email_counter"></span>
	</div>
	<div><br>
		<input class="btn btn-primary" type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<span class="color_red">*</span> - wymagane pola.
<?php
					foreach(array('js/ask_db.js','js/remaining_char_counter.js','js/check_email.js','js/osoba_form_edit.js') as $script){
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
			echo 'Nie podano osoby do edycji.';
			
		}
	}
	else {
		echo '<br>Nie jesteś zalogowany.<br />
		<a href="login.php">Zaloguj się</a><br><br> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
		bottom();
	}
?>
