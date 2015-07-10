<ol class="breadcrumb">
	<li><a href="index.php">Start</a></li>
	<li class="active">Szczegóły osoba kontaktowa</li>
</ol>
<?php
	if($st=$DB->prepare('SELECT * FROM Osoba WHERE id=?')){
		if($st->execute(array($_GET['id']))){
			if($row=$st->fetch(PDO::FETCH_ASSOC)){
				?>
				<table class="table table-striped">
					<tbody>
						<tr>
							<th>Imię:</th>
							<td><?php echo $row['imie']; ?></td>
						</tr>
						<tr>
							<th>Nazwisko:</th>
							<td><?php echo $row['nazwisko']; ?></td>
						</tr>
						<tr>
							<th>Adres email:</th>
							<td><a href="mailto:<?php echo $row['email']; ?>"><?php echo $row['email']; ?></a></td>
						</tr>
						<tr>
							<th>Sprzęt:</th>
							<td>
								<?php
									if($result=$DB->prepare('SELECT sprzet FROM Kontakt WHERE osoba=? ORDER BY sprzet')){
										if($result->execute(array($row['id']))){
											$i=0;
											while($row2=$result->fetch(PDO::FETCH_ASSOC)){
												if($result2=$DB->prepare('SELECT nazwa FROM Sprzet WHERE id=?')){
													if($result2->execute(array($row2['sprzet']))){
														if($i>1) echo '</td></tr><tr><td></td><td>';
														if($row3=$result2->fetch(PDO::FETCH_ASSOC)){
															?>
															<a href="index.php?menu=56&amp;id=<?php echo $row2['sprzet']; ?>"><?php echo $row3['nazwa']; ?></a>
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
								?>
							</td>
						</tr>
					</tbody>
				</table><?php 
			}
			else echo 'Nie znaleziono osoby o podanym identyfikatorze.<br /><br />';
		}
		else echo 'Nastąpił błąd przy pobieraniu informacji o osobie.<br /><br />';
	}
	else echo 'Nastąpił błąd przy pobieraniu informacji o osobie.<br /><br />';
?>
