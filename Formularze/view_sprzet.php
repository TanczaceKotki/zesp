<?php
	if(user::isLogged()){
?>
<ol class="breadcrumb">
	<li><a href="index.php">Start</a></li>
	<li><a href="index.php?menu=8">Zarządzaj aparaturą</a></li>
	<li class="active">Szczegóły aparatura</li>
</ol>
<?php
	if(isset($_POST['del_picture'])){
		if($st=$DB->prepare('DELETE FROM Zdjecie WHERE id=?')){
			if($st->execute(array($_POST['id']))) echo 'Zdjecie zostało usunięte.<br /><br />';
			else echo 'Nastąpił błąd przy usuwaniu zdjęcia: '.implode(' ',$st->errorInfo()).'<br /><br />';
		}
		else echo 'Nastąpił błąd przy usuwaniu zdjęcia: '.implode(' ',$DB->errorInfo()).'<br /><br />';
	}
	if(isset($_POST['del_tag'])){
		if($st=$DB->prepare('DELETE FROM Tagi_sprzetu WHERE sprzet=? AND tag=?')){
			if($st->execute(array($_POST['sprzet'],$_POST['tag']))) echo 'Tag został usunięty.<br /><br />';
			else echo 'Nastąpił błąd przy usuwaniu tagu: '.implode(' ',$st->errorInfo()).'<br /><br />';
		}
		else echo 'Nastąpił błąd przy usuwaniu tagu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
	}
	if(isset($_POST['del_kontakt'])){
		if($st=$DB->prepare('DELETE FROM Kontakt WHERE sprzet=? AND osoba=?')){
			if($st->execute(array($_POST['sprzet'],$_POST['osoba']))) echo 'Informacje kontaktowe zostały usunięte.<br /><br />';
			else echo 'Nastąpił błąd przy usuwaniu informacji kontaktowych: '.implode(' ',$st->errorInfo()).'<br /><br />';
		}
		else echo 'Nastąpił błąd przy usuwaniu informacji kontaktowych: '.implode(' ',$DB->errorInfo()).'<br /><br />';
	}
	if(isset($_POST['submitted'])){
		$send=False;
		$params=array();
		$sql='UPDATE Sprzet SET';
		if($_POST['nazwa']!==$_POST['old_nazwa']){
			$sql.=' nazwa=?';
			$params[]=$_POST['nazwa'];
			$send=True;
		}
		$data=$_POST['data_zakupu_rok'];
		if($_POST['data_zakupu_miesiac']!==""){
			$data.='-'.$_POST['data_zakupu_miesiac'];
			if($_POST['data_zakupu_dzien']!=="") $data.='-'.$_POST['data_zakupu_dzien'];
		}
		if($data!==$_POST['old_data_zakupu']){
			if($send) $sql.=',';
			$sql.=' data_zakupu=?';
			$params[]=$data;
			$send=True;
		}
		$data="";
		if($_POST['data_uruchom_rok']!==""){
			$data=$_POST['data_uruchom_rok'];
			if($_POST['data_uruchom_miesiac']!==""){
				$data.='-'.$_POST['data_uruchom_miesiac'];
				if($_POST['data_uruchom_dzien']!=="") $data.='-'.$_POST['data_uruchom_dzien'];
			}
		}
		if($data!==$_POST['old_data_uruchom']){
			if($send) $sql.=',';
			if($data==="") $sql.=' data_uruchom=NULL';
			else{
				$sql.=' data_uruchom=?';
				$params[]=$data;
			}
			$send=True;
		}
		if($_POST['wartosc']!==$_POST['old_wartosc']){
			if($send) $sql.=',';
			if($data==="") $sql.=' wartosc=NULL';
			else{
				$sql.=' wartosc=?';
				$params[]=$_POST['wartosc'];
			}
			$send=True;
		}
		if($_POST['opis']!==$_POST['old_opis']){
			if($send) $sql.=',';
			$sql.=' opis=?';
			$params[]=$_POST['opis'];
			$send=True;
		}
		if($_POST['projekt']!==$_POST['old_projekt']){
			if($send) $sql.=',';
			if($_POST['projekt']==="") $sql.=' projekt=NULL';
			else{
				$sql.=' projekt=?';
				$params[]=$_POST['projekt'];
			}
			$send=True;
		}
		if($_POST['laboratorium']!==$_POST['old_laboratorium']){
			if($send) $sql.=',';
			if($_POST['laboratorium']==="") $sql.=' laboratorium=NULL';
			else{
				$sql.=' laboratorium=?';
				$params[]=$_POST['laboratorium'];
			}
			$send=True;
		}
		if($send){
			$sql.=' WHERE id=?';
			$params[]=$_POST['id'];
			if($st=$DB->prepare($sql)){
				if($st->execute($params)) echo 'Sprzęt został pomyślnie zmodyfikowany.<br /><br />';
				else echo 'Nastąpił błąd przy modyfikowaniu sprzętu: '.implode(' ',$st->errorInfo()).'<br /><br />';
			} 
			else echo 'Nastąpił błąd przy modyfikowaniu sprzętu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
		}

	if($st=$DB->prepare('SELECT * FROM Sprzet WHERE id=?')){
		if($st->execute(array($_GET['id']))){
			if($row=$st->fetch(PDO::FETCH_ASSOC)){
				?>
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
											<form action="index.php?menu=52&amp;id=<?php echo $row['id']; ?>" method="post" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
												<input type="hidden" name="id" value="<?php echo $row2['id']; ?>" />
												<input type="submit" class="btn btn-danger" name="del_picture" value="Usuń" />
											</form>
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
							<th>Tagi</th>
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
														<form action="index.php?menu=52&amp;id=<?php echo $row['id']; ?>" method="post" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
															<input type="hidden" name="sprzet" value="<?php echo $row['id']; ?>" />
															<input type="hidden" name="tag" value="<?php echo $row2['tag']; ?>" />
															<input type="submit" class="btn btn-danger" name="del_tag" value="Usuń" />
														</form>
													<br /><?php
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
														<form action="index.php?menu=52&amp;id=<?php echo $row['id']; ?>" method="post" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
															<input type="hidden" name="sprzet" value="<?php echo $row['id']; ?>" />
															<input type="hidden" name="osoba" value="<?php echo $row2['osoba']; ?>" />
															<input type="submit" class="btn btn-danger" name="del_kontakt" value="Usuń" />
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
					</tbody>
				</table>
				<?php
			}
			else echo 'Nie udało się pobrać danych z bazy danych.';
		}
		else echo 'Nastąpił błąd przy pobieraniu informacji o sprzęcie: '.implode(' ',$st->errorInfo()).'<br /><br />';
	}
	else echo 'Nastąpił błąd przy pobieraniu informacji o sprzęcie: '.implode(' ',$DB->errorInfo()).'<br /><br />';
?>
<a class="btn btn-warning" href="index.php?menu=8">Wróć do strony zarządzania aparaturą</a>
<?php
	}
	else echo '<br />Nie jesteś zalogowany.<br /><a href="index.php?menu=10">Zaloguj się</a><br /><br /> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
?>
