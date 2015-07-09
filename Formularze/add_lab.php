<?php
	session_start();
	#require 'common.php';
	#require 'DB.php';
	require 'walidacja_danych_php/walidacja.php';
    $displayform=True;
	$DB=dbconnect();
	if(user::isLogged()){
		$user = user::getData('', '');
		if(isset($_POST['submitted'])){
			$walidacja = true;
			if( valid_length($_POST['nazwa'], 64) == false ){
				$walidacja = false;
				echo 'Błędne dane w polu nazwa.<br />';
			}
			if($walidacja and $st=$DB->prepare('INSERT INTO Laboratorium VALUES(NULL,?,?)')){
				if($st->execute(array($_POST['nazwa'],$_POST['zespol']))){
					echo 'Laboratorium zostało pomyślnie wstawione.<br /><br /><a href="index.php?menu=7">Wróć do listy labolatoriów.</a>';
					$displayform=False;
								}
				else{
					echo 'Nastąpił błąd przy dodawaniu laboratorium: '.implode(' ',$st->errorInfo()).'<br /><br />';
				}
			}
			else{
				echo 'Nastąpił błąd przy dodawaniu laboratorium: '.implode(' ',$DB->errorInfo()).'<br /><br />';
			}
		}
		if($displayform){
?>
  <ol class="breadcrumb">
  <li><a href="index.php">Start</a></li>
  <li><a href="index.php?menu=7">Zarządzaj laboratoriami</a></li>
    <li class="active">Dodaj laboratorium</li>
</ol>
<form action="index.php?menu=21" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
	<div>
		<label for="nazwa">Nazwa:<span class="color_red">*</span>: </label>
		<input class="form-control" type="text" name="nazwa" id="nazwa" value="<?php if(isset($_POST['nazwa'])) echo $_POST['nazwa']; ?>" size="64" maxlength="64" spellcheck="true" required="required" />
		<span id="nazwa_counter"></span>
	</div>
	<div><br>
		<label for="zespol">Zespół: </label>
		<select class="form-control" name="zespol" id="zespol">
			<option value=""<?php if(!isset($_POST['zespol'])) echo ' selected="selected"'; ?>>-</option>
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
	<div><br>
		<input class="btn btn-warning" type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<span class="color_red">*</span> - wymagane pola.
<?php
			foreach(array('js/remaining_char_counter.js') as $script){
				echo '<script src="'.$script.'" type="text/javascript"></script>';
			}
		}
	}
	else{
		echo '<br />Nie jesteś zalogowany.<br />
		<a href="login.php">Zaloguj się</a><br /><br /> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
		
			}
?>
