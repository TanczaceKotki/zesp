<?php
	if(user::isLogged()){
		if($lvl<2){
			$msg="";
			if(isset($_POST['submitted'])){
			$send=False;
			$params=array();
			$msg="";
			$sql='UPDATE Projekt SET';
			if($_POST['nazwa']!==$_POST['old_nazwa']){
				$sql.=' nazwa=?';
				$params[]=$_POST['nazwa'];
				$send=True;
			}
			$data=$_POST['data_rozp_rok'];
			if($_POST['data_rozp_miesiac']!==""){
				$data.='-'.$_POST['data_rozp_miesiac'];
				if($_POST['data_rozp_dzien']!=="") $data.='-'.$_POST['data_rozp_dzien'];
			}
			if($data!==$_POST['old_data_rozp']){
				if($send) $sql.=',';
				$sql.=' data_rozp=?';
				$params[]=$data;
				$send=True;
			}
			$data="";
			if($_POST['data_zakoncz_rok']!==""){
				$data=$_POST['data_zakoncz_rok'];
				if($_POST['data_zakoncz_miesiac']!==""){
					$data.='-'.$_POST['data_zakoncz_miesiac'];
					if($_POST['data_zakoncz_dzien']!=="") $data.='-'.$_POST['data_zakoncz_dzien'];
				}
			}
			if($data!==$_POST['old_data_zakoncz']){
				if($send) $sql.=',';
				if($data==="") $sql.=' data_zakoncz=NULL';
				else{
					$sql.=' data_zakoncz=?';
					$params[]=$data;
				}
				$send=True;
			}
			if($_POST['opis']!==$_POST['old_opis']){
				if($send) $sql.=',';
				$sql.=' opis=?';
				$params[]=$_POST['opis'];
				$send=True;
			}
			if($_POST['logo']!==$_POST['old_logo']){
				if($send) $sql.=',';
				$sql.=' logo=?';
				$params[]=$_POST['logo'];
				$send=True;
			}
			if($send){
				$sql.=' WHERE id=?';
				$params[]=$_POST['id'];
				if($st=$DB->prepare($sql)){
					if($st->execute($params)){
						header('Location:index.php?menu=51&id='.$_POST['id']);
						die();
					}
					else $msg='<p>Nastąpił błąd przy modyfikowaniu projektu: '.implode(' ',$st->errorInfo()).'</p>';
				}
				else $msg='<p>Nastąpił błąd przy modyfikowaniu projektu: '.implode(' ',$DB->errorInfo()).'</p>';
			}
		}
			if(isset($_POST['id'])){
				if($st=$DB->prepare('SELECT * FROM Projekt WHERE id=?')){
					if($st->execute(array($_POST['id']))){
						if($row=$st->fetch(PDO::FETCH_ASSOC)){
							breadcrumbs('Edytowanie projektu',array('index.php?menu=17' => 'Zarządzanie projektami',"index.php?menu=51&amp;id=$_POST[id]" => 'Szczegóły projektu'));
							echo "<h1 class=\"font20\">Edytowanie projektu</h1>$msg";
?>
<form action="index.php?menu=44" method="post" accept-charset="utf-8" enctype="application/x-www-form-urlencoded">
	<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
	<input type="hidden" name="old_nazwa" value="<?php echo $row['nazwa']; ?>" />
	<input type="hidden" name="old_data_rozp" value="<?php echo $row['data_rozp']; ?>" />
	<input type="hidden" name="old_data_zakoncz" value="<?php echo $row['data_zakoncz']; ?>" />
	<input type="hidden" name="old_opis" value="<?php echo $row['opis']; ?>" />
	<input type="hidden" name="old_logo" value="<?php echo $row['logo']; ?>" />
	<label for="nazwa">Nazwa<span class="color_red">*</span>:</label>
	<input class="form-control" type="text" name="nazwa" id="nazwa" value="<?php echo $row['nazwa']; ?>" size="64" maxlength="64" spellcheck="true" required="required" />
	<div id="nazwa_counter"></div>
	<?php
		$data_rozp=explode('-',$row['data_rozp']);
	?>
	<fieldset class="margin_top_10">
		<legend class="group_label font15">Data rozpoczęcia</legend>
		<label for="data_rozp_dzien">Dzień: </label>
		<select class="form-control inline_select" name="data_rozp_dzien" id="data_rozp_dzien" onchange="date_callback('data_rozp_dzien','data_rozp_miesiac','data_rozp_rok','data_zakoncz_dzien','data_zakoncz_miesiac','data_zakoncz_rok')">
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
		<select class="form-control inline_select" name="data_rozp_miesiac" id="data_rozp_miesiac" onchange="date_callback('data_rozp_dzien','data_rozp_miesiac','data_rozp_rok','data_zakoncz_dzien','data_zakoncz_miesiac','data_zakoncz_rok')">
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
		<select class="form-control inline_select" name="data_rozp_rok" id="data_rozp_rok" onchange="date_callback('data_rozp_dzien','data_rozp_miesiac','data_rozp_rok','data_zakoncz_dzien','data_zakoncz_miesiac','data_zakoncz_rok')" required="required">
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
					echo '>'.$i.'</option>';
				}
				echo '</optgroup>';
			?>
		</select>
	</fieldset>
	<?php
		$data_zakoncz=explode('-',$row['data_zakoncz']);
	?>
	<fieldset class="margin_top_10">
		<legend class="group_label font15">Data zakończenia</legend>
		<label for="data_zakoncz_dzien">Dzień: </label>
		<select class="form-control inline_select" name="data_zakoncz_dzien" id="data_zakoncz_dzien" onchange="date_callback('data_rozp_dzien','data_rozp_miesiac','data_rozp_rok','data_zakoncz_dzien','data_zakoncz_miesiac','data_zakoncz_rok')">
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
		<select class="form-control inline_select" name="data_zakoncz_miesiac" id="data_zakoncz_miesiac" onchange="date_callback('data_rozp_dzien','data_rozp_miesiac','data_rozp_rok','data_zakoncz_dzien','data_zakoncz_miesiac','data_zakoncz_rok')">
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
		<select class="form-control inline_select" name="data_zakoncz_rok" id="data_zakoncz_rok" onchange="date_callback('data_rozp_dzien','data_rozp_miesiac','data_rozp_rok','data_zakoncz_dzien','data_zakoncz_miesiac','data_zakoncz_rok')">
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
					echo '>'.$i.'</option>';
				}
				echo '</optgroup>';
			?>
		</select>
	</fieldset>
	<div class="margin_top_10">
		<label for="opis">Opis<span class="color_red">*</span>:</label>
		<textarea class="form-control" name="opis" id="opis" rows="20" cols="100" maxlength="166666666" spellcheck="true" required="required"><?php echo $row['opis']; ?></textarea>
		<div id="opis_counter"></div>
	</div>
	<div class="margin_top_10">
		<label for="logo">Logo<span class="color_red">*</span>:</label>
		<input class="form-control" type="text" name="logo" id="logo" value="<?php echo $row['logo']; ?>" size="100" maxlength="128" required="required" />
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
						else{
							breadcrumbs('Edytowanie projektu',array('index.php?menu=17' => 'Zarządzanie projektami'));
							echo '<h1 class="font20">Błąd</h1><p>Nie znaleziono projektu o podanym identyfikatorze.</p>';
						}
					}
					else{
						breadcrumbs('Edytowanie projektu',array('index.php?menu=17' => 'Zarządzanie projektami'));
						echo '<h1 class="font20">Błąd</h1><p>Nie udało się pobrać danych z bazy danych: '.implode(' ',$st->errorInfo()).'</p>';
					}
				}
				else{
					breadcrumbs('Edytowanie projektu',array('index.php?menu=17' => 'Zarządzanie projektami'));
					echo '<h1 class="font20">Błąd</h1><p>Nie udało się pobrać danych z bazy danych: '.implode(' ',$DB->errorInfo()).'</p>';
				}
			}
			else{
				breadcrumbs('Edytowanie projektu',array('index.php?menu=17' => 'Zarządzanie projektami'));
				echo '<h1 class="font20">Błąd</h1><p>Nie podano projektu do edycji.</p>';
			}
		}
		else require 'mod_cred_req.php';
	}
	else require 'not_logged_in.php';
?>
