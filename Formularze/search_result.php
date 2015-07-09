
  <ol class="breadcrumb">
  <li><a href="index.php">Start</a></li>
    <li class="active">Wyniki wyszukiwania</li>
</ol>
<div>
<?php
if(isset($_POST['submit'])){
	if(isset($_POST['category'])){
		if(isset($_POST['keyword'])){
			if(preg_match("/^[ \w\s\d@]*$/", $_POST['keyword'])){
			
			
$category = $_POST['category'];
$keyword = $_POST['keyword'];
	
echo"<table class='table table-striped'>";

switch($_POST['category'])		
{
	
	case "Osoba":
				$st=$DB->query("SELECT id, imie, nazwisko, email FROM Osoba WHERE imie LIKE '%$keyword%' OR nazwisko LIKE '% $keyword%' OR email LIKE '%$keyword%'");
				while($row=$st->fetch(PDO::FETCH_ASSOC))
				{
					$ID = $row['id'];
					$imie = $row['imie'];
					$nazwisko = $row['nazwisko'];
					$email = $row['email'];
					
					echo "<tr>";	
					echo "<td><a href=\"index.php?menu=54&amp;id=$ID\">$ID</a></td>";
					echo "<td><a href=\"index.php?menu=54&amp;id=$ID\">"  . str_replace($keyword, "<span class=\"highlight\">$keyword</span>", $row['imie']) . " </a></td>";
					echo "<td><a href=\"index.php?menu=54&amp;id=$ID\">"  . str_replace($keyword, "<span class=\"highlight\">$keyword</span>", $row['nazwisko']) . " </a></td>";
					echo "<td><a href=\"index.php?menu=54&amp;id=$ID\">"  . str_replace($keyword, "<span class=\"highlight\">$keyword</span>", $row['email']) . " </a></td>";
					echo "</tr>";
				}
				break;
	
	case "Sprzet":
				$st=$DB->query("SELECT id, nazwa, SUBSTR(opis, 1, 160) AS opis FROM Sprzet WHERE nazwa LIKE '%$keyword%' OR opis LIKE '%$keyword%'");
				while($row=$st->fetch(PDO::FETCH_ASSOC))
				{
					$ID = $row['id'];
					$nazwa = $row['nazwa'];
					$opis = $row['opis'];
					
					echo "<tr>";	
					echo "<td><a href=\"index.php?menu=52&amp;id=$ID\">$ID</a></td>";
					echo "<td><a href=\"index.php?menu=52&amp;id=$ID\">"  . str_replace($keyword, "<span class=\"highlight\">$keyword</span>", $row['nazwa']) . " </a></td>";
					echo "<td>" . str_replace($keyword, "<span class=\"highlight\">$keyword</span>", $row['opis']) . "</td>";
					echo "</tr>";
				}
				break;
	
	case "Laboratorium":
				$st=$DB->query("SELECT id, nazwa, zespol FROM Laboratorium WHERE nazwa LIKE '%$keyword%'");
				while($row=$st->fetch(PDO::FETCH_ASSOC))
				{
					$ID = $row['id'];
					$nazwa = $row['nazwa'];
					$zespol = $row['zespol'];
					
					echo "<tr>";	
					echo "<td><a href=\"index.php?menu=40&amp;id=$ID\">$ID</a></td>";
					echo "<td><a href=\"index.php?menu=40&amp;id=$ID\">"  . str_replace($keyword, "<span class=\"highlight\">$keyword</span>", $row['nazwa']) . " </a></td>";
					echo "<td>" . $zespol . " </td>";
					echo "</tr>";
				}
				break;
				
	case "Tag":
				$st=$DB->query("SELECT id, nazwa FROM Tag WHERE nazwa LIKE '%$keyword%'");
				while($row=$st->fetch(PDO::FETCH_ASSOC))
				{
					$ID = $row['id'];
					$nazwa = $row['nazwa'];
					
					echo "<tr>";	
					echo "<td><a href=\"index.php?menu=60&amp;id=$ID\">$ID</a></td>";
					echo "<td><a href=\"index.php?menu=60&amp;id=$ID\">"  . str_replace($keyword, "<span class=\"highlight\">$keyword</span>", $row['nazwa']) . " </a></td>";
					echo "</tr>";
				}
				break;
				
	case "Zespol":
				$st=$DB->query("SELECT id, nazwa FROM Zespol WHERE nazwa LIKE '%$keyword%'");
				while($row=$st->fetch(PDO::FETCH_ASSOC))
				{
					$ID = $row['id'];
					$nazwa = $row['nazwa'];
					
					echo "<tr>";	
					echo "<td><a href=\"index.php?menu=53&amp;id=$ID\">$ID</a></td>";
					echo "<td><a href=\"index.php?menu=53&amp;id=$ID\">"  . str_replace($keyword, "<span class=\"highlight\">$keyword</span>", $row['nazwa']) . " </a></td>";
					echo "</tr>";
				}	
				break;
				
	case "Zaklad":
				$st=$DB->query("SELECT id, nazwa FROM Zaklad WHERE nazwa LIKE '%$keyword%'");
				while($row=$st->fetch(PDO::FETCH_ASSOC))
				{
					$ID = $row['id'];
					$nazwa = $row['nazwa'];
					
					echo "<tr>";	
					echo "<td><a href=\"index.php?menu=61&amp;id=$ID\">$ID</a></td>";
					echo "<td><a href=\"index.php?menu=61&amp;id=$ID\">"  . str_replace($keyword, "<span class=\"highlight\">$keyword</span>", $row['nazwa']) . " </a></td>";
					echo "</tr>";
				}
				break;
				
	case "Projekt":
				$st=$DB->query("SELECT id, nazwa, SUBSTR(opis, 1, 120) AS opis FROM Projekt WHERE nazwa LIKE '%$keyword%' OR opis LIKE '%$keyword%'"); 
				while($row=$st->fetch(PDO::FETCH_ASSOC))
				{
					$ID = $row['id'];
					$nazwa = $row['nazwa'];
					$opis = $row['opis'];					
					echo "<tr>";	
					echo "<td><a href=\"index.php?menu=51&amp;id=$ID\">$ID</a></td>";
					echo "<td><a href=\"index.php?menu=51&amp;id=$ID\">"  . str_replace($keyword, "<span class=\"highlight\">$keyword</span>", $row['nazwa']) . " </a></td>";
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

