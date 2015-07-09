<?php
	session_start();
	$DB=dbconnect();
	if (user::isLogged()) {
		$user = user::getData('', '');
		
?>
 <ol class="breadcrumb">
  <li><a href="index.php">Start</a></li>
    <li class="active">Zarządzaj zdjęciami</li>
</ol>
<a class="btn btn-warning" href="index.php?menu=29">Dodaj zdjęcie</a><br/><br>

<table class="table table-striped">
	<?php
		if($result=$DB->query('SELECT id,link FROM Zdjecie ORDER BY link')){
			while($row=$result->fetch(PDO::FETCH_ASSOC)){
				?><tr>
					<td>
						<a href="index.php?menu=55&amp;id=<?php echo $row['id']; ?>"><img src="uploads/<?php echo $row['link']; ?>" width="200" alt="" /></a>
					</td>
					
					<td>
						<form action="index.php?menu=31" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
							<input class="btn btn-danger" type="submit" name="del_zdjecie" value="Usuń" />
						</form>
					</td>
				</tr><?php
			}
		}
	?>
</table>
<?php
	}
	else {
		echo '<br>Nie jesteś zalogowany.<br />
		<a href="login.php">Zaloguj się</a><br><br> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
	}
	?>
