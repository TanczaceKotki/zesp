<?php
	if(user::isLogged()){
		if($lvl<2){
			breadcrumbs('Szczegóły zdjęcia',array('index.php?menu=12' => 'Zarządzanie zdjęciami'));
			echo '<h1 class="font20">Szczegóły zdjęcia</h1>';
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
					else echo '<p>Nie znaleziono zdjęcia o podanym identyfikatorze.</p>';
				}
				else echo '<p>Nastąpił błąd przy odczytywaniu informacji o zdjęciu: '.implode(' ',$st->errorInfo()).'</p>';
			}
			else echo '<p>Nastąpił błąd przy odczytywaniu informacji o zdjęciu: '.implode(' ',$DB->errorInfo()).'</p>';
?>
<a class="btn btn-warning margin_bottom_10" href="index.php">Wróć do strony zarządzania zdjęciami</a>
<?php
		}
		else require 'mod_cred_req.php';
	}
	else require 'not_logged_in.php';
?>
