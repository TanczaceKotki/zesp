<?php
	if(user::isLogged()){
		if($st=$DB->prepare('SELECT lvl FROM Uzytkownicy WHERE login=?'))
			if($st->execute(array($_SESSION["login"])))
				if($row=$st->fetch(PDO::FETCH_ASSOC)){
					if($row['lvl']==='0'){
?>
<ol class="breadcrumb">
	<li><a href="index.php">Start</a></li>
	<li><a href="index.php?menu=13">Zarządzanie uprawnieniami dostępu</a></li>
	<li class="active">Szczegóły użytkownik</li>
</ol>
<?php
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
			else echo 'Wpisane hasła nie są takie same<br /><br />';
		}
		if($_POST['lvl']!==$_POST['old_lvl']){
			if($send) $sql.=',';
			$sql.=' lvl=?';
			$params[]=$_POST['lvl'];
			if($_POST['lvl']==='2') $add_osoba=true;
			else if($_POST['old_lvl']==='2'){
				if($st=$DB->prepare('DELETE FROM Osoba WHERE email=?')){
					if(!$st->execute(array($_POST['old_login']))) echo 'Nastąpił błąd przy modyfikowaniu użytkownika: '.implode(' ',$st->errorInfo()).'<br /><br />';
				}
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
						echo 'Osoba została pomyślnie zmodyfikowana.<br /><br />';
					}
					else echo 'Nastąpił błąd przy modyfikowaniu osoby: '.implode(' ',$st->errorInfo()).'<br /><br />';
				}
				else echo 'Nastąpił błąd przy modyfikowaniu osoby: '.implode(' ',$DB->errorInfo()).'<br /><br />';
			}
		}
		if($send){
			$sql.=' WHERE id=?';
			$params[]=$_POST['id'];
			if($st=$DB->prepare($sql)){
				if($st->execute($params)){
					echo 'Użytkownik został pomyślnie zmodyfikowany.<br /><br />';
					if($add_osoba){
						if($st2=$DB->prepare('INSERT INTO Osoba VALUES(NULL,?,?,?)')){
							if(!$st2->execute(array($_POST['imie'],$_POST['nazwisko'],$_POST['login']))) echo 'Nastąpił błąd przy modyfikowaniu użytkownika: '.implode(' ',$st->errorInfo()).'<br /><br />';
						}
					}
				}
				else echo 'Nastąpił błąd przy modyfikowaniu użytkownika: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
			else echo 'Nastąpił błąd przy modyfikowaniu użytkownika: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
	}
	if($st=$DB->prepare('SELECT id,login,lvl FROM Uzytkownicy WHERE id=?')){
		if($st->execute(array($_POST['id']))){
			if($row=$st->fetch(PDO::FETCH_ASSOC)){
				?>
				<table class="table table-striped">
					<tbody>
						<tr>
							<th>Login</th>
							<td>
								<?php
									if($row['lvl']==='2') echo '<a href="mailto:'.$row['login'].'">'.$row['login'].'</a>';
									else echo $row['login'];
								?>
							</td>
						</tr>
						<tr>
							<th>Prawa dostępu:</th>
							<td>
								<?php
									if($row['lvl']==='0') echo 'Administrator';
									elseif($row['lvl']==='1') echo 'Moderator';
									elseif($row['lvl']==='2') echo 'Osoba kontaktowa';
								?>
							</td>
						</tr>
					</tbody>
				</table><?php 
			}
			else echo 'Nastąpił błąd przy pobieraniu danych.<br /><br />';
		}
		else echo 'Nastąpił błąd przy pobieraniu danych: '.implode(' ',$st->errorInfo()).'<br /><br />';
	}
	else echo 'Nastąpił błąd przy pobieraniu danych: '.implode(' ',$DB->errorInfo()).'<br /><br />';
?>
<a class="btn btn-warning" href="index.php?menu=13">Wróć do strony zarządzania użytkownikami</a>
<?php
					}
					else echo 'Dostęp do panelu administracyjnego dozwolony jest tylko z uprawnieniami administratora.<br /><br />';
				}
	}
	else echo '<br />Nie jesteś zalogowany.<br /><a href="index.php?menu=10">Zaloguj się</a><br /><br /> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
?>
