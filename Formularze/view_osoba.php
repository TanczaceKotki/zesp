<?php
	if(user::isLogged()){
?>
<ol class="breadcrumb">
	<li><a href="index.php">Start</a></li>
	<li><a href="index.php?menu=100">Zarządzaj osobami kontaktowymi</a></li>
	<li class="active">Szczegóły osoba kontaktowa</li>
</ol>
<?php
	if(isset($_POST['del_kontakt'])){
		if($st=$DB->prepare('DELETE FROM Kontakt WHERE sprzet=? AND osoba=?')){
			if($st->execute(array($_POST['sprzet'],$_POST['osoba']))) echo 'Informacje kontaktowe zostały usunięte.<br /><br />';
			else echo 'Nastąpił błąd przy usuwaniu informacji kontaktowych: '.implode(' ',$st->errorInfo()).'<br /><br />';
		}
		else echo 'Nastąpił błąd przy usuwaniu informacji kontaktowych: '.implode(' ',$DB->errorInfo()).'<br /><br />';
	}
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
					if(!$send) echo 'Osoba została pomyślnie zmodyfikowana.<br /><br />';
				}
				else{
					echo 'Nastąpił błąd przy modyfikowaniu osoby: '.implode(' ',$st->errorInfo()).'<br /><br />';
				}
			}
			else echo 'Nastąpił błąd przy modyfikowaniu osoby: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
		if($send){
			$sql.=' WHERE id=?';
			$params[]=$_POST['id'];
			if($st=$DB->prepare($sql)){
				if($st->execute($params)){
					echo 'Osoba została pomyślnie zmodyfikowana.<br /><br />';
				}
				else echo 'Nastąpił błąd przy modyfikowaniu osoby: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
			else echo 'Nastąpił błąd przy modyfikowaniu osoby: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
	}
	if($st=$DB->prepare('SELECT * FROM Osoba WHERE id=?')){
		if($st->execute(array($_GET['id']))){
			if($row=$st->fetch(PDO::FETCH_ASSOC)){
				?>
				<table class="table table-striped">
					<tbody>
						<tr>
							<th>Imię:</th>
							<td colspan="2"><?php echo $row['imie']; ?></td>
						</tr>
						<tr>
							<th>Nazwisko:</th>
							<td colspan="2"><?php echo $row['nazwisko']; ?></td>
						</tr>
						<tr>
							<th>Adres email:</th>
							<td colspan="2"><a href="mailto:<?php echo $row['email']; ?>"><?php echo $row['email']; ?></a></td>
						</tr>
						<tr>
							<th>Sprzęt:</th>
							<td
								<?php
								$i=1;
								if($result=$DB->prepare('SELECT sprzet FROM Kontakt WHERE osoba=? ORDER BY sprzet')){
									if($result->execute(array($row['id']))){
										while($row2=$result->fetch(PDO::FETCH_ASSOC)){
											if($result2=$DB->prepare('SELECT nazwa FROM Sprzet WHERE id=?')){
												if($result2->execute(array($row2['sprzet']))){
													if($row3=$result2->fetch(PDO::FETCH_ASSOC)){
														if($i>1) echo '</tr><tr><td></td><td>';
														else echo '>';
														?><a href="index.php?menu=52&amp;id=<?php echo $row2['sprzet']; ?>"><?php echo $row3['nazwa']; ?></a>
													</td>
													<td>
														<form action="index.php?menu=54&amp;id=<?php echo $row['id']; ?>" method="post" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
															<input type="hidden" name="osoba" value="<?php echo $row['id']; ?>" />
															<input type="hidden" name="sprzet" value="<?php echo $row2['sprzet']; ?>" />
															<input type="submit" name="del_kontakt" value="Usuń" />
														</form>
														<?php
														++$i;
													}
												}
												else echo 'Nie udało się pobrać danych z bazy danych.';
											}
											else echo 'Nie udało się pobrać danych z bazy danych.';
										}
										
									}
									else echo 'Nie udało się pobrać danych z bazy danych.';
								}
								else echo 'Nie udało się pobrać danych z bazy danych.';
								if($i===1) echo ' colspan="2">';
								?>
							</td>
						</tr>
					</tbody>
				</table>
				<?php 
			}
			else echo 'Nie znaleziono osoby o podanym identyfikatorze.<br /><br />';
		}
		else echo 'Nastąpił błąd przy pobieraniu informacji o osobie: '.implode(' ',$st->errorInfo()).'<br /><br />';
	}
	else echo 'Nastąpił błąd przy pobieraniu informacji o osobie: '.implode(' ',$DB->errorInfo()).'<br /><br />';
?>
<a class="btn btn-warning" href="index.php?menu=100">Wróć do strony zarządzania osobami kontaktowymi</a>
<?php
	}
	else echo '<br />Nie jesteś zalogowany.<br /><a href="index.php?menu=10">Zaloguj się</a><br /><br /> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
?>
