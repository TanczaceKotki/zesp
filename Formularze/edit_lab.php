<?php
	session_start();
	require 'user.class.php';
	require 'common.php';
	require 'DB.php';
	top();
	if(user::isLogged()){
		$user = user::getData('', '');
		if(isset($_POST['id'])){
			$DB=dbconnect();
			if($st=$DB->prepare('SELECT * FROM Laboratorium WHERE id=?')){
				if($st->execute(array($_POST['id']))){
					$row=$st->fetch(PDO::FETCH_ASSOC);
?>
<form action="view_lab.php?id=<?php echo $row['id']; ?>" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
	<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
	<input type="hidden" name="old_nazwa" value="<?php echo $row['nazwa']; ?>" />
	<input type="hidden" name="old_zespol" value="<?php echo $row['zespol']; ?>" />
	<div>
		<label for="nazwa">Nazwa<span class="color_red">*</span>: </label>
		<input type="text" name="nazwa" id="nazwa" value="<?php echo $row['nazwa']; ?>" size="16" maxlength="64" required="required" />
		<span id="nazwa_counter"></span>
	</div>
	<div>
		<label for="zespol">Zespół<span class="color_red">*</span>: </label>
		<select name="zespol" id="zespol">
			<option value=""<?php if($row['zespol']==="") echo ' selected="selected"'; ?>>-</option>
			<?php
				if($result=$DB->query('SELECT id,nazwa FROM Zespol ORDER BY nazwa')){
					if($rows=$result->fetchAll(PDO::FETCH_ASSOC)){
						$first_letter=$rows[0]['nazwa'][0];
						echo '<optgroup label="'.strtoupper($first_letter).'">';
						foreach($rows as $row2){
							if($first_letter!==$row2['nazwa'][0]){
								$first_letter=$row2['nazwa'][0];
								echo '</optgroup><optgroup label="'.strtoupper($first_letter).'">';
							}
							echo '<option value="'.$row2['id'].'"';
							if($row['zespol']===$row2['id']) echo ' selected="selected"';
							echo '>'.$row2['nazwa'].'</option>';
						}
						echo '</optgroup>';
					}
				}
			?>
		</select>
	</div>
	<div>
		<input type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<span class="color_red">*</span> - wymagane pola.
<?php
					bottom(array('https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js','js/js-webshim/minified/polyfiller.js','js/remaining_char_counter.js','js/default_form.js'));
				}
				else{
					echo 'Nie udało się pobrać danych z bazy danych: '.implode(' ',$st->errorInfo()).'<br /><br />';
					bottom();
				}
			}
			else{
				echo 'Nie udało się pobrać danych z bazy danych: '.implode(' ',$DB->errorInfo()).'<br /><br />';
				bottom();
			}
		}
		else{
			echo 'Nie podano osoby do edycji.';
			bottom();
		}
	}
	else {
		echo '<br>Nie jesteś zalogowany.<br />
		<a href="login.php">Zaloguj się</a><br><br> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
		bottom();
	}
?>
