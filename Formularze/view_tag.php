<?php
	if(user::isLogged()){
		if($lvl<2){
			breadcrumbs('Szczegóły słowa kluczowego',array('index.php?menu=67' => 'Zarządzanie słowami kluczowymi'));
			echo '<h1 class="font20">Szczegóły słowa kluczowego</h1>';
			if(isset($_POST['del_tag'])){
				if($st=$DB->prepare('DELETE FROM Tagi_sprzetu WHERE sprzet=? AND tag=?')){
					if($st->execute(array($_POST['sprzet'],$_POST['tag']))) echo 'Tag został usunięty.<br /><br />';
					else echo 'Nastąpił błąd przy usuwaniu słowa kluczowego: '.implode(' ',$st->errorInfo()).'<br /><br />';
				}
				else echo 'Nastąpił błąd przy usuwaniu słowa kluczowego: '.implode(' ',$DB->errorInfo()).'<br /><br />';
			}
			if($st=$DB->prepare('SELECT * FROM Tag WHERE id=?')){
				if($st->execute(array($_GET['id']))){
					if($row=$st->fetch(PDO::FETCH_ASSOC)){
						?>
						<form action="index.php?menu=46" method="post" accept-charset="utf-8" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
							<input class="btn btn-warning margin_bottom_10" type="submit" value="Edytuj" />
						</form>
						<table class="table table-striped">
							<tbody>
								<tr>
									<td>Nazwa</td>
									<td><?php echo $row['nazwa']; ?></td>
								</tr>
								<tr>
									<td>Sprzet</td>
									<td
										<?php
											$i=1;
											if($result=$DB->prepare('SELECT sprzet FROM Tagi_sprzetu WHERE tag=? ORDER BY sprzet')){
												if($result->execute(array($row['id']))){
													while($row2=$result->fetch(PDO::FETCH_ASSOC)){
														if($result2=$DB->prepare('SELECT nazwa FROM Sprzet WHERE id=?')){
															if($result2->execute(array($row2['sprzet']))){
																if($row3=$result2->fetch(PDO::FETCH_ASSOC)){
																	if($i>1) echo '</td></tr><tr><td></td><td>';
																	else echo '>';
																	?>
																	<a href="index.php?menu=52&amp;id=<?php echo $row2['sprzet']; ?>"><?php echo $row3['nazwa']; ?></a>
																</td>
																<td>
																	<form action="index.php?menu=60&amp;id=<?php echo $row['id']; ?>" method="post" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
																		<input type="hidden" name="tag" value="<?php echo $row['id']; ?>" />
																		<input type="hidden" name="sprzet" value="<?php echo $row2['sprzet']; ?>" />
																		<input type="submit" class="btn btn-danger" name="del_tag" value="Usuń" />
																	</form>
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
											if($i===1) echo ' colspan=2>'
										?>
									</td>
								</tr>
							</tbody>
						</table>
						<?php
					}
					else echo '<p>Nie znaleziono tagu o podanym identyfikatorze.</p>';
				}
				else echo '<p>Nastąpił błąd przy pobieraniu informacji o tagu: '.implode(' ',$st->errorInfo()).'</p>';
			}
			else echo '<p>Nastąpił błąd przy pobieraniu informacji o tagu: '.implode(' ',$DB->errorInfo()).'</p>';
		}
		else require 'mod_cred_req.php';
	}
	else require 'not_logged_in.php';
?>
