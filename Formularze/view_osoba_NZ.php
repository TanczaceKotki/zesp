<?php
	breadcrumbs('Szczegóły osoby kontaktowej');
	echo '<h1 class="font20">Szczegóły osoby kontaktowej</h1>';
	if($st=$DB->prepare('SELECT * FROM Osoba WHERE id=?')){
		if($st->execute(array($_GET['id']))){
			if($row=$st->fetch(PDO::FETCH_ASSOC)){
				?>
				<table class="table table-striped">
					<tbody>
						<tr>
							<th>Imię</th>
							<td><?php echo htmlspecialchars($row['imie'],ENT_QUOTES|ENT_HTML5,'UTF-8',false); ?></td>
						</tr>
						<tr>
							<th>Nazwisko</th>
							<td><?php echo htmlspecialchars($row['nazwisko'],ENT_QUOTES|ENT_HTML5,'UTF-8',false); ?></td>
						</tr>
						<tr>
							<th>Adres email</th>
							<td><a href="mailto:<?php echo htmlspecialchars($row['email'],ENT_QUOTES|ENT_HTML5,'UTF-8',false); ?>"><?php echo htmlspecialchars($row['email'],ENT_QUOTES|ENT_HTML5,'UTF-8',false); ?></a></td>
						</tr>
						<tr>
							<th>Apratura</th>
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
															<a href="index.php?menu=56&amp;id=<?php echo $row2['sprzet']; ?>"><?php echo htmlspecialchars($row3['nazwa'],ENT_QUOTES|ENT_HTML5,'UTF-8',false); ?></a>
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
			else echo '<p>Nie znaleziono osoby o podanym identyfikatorze.</p>';
		}
		else echo '<p>Nastąpił błąd przy pobieraniu informacji o osobie.</p>';
	}
	else echo '<p>Nastąpił błąd przy pobieraniu informacji o osobie.</p>';
?>
