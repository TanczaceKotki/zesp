<?php
	if(user::isLogged()){
		if($lvl<2){
			breadcrumbs('Szczegóły laboratorium',array('index.php?menu=7' => 'Zarządzanie laboratoriami'));
			echo '<h1 class="font20">Szczegóły laboratorium</h1>';
			if(isset($_POST['del_zak'])){
				if($st=$DB->prepare('DELETE FROM Laborat_w_zaklad WHERE laboratorium=? AND zaklad=?')){
					if($st->execute(array($_POST['laboratorium'],$_POST['zaklad']))) echo 'Laboratorium zostało usunięte z zakładu.<br /><br />';
					else echo 'Nastąpił błąd przy usuwaniu laboratorium: '.implode(' ',$st->errorInfo()).'<br /><br />';
				}
				else echo 'Nastąpił błąd przy usuwaniu laboratorium: '.implode(' ',$DB->errorInfo()).'<br /><br />';
			}
			if(isset($_POST['del_sprzet'])){
				if($st=$DB->prepare('UPDATE Sprzet SET laboratorium=NULL WHERE id=?')){
					if($st->execute(array($_POST['sprzet']))) echo 'Laboratorium zostało usunięte ze sprzętu.<br /><br />';
					else echo 'Nastąpił błąd przy usuwaniu laboratorium: '.implode(' ',$st->errorInfo()).'<br /><br />';
				}
				else echo 'Nastąpił błąd przy usuwaniu laboratorium: '.implode(' ',$DB->errorInfo()).'<br /><br />';
			}
			if($st=$DB->prepare('SELECT * FROM Laboratorium WHERE id=?')){
				if($st->execute(array($_GET['id']))){
					if($row=$st->fetch(PDO::FETCH_ASSOC)){
						?>
						<form action="index.php?menu=41" method="post" accept-charset="utf-8" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
							<input class="btn btn-warning margin_bottom_10" type="submit" value="Edytuj" />
						</form>
						<table class="table table-striped">
							<tbody>
								<tr>
									<th>Nazwa</th>
									<td colspan="2"><?php echo htmlspecialchars($row['nazwa'],ENT_QUOTES|ENT_HTML5,'UTF-8',false); ?></td>
								</tr>
								<tr>
									<th>Zespół</th>
									<td colspan="2">
										<?php
											if($row['zespol']!==""){
												if($result=$DB->prepare('SELECT nazwa FROM Zespol WHERE id=?')){
													if($result->execute(array($row['zespol']))){
														if($row2=$result->fetch(PDO::FETCH_ASSOC)) echo '<a href="index.php?menu=53&amp;id='.$row['zespol'].'">'.htmlspecialchars($row2['nazwa'],ENT_QUOTES|ENT_HTML5,'UTF-8',false).'</a>';
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
									<td
										<?php
										if($result=$DB->prepare('SELECT zaklad FROM Laborat_w_zaklad WHERE laboratorium=?')){
											if($result->execute(array($row['id']))){
												$i=1;
												while($row2=$result->fetch(PDO::FETCH_ASSOC)){
													if($result2=$DB->prepare('SELECT nazwa FROM Zaklad WHERE id=?')){
														if($result2->execute(array($row2['zaklad']))){
															if($row3=$result2->fetch(PDO::FETCH_ASSOC)){
																if($i>1) echo '</td></tr><tr><td></td><td>';
																else echo '>';
																	?>
																	<a href="index.php?menu=61&amp;id=<?php echo $row2['zaklad']; ?>"><?php echo htmlspecialchars($row3['nazwa'],ENT_QUOTES|ENT_HTML5,'UTF-8',false); ?></a>
																</td>
																<td>
																	<form action="index.php?menu=40&amp;id=<?php echo $row['id']; ?>" method="post" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
																		<input type="hidden" name="zaklad" value="<?php echo $row['id']; ?>" />
																		<input type="hidden" name="laboratorium" value="<?php echo $row2['laboratorium']; ?>" />
																		<input type="submit" class="btn btn-danger" name="del_zak" value="Usuń" />
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
										if($i===1) echo ' colspan="2">';
										?>
									</td>
								</tr>
								<tr>
									<th>Apratura</th>
									<td
										<?php
											$i=1;
											if($result=$DB->prepare('SELECT id,nazwa FROM Sprzet WHERE laboratorium=? ORDER BY nazwa')){
												if($result->execute(array($row['id']))){
													while($row2=$result->fetch(PDO::FETCH_ASSOC)){
														if($i>1) echo '</td></tr><tr><td></td><td>';
														else echo '>';
														?>
														<a href="index.php?menu=56&amp;id=<?php echo $row2['id']; ?>"><?php echo htmlspecialchars($row2['nazwa'],ENT_QUOTES|ENT_HTML5,'UTF-8',false); ?></a>
													</td>
													<td>
														<form action="index.php?menu=40&amp;id=<?php echo $row['id']; ?>" method="post" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
															<input type="hidden" name="sprzet" value="<?php echo $row2['id']; ?>" />
															<input type="submit" class="btn btn-danger" name="del_sprzet" value="Usuń" />
														</form>
														<?php
														++$i;
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
					else echo '<p>Nie znaleziono laboratorium o podanym identyfikatorze.</p>';
				}
				else echo '<p>Nastąpił błąd przy pobieraniu informacji o laboratorium: '.implode(' ',$st->errorInfo()).'</p>';
			}
			else echo '<p>Nastąpił błąd przy pobieraniu informacji o laboratorium: '.implode(' ',$DB->errorInfo()).'</p>';
?>
<a class="btn btn-warning margin_bottom_10" href="index.php?menu=7">Wróć do zarządzania laboratoriami</a>
<?php
		}
		else require 'mod_cred_req.php';
	}
	else require 'not_logged_in.php';
?>
