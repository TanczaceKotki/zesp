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
			if($st=$DB->prepare('SELECT * FROM Projekt WHERE id=?')){
				if($st->execute(array($_POST['id']))){
					$row=$st->fetch(PDO::FETCH_ASSOC);
?>
<form action="view_projekt.php?id=<?php echo $row['id']; ?>" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
	<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
	<input type="hidden" name="old_nazwa" value="<?php echo $row['nazwa']; ?>" />
	<input type="hidden" name="old_data_rozp" value="<?php echo $row['data_rozp']; ?>" />
	<input type="hidden" name="old_data_zakoncz" value="<?php echo $row['data_zakoncz']; ?>" />
	<input type="hidden" name="old_opis" value="<?php echo $row['opis']; ?>" />
	<input type="hidden" name="old_logo" value="<?php echo $row['logo']; ?>" />
	<div>
		<label for="nazwa">Nazwa<span class="color_red">*</span>: </label>
		<input type="text" name="nazwa" id="nazwa" value="<?php echo $row['nazwa']; ?>" size="64" maxlength="64" spellcheck="true" required="required" />
		<span id="nazwa_counter"></span>
	</div>
	<?php
		$data_rozp=explode('-',$row['data_rozp']);
	?>
	<div>
		<fieldset>
			<legend>Data rozpoczęcia</legend>
			<label for="data_rozp_dzien">Dzień: </label>
			<select name="data_rozp_dzien" id="data_rozp_dzien" onchange="date_callback('data_rozp_dzien','data_rozp_miesiac','data_rozp_rok','data_zakoncz_dzien','data_zakoncz_miesiac','data_zakoncz_rok')">
				<option value=""<?php if(!isset($data_rozp[2])) echo ' selected="selected"'; ?>>-</option>
				<?php
					for($i=1;$i<32;++$i){
						echo '<option value="'.$i.'"';
						if(isset($data_rozp[2])){
							if(intval($data_rozp[2])===$i) echo ' selected="selected"';
						}
						echo '>'.$i.'</option>';
					}
				?>
			</select>
			<label for="data_rozp_miesiac"> Miesiąc: </label>
			<select name="data_rozp_miesiac" id="data_rozp_miesiac" onchange="date_callback('data_rozp_dzien','data_rozp_miesiac','data_rozp_rok','data_zakoncz_dzien','data_zakoncz_miesiac','data_zakoncz_rok')">
				<option value=""<?php if(!isset($data_rozp[1])) echo ' selected="selected"'; ?>>-</option>
				<?php
					$months=array('styczeń','luty','marzec','kwiecień','maj','czerwiec','lipiec','sierpień','wrzesień','październik','listopad','grudzień');
					for($i=0;$i<12;++$i){
						$val=$i+1;
						echo '<option value="'.$val.'"';
						if(isset($data_rozp[1])){
							if(intval($data_rozp[1])===$val) echo ' selected="selected"';
						}
						echo '>'.$months[$i].'</option>';
					}
				?>
			</select>
			<label for="data_rozp_rok"> Rok<span class="color_red">*</span>: </label>
			<select name="data_rozp_rok" id="data_rozp_rok" onchange="date_callback('data_rozp_dzien','data_rozp_miesiac','data_rozp_rok','data_zakoncz_dzien','data_zakoncz_miesiac','data_zakoncz_rok')" required="required">
				<option value="">-</option>
				<?php
					$curdecade=(intval(date('Y'))+1)-(intval(date('Y'))+1)%10;
					echo '<optgroup label="'.$curdecade.' - '.(intval(date('Y'))+1).'">';
					for($i=intval(date('Y'))+1;$i>=1950;--$i){
						if($curdecade!=$i-$i%10){
							$curdecade=$i-$i%10;
							echo '</optgroup><optgroup label="'.$curdecade.' - '.($curdecade+9).'">';
						}
						echo '<option value="'.$i.'"';
						if(intval($data_rozp[0])===$i) echo ' selected="selected"';
						echo '>'.$i.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>';
					}
					echo '</optgroup>';
				?>
			</select>
		</fieldset>
	</div>
	<?php
		$data_zakoncz=explode('-',$row['data_zakoncz']);
	?>
	<div>
		<fieldset>
			<legend>Data zakończenia</legend>
			<label for="data_zakoncz_dzien">Dzień: </label>
			<select name="data_zakoncz_dzien" id="data_zakoncz_dzien" onchange="date_callback('data_rozp_dzien','data_rozp_miesiac','data_rozp_rok','data_zakoncz_dzien','data_zakoncz_miesiac','data_zakoncz_rok')">
				<option value=""<?php if(!isset($data_zakoncz[2])) echo ' selected="selected"'; ?>>-</option>
				<?php
					for($i=1;$i<32;++$i){
						echo '<option value="'.$i.'"';
						if(isset($data_zakoncz[2])){
							if(intval($data_zakoncz[2])===$i) echo ' selected="selected"';
						}
						echo '>'.$i.'</option>';
					}
				?>
			</select>
			<label for="data_zakoncz_miesiac"> Miesiąc: </label>
			<select name="data_zakoncz_miesiac" id="data_zakoncz_miesiac" onchange="date_callback('data_rozp_dzien','data_rozp_miesiac','data_rozp_rok','data_zakoncz_dzien','data_zakoncz_miesiac','data_zakoncz_rok')">
				<option value=""<?php if(!isset($data_zakoncz[1])) echo ' selected="selected"'; ?>>-</option>
				<?php
					$months=array('styczeń','luty','marzec','kwiecień','maj','czerwiec','lipiec','sierpień','wrzesień','październik','listopad','grudzień');
					for($i=0;$i<12;++$i){
						$val=$i+1;
						echo '<option value="'.$val.'"';
						if(isset($data_zakoncz[1])){
							if(intval($data_zakoncz[1])===$val) echo ' selected="selected"';
						}
						echo '>'.$months[$i].'</option>';
					}
				?>
			</select>
			<label for="data_zakoncz_rok"> Rok: </label>
			<select name="data_zakoncz_rok" id="data_zakoncz_rok" onchange="date_callback('data_rozp_dzien','data_rozp_miesiac','data_rozp_rok','data_zakoncz_dzien','data_zakoncz_miesiac','data_zakoncz_rok')">
				<option value=""<?php if($data_zakoncz[0]==="") echo ' selected="selected"'; ?>>-</option>
				<?php
					$curdecade=(intval(date('Y'))+1)-(intval(date('Y'))+1)%10;
					echo '<optgroup label="'.$curdecade.' - '.(intval(date('Y'))+1).'">';
					for($i=intval(date('Y'))+1;$i>=1950;--$i){
						if($curdecade!=$i-$i%10){
							$curdecade=$i-$i%10;
							echo '</optgroup><optgroup label="'.$curdecade.' - '.($curdecade+9).'">';
						}
						echo '<option value="'.$i.'"';
						if(intval($data_zakoncz[0])===$i) echo ' selected="selected"';
						echo '>'.$i.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>';
					}
					echo '</optgroup>';
				?>
			</select>
		</fieldset>
	</div>
	<div>
		<label for="opis">Opis<span class="color_red">*</span>: </label>
		<textarea name="opis" id="opis" rows="20" cols="100" maxlength="166666666" spellcheck="true" required="required"><?php echo $row['opis']; ?></textarea>
		<span id="opis_counter"></span>
	</div>
	<div>
		<label for="logo">Logo<span class="color_red">*</span>: </label>
		<input type="text" name="logo" id="logo" value="<?php echo $row['logo']; ?>" size="100" maxlength="128" required="required" />
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
	}
	else {
		echo '<br>Nie jesteś zalogowany.<br />
		<a href="login.php">Zaloguj się</a><br><br> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
		bottom();
	}
?>
