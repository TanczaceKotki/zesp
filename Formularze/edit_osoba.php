<?php
	if(user::isLogged()){
		if(isset($_POST['id'])){
			$allow=false;
			if($lvl===2){
				if($st=$DB->prepare('SELECT id FROM Osoba WHERE email=?')){
					if($st->execute(array($_SESSION['login']))){
						if($row=$st->fetch(PDO::FETCH_ASSOC)){
							if($row['id']===$_POST['id']) $allow=true;
							else require 'cred_low.php';
						}
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
					$sql='UPDATE Osoba SET';
					if($_POST['imie']!==$_POST['old_imie']){
						$sql.=' imie=?';
						$params[]=$_POST['imie'];
						$send=True;
					}
					if($_POST['nazwisko']!==$_POST['old_nazwisko']){
						if($send) $sql.=',';
						$sql.=' nazwisko=?';
						$params[]=$_POST['nazwisko'];
						$send=True;
					}
					if($_POST['email']!==$_POST['old_email']){
						if($st=$DB->prepare('UPDATE Uzytkownicy SET login=? WHERE login=?')){
							if($st->execute(array($_POST['email'],$_POST['old_email']))){
								if(!$send){
									header('Location:index.php?menu=54&id='.$_POST['id']);
									die();
								}
							}
							else $msg='<p>Nastąpił błąd przy modyfikowaniu osoby: '.implode(' ',$st->errorInfo()).'</p>';
						}
						else $msg='<p>Nastąpił błąd przy modyfikowaniu osoby: '.implode(' ',$DB->errorInfo()).'</p>';
					}
					if($send){
						$sql.=' WHERE id=?';
						$params[]=$_POST['id'];
						if($st=$DB->prepare($sql)){
							if($st->execute($params)){
								header('Location:index.php?menu=54&id='.$_POST['id']);
								die();
							}
							else $msg+='<p>Nastąpił błąd przy modyfikowaniu osoby: '.implode(' ',$st->errorInfo()).'</p>';
						}
						else $msg+='<p>Nastąpił błąd przy modyfikowaniu osoby: '.implode(' ',$DB->errorInfo()).'</p>';
					}
				}
				if($st=$DB->prepare('SELECT * FROM Osoba WHERE id=?')){
					if($st->execute(array($_POST['id']))){
						if($row=$st->fetch(PDO::FETCH_ASSOC)){
							breadcrumbs('Edytowanie osoby kontaktowej',array('index.php?menu=100' => 'Zarządzanie osobami kontaktowymi',"index.php?menu=54&amp;id=$_POST[id]" => 'Szczegóły osoby kontaktowej'));
							echo "<h1 class=\"font20\">Edytowanie osoby kontaktowej</h1>$msg";
?>
<form action="index.php?menu=42" method="post" accept-charset="utf-8" enctype="application/x-www-form-urlencoded" onsubmit="return ajax_check()">
	<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
	<input type="hidden" name="old_imie" value="<?php echo $row['imie']; ?>" />
	<input type="hidden" name="old_nazwisko" value="<?php echo $row['nazwisko']; ?>" />
	<input type="hidden" name="old_email" id="old_email" value="<?php echo $row['email']; ?>" />
	<label for="imie">Imię<span class="color_red">*</span>:</label>
	<input class="form-control" type="text" name="imie" id="imie" value="<?php echo $row['imie']; ?>" size="16" maxlength="16" required="required" />
	<div id="imie_counter"></div>
	<div class="margin_top_10">
		<label for="nazwisko">Nazwisko<span class="color_red">*</span>:</label>
		<input class="form-control" type="text" name="nazwisko" id="nazwisko" value="<?php echo $row['nazwisko']; ?>" size="32" maxlength="32" required="required" />
		<div id="nazwisko_counter"></div>
	</div>
	<div class="margin_top_10">
		<label for="email">Adres e-mail<span class="color_red">*</span>:</label>
		<input class="form-control" type="email" name="email" id="email" value="<?php echo $row['email']; ?>" size="32" maxlength="254" onchange="check_email_2()" required="required" />
		<div id="email_counter"></div>
	</div>
	<div class="margin_top_10">
		<input class="btn btn-primary" type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<p class="margin_top_10"><span class="color_red">*</span> - wymagane pola.</p>
<?php
							foreach(array('js/ask_db.js','js/remaining_char_counter.js','js/check_email.js','js/osoba_form_edit.js') as $script){
								echo '<script src="'.$script.'" type="text/javascript"></script>';
							}
						}
						else{
							breadcrumbs('Edytowanie osoby kontaktowej',array('index.php?menu=100' => 'Zarządzanie osobami kontaktowymi'));
							echo '<h1 class="font20">Błąd</h1><p>Nie znaleziono laboratorium o podanym identyfikatorze.</p>';
						}
					}
					else{
						breadcrumbs('Edytowanie osoby kontaktowej',array('index.php?menu=100' => 'Zarządzanie osobami kontaktowymi'));
						echo '<h1 class="font20">Błąd</h1><p>Nie udało się pobrać danych z bazy danych: '.implode(' ',$st->errorInfo()).'</p>';
					}
				}
				else{
					breadcrumbs('Edytowanie osoby kontaktowej',array('index.php?menu=100' => 'Zarządzanie osobami kontaktowymi'));
					echo '<h1 class="font20">Błąd</h1><p>Nie udało się pobrać danych z bazy danych: '.implode(' ',$DB->errorInfo()).'</p>';
				}
			}
		}
		else{
			breadcrumbs('Edytowanie osoby kontaktowej',array('index.php?menu=100' => 'Zarządzanie osobami kontaktowymi'));
			echo '<h1 class="font20">Błąd</h1><p>Nie podano osoby do edycji.</p>';
		}
	}
	else require 'not_logged_in.php';
?>
