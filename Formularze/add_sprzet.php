<?php
	session_start();
	require 'user.class.php';
	require 'common.php';
	require 'DB.php';
	require 'walidacja_danych_php/walidacja.php';
	top(array('https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css'));
	$DB=dbconnect();
	$displayform=True;
	if(user::isLogged()){
		$user = user::getData('', '');
		if(isset($_POST['submitted'])){
			$walidacja = true;
			if( valid_length($_POST['nazwa'], 512) == false ){
				$walidacja = false;
				echo 'Błędne dane w polu nazwa.<br/>';
			}
			if( valid_date($_POST['data_zakupu_dzien'].'-'.$_POST['data_zakupu_miesiac'].'-'.$_POST['data_zakupu_rok']) == false ){
				$walidacja = false;
				echo 'Błędne dane w polu data zakupu.<br/>';
			}
			if( valid_date($_POST['data_uruchom_dzien'].'-'.$_POST['data_uruchom_miesiac'].'-'.$_POST['data_uruchom_rok']) == false ){
				$walidacja = false;
				echo 'Błędne dane w polu data uruchomienia.<br/>';
			}
			if( valid_length($_POST['opis'], 166666666) == false ){
				$walidacja = false;
				echo 'Błędne dane w polu opis.<br/>';
			}
			if( $walidacja ){
				$params=array($_POST['nazwa']);
				$params[]=$_POST['data_zakupu_rok'];
				if($_POST['data_zakupu_miesiac']!==""){
					$params[1].='-'.str_pad($_POST['data_zakupu_miesiac'],2,'0',STR_PAD_LEFT);
					if($_POST['data_zakupu_dzien']!=="") $params[1].='-'.str_pad($_POST['data_zakupu_dzien'],2,'0',STR_PAD_LEFT);
				}
				$sql='INSERT INTO Sprzet VALUES(NULL,?,?,';
				if($_POST['data_uruchom_rok']===""){
					$sql.='NULL,';
				}
				else{
					$sql.='?,';
					$params[]=$_POST['data_uruchom_rok'];
					if($_POST['data_uruchom_miesiac']!==""){
						$params[2].='-'.str_pad($_POST['data_uruchom_miesiac'],2,'0',STR_PAD_LEFT);
						if($_POST['data_uruchom_dzien']!=="") $params[2].='-'.str_pad($_POST['data_uruchom_dzien'],2,'0',STR_PAD_LEFT);
					}
				}
				if($_POST['wartosc']===""){
					$sql.='NULL,?,';
				}
				else{
					$sql.='?,?,';
					$params[]=$_POST['wartosc'];
				}
				$params[]=$_POST['opis'];
				if($_POST['projekt']===""){
					$sql.='NULL,';
				}
				else{
					$sql.='?,';
					$params[]=$_POST['projekt'];
				}
				if($_POST['laboratorium']===""){
					$sql.='NULL)';
				}
				else{
					$sql.='?);';
					$params[]=$_POST['laboratorium'];
				}
				if($st=$DB->prepare($sql)){
					if($st->execute($params)){
						echo 'Sprzęt został pomyślnie wstawiony.<br /><br /><a href="index.php">Wróć do strony głównej.</a>';
						$displayform=False;
						bottom();
					}
					else{
						echo 'Nastąpił błąd przy dodawaniu sprzętu: '.implode(' ',$st->errorInfo()).'<br /><br />';
					}
				}
				else{
					echo 'Nastąpił błąd przy dodawaniu sprzętu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
				}
			}
		}
		if($displayform){
?>
<form action="add_sprzet.php" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded" onsubmit="return check_if_number(document.getElementById('wartosc').value)">
	<div>
		<label for="nazwa">Nazwa<span class="color_red">*</span>: </label>
		<input type="text" name="nazwa" id="nazwa" value="<?php if(isset($_POST['nazwa'])) echo $_POST['nazwa']; ?>" size="100" maxlength="512" spellcheck="true" required="required" />
		<span id="nazwa_counter"></span>
	</div>
	<div>
		<fieldset>
			<legend>Data zakupu</legend>
			<label for="data_zakupu_dzien">Dzień: </label>
			<select name="data_zakupu_dzien" id="data_zakupu_dzien">
				<option value=""<?php if(!isset($_POST['data_zakupu_dzien'])) echo ' selected="selected"'; elseif($_POST['data_zakupu_dzien']==="") echo ' selected="selected"'; ?>>-</option>
				<?php
					for($i=1;$i<32;++$i){
						echo '<option value="'.$i.'"';
						if(isset($_POST['data_zakupu_dzien'])){
							if(intval($_POST['data_zakupu_dzien'])===$i) echo ' selected="selected"';
						}
						echo '>'.$i.'</option>';
					}
				?>
			</select>
			<label for="data_zakupu_miesiac"> Miesiąc: </label>
			<select name="data_zakupu_miesiac" id="data_zakupu_miesiac" onchange="day_switch_with_required_year('data_zakupu_dzien','data_zakupu_miesiac','data_zakupu_rok')">
				<option value=""<?php if(!isset($_POST['data_zakupu_miesiac'])) echo ' selected="selected"'; elseif($_POST['data_zakupu_miesiac']==="") echo ' selected="selected"'; ?>>-</option>
				<?php
					$months=array('styczeń','luty','marzec','kwiecień','maj','czerwiec','lipiec','sierpień','wrzesień','październik','listopad','grudzień');
					for($i=0;$i<12;++$i){
						$val=$i+1;
						echo '<option value="'.$val.'"';
						if(isset($_POST['data_zakupu_miesiac'])){
							if(intval($_POST['data_zakupu_miesiac'])===$val) echo ' selected="selected"';
						}
						echo '>'.$months[$i].'</option>';
					}
				?>
			</select>
			<label for="data_zakupu_rok"> Rok<span class="color_red">*</span>: </label>
			<select name="data_zakupu_rok" id="data_zakupu_rok" onchange="day_switch_with_required_year('data_zakupu_dzien','data_zakupu_miesiac','data_zakupu_rok')" required="required">
				<option value=""<?php if(!isset($_POST['data_zakupu_rok'])) echo ' selected="selected"'; elseif($_POST['data_zakupu_rok']==="") echo ' selected="selected"'; ?>>-</option>
				<?php
					$curdecade=(intval(date('Y'))+1)-(intval(date('Y'))+1)%10;
					echo '<optgroup label="'.$curdecade.' - '.(intval(date('Y'))+1).'">';
					for($i=intval(date('Y'))+1;$i>=1950;--$i){
						if($curdecade!=$i-$i%10){
							$curdecade=$i-$i%10;
							echo '</optgroup><optgroup label="'.$curdecade.' - '.($curdecade+9).'">';
						}
						echo '<option value="'.$i.'"';
						if(isset($_POST['data_zakupu_rok'])){
							if(intval($_POST['data_zakupu_rok'])===$i) echo ' selected="selected"';
						}
						echo '>'.$i.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>';
					}
					echo '</optgroup>';
				?>
			</select>
		</fieldset>
	</div>
	<div>
		<fieldset>
			<legend>Data uruchomienia</legend>
			<label for="data_uruchom_dzien">Dzień: </label>
			<select name="data_uruchom_dzien" id="data_uruchom_dzien">
				<option value=""<?php if(!isset($_POST['data_uruchom_dzien'])) echo ' selected="selected"'; elseif($_POST['data_uruchom_dzien']==="") echo ' selected="selected"'; ?>>-</option>
				<?php
					for($i=1;$i<32;++$i){
						echo '<option value="'.$i.'"';
						if(isset($_POST['data_uruchom_dzien'])){
							if(intval($_POST['data_uruchom_dzien'])===$i) echo ' selected="selected"';
						}
						echo '>'.$i.'</option>';
					}
				?>
			</select>
			<label for="data_uruchom_miesiac"> Miesiąc: </label>
			<select name="data_uruchom_miesiac" id="data_uruchom_miesiac" onchange="day_switch_with_optional_year('data_uruchom_dzien','data_uruchom_miesiac','data_uruchom_rok')">
				<option value=""<?php if(!isset($_POST['data_uruchom_miesiac'])) echo ' selected="selected"'; elseif($_POST['data_uruchom_miesiac']==="") echo ' selected="selected"'; ?>>-</option>
				<?php
					$months=array('styczeń','luty','marzec','kwiecień','maj','czerwiec','lipiec','sierpień','wrzesień','październik','listopad','grudzień');
					for($i=0;$i<12;++$i){
						$val=$i+1;
						echo '<option value="'.$val.'"';
						if(isset($_POST['data_uruchom_miesiac'])){
							if(intval($_POST['data_uruchom_miesiac'])===$val) echo ' selected="selected"';
						}
						echo '>'.$months[$i].'</option>';
					}
				?>
			</select>
			<label for="data_uruchom_rok"> Rok: </label>
			<select name="data_uruchom_rok" id="data_uruchom_rok" onchange="day_switch_with_optional_year('data_uruchom_dzien','data_uruchom_miesiac','data_uruchom_rok')">
				<option value=""<?php if(!isset($_POST['data_uruchom_rok'])) echo ' selected="selected"'; elseif($_POST['data_uruchom_rok']==="") echo ' selected="selected"'; ?>>-</option>
				<?php
					$curdecade=(intval(date('Y'))+1)-(intval(date('Y'))+1)%10;
					echo '<optgroup label="'.$curdecade.' - '.(intval(date('Y'))+1).'">';
					for($i=intval(date('Y'))+1;$i>=1950;--$i){
						if($curdecade!=$i-$i%10){
							$curdecade=$i-$i%10;
							echo '</optgroup><optgroup label="'.$curdecade.' - '.($curdecade+9).'">';
						}
						echo '<option value="'.$i.'"';
						if(isset($_POST['data_uruchom_rok'])){
							if(intval($_POST['data_uruchom_rok'])===$i) echo ' selected="selected"';
						}
						echo '>'.$i.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>';
					}
					echo '</optgroup>';
				?>
			</select>
		</fieldset>
	</div>
	<div>
		<label for="wartosc">Wartość: </label>
		<input type="number" name="wartosc" id="wartosc" value="<?php if(isset($_POST['wartosc'])) echo $_POST['wartosc']; ?>" min="0" step="1" max="9223372036854775807" maxlength="19" size="19" onchange="check_if_number(this.value)" />gr
		<div id="numerror"></div>
	</div>
	<div>
		<label for="opis">Opis<span class="color_red">*</span>: </label>
		<textarea name="opis" id="opis" rows="20" cols="100" maxlength="166666666" spellcheck="true" required="required"><?php if(isset($_POST['opis'])) echo $_POST['opis']; ?></textarea>
		<span id="opis_counter"></span>
	</div>
	<div>
		<label for="projekt">Projekt: </label>
		<select name="projekt" id="projekt">
			<option value=""<?php if(!isset($_POST['projekt'])) echo ' selected="selected"'; ?>>-</option>
			<?php
				if($result=$DB->query("SELECT id,nazwa FROM Projekt ORDER BY nazwa")){
					if($rows=$result->fetchAll(PDO::FETCH_ASSOC)){
						$first_letter=$rows[0]['nazwa'][0];
						echo '<optgroup label="'.strtoupper($first_letter).'">';
						foreach($rows as $row){
							if($first_letter!==$row['nazwa'][0]){
								$first_letter=$row['nazwa'][0];
								echo '</optgroup><optgroup label="'.strtoupper($first_letter).'">';
							}
							echo '<option value="'.$row['id'].'"';
							if(isset($_POST['projekt'])){
								if($_POST['projekt']===$row['id']) echo ' selected="selected"';
							}
							echo '>'.$row['nazwa'].'</option>';
						}
						echo '</optgroup>';
					}
				}
			?>
		</select>
	</div>
	<div>
		<label for="laboratorium">Laboratorium: </label>
		<select name="laboratorium" id="laboratorium">
			<option value=""<?php if(!isset($_POST['laboratorium'])) echo ' selected="selected"'; ?>>-</option>
			<?php
				if($result=$DB->query('SELECT id,nazwa FROM Laboratorium ORDER BY nazwa')){
					if($rows=$result->fetchAll(PDO::FETCH_ASSOC)){
						sort($rows);
						$first_letter=$rows[0]['nazwa'][0];
						echo '<optgroup label="'.strtoupper($first_letter).'">';
						foreach($rows as $row){
							if($first_letter!==$row['nazwa'][0]){
								$first_letter=$row['nazwa'][0];
								echo '</optgroup><optgroup label="'.strtoupper($first_letter).'">';
							}
							echo '<option value="'.$row['id'].'"';
							if(isset($_POST['laboratorium'])){
								if($_POST['laboratorium']===$row['id']) echo ' selected="selected"';
							}
							echo '>'.$row['nazwa'].'</option>';
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
			bottom(array('js/day_switch.js','https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js','https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js','js/modernizr.js','js/js-webshim/minified/polyfiller.js','js/remaining_char_counter.js','js/sprzet_form.js'));
		}
	}
	else {
		echo '<br>Nie jesteś zalogowany.<br />
		<a href="login.php">Zaloguj się</a><br><br> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
		bottom();
	}
?>
