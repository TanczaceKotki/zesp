<?php
	require 'common.php';
	require 'DB.php';
	top();
	$DB=dbconnect();
	$displayform=True;
	if(isset($_POST['submitted'])){
		$params=array($_POST['nazwa']);
		$params[]=$_POST['data_zakupu_rok'];
		if($_POST['data_zakupu_miesiac']!==""){
			$params[1].='-'.$_POST['data_zakupu_miesiac'];
			if($_POST['data_zakupu_dzien']!=="") $params[1].='-'.$_POST['data_zakupu_dzien'];
		}
		$sql='INSERT INTO Sprzet VALUES(NULL,?,?,';
		if($_POST['data_uruchom_rok']===""){
			$sql.='NULL,?,?,';
		}
		else{
			$sql.='?,?,?,';
			$params[]=$_POST['data_uruchom_rok'];
			if($_POST['data_uruchom_miesiac']!==""){
				$params[2].='-'.$_POST['data_uruchom_miesiac'];
				if($_POST['data_uruchom_dzien']!=="") $params[2].='-'.$_POST['data_uruchom_dzien'];
			}
		}
		$params[]=$_POST['wartosc'];
		$params[]=$_POST['opis'];
		if($_POST['projekt']==='-'){
			$sql.='NULL,';
		}
		else{
			$sql.='?,';
			$params[]=$_POST['projekt'];
		}
		if($_POST['laboratorium']==='-'){
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
	if($displayform){
?>
<form action="add_sprzet.php" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
	<div>
		<label for="nazwa">Nazwa: </label>
		<input type="text" name="nazwa" id="nazwa" value="<?php if(isset($_POST['nazwa'])) echo $_POST['nazwa']; ?>" size="10" maxlength="512" spellcheck="true" required />
	</div>
	<div>
		Data zakupu:<br/>
		<label for="data_zakupu_dzien">Dzień: </label>
		<select name="data_zakupu_dzien" id="data_zakupu_dzien">
			<option value=""<?php if(!isset($_POST['data_zakupu_dzien'])) echo ' selected'; elseif($_POST['data_zakupu_dzien']==="") echo ' selected'; ?>>-</option>
			<?php
				for($i=1;$i<32;++$i){
					echo '<option value="'.str_pad("$i",2,'0',STR_PAD_LEFT).'"';
					if(isset($_POST['data_zakupu_dzien'])){
						if($_POST['data_zakupu_dzien']===str_pad("$i",2,'0',STR_PAD_LEFT)) echo ' selected';
					}
					echo '>'.$i.'</option>';
				}
			?>
		</select>
		<label for="data_zakupu_miesiac"> Miesiąc: </label>
		<select name="data_zakupu_miesiac" id="data_zakupu_miesiac" onchange="day_switch_with_required_year('data_zakupu_miesiac','data_zakupu_dzien','data_zakupu_rok')">
			<option value=""<?php if(!isset($_POST['data_zakupu_miesiac'])) echo ' selected'; elseif($_POST['data_zakupu_miesiac']==="") echo ' selected'; ?>>-</option>
			<?php
				$months=array('styczeń','luty','marzec','kwiecień','maj','czerwiec','lipiec','sierpień','wrzesień','październik','listopad','grudzień');
				for($i=0;$i<12;++$i){
					$val=$i+1;
					echo '<option value="'.str_pad("$val",2,'0',STR_PAD_LEFT).'"';
					if(isset($_POST['data_zakupu_miesiac'])){
						if($_POST['data_zakupu_miesiac']===str_pad("$val",2,'0',STR_PAD_LEFT)) echo ' selected';
					}
					echo '>'.$months[$i].'</option>';
				}
			?>
		</select>
		<label for="data_zakupu_rok"> Rok: </label>
		<select name="data_zakupu_rok" id="data_zakupu_rok" onchange="day_switch_with_required_year('data_zakupu_miesiac','data_zakupu_dzien','data_zakupu_rok')" required>
			<option value=""<?php if(!isset($_POST['data_zakupu_rok'])) echo ' selected'; elseif($_POST['data_zakupu_rok']==="") echo ' selected'; ?>>-</option>
			<?php
				for($i=intval(date('Y'))+1;$i>=1950;--$i){
					echo '<option value="'.$i.'"';
					if(isset($_POST['data_zakupu_rok'])){
						if(intval($_POST['data_zakupu_rok'])===$i) echo ' selected';
					}
					echo '>'.$i.'</option>';
				}
			?>
		</select>
	</div>
	<div>
		Data uruchomienia:<br/>
		<label for="data_uruchom_dzien">Dzień: </label>
		<select name="data_uruchom_dzien" id="data_uruchom_dzien">
			<option value=""<?php if(!isset($_POST['data_uruchom_dzien'])) echo ' selected'; elseif($_POST['data_uruchom_dzien']==="") echo ' selected'; ?>>-</option>
			<?php
				for($i=1;$i<32;++$i){
					echo '<option value="'.str_pad("$i",2,'0',STR_PAD_LEFT).'"';
					if(isset($_POST['data_uruchom_dzien'])){
						if($_POST['data_uruchom_dzien']===str_pad("$i",2,'0',STR_PAD_LEFT)) echo ' selected';
					}
					echo '>'.$i.'</option>';
				}
			?>
		</select>
		<label for="data_uruchom_miesiac"> Miesiąc: </label>
		<select name="data_uruchom_miesiac" id="data_uruchom_miesiac" onchange="day_switch_with_optional_year('data_uruchom_miesiac','data_uruchom_dzien','data_uruchom_rok')">
			<option value=""<?php if(!isset($_POST['data_uruchom_miesiac'])) echo ' selected'; elseif($_POST['data_uruchom_miesiac']==="") echo ' selected'; ?>>-</option>
			<?php
				$months=array('styczeń','luty','marzec','kwiecień','maj','czerwiec','lipiec','sierpień','wrzesień','październik','listopad','grudzień');
				for($i=0;$i<12;++$i){
					$val=$i+1;
					echo '<option value="'.str_pad("$val",2,'0',STR_PAD_LEFT).'"';
					if(isset($_POST['data_uruchom_miesiac'])){
						if($_POST['data_uruchom_miesiac']===str_pad("$val",2,'0',STR_PAD_LEFT)) echo ' selected';
					}
					echo '>'.$months[$i].'</option>';
				}
			?>
		</select>
		<label for="data_uruchom_rok"> Rok: </label>
		<select name="data_uruchom_rok" id="data_uruchom_rok" onchange="day_switch_with_optional_year('data_uruchom_miesiac','data_uruchom_dzien','data_uruchom_rok')">
			<option value=""<?php if(!isset($_POST['data_uruchom_rok'])) echo ' selected'; elseif($_POST['data_uruchom_rok']==="") echo ' selected'; ?>>-</option>
			<?php
				for($i=intval(date('Y'))+1;$i>=1950;--$i){
					echo '<option value="'.$i.'"';
					if(isset($_POST['data_uruchom_rok'])){
						if(intval($_POST['data_uruchom_rok'])===$i) echo ' selected';
					}
					echo '>'.$i.'</option>';
				}
			?>
		</select>
	</div>
	<div>
		<label for="wartosc">Wartość: </label>
		<input type="text" name="wartosc" id="wartosc" value="<?php if(isset($_POST['wartosc'])) echo $_POST['wartosc']; ?>" size="10" maxlength="10" required />gr
	</div>
	<div>
		<label for="opis">Opis: </label>
		<textarea name="opis" id="opis" rows="20" cols="100" maxlength="166666666" spellcheck="true" required><?php if(isset($_POST['opis'])) echo $_POST['opis']; ?></textarea>
	</div>
	<div>
		<label for="projekt">Projekt: </label>
		<select name="projekt" id="projekt">
			<option value=""<?php if(!isset($_POST['projekt'])) echo ' selected'; ?>>-</option>
			<?php
				if($result=$DB->query("SELECT id,nazwa FROM Projekt ORDER BY nazwa")){
					while($row=$result->fetch(PDO::FETCH_ASSOC)){
						echo '<option value="'.$row['id'].'"';
						if(isset($_POST['projekt'])){
							if($_POST['projekt']===$row['id']) echo ' selected';
						}
						echo '>'.$row['nazwa'].'</option>';
					}
				}
			?>
		</select>
	</div>
	<div>
		<label for="laboratorium">Laboratorium: </label>
		<select name="laboratorium" id="laboratorium">
			<option value=""<?php if(!isset($_POST['laboratorium'])) echo ' selected'; ?>>-</option>
			<?php
				if($result=$DB->query("SELECT id,nazwa FROM Laboratorium ORDER BY nazwa")){
					while($row=$result->fetch(PDO::FETCH_ASSOC)){
						echo '<option value="'.$row['id'].'"';
						if(isset($_POST['laboratorium'])){
							if($_POST['laboratorium']===$row['id']) echo ' selected';
						}
						echo '>>'.$row['nazwa'].'</option>';
					}
				}
			?>
		</select>
	</div>
	<div>
		<input type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<?php
		bottom(array('js/day_switch.js','js/day_switch_sprzet.js'));
	}
?>
