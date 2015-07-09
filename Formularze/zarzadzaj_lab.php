
<?php
	session_start();
	require_once 'user.class.php';
	$DB=dbconnect();
	if (user::isLogged()) {
		$user = user::getData('', '');
		
?>
  <ol class="breadcrumb">
  <li><a href="index.php">Start</a></li>
    <li class="active">Zarządzaj laboratoriami</li>
</ol>
<a class="btn btn-warning" href="index.php?menu=21">Dodaj laboratorium</a><br /> <br />

<a class="btn btn-warning" href="index.php?menu=22">Dodaj informację o laboratorium w zakładzie</a><br /> <br />

<a class="btn btn-warning" href="index.php?menu=28">Dodaj zakład</a>
<br /><br />

	<table class="table table-striped"> <tbody>
	<?php
		if($result=$DB->query('SELECT id,nazwa FROM Laboratorium ORDER BY nazwa')){
			while($row=$result->fetch(PDO::FETCH_ASSOC)){
				?><tr>
				
					<td>
						<a href="index.php?menu=40&amp;id=<?php echo $row['id']; ?>"><?php echo $row['nazwa']; ?></a>
					</td>
					<td>
						</td>
					<td>
						<form action="index.php?menu=41" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
							<input class="btn btn-warning" type="submit" name="submittede" value="Edytuj" />
						</form>
					</td>
					<td>
						<form action="index.php?menu=31" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
							<input class="btn btn-danger" type="submit" name="del_lab" value="Usuń" />
						</form>
					</td>
				</tr><?php
			}
		}
	?>
	<tbody></table><br />
<?php
	}
	else {
		echo '<br>Nie jesteś zalogowany.<br />
		<a href="login.php">Zaloguj się</a><br><br> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
	}
	
	?>
