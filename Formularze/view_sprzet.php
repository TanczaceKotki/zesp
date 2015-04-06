<?php
	require 'common.php';
	require 'DB.php';
	top();
	$DB=dbconnect();
	if($st=$DB->prepare('SELECT * FROM Sprzet WHERE id=?')){
		if($st->execute(array($_GET['id']))){
			$row=$st->fetch(PDO::FETCH_ASSOC);
			echo '<table><tr><td>Nazwa</td><td>'.$row['nazwa'].'</td></tr><tr><td>Data zakupu</td><td>'.$row['data_zakupu'].'</td></tr><tr><td>Data zakupu</td><td>';
			if($row['data_zakupu']!=="") echo $row['data_zakupu'];
			echo '</td></tr><tr><td>Wartość</td><td>'.$row['wartosc'].'</td></tr><tr><td>Opis</td><td>'.$row['opis'].'</td></tr><tr><td>Projekt</td><td>';
			if($row['projekt']!==""){
				if($result=$DB->query('SELECT nazwa FROM Projekt WHERE id='.$row['projekt'])){
					$row2=$result->fetch(PDO::FETCH_ASSOC);
					echo $row2['nazwa'];
				}
				else echo 'Nie udało się pobrać danych z bazy danych.';
			}
			echo '</td></tr><tr><td>Laboratorium</td><td>';
			if($row['laboratorium']!==""){
				if($result=$DB->query('SELECT nazwa FROM Laboratorium WHERE id='.$row['laboratorium'])){
					$row2=$result->fetch(PDO::FETCH_ASSOC);
					echo $row2['nazwa'];
				}
				else echo 'Nie udało się pobrać danych z bazy danych.';
			}
			echo '</td></tr></table><br /><br />Zdjęcia:';
			if($result=$DB->query('SELECT link FROM Zdjecie WHERE sprzet='.$row['id'].' ORDER BY link')){
				while($row2=$result->fetch(PDO::FETCH_ASSOC)){
					echo '<img src="'.$row2['link'].'" width="200" alt="" />';
				}
			}
			echo '</td></tr></table><br /><br />Tagi:';
			if($result=$DB->query('SELECT tag FROM Tagi_sprzetu WHERE sprzet='.$row['id'].' ORDER BY tag')){
				$comma_flag=False;
				while($row2=$result->fetch(PDO::FETCH_ASSOC)){
					if($result2=$DB->query('SELECT nazwa FROM Tag WHERE id='.$row2['tag'])){
						$row2=$result2->fetch(PDO::FETCH_ASSOC);
						if($comma_flag) echo ' ,';
						$comma_flag=True;
						echo $row2['nazwa'];
					}
				}
			}
			else echo 'Nie udało się pobrać danych z bazy danych.';
			echo '<br /><br />Kontakt: ';
			if($result=$DB->query('SELECT osoba FROM Kontakt WHERE sprzet='.$row['id'].' ORDER BY osoba')){
				$comma_flag=False;
				while($row2=$result->fetch(PDO::FETCH_ASSOC)){
					if($result2=$DB->query('SELECT imie,nazwisko,email FROM Osoba WHERE id='.$row2['osoba'])){
						$row2=$result2->fetch(PDO::FETCH_ASSOC);
						if($comma_flag) echo ' ,';
						$comma_flag=True;
						echo $row2['imie'].' '.$row2['nazwisko'].' ('.$row2['email'].')';
					}
				}
			}
			else echo 'Nie udało się pobrać danych z bazy danych.';
		}
		else{
			echo 'Nastąpił błąd przy dodawaniu informacji o tagu sprzętu: '.implode(' ',$st->errorInfo()).'<br /><br />';
		}
	}
	else{
		echo 'Nastąpił błąd przy dodawaniu informacji o tagu sprzętu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
	}
	bottom();
?>