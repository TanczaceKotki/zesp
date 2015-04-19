<?php
	session_start();
	require_once 'user.class.php';
	require 'common.php';
	top();
	
	if (user::isLogged()) {
		$user = user::getData('', '');
		$displayform=True;
		if(isset($_POST['submitted'])){
			print_r($_POST);
			require 'DB.php';
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
		<label for="nazwa">Nazwa: </label>
		<input type="text" name="nazwa" id="nazwa" value="<?php if(isset($_POST['nazwa'])) echo $_POST['nazwa']; ?>" size="10" maxlength="512" spellcheck="true" required />
	</div>
	<div>
		Data rozpoczęcia:<br/>
		<label for="data_rozp_dzien">Dzień: </label>
		<select name="data_rozp_dzien" id="data_rozp_dzien">
			<option value=""<?php if(!isset($_POST['data_rozp_dzien'])) echo ' selected'; elseif($_POST['data_rozp_dzien']==="") echo ' selected'; ?>>-</option>
			<?php
				for($i=1;$i<32;++$i){
					echo '<option value="'.str_pad("$i",2,'0',STR_PAD_LEFT).'"';
					if(isset($_POST['data_rozp_dzien'])){
						if($_POST['data_rozp_dzien']===str_pad("$i",2,'0',STR_PAD_LEFT)) echo ' selected';
					}
					echo '>'.$i.'</option>';
				}
			?>
		</select>
		<label for="data_rozp_miesiac"> Miesiąc: </label>
		<select name="data_rozp_miesiac" id="data_rozp_miesiac" onchange="day_switch_with_required_year('data_rozp_miesiac','data_rozp_dzien','data_rozp_rok')">
			<option value=""<?php if(!isset($_POST['data_rozp_miesiac'])) echo ' selected'; elseif($_POST['data_rozp_miesiac']==="") echo ' selected'; ?>>-</option>
			<?php
				$months=array('styczeń','luty','marzec','kwiecień','maj','czerwiec','lipiec','sierpień','wrzesień','październik','listopad','grudzień');
				for($i=0;$i<12;++$i){
					$val=$i+1;
					echo '<option value="'.str_pad("$val",2,'0',STR_PAD_LEFT).'"';
					if(isset($_POST['data_rozp_miesiac'])){
						if($_POST['data_rozp_miesiac']===str_pad("$val",2,'0',STR_PAD_LEFT)) echo ' selected';
					}
					echo '>'.$months[$i].'</option>';
				}
			?>
		</select>
		<label for="data_rozp_rok"> Rok: </label>
		<select name="data_rozp_rok" id="data_rozp_rok" required>
			<option value=""<?php if(!isset($_POST['data_rozp_rok'])) echo ' selected'; elseif($_POST['data_rozp_rok']==="") echo ' selected'; ?>>-</option>
			<?php
				for($i=intval(date('Y'))+1;$i>=1950;--$i){
					echo '<option value="'.$i.'"';
					if(isset($_POST['data_rozp_rok'])){
						if(intval($_POST['data_rozp_rok'])===$i) echo ' selected';
					}
					echo '>'.$i.'</option>';
				}
			?>
		</select>
	</div>
	<div>
		Data zakończenia:<br/>
		<label for="data_zakoncz_dzien">Dzień: </label>
		<select name="data_zakoncz_dzien" id="data_zakoncz_dzien">
			<option value=""<?php if(!isset($_POST['data_zakoncz_dzien'])) echo ' selected'; elseif($_POST['data_zakoncz_dzien']==="") echo ' selected'; ?>>-</option>
			<?php
				for($i=1;$i<32;++$i){
					echo '<option value="'.str_pad("$i",2,'0',STR_PAD_LEFT).'"';
					if(isset($_POST['data_zakoncz_dzien'])){
						if($_POST['data_zakoncz_dzien']===str_pad("$i",2,'0',STR_PAD_LEFT)) echo ' selected';
					}
					echo '>'.$i.'</option>';
				}
			?>
		</select>
		<label for="data_zakoncz_miesiac"> Miesiąc: </label>
		<select name="data_zakoncz_miesiac" id="data_zakoncz_miesiac" onchange="day_switch_with_optional_year('data_zakoncz_miesiac','data_zakoncz_dzien','data_zakoncz_rok')">
			<option value=""<?php if(!isset($_POST['data_zakoncz_miesiac'])) echo ' selected'; elseif($_POST['data_zakoncz_miesiac']==="") echo ' selected'; ?>>-</option>
			<?php
				$months=array('styczeń','luty','marzec','kwiecień','maj','czerwiec','lipiec','sierpień','wrzesień','październik','listopad','grudzień');
				for($i=0;$i<12;++$i){
					$val=$i+1;
					echo '<option value="'.str_pad("$val",2,'0',STR_PAD_LEFT).'"';
					if(isset($_POST['data_zakoncz_miesiac'])){
						if($_POST['data_zakoncz_miesiac']===str_pad("$val",2,'0',STR_PAD_LEFT)) echo ' selected';
					}
					echo '>'.$months[$i].'</option>';
				}
			?>
		</select>
		<label for="data_zakoncz_rok"> Rok: </label>
		<select name="data_zakoncz_rok" id="data_zakoncz_rok">
			<option value=""<?php if(!isset($_POST['data_zakoncz_rok'])) echo ' selected'; elseif($_POST['data_zakoncz_rok']==="") echo ' selected'; ?>>-</option>
			<?php
				for($i=intval(date('Y'))+1;$i>=1950;--$i){
					echo '<option value="'.$i.'"';
					if(isset($_POST['data_zakoncz_rok'])){
						if(intval($_POST['data_zakoncz_rok'])===$i) echo ' selected';
					}
					echo '>'.$i.'</option>';
				}
			?>
		</select>
	</div>
	<div>
		<label for="opis">Opis: </label>
		<textarea name="opis" id="opis" rows="20" cols="100" maxlength="166666666" required><?php if(isset($_POST['opis'])) echo $_POST['opis']; ?></textarea>
	</div>
	<div>
		<label for="logo">Logo: </label>
		<input type="text" name="logo" id="logo" value="<?php if(isset($_POST['logo'])) echo $_POST['logo']; ?>" size="16" maxlength="128" required />
	</div>
	<div>
		<input type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<?php
		}
	}
	else {
		echo '<br>Nie jesteś zalogowany.<br />
		<a href="login.php">Zaloguj się</a><br><br> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
	}
		bottom(array('js/day_switch.js','js/day_switch_projekt.js'));
?>
