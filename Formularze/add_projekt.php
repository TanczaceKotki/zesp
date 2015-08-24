<?php
	$displayform=True;
	if(user::isLogged()){
		if($lvl<2){
			breadcrumbs('Nowy projekt',array('index.php?menu=17' => 'Zarządzanie projektami'));
			echo '<h1 class="font20">Nowy projekt</h1>';
			if(isset($_POST['submitted'])){
				require 'walidacja_danych_php/walidacja.php';
				$walidacja=true;
				$err_msg='<section><h2 class="font17">W przesłanych danych wystąpiły następujące błędy:</h2><ul class="error_list">';
				if( valid_length($_POST['nazwa'], 512) == false ){
					$walidacja = false;
					$err_msg.='<li>Błędne dane w polu nazwa.</li>';
				}
				if( valid_date($_POST['data_rozp_dzien'].'-'.$_POST['data_rozp_miesiac'].'-'.$_POST['data_rozp_rok']) == false ){
					$walidacja = false;
					$err_msg.='<li>Błędne dane w polu data rozpoczęcia.</li>';
				}
				if( valid_date($_POST['data_zakoncz_dzien'].'-'.$_POST['data_zakoncz_miesiac'].'-'.$_POST['data_zakoncz_rok']) == false ){
					$walidacja = false;
					$err_msg.='<li>Błędne dane w polu data zakonczenia.</li>';
				}
				if( valid_length($_POST['opis'], 166666666) == false ){
					$walidacja = false;
					$err_msg.='<li>Błędne dane w polu opis.</li>';
				}
				if( valid_length($_POST['logo'], 128) == false ){
					$walidacja = false;
					$err_msg.='<li>Błędne dane w polu logo.</li>';
				}
				if( $walidacja ){
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
							echo '<p>Projekt został pomyślnie wstawiony.</p><p><a href="index.php?menu=17">Wróć do strony zarządzania projektami.</a></p>';
							$displayform=False;
						}
						else echo '<p>Nastąpił błąd przy dodawaniu projektu: '.implode(' ',$st->errorInfo()).'</p>';
					}
					else echo '<p>Nastąpił błąd przy dodawaniu projektu: '.implode(' ',$DB->errorInfo()).'</p>';
				}
				else echo "$err_msg</ul></section>";
			}
			if($displayform){
?>
<form action="index.php?menu=24" method="post" accept-charset="utf-8" enctype="application/x-www-form-urlencoded">
	<label  for="nazwa">Nazwa<span class="color_red">*</span>:</label>
	<input class="form-control" type="text" name="nazwa" id="nazwa" value="<?php if(isset($_POST['nazwa'])) echo $_POST['nazwa']; ?>" size="64" maxlength="64" spellcheck="true" required="required" />
	<div id="nazwa_counter"></div>
	<fieldset class="margin_top_10">
		<legend class="group_label font15">Data rozpoczęcia</legend>
		<label for="data_rozp_dzien">Dzień: </label>
		<select class="form-control inline_select" name="data_rozp_dzien" id="data_rozp_dzien" onchange="date_callback()">
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
		<select class="form-control inline_select" name="data_rozp_miesiac" id="data_rozp_miesiac" onchange="date_callback()">
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
		<select class="form-control inline_select" name="data_rozp_rok" id="data_rozp_rok" onchange="date_callback()" required="required">
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
					echo '>'.$i.'</option>';
				}
				echo '</optgroup>';
			?>
		</select>
	</fieldset>
	<fieldset class="margin_top_10">
		<legend class="group_label font15">Data zakończenia</legend>
		<label for="data_zakoncz_dzien">Dzień: </label>
		<select class="form-control inline_select" name="data_zakoncz_dzien" id="data_zakoncz_dzien" onchange="date_callback()">
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
		<select class="form-control inline_select" name="data_zakoncz_miesiac" id="data_zakoncz_miesiac" onchange="date_callback()">
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
		<select class="form-control inline_select" name="data_zakoncz_rok" id="data_zakoncz_rok" onchange="date_callback()">
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
					echo '>'.$i.'</option>';
				}
				echo '</optgroup>';
			?>
		</select>
	</fieldset>
	<div class="margin_top_10">
		<label for="opis">Opis<span class="color_red">*</span>:</label>
		<textarea class="form-control" name="opis" id="opis" rows="20" cols="100" maxlength="166666666" spellcheck="true" required="required"><?php if(isset($_POST['opis'])) echo $_POST['opis']; ?></textarea>
		<div id="opis_counter"></div>
	</div>
	<div class="margin_top_10">
		<label for="logo">Logo<span class="color_red">*</span>:</label>
		<input class="form-control" type="text" name="logo" id="logo" value="<?php if(isset($_POST['logo'])) echo $_POST['logo']; ?>" size="100" maxlength="128" required="required" />
		<div id="logo_counter"></div>
	</div>
	<div class="margin_top_10">
		<input class="btn btn-warning" type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<p class="margin_top_10"><span class="color_red">*</span> - wymagane pola.</p>
<?php
				foreach(array('js/remaining_char_counter.js','js/projekt_form.js') as $script){
					echo '<script src="'.$script.'" type="text/javascript"></script>';
				}
			}
		}
		else require 'mod_cred_req.php';
	}
	else require 'not_logged_in.php';
?>
