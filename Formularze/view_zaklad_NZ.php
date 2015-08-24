<?php
	breadcrumbs('Szczegóły zakładu');
	echo '<h1 class="font20">Szczegóły zakładu</h1>';
	if($st=$DB->prepare('SELECT * FROM Zaklad WHERE id=?')){
		if($st->execute(array($_GET['id']))){
			if($row=$st->fetch(PDO::FETCH_ASSOC)){
				?>
				<table class="table table-striped">
					<tbody>
						<tr>
							<th>Nazwa</th>
							<td><?php echo $row['nazwa']; ?></td>
						</tr>
						<tr>
							<th>Laboratoria</th>
							<td>
								<?php
									if($result=$DB->prepare('SELECT * FROM Laborat_w_zaklad WHERE zaklad=? ORDER BY laboratorium')){
										if($result->execute(array($row['id']))){
											$i=1;
											while($row2=$result->fetch(PDO::FETCH_ASSOC)){
												if($result2=$DB->prepare('SELECT nazwa FROM Laboratorium WHERE id=?')){
													if($result2->execute(array($row2['laboratorium']))){
														if($row3=$result2->fetch(PDO::FETCH_ASSOC)){
															if($i>1) echo '</td></tr><tr><td></td><td>';
															?><a href="index.php?menu=57&amp;id=<?php echo $row2['laboratorium']; ?>"><?php echo htmlspecialchars($row3['nazwa'],ENT_QUOTES|ENT_HTML5,'UTF-8',false); ?></a>
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
			else echo '<p>Nie znaleziono zakładu o podanym identyfikatorze.</p>';
		}
		else echo '<p>Nastąpił błąd przy pobieraniu informacji o zakładzie.</p>';
	}
	else echo '<p>Nastąpił błąd przy pobieraniu informacji o zakładzie.</p>';
?>
