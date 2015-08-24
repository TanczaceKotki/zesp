<?php
	breadcrumbs('Szczegóły aparatury',array('index.php?menu=4' => 'Aparatura'));
	echo '<h1 class="font20">Szczegóły aparatury</h1>';
	if($st=$DB->prepare('SELECT * FROM Sprzet WHERE id=?')){
		if($st->execute(array($_GET['id']))){
			if($row=$st->fetch(PDO::FETCH_ASSOC)){
				?>
				<table class="table table-striped">
					<tbody>
						<tr>
							<th>Nazwa</th>
							<td><?php echo htmlspecialchars($row['nazwa'],ENT_QUOTES|ENT_HTML5,'UTF-8',false); ?></td>
						</tr>
						<tr>
							<th>Data zakupu</th>
							<td><?php echo $row['data_zakupu']; ?></td>
						</tr>
						<tr>
							<th>Data uruchomienia</th>
							<td><?php if($row['data_uruchom']!=="") echo $row['data_uruchom']; ?></td>
						</tr>
						<tr>
							<th>Wartość</th>
							<td><?php echo $row['wartosc']; ?></td>
						</tr>
						<tr>
							<th>Opis</th>
							<td><?php echo htmlspecialchars($row['opis'],ENT_QUOTES|ENT_HTML5,'UTF-8',false); ?></td>
						</tr>
						<tr>
							<th>Projekt</th>
							<td>
								<?php
									if($row['projekt']!==""){
										if($result=$DB->prepare('SELECT nazwa FROM Projekt WHERE id=?')){
											if($result->execute(array($row['projekt']))){
												if($row2=$result->fetch(PDO::FETCH_ASSOC)) echo '<a href="index.php?menu=59&amp;id='.$row['projekt'].'">'.htmlspecialchars($row2['nazwa'],ENT_QUOTES|ENT_HTML5,'UTF-8',false).'</a>';
											}
											else echo 'Nie udało się pobrać danych z bazy danych.';
										}
										else echo 'Nie udało się pobrać danych z bazy danych.';
									}
								?>
							</td>
						</tr>
						<tr>
							<th>Laboratorium</th>
							<td>
								<?php
									if($row['laboratorium']!==""){
										if($result=$DB->prepare('SELECT nazwa FROM Laboratorium WHERE id=?')){
											if($result->execute(array($row['laboratorium']))){
												if($row2=$result->fetch(PDO::FETCH_ASSOC)) echo '<a href="index.php?menu=57&amp;id='.$row['laboratorium'].'">'.htmlspecialchars($row2['nazwa'],ENT_QUOTES|ENT_HTML5,'UTF-8',false).'</a>';
											}
											else echo 'Nie udało się pobrać danych z bazy danych.';
										}
										else echo 'Nie udało się pobrać danych z bazy danych.';
									}
								?>
							</td>
						</tr>
						<tr>
							<th>Zdjęcia</th>
							<td>
								<?php
									if($result=$DB->prepare('SELECT id,link FROM Zdjecie WHERE sprzet=? ORDER BY link')){
										if($result->execute(array($row['id']))){
											while($row2=$result->fetch(PDO::FETCH_ASSOC)){
												?>
												<a href="index.php?menu=62&amp;id=<?php echo $row2['id']; ?>">
													<img src="uploads/<?php echo $row2['link']; ?>" width="200" alt="" />
												</a>
												<?php
											}
										}
										else echo 'Nie udało się pobrać danych z bazy danych.';
									}
									else echo 'Nie udało się pobrać danych z bazy danych.';
								?>
							</td>
						</tr>
						<tr>
							<th>Tagi</th>
							<td>
								<?php
									if($result=$DB->prepare('SELECT tag FROM Tagi_sprzetu WHERE sprzet=? ORDER BY tag')){
										if($result->execute(array($row['id']))){
											$i=1;
											while($row2=$result->fetch(PDO::FETCH_ASSOC)){
												if($result2=$DB->prepare('SELECT nazwa FROM Tag WHERE id=?')){
													if($result2->execute(array($row2['tag']))){
														if($row3=$result2->fetch(PDO::FETCH_ASSOC)){
															if($i>1) echo '</td></tr><tr><td></td><td>';
															?>
																<a href="index.php?menu=64&amp;id=<?php echo $row2['tag']; ?>"><?php echo htmlspecialchars($row3['nazwa'],ENT_QUOTES|ENT_HTML5,'UTF-8',false); ?></a>
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
						<tr>
							<th>Kontakt</th>
							<td>
								<?php
									if($result=$DB->prepare('SELECT osoba FROM Kontakt WHERE sprzet=? ORDER BY osoba')){
										if($result->execute(array($row['id']))){
											$i=1;
											while($row2=$result->fetch(PDO::FETCH_ASSOC)){
												if($result2=$DB->prepare('SELECT imie,nazwisko,email FROM Osoba WHERE id=?')){
													if($result2->execute(array($row2['osoba']))){
														if($row3=$result2->fetch(PDO::FETCH_ASSOC)){
															if($i>1) echo '</td></tr><tr><td></td><td>';
															?>
															<a href="index.php?menu=65&amp;id=<?php echo htmlspecialchars($row2['osoba'],ENT_QUOTES|ENT_HTML5,'UTF-8',false); ?>"><?php echo $row3['imie'].' '.htmlspecialchars($row3['nazwisko'],ENT_QUOTES|ENT_HTML5,'UTF-8',false).' ('.htmlspecialchars($row3['email'],ENT_QUOTES|ENT_HTML5,'UTF-8',false).')'; ?></a>
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
				</table>
				<?php
			}
			else echo '<p>Nie udało się pobrać danych z bazy danych.</p>';
		}
		else echo '<p>Nastąpił błąd przy pobieraniu informacji o sprzęcie</p>';
	}
	else echo '<p>Nastąpił błąd przy pobieraniu informacji o sprzęcie</p>';
?>
<a class="btn btn-warning margin_bottom_10" href="index.php?menu=4">Wróć do strony aparatura</a>
