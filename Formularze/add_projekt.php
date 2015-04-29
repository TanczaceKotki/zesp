<?php
	session_start();
	require 'user.class.php';
	require 'common.php';
	require 'DB.php';
	top();
	$displayform=True;
	if(user::isLogged()){
		$user = user::getData('', '');
		if(isset($_POST['submitted'])){
			$DB=dbconnect();
			$params=array($_POST['nazwa']);
			$params[]=$_POST['data_rozp_rok'];
			if($_POST['data_rozp_miesiac']!==""){
				$params[1].='-'.$_POST['data_rozp_miesiac'];
				if($_POST['data_rozp_dzien']!=="") $params[1].='-'.$_POST['data_rozp_dzien'];
			}
			$sql='INSERT INTO Projekt VALUES(NULL,?,?,';
			if($_POST['data_zakoncz_rok']===""){
				$sql.='NULL,?,?)';
			}
			else{
				$sql.='?,?,?)';
				$params[]=$_POST['data_zakoncz_rok'];
				if($_POST['data_zakoncz_miesiac']!==""){
					$params[2].='-'.$_POST['data_zakoncz_miesiac'];
					if($_POST['data_zakoncz_dzien']!=="") $params[2].='-'.$_POST['data_zakoncz_dzien'];
				}
			}
			$params[]=$_POST['opis'];
			$params[]=$_POST['logo'];
			if($st=$DB->prepare($sql)){
				if($st->execute($params)){
					echo 'Projekt został pomyślnie wstawiony.<br /><br /><a href="index.php">Wróć do strony głównej.</a>';
					$displayform=False;
					bottom();
				}
				else{
					echo 'Nastąpił błąd przy dodawaniu projektu: '.implode(' ',$st->errorInfo()).'<br /><br />';
				}
			}
			else{
				echo 'Nastąpił błąd przy dodawaniu projektu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
			}
		}
		if($displayform){
?>
<form action="add_projekt.php" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
	<div>
		<label for="nazwa">Nazwa<span class="color_red">*</span>: </label>
		<input type="text" name="nazwa" id="nazwa" value="<?php if(isset($_POST['nazwa'])) echo $_POST['nazwa']; ?>" size="64" maxlength="64" spellcheck="true" required="required" />
		<span id="nazwa_counter"></span>
	</div>
	<div>
		<fieldset>
			<legend>Data rozpoczęcia</legend>
			<label for="data_rozp_dzien">Dzień: </label>
			<select name="data_rozp_dzien" id="data_rozp_dzien" onchange="date_callback('data_rozp_dzien','data_rozp_miesiac','data_rozp_rok','data_zakoncz_dzien','data_zakoncz_miesiac','data_zakoncz_rok')">
				<option value=""<?php if(!isset($_POST['data_rozp_dzien'])) echo ' selected="selected"'; elseif($_POST['data_rozp_dzien']==="") echo ' selected="selected"'; ?>>-</option>
				<?php
					for($i=1;$i<32;++$i){
						echo '<option value="'.$i.'"';
						if(isset($_POST['data_rozp_dzien'])){
							if(intval($_POST['data_rozp_dzien'])===$i) echo ' selected="selected"';
						}
						echo '>'.$i.'</option>';
					}
				?>
			</select>
			<label for="data_rozp_miesiac"> Miesiąc: </label>
			<select name="data_rozp_miesiac" id="data_rozp_miesiac" onchange="date_callback('data_rozp_dzien','data_rozp_miesiac','data_rozp_rok','data_zakoncz_dzien','data_zakoncz_miesiac','data_zakoncz_rok')">
				<option value=""<?php if(!isset($_POST['data_rozp_miesiac'])) echo ' selected="selected"'; elseif($_POST['data_rozp_miesiac']==="") echo ' selected="selected"'; ?>>-</option>
				<?php
					$months=array('styczeń','luty','marzec','kwiecień','maj','czerwiec','lipiec','sierpień','wrzesień','październik','listopad','grudzień');
					for($i=0;$i<12;++$i){
						$val=$i+1;
						echo '<option value="'.$val.'"';
						if(isset($_POST['data_rozp_miesiac'])){
							if(intval($_POST['data_rozp_miesiac'])===$val) echo ' selected="selected"';
						}
						echo '>'.$months[$i].'</option>';
					}
				?>
			</select>
			<label for="data_rozp_rok"> Rok<span class="color_red">*</span>: </label>
			<select name="data_rozp_rok" id="data_rozp_rok" onchange="date_callback('data_rozp_dzien','data_rozp_miesiac','data_rozp_rok','data_zakoncz_dzien','data_zakoncz_miesiac','data_zakoncz_rok')" required="required">
				<option value=""<?php if(!isset($_POST['data_rozp_rok'])) echo ' selected="selected"'; elseif($_POST['data_rozp_rok']==="") echo ' selected="selected"'; ?>>-</option>
				<?php
					$curdecade=(intval(date('Y'))+1)-(intval(date('Y'))+1)%10;
					echo '<optgroup label="'.$curdecade.' - '.(intval(date('Y'))+1).'">';
					for($i=intval(date('Y'))+1;$i>=1950;--$i){
						if($curdecade!=$i-$i%10){
							$curdecade=$i-$i%10;
							echo '</optgroup><optgroup label="'.$curdecade.' - '.($curdecade+9).'">';
						}
						echo '<option value="'.$i.'"';
						if(isset($_POST['data_rozp_rok'])){
							if(intval($_POST['data_rozp_rok'])===$i) echo ' selected="selected"';
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
			<legend>Data zakończenia</legend>
			<label for="data_zakoncz_dzien">Dzień: </label>
			<select name="data_zakoncz_dzien" id="data_zakoncz_dzien" onchange="date_callback('data_rozp_dzien','data_rozp_miesiac','data_rozp_rok','data_zakoncz_dzien','data_zakoncz_miesiac','data_zakoncz_rok')">
				<option value=""<?php if(!isset($_POST['data_zakoncz_dzien'])) echo ' selected="selected"'; elseif($_POST['data_zakoncz_dzien']==="") echo ' selected="selected"'; ?>>-</option>
				<?php
					for($i=1;$i<32;++$i){
						echo '<option value="'.$i.'"';
						if(isset($_POST['data_zakoncz_dzien'])){
							if(intval($_POST['data_zakoncz_dzien'])===$i) echo ' selected="selected"';
						}
						echo '>'.$i.'</option>';
					}
				?>
			</select>
			<label for="data_zakoncz_miesiac"> Miesiąc: </label>
			<select name="data_zakoncz_miesiac" id="data_zakoncz_miesiac" onchange="date_callback('data_rozp_dzien','data_rozp_miesiac','data_rozp_rok','data_zakoncz_dzien','data_zakoncz_miesiac','data_zakoncz_rok')">
				<option value=""<?php if(!isset($_POST['data_zakoncz_miesiac'])) echo ' selected="selected"'; elseif($_POST['data_zakoncz_miesiac']==="") echo ' selected="selected"'; ?>>-</option>
				<?php
					$months=array('styczeń','luty','marzec','kwiecień','maj','czerwiec','lipiec','sierpień','wrzesień','październik','listopad','grudzień');
					for($i=0;$i<12;++$i){
						$val=$i+1;
						echo '<option value="'.$val.'"';
						if(isset($_POST['data_zakoncz_miesiac'])){
							if(intval($_POST['data_zakoncz_miesiac'])===$val) echo ' selected="selected"';
						}
						echo '>'.$months[$i].'</option>';
					}
				?>
			</select>
			<label for="data_zakoncz_rok"> Rok: </label>
			<select name="data_zakoncz_rok" id="data_zakoncz_rok" onchange="date_callback('data_rozp_dzien','data_rozp_miesiac','data_rozp_rok','data_zakoncz_dzien','data_zakoncz_miesiac','data_zakoncz_rok')">
				<option value=""<?php if(!isset($_POST['data_zakoncz_rok'])) echo ' selected="selected"'; elseif($_POST['data_zakoncz_rok']==="") echo ' selected="selected"'; ?>>-</option>
				<?php
					$curdecade=(intval(date('Y'))+1)-(intval(date('Y'))+1)%10;
					echo '<optgroup label="'.$curdecade.' - '.(intval(date('Y'))+1).'">';
					for($i=intval(date('Y'))+1;$i>=1950;--$i){
						if($curdecade!=$i-$i%10){
							$curdecade=$i-$i%10;
							echo '</optgroup><optgroup label="'.$curdecade.' - '.($curdecade+9).'">';
						}
						echo '<option value="'.$i.'"';
						if(isset($_POST['data_zakoncz_rok'])){
							if(intval($_POST['data_zakoncz_rok'])===$i) echo ' selected="selected"';
						}
						echo '>'.$i.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>';
					}
					echo '</optgroup>';
				?>
			</select>
		</fieldset>
	</div>
	<div>
		<label for="opis">Opis<span class="color_red">*</span>: </label>
		<textarea name="opis" id="opis" rows="20" cols="100" maxlength="166666666" spellcheck="true" required="required"><?php if(isset($_POST['opis'])) echo $_POST['opis']; ?></textarea>
		<span id="opis_counter"></span>
	</div>
	<div>
		<label for="logo">Logo<span class="color_red">*</span>: </label>
		<input type="text" name="logo" id="logo" value="<?php if(isset($_POST['logo'])) echo $_POST['logo']; ?>" size="100" maxlength="128" required="required" />
		<span id="logo_counter"></span>
	</div>
	<div>
		<input type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<span class="color_red">*</span> - wymagane pola.
<?php
			bottom(array('js/date_callback.js','https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js','js/js-webshim/minified/polyfiller.js','js/remaining_char_counter.js','js/projekt_form.js'));
		}
	}
	else {
		echo '<br>Nie jesteś zalogowany.<br />
		<a href="login.php">Zaloguj się</a><br><br> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
		bottom();
	}
?>
