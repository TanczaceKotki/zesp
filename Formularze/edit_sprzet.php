<?php
	session_start();
	require_once 'user.class.php';
	require 'common.php';
	top();
	
	if (user::isLogged()) {
	$user = user::getData('', '');
	if(isset($_POST['id'])){
		require 'DB.php';
		$DB=dbconnect();
		if($st=$DB->prepare('SELECT * FROM Sprzet WHERE id=?')){
			if($st->execute(array($_POST['id']))){
				$row=$st->fetch(PDO::FETCH_ASSOC);
?>
<form action="view_sprzet.php?id=<?php echo $row['id']; ?>" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
	<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
	<input type="hidden" name="old_nazwa" value="<?php echo $row['nazwa']; ?>" />
	<input type="hidden" name="old_data_zakupu" value="<?php echo $row['data_zakupu']; ?>" />
	<input type="hidden" name="old_data_uruchom" value="<?php echo $row['data_uruchom']; ?>" />
	<input type="hidden" name="old_wartosc" value="<?php echo $row['wartosc']; ?>" />
	<input type="hidden" name="old_opis" value="<?php echo $row['opis']; ?>" />
	<input type="hidden" name="old_projekt" value="<?php echo $row['projekt']; ?>" />
	<input type="hidden" name="old_laboratorium" value="<?php echo $row['laboratorium']; ?>" />
	<div>
		<label for="nazwa">Nazwa: </label>
		<input type="text" name="nazwa" id="nazwa" value="<?php echo $row['nazwa']; ?>" size="10" maxlength="512" spellcheck="true" required />
	</div>
	<?php
		$data_zakupu=explode('-',$row['data_zakupu']);
	?>
	<div>
		Data zakupu:<br/>
		<label for="data_zakupu_dzien">Dzień: </label>
		<select name="data_zakupu_dzien" id="data_zakupu_dzien">
			<option value=""<?php if(!isset($data_zakupu[2])) echo ' selected'; ?>>-</option>
			<?php
				for($i=1;$i<32;++$i){
					echo '<option value="'.str_pad("$i",2,'0',STR_PAD_LEFT).'"';
					if(isset($data_zakupu[2])){
						if($data_zakupu[2]===str_pad("$i",2,'0',STR_PAD_LEFT)) echo ' selected';
					}
					echo '>'.$i.'</option>';
				}
			?>
		</select>
		<label for="data_zakupu_miesiac"> Miesiąc: </label>
		<select name="data_zakupu_miesiac" id="data_zakupu_miesiac" onchange="day_switch_with_required_year('data_zakupu_miesiac','data_zakupu_dzien','data_zakupu_rok')">
			<option value=""<?php if(!isset($data_zakupu[1])) echo ' selected'; ?>>-</option>
			<?php
				$months=array('styczeń','luty','marzec','kwiecień','maj','czerwiec','lipiec','sierpień','wrzesień','październik','listopad','grudzień');
				for($i=0;$i<12;++$i){
					$val=$i+1;
					echo '<option value="'.str_pad("$val",2,'0',STR_PAD_LEFT).'"';
					if(isset($data_zakupu[1])){
						if($data_zakupu[1]===str_pad("$val",2,'0',STR_PAD_LEFT)) echo ' selected';
					}
					echo '>'.$months[$i].'</option>';
				}
			?>
		</select>
		<label for="data_zakupu_rok"> Rok: </label>
		<select name="data_zakupu_rok" id="data_zakupu_rok" required>
			<option value="">-</option>
			<?php
				for($i=intval(date('Y'))+1;$i>=1950;--$i){
					echo '<option value="'.$i.'"';
					if(isset($data_zakupu[0])){
						if(intval($data_zakupu[0])===$i) echo ' selected';
					}
					echo '>'.$i.'</option>';
				}
			?>
		</select>
	</div>
	<?php
		$data_uruchom=explode('-',$row['data_uruchom']);
	?>
	<div>
		Data uruchomienia:<br/>
		<label for="data_uruchom_dzien">Dzień: </label>
		<select name="data_uruchom_dzien" id="data_uruchom_dzien">
			<option value=""<?php if(!isset($data_uruchom[2])) echo ' selected'; ?>>-</option>
			<?php
				for($i=1;$i<32;++$i){
					echo '<option value="'.str_pad("$i",2,'0',STR_PAD_LEFT).'"';
					if(isset($data_uruchom[2])){
						if($data_uruchom[2]===str_pad("$i",2,'0',STR_PAD_LEFT)) echo ' selected';
					}
					echo '>'.$i.'</option>';
				}
			?>
		</select>
		<label for="data_uruchom_miesiac"> Miesiąc: </label>
		<select name="data_uruchom_miesiac" id="data_uruchom_miesiac" onchange="day_switch_with_required_year('data_uruchom_miesiac','data_uruchom_dzien','data_uruchom_rok')">
			<option value=""<?php if(!isset($data_uruchom[1])) echo ' selected'; ?>>-</option>
			<?php
				$months=array('styczeń','luty','marzec','kwiecień','maj','czerwiec','lipiec','sierpień','wrzesień','październik','listopad','grudzień');
				for($i=0;$i<12;++$i){
					$val=$i+1;
					echo '<option value="'.str_pad("$val",2,'0',STR_PAD_LEFT).'"';
					if(isset($data_uruchom[1])){
						if($data_uruchom[1]===str_pad("$val",2,'0',STR_PAD_LEFT)) echo ' selected';
					}
					echo '>'.$months[$i].'</option>';
				}
			?>
		</select>
		<label for="data_uruchom_rok"> Rok: </label>
		<select name="data_uruchom_rok" id="data_uruchom_rok" required>
			<option value="">-</option>
			<?php
				for($i=intval(date('Y'))+1;$i>=1950;--$i){
					echo '<option value="'.$i.'"';
					if(isset($data_uruchom[0])){
						if(intval($data_uruchom[0])===$i) echo ' selected';
					}
					echo '>'.$i.'</option>';
				}
			?>
		</select>
	</div>
	<div>
		<label for="wartosc">Wartość: </label>
		<input type="text" name="wartosc" id="wartosc" value="<?php echo $row['wartosc']; ?>" size="10" maxlength="10" required />gr
	</div>
	<div>
		<label for="opis">Opis: </label>
		<textarea name="opis" id="opis" rows="20" cols="100" maxlength="166666666" spellcheck="true" required><?php echo $row['opis']; ?></textarea>
	</div>
	<div>
		<label for="projekt">Projekt: </label>
		<select name="projekt" id="projekt">
			<?php
				if($row['projekt']==="") echo '<option value="" selected>-</option>';
				else echo '<option value="">-</option>';
				if($result=$DB->query("SELECT id,nazwa FROM Projekt ORDER BY nazwa")){
					while($row2=$result->fetch(PDO::FETCH_ASSOC)){
						if($row['projekt']===$row2['id']) echo '<option value="'.$row2['id'].'" selected>'.$row2['nazwa'].'</option>';
						else echo '<option value="'.$row2['id'].'">'.$row2['nazwa'].'</option>';
					}
				}
			?>
		</select>
	</div>
	<div>
		<label for="laboratorium">Laboratorium: </label>
		<select name="laboratorium" id="laboratorium">
			<?php
				if($row['laboratorium']==="") echo '<option value="" selected>-</option>';
				else echo '<option value="">-</option>';
				if($result=$DB->query("SELECT id,nazwa FROM Laboratorium ORDER BY nazwa")){
					while($row2=$result->fetch(PDO::FETCH_ASSOC)){
						if($row['laboratorium']===$row2['id']) echo '<option value="'.$row2['id'].'" selected>'.$row2['nazwa'].'</option>';
						else echo '<option value="'.$row2['id'].'">'.$row2['nazwa'].'</option>';
					}
				}
			?>
		</select>
	</div>
	<div>
		<input type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<script type="text/javascript">
	var date_fields=["data_zakupu","data_uruchom"];
</script>
<?php
				bottom(array('js/day_switch.js','js/day_switch_sprzet.js'));
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
		echo 'Nie podano sprzętu do edycji.';
	}
	}
	else {
		echo '<br>Nie jesteś zalogowany.<br />
		<a href="login.php">Zaloguj się</a><br><br> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
	}
		bottom();
?>
