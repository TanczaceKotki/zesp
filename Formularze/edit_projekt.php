<?php
	require 'common.php';
	top();
	if(isset($_POST['id'])){
		require 'DB.php';
		$DB=dbconnect();
		if($st=$DB->prepare('SELECT * FROM Projekt WHERE id=?')){
			if($st->execute(array($_POST['id']))){
				$row=$st->fetch(PDO::FETCH_ASSOC);
				top();
?>
<form action="view_projekt.php?id=<?php echo $row['id']; ?>" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
	<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
	<input type="hidden" name="old_nazwa" value="<?php echo $row['nazwa']; ?>" />
	<input type="hidden" name="old_data_rozp" value="<?php echo $row['data_rozp']; ?>" />
	<input type="hidden" name="old_data_zakoncz" value="<?php echo $row['data_zakoncz']; ?>" />
	<input type="hidden" name="old_opis" value="<?php echo $row['opis']; ?>" />
	<input type="hidden" name="old_logo" value="<?php echo $row['logo']; ?>" />
	<div>
		<label for="nazwa">Nazwa: </label>
		<input type="text" name="nazwa" id="nazwa" value="<?php echo $row['nazwa']; ?>" size="10" maxlength="64" spellcheck="true" required />
	</div>
	<?php
		$data_rozp=explode('-',$row['data_rozp']);
	?>
	<div>
		Data rozpoczęcia:<br/>
		<label for="data_rozp_dzien">Dzień: </label>
		<select name="data_rozp_dzien" id="data_rozp_dzien">
			<option value=""<?php if(!isset($data_rozp[2])) echo ' selected'; ?>>-</option>
			<?php
				for($i=1;$i<32;++$i){
					echo '<option value="'.str_pad("$i",2,'0',STR_PAD_LEFT).'"';
					if(isset($data_rozp[2])){
						if($data_rozp[2]===str_pad("$i",2,'0',STR_PAD_LEFT)) echo ' selected';
					}
					echo '>'.$i.'</option>';
				}
			?>
		</select>
		<label for="data_rozp_miesiac"> Miesiąc: </label>
		<select name="data_rozp_miesiac" id="data_rozp_miesiac" onchange="day_switch_with_required_year('data_rozp_miesiac','data_rozp_dzien','data_rozp_rok')">
			<option value=""<?php if(!isset($data_rozp[1])) echo ' selected'; ?>>-</option>
			<?php
				$months=array('styczeń','luty','marzec','kwiecień','maj','czerwiec','lipiec','sierpień','wrzesień','październik','listopad','grudzień');
				for($i=0;$i<12;++$i){
					$val=$i+1;
					echo '<option value="'.str_pad("$val",2,'0',STR_PAD_LEFT).'"';
					if(isset($data_rozp[1])){
						if($data_rozp[1]===str_pad("$val",2,'0',STR_PAD_LEFT)) echo ' selected';
					}
					echo '>'.$months[$i].'</option>';
				}
			?>
		</select>
		<label for="data_rozp_rok"> Rok: </label>
		<select name="data_rozp_rok" id="data_rozp_rok" required>
			<option value="">-</option>
			<?php
				for($i=intval(date('Y'))+1;$i>=1950;--$i){
					echo '<option value="'.$i.'"';
					if(isset($data_rozp[0])){
						if(intval($data_rozp[0])===$i) echo ' selected';
					}
					echo '>'.$i.'</option>';
				}
			?>
		</select>
	</div>
	<?php
		$data_zakoncz=explode('-',$row['data_zakoncz']);
	?>
	<div>
		Data zakończenia:<br/>
		<label for="data_zakoncz_dzien">Dzień: </label>
		<select name="data_zakoncz_dzien" id="data_zakoncz_dzien">
			<option value=""<?php if(!isset($data_zakoncz[2])) echo ' selected'; ?>>-</option>
			<?php
				for($i=1;$i<32;++$i){
					echo '<option value="'.str_pad("$i",2,'0',STR_PAD_LEFT).'"';
					if(isset($data_zakoncz[2])){
						if($data_zakoncz[2]===str_pad("$i",2,'0',STR_PAD_LEFT)) echo ' selected';
					}
					echo '>'.$i.'</option>';
				}
			?>
		</select>
		<label for="data_zakoncz_miesiac"> Miesiąc: </label>
		<select name="data_zakoncz_miesiac" id="data_zakoncz_miesiac" onchange="day_switch_with_required_year('data_zakoncz_miesiac','data_zakoncz_dzien','data_zakoncz_rok')">
			<option value=""<?php if(!isset($data_zakoncz[1])) echo ' selected'; ?>>-</option>
			<?php
				$months=array('styczeń','luty','marzec','kwiecień','maj','czerwiec','lipiec','sierpień','wrzesień','październik','listopad','grudzień');
				for($i=0;$i<12;++$i){
					$val=$i+1;
					echo '<option value="'.str_pad("$val",2,'0',STR_PAD_LEFT).'"';
					if(isset($data_zakoncz[1])){
						if($data_zakoncz[1]===str_pad("$val",2,'0',STR_PAD_LEFT)) echo ' selected';
					}
					echo '>'.$months[$i].'</option>';
				}
			?>
		</select>
		<label for="data_zakoncz_rok"> Rok: </label>
		<select name="data_zakoncz_rok" id="data_zakoncz_rok" required>
			<option value=""<?php if(!isset($data_zakoncz[0])) echo ' selected'; ?>>-</option>
			<?php
				for($i=intval(date('Y'))+1;$i>=1950;--$i){
					echo '<option value="'.$i.'"';
					if(isset($data_zakoncz[0])){
						if(intval($data_zakoncz[0])===$i) echo ' selected';
					}
					echo '>'.$i.'</option>';
				}
			?>
		</select>
	</div>
	<div>
		<label for="opis">Opis: </label>
		<textarea name="opis" id="opis" rows="20" cols="100" maxlength="166666666" spellcheck="true" required><?php echo $row['opis']; ?></textarea>
	</div>
	<div>
		<label for="logo">Logo: </label>
		<input type="text" name="logo" id="logo" value="<?php echo $row['logo']; ?>" size="10" maxlength="1700" required />
	</div>
	<div>
		<input type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<script type="text/javascript">
	var date_fields=["data_rozp","data_zakoncz"];
</script>
<?php
				bottom(array('js/day_switch.js','js/day_switch_projekt.js'));
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
		echo 'Nie podano projektu do edycji.';
		bottom();
	}
?>
