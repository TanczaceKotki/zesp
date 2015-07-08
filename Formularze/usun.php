<?php if (user::isLogged()) {
		$user = user::getData('', '');
		if(isset($_POST['del_sprzet'])){
			if($st=$DB->prepare('DELETE FROM Sprzet WHERE id=?')){
				if($st->execute(array($_POST['id']))) echo 'Sprzęt został usunięty.<br /><br />';
				else echo 'Nastąpił błąd przy usuwaniu sprzętu: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
			else echo 'Nastąpił błąd przy usuwaniu sprzętu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
		if(isset($_POST['del_osoba'])){
			if($st=$DB->prepare('DELETE FROM Osoba WHERE id=?')){
				if($st->execute(array($_POST['id']))) echo 'Osoba została usunięta.<br /><br />';
				else echo 'Nastąpił błąd przy usuwaniu osoby: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
			else echo 'Nastąpił błąd przy usuwaniu osoby: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
		if(isset($_POST['del_tag'])){
			if($st=$DB->prepare('DELETE FROM Tag WHERE id=?')){
				if($st->execute(array($_POST['id']))) echo 'Tag został usunięty.<br /><br />';
				else echo 'Nastąpił błąd przy usuwaniu tagu: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
			else echo 'Nastąpił błąd przy usuwaniu tagu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
		if(isset($_POST['del_projekt'])){
			if($st=$DB->prepare('DELETE FROM Projekt WHERE id=?')){
				if($st->execute(array($_POST['id']))) echo 'Projekt został usunięty.<br /><br />';
				else echo 'Nastąpił błąd przy usuwaniu projektu: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
			else echo 'Nastąpił błąd przy usuwaniu projektu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
		if(isset($_POST['del_lab'])){
			if($st=$DB->prepare('DELETE FROM Laboratorium WHERE id=?')){
				if($st->execute(array($_POST['id']))) echo 'Laboratorium zostało usunięte.<br /><br />';
				else echo 'Nastąpił błąd przy usuwaniu laboratorium: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
			else echo 'Nastąpił błąd przy usuwaniu laboratorium: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
		if(isset($_POST['del_zespol'])){
			if($st=$DB->prepare('DELETE FROM Zespol WHERE id=?')){
				if($st->execute(array($_POST['id']))) echo 'Zespół został usunięty.<br /><br />';
				else echo 'Nastąpił błąd przy usuwaniu zespołu: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
			else echo 'Nastąpił błąd przy usuwaniu zespołu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
		if(isset($_POST['del_zaklad'])){
			if($st=$DB->prepare('DELETE FROM Zaklad WHERE id=?')){
				if($st->execute(array($_POST['id']))) echo 'Zakład został usunięty.<br /><br />';
				else echo 'Nastąpił błąd przy usuwaniu zakładu: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
			else echo 'Nastąpił błąd przy usuwaniu zakładu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
		if(isset($_POST['del_uzytkownika'])){
									if($st=$DB->prepare('DELETE FROM Uzytkownicy WHERE id=?')){
										if($st->execute(array($_POST['id']))){ 
											echo 'Użytkownik został usunięty.<br />';}}}
		if(isset($_POST['del_zdjecie'])){
			if($st=$DB->prepare('DELETE FROM Zdjecie WHERE id=?')){
				if($st->execute(array($_POST['id']))) echo 'Zdjęcie zostało usunięte.<br /><br />';
				else echo 'Nastąpił błąd przy usuwaniu zdjęcia: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
			else echo 'Nastąpił błąd przy usuwaniu zdjęcia: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		} }
else {
		echo '<br>Nie jesteś zalogowany.<br />
		<a href="login.php">Zaloguj się</a><br><br> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
	} 
?>
