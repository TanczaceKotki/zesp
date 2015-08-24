<?php
	if(user::isLogged()){
		if(isset($_POST['id'])){
			$allow=false;
			if($lvl===2){
				if($st=$DB->prepare('SELECT id FROM Sprzet WHERE id IN (SELECT sprzet FROM Kontakt WHERE osoba IN (SELECT id FROM Osoba WHERE email=?))')){
					if($st->execute(array($_SESSION['login']))){
						while($row=$st->fetch(PDO::FETCH_ASSOC)){
							if($row['id']===$_POST['id']) $allow=true;
						}
						if(!$allow) require 'cred_low.php';
					}
				}
			}
			else if($lvl<2) $allow=true;
			else require 'cred_low.php';
			if($allow){
				$msg="";
				if(isset($_POST['submitted'])){
					$send=False;
					$params=array();
					$sql='UPDATE Sprzet SET';
					if($_POST['nazwa']!==$_POST['old_nazwa']){
						$sql.=' nazwa=?';
						$params[]=$_POST['nazwa'];
						$send=True;
					}
					$data=$_POST['data_zakupu_rok'];
					if($_POST['data_zakupu_miesiac']!==""){
						$data.='-'.$_POST['data_zakupu_miesiac'];
						if($_POST['data_zakupu_dzien']!=="") $data.='-'.$_POST['data_zakupu_dzien'];
					}
					if($data!==$_POST['old_data_zakupu']){
						if($send) $sql.=',';
						$sql.=' data_zakupu=?';
						$params[]=$data;
						$send=True;
					}
					$data="";
					if($_POST['data_uruchom_rok']!==""){
						$data=$_POST['data_uruchom_rok'];
						if($_POST['data_uruchom_miesiac']!==""){
							$data.='-'.$_POST['data_uruchom_miesiac'];
							if($_POST['data_uruchom_dzien']!=="") $data.='-'.$_POST['data_uruchom_dzien'];
						}
					}
					if($data!==$_POST['old_data_uruchom']){
						if($send) $sql.=',';
						if($data==="") $sql.=' data_uruchom=NULL';
						else{
							$sql.=' data_uruchom=?';
							$params[]=$data;
						}
						$send=True;
					}
					if($_POST['wartosc']!==$_POST['old_wartosc']){
						if($send) $sql.=',';
						if($data==="") $sql.=' wartosc=NULL';
						else{
							$sql.=' wartosc=?';
							$params[]=$_POST['wartosc'];
						}
						$send=True;
					}
					if($_POST['opis']!==$_POST['old_opis']){
						if($send) $sql.=',';
						$sql.=' opis=?';
						$params[]=$_POST['opis'];
						$send=True;
					}
					if($_POST['projekt']!==$_POST['old_projekt']){
						if($send) $sql.=',';
						if($_POST['projekt']==="") $sql.=' projekt=NULL';
						else{
							$sql.=' projekt=?';
							$params[]=$_POST['projekt'];
						}
						$send=True;
					}
					if($_POST['laboratorium']!==$_POST['old_laboratorium']){
						if($send) $sql.=',';
						if($_POST['laboratorium']==="") $sql.=' laboratorium=NULL';
						else{
							$sql.=' laboratorium=?';
							$params[]=$_POST['laboratorium'];
						}
						$send=True;
					}
					if($send){
						$sql.=' WHERE id=?';
						$params[]=$_POST['id'];
						if($st=$DB->prepare($sql)){
							if($st->execute($params)){
								header('Location:index.php?menu=52&id='.$_POST['id']);
								die();
							}
							else $msg='<p>Nastąpił błąd przy modyfikowaniu aparatury: '.implode(' ',$st->errorInfo()).'</p>';
						} 
						else $msg='<p>Nastąpił błąd przy modyfikowaniu aparatury: '.implode(' ',$DB->errorInfo()).'</p>';
					}
				}
				if($st=$DB->prepare('SELECT * FROM Sprzet WHERE id=?')){
					if($st->execute(array($_POST['id']))){
						if($row=$st->fetch(PDO::FETCH_ASSOC)){
							breadcrumbs('Edytowanie aparatury',array('index.php?menu=8' => 'Zarządzanie aparaturą',"index.php?menu=52&amp;id=$_POST[id]" => 'Szczegóły aparatury'));
							echo "<h1 class=\"font20\">Edytowanie aparatury</h1>$msg";
?>
<form action="index.php?menu=45" method="post" accept-charset="utf-8" enctype="application/x-www-form-urlencoded" onsubmit="return check_if_number()">
	<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
	<input type="hidden" name="old_nazwa" value="<?php echo $row['nazwa']; ?>" />
	<input type="hidden" name="old_data_zakupu" value="<?php echo $row['data_zakupu']; ?>" />
	<input type="hidden" name="old_data_uruchom" value="<?php echo $row['data_uruchom']; ?>" />
	<input type="hidden" name="old_wartosc" value="<?php echo $row['wartosc']; ?>" />
	<input type="hidden" name="old_opis" value="<?php echo $row['opis']; ?>" />
	<input type="hidden" name="old_projekt" value="<?php echo $row['projekt']; ?>" />
	<input type="hidden" name="old_laboratorium" value="<?php echo $row['laboratorium']; ?>" />
	<label for="nazwa">Nazwa<span class="color_red">*</span>:</label>
	<input class="form-control" type="text" name="nazwa" id="nazwa" value="<?php echo $row['nazwa']; ?>" size="100" maxlength="512" spellcheck="true" required="required" />
	<div id="nazwa_counter"></div>
	<?php
		$data_zakupu=explode('-',$row['data_zakupu']);
	?>
	<fieldset class="margin_top_10">
		<legend class="group_label font15">Data zakupu:</legend>
		<label for="data_zakupu_dzien">Dzień: </label>
		<select class="form-control inline_select" name="data_zakupu_dzien" id="data_zakupu_dzien">
			<option value=""<?php if(!isset($data_zakupu[2])) echo ' selected="selected"'; ?>>-</option>
			<?php
				for($i=1;$i<32;++$i){
					echo '<option value="'.$i.'"';
					if(isset($data_zakupu[2])){
						if(intval($data_zakupu[2])===$i) echo ' selected="selected"';
					}
					echo '>'.$i.'</option>';
				}
			?>
		</select>
		<label for="data_zakupu_miesiac"> Miesiąc: </label>
		<select class="form-control inline_select" name="data_zakupu_miesiac" id="data_zakupu_miesiac" onchange="day_switch_with_required_year()">
			<option value=""<?php if(!isset($data_zakupu[1])) echo ' selected="selected"'; ?>>-</option>
			<?php
				$months=array('styczeń','luty','marzec','kwiecień','maj','czerwiec','lipiec','sierpień','wrzesień','październik','listopad','grudzień');
				for($i=0;$i<12;++$i){
					$val=$i+1;
					echo '<option value="'.$val.'"';
					if(isset($data_zakupu[1])){
						if(intval($data_zakupu[1])===$val) echo ' selected="selected"';
					}
					echo '>'.$months[$i].'</option>';
				}
			?>
		</select>
		<label for="data_zakupu_rok"> Rok<span class="color_red">*</span>: </label>
		<select class="form-control inline_select" name="data_zakupu_rok" id="data_zakupu_rok" onchange="day_switch_with_required_year()" required="required">
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
					if(intval($data_zakupu[0])===$i) echo ' selected="selected"';
					echo '>'.$i.'</option>';
				}
				echo '</optgroup>';
			?>
		</select>
	</fieldset>
	<?php
		$data_uruchom=explode('-',$row['data_uruchom']);
	?>
	<fieldset class="margin_top_10">
		<legend class="group_label font15">Data uruchomienia:</legend>
		<label for="data_uruchom_dzien">Dzień: </label>
		<select class="form-control inline_select" name="data_uruchom_dzien" id="data_uruchom_dzien">
			<option value=""<?php if(!isset($data_uruchom[2])) echo ' selected="selected"'; ?>>-</option>
			<?php
				for($i=1;$i<32;++$i){
					echo '<option value="'.$i.'"';
					if(isset($data_uruchom[2])){
						if(intval($data_uruchom[2])===$i) echo ' selected="selected"';
					}
					echo '>'.$i.'</option>';
				}
			?>
		</select>
		<label for="data_uruchom_miesiac"> Miesiąc: </label>
		<select class="form-control inline_select" name="data_uruchom_miesiac" id="data_uruchom_miesiac" onchange="day_switch_with_optional_year()">
			<option value=""<?php if(!isset($data_uruchom[1])) echo ' selected="selected"'; ?>>-</option>
			<?php
				$months=array('styczeń','luty','marzec','kwiecień','maj','czerwiec','lipiec','sierpień','wrzesień','październik','listopad','grudzień');
				for($i=0;$i<12;++$i){
					$val=$i+1;
					echo '<option value="'.$val.'"';
					if(isset($data_uruchom[1])){
						if(intval($data_uruchom[1])===$val) echo ' selected="selected"';
					}
					echo '>'.$months[$i].'</option>';
				}
			?>
		</select>
		<label for="data_uruchom_rok"> Rok: </label>
		<select class="form-control inline_select" name="data_uruchom_rok" id="data_uruchom_rok" onchange="day_switch_with_optional_year()">
			<option value=""<?php if($data_uruchom[0]==="") echo ' selected="selected"'; ?>>-</option>
			<?php
				$curdecade=(intval(date('Y'))+1)-(intval(date('Y'))+1)%10;
				echo '<optgroup label="'.$curdecade.' - '.(intval(date('Y'))+1).'">';
				for($i=intval(date('Y'))+1;$i>=1950;--$i){
					if($curdecade!=$i-$i%10){
						$curdecade=$i-$i%10;
						echo '</optgroup><optgroup label="'.$curdecade.' - '.($curdecade+9).'">';
					}
					echo '<option value="'.$i.'"';
					if(intval($data_uruchom[0])===$i) echo ' selected="selected"';
					echo '>'.$i.'</option>';
				}
				echo '</optgroup>';
			?>
		</select>
	</fieldset>
	<div class="margin_top_10">
		<label for="wartosc">Wartość w groszach:</label>
		<input class="form-control" type="number" name="wartosc" id="wartosc" value="<?php echo $row['wartosc']; ?>" min="0" step="1" max="9223372036854775807" maxlength="19" size="19" onchange="check_if_number()" />
	</div>
	<div class="margin_top_10">
		<label for="opis">Opis<span class="color_red">*</span>:</label>
		<textarea class="form-control" name="opis" id="opis" rows="20" cols="100" maxlength="166666666" spellcheck="true" required="required"><?php echo $row['opis']; ?></textarea>
		<div id="opis_counter"></div>
	</div>
	<div class="margin_top_10">
		<label for="projekt">Projekt:</label>
		<select class="form-control" name="projekt" id="projekt">
			<option value=""<?php if($row['projekt']==="") echo ' selected="selected"'; ?>>-</option>
			<?php
				if($result=$DB->query('SELECT id,nazwa FROM Projekt ORDER BY nazwa')){
					if($rows=$result->fetchAll(PDO::FETCH_ASSOC)){
						$first_letter=$rows[0]['nazwa'][0];
						echo '<optgroup label="'.$first_letter.'">';
						foreach($rows as $row2){
							if($first_letter!==$row2['nazwa'][0]){
								$first_letter=$row2['nazwa'][0];
								echo '</optgroup><optgroup label="'.$first_letter.'">';
							}
							echo '<option value="'.$row2['id'].'"';
							if($row['projekt']===$row2['id']) echo ' selected="selected"';
							echo '>'.$row2['nazwa'].'</option>';
						}
						echo '</optgroup>';
					}
				}
			?>
		</select>
	</div>
	<div class="margin_top_10">
		<label for="laboratorium">Laboratorium:</label>
		<select class="form-control" name="laboratorium" id="laboratorium">
			<option value=""<?php if($row['laboratorium']==="") echo ' selected="selected"'; ?>>-</option>
			<?php
				if($result=$DB->query('SELECT id,nazwa FROM Laboratorium ORDER BY nazwa')){
					if($rows=$result->fetchAll(PDO::FETCH_ASSOC)){
						
						$first_letter=$rows[0]['nazwa'][0];
						echo '<optgroup label="'.$first_letter.'">';
						foreach($rows as $row2){
							if($first_letter!==$row2['nazwa'][0]){
								$first_letter=$row2['nazwa'][0];
								echo '</optgroup><optgroup label="'.$first_letter.'">';
							}
							echo '<option value="'.$row2['id'].'"';
							if($row['laboratorium']===$row2['id']) echo ' selected="selected"';
							echo '>'.$row2['nazwa'].'</option>';
						}
						echo '</optgroup>';
					}
				}
			?>
		</select>
	</div>
	<div class="margin_top_10">
		<input class="btn btn-primary" type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<p class="margin_top_10"><span class="color_red">*</span> - wymagane pola.</p>
<?php
							foreach(array('https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js','js/remaining_char_counter.js','js/sprzet_form.js') as $script){
								echo '<script src="'.$script.'" type="text/javascript"></script>';
							}
						}
						else{
							breadcrumbs('Edytowanie aparatury',array('index.php?menu=8' => 'Zarządzanie aparaturą'));
							echo '<h1 class="font20">Błąd</h1><p>Nie znaleziono aparatury o podanym identyfikatorze.</p>';
						}
					}
					else{
						breadcrumbs('Edytowanie aparatury',array('index.php?menu=8' => 'Zarządzanie aparaturą'));
						echo '<h1 class="font20">Błąd</h1><p>Nie udało się pobrać danych z bazy danych: '.implode(' ',$st->errorInfo()).'</p>';
					}
				}
				else{
					breadcrumbs('Edytowanie aparatury',array('index.php?menu=8' => 'Zarządzanie aparaturą'));
					echo '<h1 class="font20">Błąd</h1><p>Nie udało się pobrać danych z bazy danych: '.implode(' ',$DB->errorInfo()).'</p>';
				}
			}
		}
		else{
			breadcrumbs('Edytowanie aparatury',array('index.php?menu=8' => 'Zarządzanie aparaturą'));
			echo '<h1 class="font20">Błąd</h1><p>Nie podano sprzętu do edycji.</p>';
		}
	}
	else require 'not_logged_in.php';
?>
