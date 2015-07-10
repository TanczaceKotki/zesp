<?php
	if(user::isLogged()){
?>
<ol class="breadcrumb">
	<li><a href="index.php">Start</a></li>
	<li><a href="index.php?menu=9">Zarządzanie zespołami</a></li>
	<li class="active">Szczegóły zespołu</li>
</ol>
<?php
	if($st=$DB->prepare('SELECT * FROM Zespol WHERE id=?')){
		if($st->execute(array($_GET['id']))){
			if($row=$st->fetch(PDO::FETCH_ASSOC)){
				?>
				<table class="table table-striped">
					<tbody>
						<tr>
							<th>Nazwa:</th>
							<td><?php echo $row['nazwa']; ?></td>
						</tr>
						<tr>
							<th>Laboratoria</th>
							<td>
								<?php
									if($result=$DB->prepare('SELECT id,nazwa FROM Laboratorium WHERE zespol=? ORDER BY nazwa')){
										if($result->execute(array($row['id']))){
											$i=1;
											while($row2=$result->fetch(PDO::FETCH_ASSOC)){
												if($i>1) echo '</td></tr><tr><td></td><td>';
												echo '<a href="index.php?menu=40&amp;id='.$row2['id'].'">'.$row2['nazwa'].'</a>';
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
			else echo 'Nie znaleziono zespołu o podanym identyfikatorze.<br /><br />';
		}
		else echo 'Nastąpił błąd przy odczytywaniu informacji o zespole: '.implode(' ',$st->errorInfo()).'<br /><br />';
	}
	else echo 'Nastąpił błąd przy odczytywaniu informacji o zespole: '.implode(' ',$DB->errorInfo()).'<br /><br />';
?>
<a class="btn btn-warning" href="index.php?menu=9">Wróć do strony z zespołami</a>
<?php
	}
	else echo '<br />Nie jesteś zalogowany.<br /><a href="index.php?menu=10">Zaloguj się</a><br /><br /> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
?>
