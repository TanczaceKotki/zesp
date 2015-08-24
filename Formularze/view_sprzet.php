<?php
	if(user::isLogged()){
		if(isset($_GET['id'])){
			$allow=false;
			if($lvl===2){
				if($st=$DB->prepare('SELECT id FROM Sprzet WHERE id IN (SELECT sprzet FROM Kontakt WHERE osoba IN (SELECT id FROM Osoba WHERE email=?))')){
					if($st->execute(array($_SESSION['login']))){
						while($row=$st->fetch(PDO::FETCH_ASSOC)){
							if($row['id']===$_GET['id']) $allow=true;
						}
						if(!$allow) require 'cred_low.php';
					}
				}
			}
			else if($lvl<2) $allow=true;
			else require 'cred_low.php';
			if($allow){
				breadcrumbs('Szczegóły aparatury',array('index.php?menu=8' => 'Zarządzanie aparaturą'));
				if(isset($_POST['del_picture'])){
					if($st=$DB->prepare('DELETE FROM Zdjecie WHERE id=?')){
						if($st->execute(array($_POST['id']))) echo '<p>Zdjęcie zostało usunięte.</p>';
						else echo '<p>Nastąpił błąd przy usuwaniu zdjęcia: '.implode(' ',$st->errorInfo()).'</p>';
					}
					else echo '<p>Nastąpił błąd przy usuwaniu zdjęcia: '.implode(' ',$DB->errorInfo()).'</p>';
				}
				if(isset($_POST['del_tag'])){
					if($st=$DB->prepare('DELETE FROM Tagi_sprzetu WHERE sprzet=? AND tag=?')){
						if($st->execute(array($_POST['sprzet'],$_POST['tag']))) echo '<p>Słowo kluczowe zostało usunięte.</p>';
						else echo '<p>Nastąpił błąd przy usuwaniu słowa kluczowego: '.implode(' ',$st->errorInfo()).'</p>';
					}
					else echo '<p>Nastąpił błąd przy usuwaniu słowa kluczowego: '.implode(' ',$DB->errorInfo()).'</p>';
				}
				if(isset($_POST['del_kontakt'])){
					if($st=$DB->prepare('DELETE FROM Kontakt WHERE sprzet=? AND osoba=?')){
						if($st->execute(array($_POST['sprzet'],$_POST['osoba']))) echo '<p>Informacja kontaktowa została usunięta.</p>';
						else echo '<p>Nastąpił błąd przy usuwaniu informacji kontaktowej: '.implode(' ',$st->errorInfo()).'</p>';
					}
					else echo '<p>Nastąpił błąd przy usuwaniu informacji kontaktowej: '.implode(' ',$DB->errorInfo()).'</p>';
				}
				if($st=$DB->prepare('SELECT * FROM Sprzet WHERE id=?')){
					if($st->execute(array($_GET['id']))){
						if($row=$st->fetch(PDO::FETCH_ASSOC)){
							?>
							<form action="index.php?menu=45" method="post" accept-charset="utf-8" enctype="application/x-www-form-urlencoded">
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
										<th>Data zakupu</th>
										<td colspan="2"><?php echo $row['data_zakupu']; ?></td>
									</tr>
									<tr>
										<th>Data uruchomienia</th>
										<td colspan="2"><?php if($row['data_uruchom']!=="") echo $row['data_uruchom']; ?></td>
									</tr>
									<tr>
										<th>Wartość</th>
										<td colspan="2"><?php echo $row['wartosc']; ?></td>
									</tr>
									<tr>
										<th>Opis</th>
										<td colspan="2"><?php echo htmlspecialchars($row['opis'],ENT_QUOTES|ENT_HTML5,'UTF-8',false); ?></td>
									</tr>
									<tr>
										<th>Projekt</th>
										<td colspan="2">
											<?php
												if($row['projekt']!==""){
													if($result=$DB->prepare('SELECT nazwa FROM Projekt WHERE id=?')){
														if($result->execute(array($row['projekt']))){
															if($row2=$result->fetch(PDO::FETCH_ASSOC)) echo '<a href="index.php?menu=51&amp;id='.$row['projekt'].'">'.htmlspecialchars($row2['nazwa'],ENT_QUOTES|ENT_HTML5,'UTF-8',false).'</a>';
														}
														else echo 'Nie udało się pobrać danych z bazy danych.';
													}
													else echo 'Nie udało się pobrać danych z bazy danych.';
												}
											?>
										</td>
									</tr>
									<tr>
										<th>Laboratorium</th>
										<td colspan="2">
											<?php
												if($row['laboratorium']!==""){
													if($result=$DB->prepare('SELECT nazwa FROM Laboratorium WHERE id=?')){
														if($result->execute(array($row['laboratorium']))){
															if($row2=$result->fetch(PDO::FETCH_ASSOC)) echo '<a href="index.php?menu=40&amp;id='.$row['laboratorium'].'">'.htmlspecialchars($row2['nazwa'],ENT_QUOTES|ENT_HTML5,'UTF-8',false).'</a>';
														}
														else echo 'Nie udało się pobrać danych z bazy danych.';
													}
													else echo 'Nie udało się pobrać danych z bazy danych.';
												}
											?>
										</td>
									</tr>
									<tr>
										<th>Zdjęcia</th>
										<td
											<?php
											$i=1;
											if($result=$DB->prepare('SELECT id,link FROM Zdjecie WHERE sprzet=? ORDER BY link')){
												if($result->execute(array($row['id']))){
													while($row2=$result->fetch(PDO::FETCH_ASSOC)){
														if($i>1) echo '</td></tr><tr><td></td><td>';
														else echo '>';
														?><a href="index.php?menu=55&amp;id=<?php echo $row2['id']; ?>"><img src="uploads/<?php echo $row2['link']; ?>" width="200" alt="" /></a>
													</td>
													<td>
														<?php
															if($lvl<2){
														?>
														<form action="index.php?menu=52&amp;id=<?php echo $row['id']; ?>" method="post" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
															<input type="hidden" name="id" value="<?php echo $row2['id']; ?>" />
															<input type="submit" class="btn btn-danger" name="del_picture" value="Usuń" />
														</form>
														<?php
															}
														?>
													<br />
													<?php
														++$i;
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
										<th>Słowa kluczowe</th>
										<td
											<?php
											$i=1;
											if($result=$DB->prepare('SELECT tag FROM Tagi_sprzetu WHERE sprzet=? ORDER BY tag')){
												if($result->execute(array($row['id']))){
													while($row2=$result->fetch(PDO::FETCH_ASSOC)){
														if($result2=$DB->prepare('SELECT nazwa FROM Tag WHERE id=?')){
															if($result2->execute(array($row2['tag']))){
																if($row3=$result2->fetch(PDO::FETCH_ASSOC)){
																	if($i>1) echo '</td></tr><tr><td></td><td>';
																	else echo '>';
																	?><a href="index.php?menu=60&amp;id=<?php echo $row2['tag']; ?>"><?php echo $row3['nazwa']; ?></a>
																</td>
																<td>
																	<?php
																		if($lvl<2){
																	?>
																	<form action="index.php?menu=52&amp;id=<?php echo $row['id']; ?>" method="post" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
																		<input type="hidden" name="sprzet" value="<?php echo $row['id']; ?>" />
																		<input type="hidden" name="tag" value="<?php echo $row2['tag']; ?>" />
																		<input type="submit" class="btn btn-danger" name="del_tag" value="Usuń" />
																	</form>
																<?php
																	}
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
										<th>Kontakt</th>
										<td
											<?php 
											$i=1;
											if($result=$DB->prepare('SELECT osoba FROM Kontakt WHERE sprzet=? ORDER BY osoba')){
												if($result->execute(array($row['id']))){
													while($row2=$result->fetch(PDO::FETCH_ASSOC)){
														if($result2=$DB->prepare('SELECT imie,nazwisko,email FROM Osoba WHERE id=?')){
															if($result2->execute(array($row2['osoba']))){
																if($row3=$result2->fetch(PDO::FETCH_ASSOC)){
																	if($i>1) echo '</tr><tr><td></td><td>';
																	else echo '>';
																	?><a href="index.php?menu=54&amp;id=<?php echo $row2['osoba']; ?>"><?php echo $row3['imie'].' '.$row3['nazwisko'].' ('.$row3['email'].')'; ?></a>
																</td>
																<td>
																	<?php
																		if($lvl<2){
																	?>
																	<form action="index.php?menu=52&amp;id=<?php echo $row['id']; ?>" method="post" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
																		<input type="hidden" name="sprzet" value="<?php echo $row['id']; ?>" />
																		<input type="hidden" name="osoba" value="<?php echo $row2['osoba']; ?>" />
																		<input type="submit" class="btn btn-danger" name="del_kontakt" value="Usuń" />
																	</form>
																<?php
																	}
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
							</table>
							<?php
						}
						else echo '<h1 class="font20">Błąd</h1><p>Nie znaleziono aparatury o podanym identyfikatorze.</p>';
					}
					else echo '<h1 class="font20">Błąd</h1><p>Nie udało się pobrać danych z bazy danych: '.implode(' ',$st->errorInfo()).'</p>';
				}
				else echo '<h1 class="font20">Błąd</h1><p>Nie udało się pobrać danych z bazy danych: '.implode(' ',$DB->errorInfo()).'</p>';
?>
<a class="btn btn-warning margin_bottom_10" href="index.php?menu=8">Wróć do strony zarządzania aparaturą</a>
<?php
			}
		}
		else echo '<h1 class="font20">Błąd</h1><p>Nie podano osoby do edycji.</p>';
	}
	else require 'not_logged_in.php';
?>
