<?php
	if(user::isLogged()){
?>
<ol class="breadcrumb">
	<li><a href="index.php">Start</a></li>
	<li class="active">Szczegóły tag</li>
</ol>
<?php
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
				<br />
				<table class="table table-striped">
					<tbody>
						<tr>
							<td>Nazwa</td>
							<td><?php echo $row['nazwa']; ?></td>
						</tr>
						<tr>
							<td>Sprzet</td>
							<td>
								<?php
									if($result=$DB->prepare('SELECT sprzet FROM Tagi_sprzetu WHERE tag=? ORDER BY sprzet')){
										if($result->execute(array($row['id']))){
											$i=1;
											while($row2=$result->fetch(PDO::FETCH_ASSOC)){
												if($result2=$DB->prepare('SELECT nazwa FROM Sprzet WHERE id=?')){
													if($result2->execute(array($row2['sprzet']))){
														if($row3=$result2->fetch(PDO::FETCH_ASSOC)){
															if($i>1) echo '</td></tr><tr><td></td><td>';
															?>
															<a href="index.php?menu=52&amp;id=<?php echo $row2['sprzet']; ?>"><?php echo $row3['nazwa']; ?></a>
															<form action="index.php?menu=60&amp;id=<?php echo $row['id']; ?>" method="post" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
																<input type="hidden" name="tag" value="<?php echo $row['id']; ?>" />
																<input type="hidden" name="sprzet" value="<?php echo $row2['sprzet']; ?>" />
																<input type="submit" name="del_tag" value="Usuń" />
															</form>
															<?php
														}
													}
													else echo 'Nie udało się pobrać danych z bazy danych.';
												}
												else echo 'Nie udało się pobrać danych z bazy danych.';
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
				</table>
				<?php
			}
			else echo 'Nie znaleziono tagu o podanym identyfikatorze.<br /><br />';
		}
		else echo 'Nastąpił błąd przy pobieraniu informacji o tagu: '.implode(' ',$st->errorInfo()).'<br /><br />';
	}
	else echo 'Nastąpił błąd przy pobieraniu informacji o tagu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
	}
	else echo '<br />Nie jesteś zalogowany.<br /><a href="index.php?menu=10">Zaloguj się</a><br /><br /> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
?>
