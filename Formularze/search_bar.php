<!DOCTYPE html>
<html lang="pl">
	<head>
		<title>Wyszukiwarka</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<style>table,tr,td{border:1px solid #000}</style>
				<style type="text/css"> .highlight { background-color: yellow; } </style>
	</head>
<body>

<div align="left">

Kategoria:<br>

<form  method="post" action="search_bar.php"  id="searchform">

	<select name="category">
		<option value="Sprzet">Sprzęt</option>
		<option value="Osoba">Osoba</option>
		<option value="Laboratorium">Laboratorium</option>
		<option value="Tag">Tag</option>
		<option value="Zespol">Zespół</option>
		<option value="Zaklad">Zakład</option>
		<option value="Projekt">Projekt</option>
	</select>
	<br>

	<input  type="text" name="keyword">
	<input  type="submit" name="submit" value="Search">

</form>

</div>

<div align="center">
<?php

require 'common.php';
require 'DB.php';
top();
$DB=dbconnect();

if(isset($_POST['submit'])){
	if(isset($_POST['category'])){
		if(isset($_POST['keyword'])){
			if(preg_match("/^[ \w\s\d@]*$/", $_POST['keyword'])){
			
			
$category = $_POST['category'];
$keyword = $_POST['keyword'];
	
echo"<table cellpadding=\"10\">";

switch($_POST['category'])		
{
	
	case "Osoba":
				$st=$DB->prepare("SELECT id, imie, nazwisko, email FROM Osoba WHERE imie LIKE '%" . $keyword . "%' OR nazwisko LIKE '%" . $keyword . "%' OR email LIKE '%" . $keyword . "%'");
				$st->execute();
				while($row=$st->fetch(PDO::FETCH_ASSOC))
				{
					$ID = $row['id'];
					$imie = $row['imie'];
					$nazwisko = $row['nazwisko'];
					$email = $row['email'];
					
					echo "<tr>";	
					echo "<td><a  href=\"view_osoba.php?id=$ID\">"  .$ID. "</a></td>";
					echo "<td><a  href=\"view_osoba.php?id=$ID\">"  . str_replace($keyword, "<span class=\"highlight\">$keyword</span>", $row['imie']) . " </a></td>";
					echo "<td><a  href=\"view_osoba.php?id=$ID\">"  . str_replace($keyword, "<span class=\"highlight\">$keyword</span>", $row['nazwisko']) . " </a></td>";
					echo "<td><a  href=\"view_osoba.php?id=$ID\">"  . str_replace($keyword, "<span class=\"highlight\">$keyword</span>", $row['email']) . " </a></td>";
					echo "</tr>";
				}
				break;
	
	case "Sprzet":
				$st=$DB->prepare("SELECT id, nazwa, SUBSTR(opis, 1, 160) AS opis FROM Sprzet WHERE nazwa LIKE '%" . $keyword . "%' OR opis LIKE '%" . $keyword . "%'"); 
				$st->execute();
				while($row=$st->fetch(PDO::FETCH_ASSOC))
				{
					$ID = $row['id'];
					$nazwa = $row['nazwa'];
					$opis = $row['opis'];
					
					echo "<tr>";	
					echo "<td><a  href=\"view_sprzet.php?id=$ID\">" .$ID. "</a></td>";
					echo "<td><a  href=\"view_sprzet.php?id=$ID\">"  . str_replace($keyword, "<span class=\"highlight\">$keyword</span>", $row['nazwa']) . " </a></td>";
					echo "<td>" . str_replace($keyword, "<span class=\"highlight\">$keyword</span>", $row['opis']) . "</td>";
					echo "</tr>";
				}
				break;
	
	case "Laboratorium":
				$st=$DB->prepare("SELECT id, nazwa, zespol FROM Laboratorium WHERE nazwa LIKE '%" . $keyword . "%'"); 
				$st->execute();
				while($row=$st->fetch(PDO::FETCH_ASSOC))
				{
					$ID = $row['id'];
					$nazwa = $row['nazwa'];
					$zespol = $row['zespol'];
					
					echo "<tr>";	
					echo "<td><a  href=\"view_lab.php?id=$ID\">" .$ID. "</a></td>";
					echo "<td><a  href=\"view_lab.php?id=$ID\">"  . str_replace($keyword, "<span class=\"highlight\">$keyword</span>", $row['nazwa']) . " </a></td>";
					echo "<td>" . $zespol . " </td>";
					echo "</tr>";
				}
				break;
				
	case "Tag":
				$st=$DB->prepare("SELECT id, nazwa FROM Tag WHERE nazwa LIKE '%" . $keyword . "%'"); 
				$st->execute();
				while($row=$st->fetch(PDO::FETCH_ASSOC))
				{
					$ID = $row['id'];
					$nazwa = $row['nazwa'];
					
					echo "<tr>";	
					echo "<td><a  href=\"view_tag.php?id=$ID\">" .$ID. "</a></td>";
					echo "<td><a  href=\"view_tag.php?id=$ID\">"  . str_replace($keyword, "<span class=\"highlight\">$keyword</span>", $row['nazwa']) . " </a></td>";
					echo "</tr>";
				}
				break;
				
	case "Zespol":
				$st=$DB->prepare("SELECT id, nazwa FROM Zespol WHERE nazwa LIKE '%" . $keyword . "%'"); 
				$st->execute();
				while($row=$st->fetch(PDO::FETCH_ASSOC))
				{
					$ID = $row['id'];
					$nazwa = $row['nazwa'];
					
					echo "<tr>";	
					echo "<td><a  href=\"view_zespol.php?id=$ID\">" .$ID. "</a></td>";
					echo "<td><a  href=\"view_zespol.php?id=$ID\">"  . str_replace($keyword, "<span class=\"highlight\">$keyword</span>", $row['nazwa']) . " </a></td>";
					echo "</tr>";
				}	
				break;
				
	case "Zaklad":
				$st=$DB->prepare("SELECT id, nazwa FROM Zaklad WHERE nazwa LIKE '%" . $keyword . "%'"); 
				$st->execute();
				while($row=$st->fetch(PDO::FETCH_ASSOC))
				{
					$ID = $row['id'];
					$nazwa = $row['nazwa'];
					
					echo "<tr>";	
					echo "<td><a  href=\"view_zaklad.php?id=$ID\">" .$ID. "</a></td>";
					echo "<td><a  href=\"view_zaklad.php?id=$ID\">"  . str_replace($keyword, "<span class=\"highlight\">$keyword</span>", $row['nazwa']) . " </a></td>";
					echo "</tr>";
				}
				break;
				
	case "Projekt":
				$st=$DB->prepare("SELECT id, nazwa, SUBSTR(opis, 1, 120) AS opis FROM Projekt WHERE nazwa LIKE '%" . $keyword . "%' OR opis LIKE '%" . $keyword . "%'"); 
				$st->execute();
				while($row=$st->fetch(PDO::FETCH_ASSOC))
				{
					$ID = $row['id'];
					$nazwa = $row['nazwa'];
					$opis = $row['opis'];					
					echo "<tr>";	
					echo "<td><a  href=\"view_projekt.php?id=$ID\">" .$ID. "</a></td>";
					echo "<td><a  href=\"view_projekt.php?id=$ID\">"  . str_replace($keyword, "<span class=\"highlight\">$keyword</span>", $row['nazwa']) . " </a></td>";
					echo "<td> " . str_replace($keyword, "<span class=\"highlight\">$keyword</span>", $row['opis']) . "</td>";
					echo "</tr>";
				}
				break;


}

echo "</table>";

}else{echo "Niepoprawne znaki w zapytaniu.<br>Dozwolone znaki a-z, A-Z, 0-9, '@'.";}
}else{echo "Niepoprawne zapytanie.<br>Spróbuj jeszcze raz.";}
}else{echo "Niepoprawna kategoria";}
}

?>

</div>
</body>
</html>
