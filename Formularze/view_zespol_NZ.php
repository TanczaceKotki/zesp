<?php
	breadcrumbs('Szczegóły zespołu laboratoriów',array('index.php?menu=5' => 'Zespoły laboratoriów'));
	echo '<h1 class="font20">Szczegóły zespołu laboratoriów</h1>';
	if($st=$DB->prepare('SELECT * FROM Zespol WHERE id=?')){
		if($st->execute(array($_GET['id']))){
			if($row=$st->fetch(PDO::FETCH_ASSOC)){
				?>
				<table class="table table-striped">
					<tbody>
						<tr>
							<td>Nazwa:</td>
							<td><?php echo $row['nazwa']; ?></td>
						</tr>
						<tr>
							<td>Laboratoria</td>
							<td>
								<?php
									if($result=$DB->prepare('SELECT id,nazwa FROM Laboratorium WHERE zespol=? ORDER BY nazwa')){
										if($result->execute(array($row['id']))){
											$i=1;
											while($row2=$result->fetch(PDO::FETCH_ASSOC)){
												if($i>1) echo '</td></tr><tr><td></td><td>';
												echo '<a href="index.php?menu=57&amp;id='.$row2['id'].'">'.$row2['nazwa'].'</a>';
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
				</table><?php
			}
			else echo '<p>Nie znaleziono zespołu o podanym identyfikatorze.</p>';
		}
		else echo '<p>Nastąpił błąd przy odczytywaniu informacji o zespole: '.implode(' ',$st->errorInfo()).'</p>';
	}
	else echo '<p>Nastąpił błąd przy odczytywaniu informacji o zespole: '.implode(' ',$DB->errorInfo()).'</p>';
?>
<a class="btn btn-warning margin_bottom_10" href="index.php?menu=5">Wróć do strony z zespołami laboratoriów</a>
