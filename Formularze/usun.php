<?php
	if(user::isLogged()){
		if($lvl<2){
			$user = user::getData('', '');
			if(isset($_POST['del_sprzet'])){
				breadcrumbs('Usuwanie aparatury',array('index.php?menu=8' => 'Zarządzanie aparaturą'));
				if($st=$DB->prepare('DELETE FROM Sprzet WHERE id=?')){
					if($st->execute(array($_POST['id']))) echo '<h1 class="font20">Usuwanie aparatury</h1><p>Aparatura została usunięta.</p><p><a href="index.php?menu=8">Wróć do strony zarządzania aparaturą.</a></p>';
					else echo '<h1 class="font20">Błąd</h1><p>Nastąpił błąd przy usuwaniu aparatury: '.implode(' ',$st->errorInfo()).'</p>';
				}
				else echo '<h1 class="font20">Błąd</h1><p>Nastąpił błąd przy usuwaniu aparatury: '.implode(' ',$DB->errorInfo()).'</p>';
			}
			else if(isset($_POST['del_osoba'])){
				breadcrumbs('Usuwanie osoby kontaktowej',array('index.php?menu=100' => 'Zarządzanie osobami kontaktowymi'));
				if($st=$DB->prepare('DELETE FROM Uzytkownicy WHERE login=?')){
					if($st->execute(array($_POST['email']))) echo '<h1 class="font20">Usuwanie osoby kontaktowej</h1><p>Osoba została usunięta.</p><p><a href="index.php?menu=100">Wróć do strony zarządzania osobami kontaktowymi.</a></p>';
					else echo '<h1 class="font20">Błąd</h1><p>Nastąpił błąd przy usuwaniu osoby: '.implode(' ',$st->errorInfo()).'</p>';
				}
				else echo '<h1 class="font20">Błąd</h1><p>Nastąpił błąd przy usuwaniu osoby kontaktowej: '.implode(' ',$DB->errorInfo()).'</p>';
			}
			else if(isset($_POST['del_tag'])){
				breadcrumbs('Usuwanie słowa kluczowego',array('index.php?menu=67' => 'Zarządzanie słowami kluczowymi'));
				if($st=$DB->prepare('DELETE FROM Tag WHERE id=?')){
					if($st->execute(array($_POST['id']))) echo '<h1 class="font20">Usuwanie słowa kluczowego</h1><p>Słowo kluczowe zostało usunięte.</p><p><a href="index.php?menu=67">Wróć do strony zarządzania słowami kluczowymi.</a></p>';
					else echo '<h1 class="font20">Błąd</h1><p>Nastąpił błąd przy usuwaniu tagu: '.implode(' ',$st->errorInfo()).'</p>';
				}
				else echo '<h1 class="font20">Błąd</h1><p>Nastąpił błąd przy usuwaniu słowa kluczowego: '.implode(' ',$DB->errorInfo()).'</p>';
			}
			else if(isset($_POST['del_projekt'])){
				breadcrumbs('Usuwanie projektu',array('index.php?menu=17' => 'Zarządzanie projektami'));
				if($st=$DB->prepare('DELETE FROM Projekt WHERE id=?')){
					if($st->execute(array($_POST['id']))) echo '<h1 class="font20">Usuwanie projektu</h1><p>Projekt został usunięty.</p><p><a href="index.php?menu=17">Wróć do strony zarządzania projektami.</a></p>';
					else echo '<h1 class="font20">Błąd</h1><p>Nastąpił błąd przy usuwaniu projektu: '.implode(' ',$st->errorInfo()).'</p>';
				}
				else echo '<h1 class="font20">Błąd</h1><p>Nastąpił błąd przy usuwaniu projektu: '.implode(' ',$DB->errorInfo()).'</p>';
			}
			else if(isset($_POST['del_lab'])){
				breadcrumbs('Usuwanie laboratorium',array('index.php?menu=7' => 'Zarządzanie laboratoriami'));
				if($st=$DB->prepare('DELETE FROM Laboratorium WHERE id=?')){
					if($st->execute(array($_POST['id']))) echo '<h1 class="font20">Usuwanie laboratorium</h1><p>Laboratorium zostało usunięte.</p><p><a href="index.php?menu=7">Wróć do strony zarządzania laboratoriami.</a></p>';
					else echo '<h1 class="font20">Błąd</h1><p>Nastąpił błąd przy usuwaniu laboratorium: '.implode(' ',$st->errorInfo()).'</p>';
				}
				else echo '<h1 class="font20">Błąd</h1><p>Nastąpił błąd przy usuwaniu laboratorium: '.implode(' ',$DB->errorInfo()).'</p>';
			}
			else if(isset($_POST['del_zespol'])){
				breadcrumbs('Usuwanie zespołu laboratoriów',array('index.php?menu=9' => 'Zarządzanie zespołami laboratoriów'));
				if($st=$DB->prepare('DELETE FROM Zespol WHERE id=?')){
					if($st->execute(array($_POST['id']))) echo '<h1 class="font20">Usuwanie zespołu laboratoriów</h1><p>Zespół laboratoriów został usunięty.</p><p><a href="index.php?menu=9">Wróć do strony zarządzania zespołami laboratoriów.</a></p>';
					else echo '<h1 class="font20">Błąd</h1><p>Nastąpił błąd przy usuwaniu zespołu: '.implode(' ',$st->errorInfo()).'</p>';
				}
				else echo '<h1 class="font20">Błąd</h1><p>Nastąpił błąd przy usuwaniu zespołu laboratorium: '.implode(' ',$DB->errorInfo()).'</p>';
			}
			else if(isset($_POST['del_zaklad'])){
				breadcrumbs('Usuwanie zakładu',array('index.php?menu=66' => 'Zarządzanie zakładów'));
				if($st=$DB->prepare('DELETE FROM Zaklad WHERE id=?')){
					if($st->execute(array($_POST['id']))) echo '<h1 class="font20">Usuwanie zakładu</h1><p>Zakład został usunięty.</p><p><a href="index.php?menu=66">Wróć do strony zarządzania zakładami.</a></p>';
					else echo '<h1 class="font20">Błąd</h1><p>Nastąpił błąd przy usuwaniu zakładu: '.implode(' ',$st->errorInfo()).'</p>';
				}
				else echo '<h1 class="font20">Błąd</h1><p>Nastąpił błąd przy usuwaniu zakładu: '.implode(' ',$DB->errorInfo()).'</p>';
			}
			else if(isset($_POST['del_uzytkownika'])){
				if($lvl===0){
					breadcrumbs('Usuwanie użytkownika',array('index.php?menu=12' => 'Zarządzanie użytkownikami'));
					if($st=$DB->prepare('DELETE FROM Uzytkownicy WHERE id=?')){
						if($st->execute(array($_POST['id']))){ 
							echo '<h1 class="font20">Usuwanie użytkownika</h1><p>Użytkownik został usunięty.</p><p><a href="index.php?menu=13">Wróć do strony zarządzania użytkownikami.</a></p>';
						}
						else echo '<h1 class="font20">Błąd</h1><p>Nastąpił błąd przy usuwaniu zdjęcia: '.implode(' ',$st->errorInfo()).'</p>';
					}
					else echo '<h1 class="font20">Błąd</h1><p>Nastąpił błąd przy usuwaniu zdjęć: '.implode(' ',$DB->errorInfo()).'</p>';
				}
				else require 'admin_cred_req.php';
			}
			else if(isset($_POST['del_zdjecie'])){
				breadcrumbs('Usuwanie zdjęcia',array('index.php?menu=12' => 'Zarządzanie zdjęciami'));
				if($st=$DB->prepare('DELETE FROM Zdjecie WHERE id=?')){
					if($st->execute(array($_POST['id']))) echo '<h1 class="font20">Usuwanie zdjęcia</h1><p>Zdjęcie zostało usunięte.</p><p><a href="index.php?menu=12">Wróć do strony zarządzania zdjęciami.</a></p>';
					else echo '<h1 class="font20">Błąd</h1><p>Nastąpił błąd przy usuwaniu zdjęcia: '.implode(' ',$st->errorInfo()).'</p>';
				}
				else echo '<h1 class="font20">Błąd</h1><p>Nastąpił błąd przy usuwaniu zdjęcia: '.implode(' ',$DB->errorInfo()).'</p>';
			}
		}
		else require 'mod_cred_req.php';
	}
	else require 'not_logged_in.php';
?>
