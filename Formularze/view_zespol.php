<?php
	if(user::isLogged()){
		if($lvl<2){
			breadcrumbs('Szczegóły zespołu laboratoriów',array('index.php?menu=9' => 'Zarządzanie zespołami laboratoriów'));
			echo '<h1 class="font20">Szczegóły zespołu laboratoriów</h1>';
			if($st=$DB->prepare('SELECT * FROM Zespol WHERE id=?')){
				if($st->execute(array($_GET['id']))){
					if($row=$st->fetch(PDO::FETCH_ASSOC)){
						?>
						<form action="index.php?menu=47" method="post" accept-charset="utf-8" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
							<input class="btn btn-warning margin_bottom_10" type="submit" value="Edytuj" />
						</form>
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
					else echo '<p>Nie znaleziono zespołu o podanym identyfikatorze.</p>';
				}
				else echo '<p>Nastąpił błąd przy odczytywaniu informacji o zespole: '.implode(' ',$st->errorInfo()).'</p>';
			}
			else echo '<p>Nastąpił błąd przy odczytywaniu informacji o zespole: '.implode(' ',$DB->errorInfo()).'</p>';
?>
<a class="btn btn-warning margin_bottom_10" href="index.php?menu=9">Wróć do strony zarządzania zespołami laboratoriów</a>
<?php
		}
		else require 'mod_cred_req.php';
	}
	else require 'not_logged_in.php';
?>
