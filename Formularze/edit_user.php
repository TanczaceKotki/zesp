<?php
	if(user::isLogged()){
		if($lvl===0){
			$msg="";
			if(isset($_POST['submitted'])){
				$send=false;
				$add_osoba=false;
				$params=array();
				$sql='UPDATE Uzytkownicy SET';
				if($_POST['login']!==$_POST['old_login']){
					$sql.=' login=?';
					$params[]=$_POST['login'];
					$send=true;
				}
				if($_POST['pass']!==''){
					if($_POST['pass']===$_POST['pass_v']){
						if($send) $sql.=',';
						$sql.=' pass=?';
						$params[]=password_hash($_POST['pass'], PASSWORD_DEFAULT);
						$send=true;
					}
					else $msg='<p>Wpisane hasła się nie zgadzają.</p>';
				}
				if($_POST['lvl']!==$_POST['old_lvl']){
					if($send) $sql.=',';
					$sql.=' lvl=?';
					$params[]=$_POST['lvl'];
					if($_POST['lvl']==='2') $add_osoba=true;
					else if($_POST['old_lvl']==='2'){
						if($st=$DB->prepare('DELETE FROM Osoba WHERE email=?')){
							if(!$st->execute(array($_POST['old_login']))) $msg+='<p>Nastąpił błąd przy modyfikowaniu użytkownika: '.implode(' ',$st->errorInfo()).'</p>';
						}
						else $msg+='<p>Nastąpił błąd przy modyfikowaniu użytkownika: '.implode(' ',$DB->errorInfo()).'</p>';
					}
					$send=true;
				}
				else if($_POST['lvl']==='2'){
					$send2=False;
					$params2=array();
					$sql2='UPDATE Osoba SET';
					if($_POST['imie']!==$_POST['old_imie']){
						$sql2.=' imie=?';
						$params2[]=$_POST['imie'];
						$send2=True;
					}
					if($_POST['nazwisko']!==$_POST['old_nazwisko']){
						if($send2) $sql2.=',';
						$sql2.=' nazwisko=?';
						$params2[]=$_POST['nazwisko'];
						$send2=True;
					}
					if($send2){
						$sql2.=' WHERE email=?';
						$params2[]=$_POST['login'];
						if($st=$DB->prepare($sql2)){
							if($st->execute($params2)){
								if(!$send){
									header("Location:index.php?menu=118&id=$_POST[id]");
									die();
								}
							}
							else $msg+='<p>Nastąpił błąd przy modyfikowaniu użytkownika: '.implode(' ',$st->errorInfo()).'</p>';
						}
						else $msg+='<p>Nastąpił błąd przy modyfikowaniu użytkownika: '.implode(' ',$DB->errorInfo()).'</p>';
					}
				}
				if($send){
					$sql.=' WHERE id=?';
					$params[]=$_POST['id'];
					if($st=$DB->prepare($sql)){
						if($st->execute($params)){
							if($add_osoba){
								if($st2=$DB->prepare('INSERT INTO Osoba VALUES(NULL,?,?,?)')){
									if($st2->execute(array($_POST['imie'],$_POST['nazwisko'],$_POST['login']))){
										header("Location:index.php?menu=118&id=$_POST[id]");
										die();
									}
									else{
										$msg+='<p>Nastąpił błąd przy modyfikowaniu użytkownika: '.implode(' ',$st->errorInfo()).'</p>';
									}
								}
								else $msg+='<p>Nastąpił błąd przy modyfikowaniu użytkownika: '.implode(' ',$DB->errorInfo()).'</p>';
							}
							else{
								header("Location:index.php?menu=118&id=$_POST[id]");
								die();
							}
						}
						else $msg+='<p>Nastąpił błąd przy modyfikowaniu użytkownika: '.implode(' ',$st->errorInfo()).'</p>';
					}
					else $msg+='<p>Nastąpił błąd przy modyfikowaniu użytkownika: '.implode(' ',$DB->errorInfo()).'</p>';
				}
			}
			if(isset($_POST['id'])){
				if($st=$DB->prepare('SELECT id,login,lvl FROM Uzytkownicy WHERE id=?')){
					if($st->execute(array($_POST['id']))){
						if($row=$st->fetch(PDO::FETCH_ASSOC)){
							breadcrumbs('Edytowanie użytkownika',array('index.php?menu=13' => 'Zarządzanie użytkownikami',"index.php?menu=118&amp;id=$_POST[id]" => 'Szczegóły użytkownika'));
							echo "<h1 class=\"font20\">Edytowanie użytkownika</h1>$msg";
?>
<form action="index.php?menu=43" method="post" accept-charset="utf-8" enctype="application/x-www-form-urlencoded">
	<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
	<input type="hidden" name="old_login" id="old_login" value="<?php echo $row['login']; ?>" />
	<input type="hidden" name="old_lvl" value="<?php echo $row['lvl']; ?>" />
	<?php
		if($row['lvl']==='2'){
			if($st2=$DB->prepare('SELECT imie,nazwisko FROM Osoba WHERE email=?')){
				if($st2->execute(array($row['login']))){
					$row2=$st2->fetch(PDO::FETCH_ASSOC);
					?>
					<input type="hidden" name="old_imie" value="<?php echo $row2['imie']; ?>" />
					<input type="hidden" name="old_nazwisko" value="<?php echo $row2['nazwisko']; ?>" />
					<?php
				}
			}
		}
	?>
	<label for="login" id="login_label">Login<span class="color_red">*</span>:</label>
	<input class="form-control" type="text" name="login" id="login" value="<?php echo $row['login']; ?>" size="100" maxlength="254" required="required" onchange="check_login_edit()" />
	<div id="login_counter"></div>
	<div class="margin_top_10">
		<label for="pass">Nowe hasło:</label>
		<input class="form-control" type="password" name="pass" id="pass" value="" size="100" maxlength="512" onchange="compare_pass()" />
		<div id="pass_counter"></div>
		<p>Zostaw to pole puste aby nie zmieniać hasła.</p>
	</div>
	<div class="margin_top_10">
		<label for="pass">Nowe hasło (powtórz):</label>
		<input class="form-control" type="password" name="pass_v" id="pass_v" value="" size="100" maxlength="512" onchange="compare_pass()" />
		<div id="pass_v_counter"></div>
		<p>Zostaw to pole puste aby nie zmieniać hasła.</p>
	</div>
	<fieldset class="margin_top_10">
		<legend class="group_label font15">Poziom uprawnień<span class="color_red">*</span></legend>
		<label><input type="radio" name="lvl" value="0" onchange="not_level_2()"<?php if($row['lvl']==='0') echo ' checked="checked"'; ?> required="required" /> Administrator</label>
		<div class="margin_top_10">
			<label><input type="radio" name="lvl" value="1" onchange="not_level_2()"<?php if($row['lvl']==='1') echo ' checked="checked"'; ?> required="required" /> Moderator</label>
		</div>
		<div class="margin_top_10">
			<label><input type="radio" name="lvl" id="kont" onchange="level_2()" value="2"<?php if($row['lvl']==='2') echo ' checked="checked"'; ?> required="required" /> Osoba kontaktowa</label>
		</div>
	</fieldset>
	<fieldset class="margin_top_10" id="kont_inputs">
		<legend class="group_label font15">Dane osoby kontaktowej<span class="color_red">*</span></legend>
		<label for="imie">Imię<span class="color_red">*</span>:</label>
		<input class="form-control" type="text" name="imie" id="imie" value="<?php if(isset($row2['imie'])) echo $row2['imie']; ?>" size="16" maxlength="16" />
		<div id="imie_counter"></div>
		<div class="margin_top_10">
			<label for="nazwisko">Nazwisko<span class="color_red">*</span>:</label>
			<input class="form-control" type="text" name="nazwisko" id="nazwisko" value="<?php if(isset($row2['nazwisko'])) echo $row2['nazwisko']; ?>" size="32" maxlength="32" />
			<div id="nazwisko_counter"></div>
		</div>
	</fieldset>
	<div class="margin_top_10">
		<input class="btn btn-warning" type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<p class="margin_top_10"><span class="color_red">*</span> - wymagane pola.</p>
<?php
							foreach(array('js/ask_db.js','js/check_email.js','js/remaining_char_counter.js','js/user_form_edit.js','js/user_lib.js') as $script) echo '<script src="'.$script.'" type="text/javascript"></script>';
						}
						else{
							breadcrumbs('Edytowanie użytkownika',array('index.php?menu=13' => 'Zarządzanie użytkownikami'));
							echo '<h1 class="font20">Błąd</h1><p>Nie znaleziono użytkownika o podanym identyfikatorze.</p>';
						}
					}
					else{
						breadcrumbs('Edytowanie użytkownika',array('index.php?menu=13' => 'Zarządzanie użytkownikami'));
						echo '<h1 class="font20">Błąd</h1><p>Nie udało się pobrać danych z bazy danych: '.implode(' ',$st->errorInfo()).'</p>';
					}
				}
				else{
					breadcrumbs('Edytowanie użytkownika',array('index.php?menu=13' => 'Zarządzanie użytkownikami'));
					echo '<h1 class="font20">Błąd</h1><p>Nie udało się pobrać danych z bazy danych: '.implode(' ',$DB->errorInfo()).'</p>';
				}
			}
			else{
				breadcrumbs('Edytowanie użytkownika',array('index.php?menu=13' => 'Zarządzanie użytkownikami'));
				echo '<h1 class="font20">Błąd</h1><p>Nie podano użytkownika do edycji.</p>';
			}
		}
		else require 'admin_cred_req.php';
	}
	else require 'not_logged_in.php';
?>
