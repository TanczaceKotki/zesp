<?php
	if(user::isLogged()){
?>
<ol class="breadcrumb">
	<li><a href="index.php">Start</a></li>
	<li><a href="index.php?menu=3">Zarządzanie zdjęciami</a></li>
	<li class="active">Zdjęcia</li>
</ol>
<?php
	if($st=$DB->prepare('SELECT * FROM Zdjecie WHERE id=?')){
		if($st->execute(array($_GET['id']))){
			if($row=$st->fetch(PDO::FETCH_ASSOC)){
				?>
				<table class="table table-striped">
					<tbody>
						<tr>
							<th>Podgląd:</th>
							<td><a href="uploads/<?php echo $row['link']; ?>"><img src="uploads/<?php echo $row['link']; ?>" width="200" alt="" /></a></td>
						</tr>
						<tr>
							<th>Link:</th>
							<td><?php echo $row['link']; ?></td>
						</tr>
						<tr>
							<th>Sprzęt:</th>
							<td>
								<?php
									if($result=$DB->prepare('SELECT nazwa FROM Sprzet WHERE id=?')){
										if($result->execute(array($row['sprzet']))){
											if($row2=$result->fetch(PDO::FETCH_ASSOC)) echo '<a href="index.php?menu=52&amp;id='.$row['sprzet'].'">'.$row2['nazwa'].'</a>';
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
			else echo 'Nie znaleziono zdjęcia o podanym identyfikatorze.<br /><br />';
		}
		else echo 'Nastąpił błąd przy odczytywaniu informacji o zdjęciu: '.implode(' ',$st->errorInfo()).'<br /><br />';
	}
	else echo 'Nastąpił błąd przy odczytywaniu informacji o zdjęciu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
?>
<a class="btn btn-warning" href="index.php">Wróć do strony zarządzania zdjęciami</a>
<?php
	}
	else echo '<br />Nie jesteś zalogowany.<br /><a href="index.php?menu=10">Zaloguj się</a><br /><br /> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
?>
