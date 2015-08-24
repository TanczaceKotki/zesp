<?php
	breadcrumbs('Szczegóły słowa kluczowego');
	echo '<h1 class="font20">Szczegóły słowa kluczowego</h1>';
	if($st=$DB->prepare('SELECT * FROM Tag WHERE id=?')){
		if($st->execute(array($_GET['id']))){
			if($row=$st->fetch(PDO::FETCH_ASSOC)){
				?>
				<table class="table table-striped">
					<tbody>
						<tr>
							<td>Nazwa</td>
							<td><?php echo $row['nazwa']; ?></td>
						</tr>
						<tr>
							<td>Sprzet</td>
							<td>
								<?php
									if($result=$DB->prepare('SELECT sprzet FROM Tagi_sprzetu WHERE tag=? ORDER BY sprzet')){
										if($result->execute(array($row['id']))){
											$i=1;
											while($row2=$result->fetch(PDO::FETCH_ASSOC)){
												if($result2=$DB->prepare('SELECT nazwa FROM Sprzet WHERE id=?')){
													if($result2->execute(array($row2['sprzet']))){
														if($row3=$result2->fetch(PDO::FETCH_ASSOC)){
															if($i>1) echo '</td></tr><tr><td></td><td>';
															?>
															<a href="index.php?menu=56&amp;id=<?php echo $row2['sprzet']; ?>"><?php echo $row3['nazwa']; ?></a>
															<?php
														}
													}
													else echo 'Nie udało się pobrać danych z bazy danych.';
												}
												else echo 'Nie udało się pobrać danych z bazy danych.';
												++$i;
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
			else echo '<p>Nie znaleziono tagu o podanym identyfikatorze.</p>';
		}
		else echo '<p>Nastąpił błąd przy pobieraniu informacji o tagu</p>';
	}
	else echo '<p>Nastąpił błąd przy pobieraniu informacji o tagu</p>';
?>
