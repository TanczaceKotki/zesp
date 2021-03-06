<?php
	if(user::isLogged()){
		if($lvl<2){
			breadcrumbs('Szczegóły zakładu',array('index.php?menu=66' => 'Zarządzanie zakładami'));
			echo '<h1 class="font20">Szczegóły zakładu</h1>';
			if(isset($_POST['del_lab'])){
				if($st=$DB->prepare('DELETE FROM Laborat_w_zaklad WHERE laboratorium=? AND zaklad=?')){
					if($st->execute(array($_POST['laboratorium'],$_POST['zaklad']))) echo 'Laboratorium zostało usunięte.<br /><br />';
					else echo 'Nastąpił błąd przy usuwaniu laboratorium: '.implode(' ',$st->errorInfo()).'<br /><br />';
				}
				else echo 'Nastąpił błąd przy usuwaniu laboratorium: '.implode(' ',$DB->errorInfo()).'<br /><br />';
			}
			if($st=$DB->prepare('SELECT * FROM Zaklad WHERE id=?')){
				if($st->execute(array($_GET['id']))){
					if($row=$st->fetch(PDO::FETCH_ASSOC)){
						?>
						<form action="index.php?menu=48" method="post" accept-charset="utf-8" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
							<input class="btn btn-warning margin_bottom_10" type="submit" value="Edytuj" />
						</form>
						<table class="table table-striped">
							<tbody>
								<tr>
									<th>Nazwa</th>
									<td colspan="2"><?php echo $row['nazwa']; ?></td>
								</tr>
								<tr>
									<th>Laboratoria</th>
									<td
										<?php
										$i=1;
										if($result=$DB->prepare('SELECT * FROM Laborat_w_zaklad WHERE zaklad=? ORDER BY laboratorium')){
											if($result->execute(array($row['id']))){
												while($row2=$result->fetch(PDO::FETCH_ASSOC)){
													if($result2=$DB->prepare('SELECT nazwa FROM Laboratorium WHERE id=?')){
														if($result2->execute(array($row2['laboratorium']))){
															if($row3=$result2->fetch(PDO::FETCH_ASSOC)){
																if($i>1) echo '</tr><tr><td></td><td>';
																else echo '>';
																?><a href="index.php?menu=40&amp;id=<?php echo $row2['laboratorium']; ?>"><?php echo $row3['nazwa']; ?></a>
															</td>
															<td>
																<form action="index.php?menu=61&amp;id=<?php echo $row['id']; ?>" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
																	<input type="hidden" name="zaklad" value="<?php echo $row['id']; ?>" />
																	<input type="hidden" name="laboratorium" value="<?php echo $row2['laboratorium']; ?>" />
																	<input type="submit" class="btn btn-danger" name="del_lab" value="Usuń" />
																</form>
																<br />
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
										if($i===1) echo ' colspan="2">';
										?>
									</td>
								</tr>
							</tbody>
						</table><?php
					}
					else echo '<p>Nie znaleziono zakładu o podanym identyfikatorze.</p>';
				}
				else echo '<p>Nastąpił błąd przy pobieraniu informacji o zakładzie: '.implode(' ',$st->errorInfo()).'</p>';
			}
			else echo '<p>Nastąpił błąd przy pobieraniu informacji o zakładzie: '.implode(' ',$DB->errorInfo()).'</p>';
		}
		else require 'mod_cred_req.php';
	}
	else require 'not_logged_in.php';
?>
