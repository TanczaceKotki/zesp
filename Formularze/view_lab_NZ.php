<ol class="breadcrumb">
	<li><a href="index.php">Start</a></li>
	<li><a href="index.php?menu=3">Laboratoria</a></li>
	<li class="active">Szczegóły laboratorium</li>
</ol>
 <?php
	if($st=$DB->prepare('SELECT * FROM Laboratorium WHERE id=?')){
		if($st->execute(array($_GET['id']))){
			if($row=$st->fetch(PDO::FETCH_ASSOC)){
				?>
				<table class="table table-striped">
					<tbody>
						<tr>
							<th>Nazwa</th>
							<td> <?php echo htmlspecialchars(htmlspecialchars($row['nazwa'],ENT_QUOTES|ENT_HTML5,'UTF-8',false),ENT_QUOTES|ENT_HTML5,'UTF-8',false); ?></td>
						</tr>
						<tr>
							<th>Zespół</th>
							<td>
								 <?php
									if($row['zespol']!==""){
										if($result=$DB->prepare('SELECT nazwa FROM Zespol WHERE id=?')){
											if($result->execute(array($row['zespol']))){
												if($row2=$result->fetch(PDO::FETCH_ASSOC)) echo '<a href="index.php?menu=58&amp;id='.$row['zespol'].'">'.htmlspecialchars($row2['nazwa'],ENT_QUOTES|ENT_HTML5,'UTF-8',false).'</a>';
												else echo 'Nie udało się pobrać danych z bazy danych.';
											}
											else echo 'Nie udało się pobrać danych z bazy danych.';
										}
										else echo 'Nie udało się pobrać danych z bazy danych.';
									}
								?>
							</td>
						</tr>
						<tr>
							<th>Zakłady</th>
							<td>
								 <?php
									if($result=$DB->prepare('SELECT zaklad FROM Laborat_w_zaklad WHERE laboratorium=?')){
										if($result->execute(array($row['id']))){
											$i=1;
											while($row2=$result->fetch(PDO::FETCH_ASSOC)){
												if($result2=$DB->prepare('SELECT nazwa FROM Zaklad WHERE id=?')){
													if($result2->execute(array($row2['zaklad']))){
														if($row3=$result2->fetch(PDO::FETCH_ASSOC)){
															if($i>1) echo '</td></tr><tr><td></td><td>';
															?>
															<a href="index.php?menu=63&amp;id= <?php echo $row2['zaklad']; ?>"> <?php echo htmlspecialchars($row3['nazwa'],ENT_QUOTES|ENT_HTML5,'UTF-8',false); ?></a>
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
							<th>Apratura</th>
							<td>
								 <?php
									if($result=$DB->prepare('SELECT id,nazwa FROM Sprzet WHERE laboratorium=? ORDER BY nazwa')){
										if($result->execute(array($row['id']))){
											$i=1;
											while($row2=$result->fetch(PDO::FETCH_ASSOC)){
												if($i>1) echo '</td></tr><tr><td></td><td>';
												?>
												<a href="index.php?menu=56&amp;id= <?php echo $row2['id']; ?>"> <?php echo htmlspecialchars($row2['nazwa'],ENT_QUOTES|ENT_HTML5,'UTF-8',false); ?></a>
												 <?php
												++$i
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
			else echo 'Nie znaleziono laboratorium o podanym identyfikatorze.<br /><br />';
		}
		else echo 'Nastąpił błąd przy pobieraniu informacji o laboratorium.<br /><br />';
	}
	else echo 'Nastąpił błąd przy pobieraniu informacji o laboratorium.<br /><br />';
?>
<a class="btn btn-warning" href="index.php?menu=3">Wróć do strony laboratoriów</a>
