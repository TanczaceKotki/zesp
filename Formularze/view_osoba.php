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
	if($st=$DB->prepare('SELECT * FROM Osoba WHERE id=?')){
		if($st->execute(array($_GET['id']))){
			if($row=$st->fetch(PDO::FETCH_ASSOC)){
				?>
				<table class="table table-striped">
					<tbody>
						<tr>
							<th>Imię</th>
							<td colspan="2"> <?php echo htmlspecialchars($row['imie'],ENT_QUOTES|ENT_HTML5,'UTF-8',false); ?></td>
						</tr>
						<tr>
							<th>Nazwisko</th>
							<td colspan="2"> <?php echo htmlspecialchars($row['nazwisko'],ENT_QUOTES|ENT_HTML5,'UTF-8',false); ?></td>
						</tr>
						<tr>
							<th>Adres email</th>
							<td colspan="2"><a href="mailto: <?php echo htmlspecialchars($row['email'],ENT_QUOTES|ENT_HTML5,'UTF-8',false); ?>"> <?php echo htmlspecialchars($row['email'],ENT_QUOTES|ENT_HTML5,'UTF-8',false); ?></a></td>
						</tr>
						<tr>
							<th>Apratura</th>
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
														?><a href="index.php?menu=52&amp;id= <?php echo $row2['sprzet']; ?>"> <?php echo htmlspecialchars($row3['nazwa'],ENT_QUOTES|ENT_HTML5,'UTF-8',false); ?></a>
													</td>
													<td>
														<form action="index.php?menu=54&amp;id= <?php echo $row['id']; ?>" method="post" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
															<input type="hidden" name="osoba" value=" <?php echo $row['id']; ?>" />
															<input type="hidden" name="sprzet" value=" <?php echo $row2['sprzet']; ?>" />
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
