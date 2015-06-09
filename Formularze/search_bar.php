<!DOCTYPE>
<html>

<body>


<div align="left">
Kategoria:<br>

<form  method="post" action="search.php?go"  id="searchform">

<select name="category">
<option value="Sprzęt">Sprzęt</option>
<option value="Osoba">Osoba</option>
<option value="Laboratorium">Laboratorium</option>
<option value="Tag">Tag</option>
<option value="Zespol">Zespół</option>
<option value="Zakład">Zakład</option>
<option value="Projekt">Projekt</option>
</select>
<br>

<input  type="text" name="keyword">
<input  type="submit" name="submit" value="Search">
</form>




<?php


  if(isset($_POST['submit'])){
  	if(isset($_GET['go'])){
  		if(preg_match("/^\d[ a-zA-Z]+/", $_POST['keyword'])){
		

 			 $keyword=$_POST['keyword'];
			 $cat=$_POST['category'];
			 $DBName = nazwadb; //do zmiany


  			//połączenie z bazą danych, TRZEBA ZMIENIĆ PARAMETRY!!
  			$db=mysql_connect  ("servername", "username",  "password") or die ('Nie można połączyć się z bazą danych. Error: ' . mysql_error());

			$mydb=mysql_select_db("$DBName");

	

			
echo "<table>";


if($cat == "Sprzet")
{ 
$sql="SELECT id, nazwa, opis, laboratorium FROM $cat WHERE nazwa LIKE '%" . $keyword . "%' OR opis LIKE '%" . $keyword . "%'"; 
$result=mysql_query($sql);

while($row=mysql_fetch_array($result))
	{
		$ID = $row['id'];
		$nazwa = $row['nazwa'];
		$opis = mysql_query("SELECT LEFT(opis, 40) FROM Sprzet WHERE id = '$ID'");
		$lab = $row['laboratorium'];

		echo "<tr>";	
  		echo "<td>" . "<a  href=\"search.php?id=$ID\">" .$ID. "</a></td><td>"  .$nazwa . " </td><td> " . $opis .  "</td>";
		echo "</tr>";
	}

}


if($cat == "Osoba")
{ 
$sql="SELECT id, imie, nazwisko, email FROM $cat WHERE imie LIKE '%" . $keyword . "%' OR nazwisko LIKE '%" . $keyword . "%' OR email LIKE '%" . $keyword . "%'"; 
$result=mysql_query($sql);

while($row=mysql_fetch_array($result))
	{
		$ID = $row['id'];
		$imie = $row['imie'];
		$nazwisko = $row['nazwisko'];
		$email = $row['email'];

		echo "<tr>";	
  		echo "<td>" . "<a  href=\"search.php?id=$ID\">" .$ID. "</a></td><td>"  .$imie . " </td><td> " . $nazwisko . " </td><td> " . $email . "</td>";
		echo "</tr>";
	}

}


if($cat == "Laboratorium")
{ 
$sql="SELECT id, nazwa, zespol FROM $cat WHERE nazwa LIKE '%" . $keyword . "%"; 
$result=mysql_query($sql);

while($row=mysql_fetch_array($result))
	{
		$ID = $row['id'];
		$nazwa = $row['nazwa'];
		$zespol = $row['zespol'];

		echo "<tr>";	
  		echo "<td>" . "<a  href=\"search.php?id=$ID\">" .$ID. "</a></td><td>"  .$nazwa . " </td><td> " . $zespol . " </td>";
		echo "</tr>";
	}
}


if($cat == "Tag")
{ 
$sql="SELECT id, nazwa FROM $cat WHERE nazwa LIKE '%" . $keyword . "%'"; 
$result=mysql_query($sql);

while($row=mysql_fetch_array($result))
	{
		$ID = $row['id'];
		$nazwa = $row['nazwa'];
		
		echo "<tr>";	
  		echo "<td>" . "<a  href=\"search.php?id=$ID\">" .$ID. "</a></td><td>"  .$nazwa . " </td>";
		echo "</tr>";
	}
}


if($cat == "Zespol")
{ 
$sql="SELECT id, nazwa FROM $cat WHERE nazwa LIKE '%" . $keyword . "%'"; 
$result=mysql_query($sql);

while($row=mysql_fetch_array($result))
	{
		$ID = $row['id'];
		$nazwa = $row['nazwa'];
		
		echo "<tr>";	
  		echo "<td>" . "<a  href=\"search.php?id=$ID\">" .$ID. "</a></td><td>"  .$nazwa . " </td>";
		echo "</tr>";
	}
}


if($cat == "Zaklad")
{ 
$sql="SELECT id, nazwa FROM $cat WHERE nazwa LIKE '%" . $keyword . "%'"; 
$result=mysql_query($sql);

while($row=mysql_fetch_array($result))
	{
		$ID = $row['id'];
		$nazwa = $row['nazwa'];
		
		echo "<tr>";	
  		echo "<td>" . "<a  href=\"search.php?id=$ID\">" .$ID. "</a></td><td>"  .$nazwa . " </td>";
		echo "</tr>";
	}
}


if($cat == "Projekt")
{ 
$sql="SELECT id, nazwa, opis FROM $cat WHERE nazwa LIKE '%" . $keyword . "%' OR opis LIKE '%" . $keyword . "%'"; 
$result=mysql_query($sql);

while($row=mysql_fetch_array($result))
	{
		$ID = $row['id'];
		$nazwa = $row['nazwa'];
		$opis = mysql_query("SELECT LEFT(opis, 40) FROM Sprzet WHERE id = '$ID'");

		echo "<tr>";	
  		echo "<td>" . "<a  href=\"search.php?id=$ID\">" .$ID. "</a></td><td>"  .$nazwa . " </td><td> " . $opis .  "</td>";
		echo "</tr>";
	}
}


echo "</table>";
		}
  		else{ echo "Wprowadź zapytanie"; }
  	}
  }
?>


</div>
</body>
</html>

