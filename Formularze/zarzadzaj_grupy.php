<?php
	session_start();

	if (user::isLogged()) {
		$user = user::getData('', '');
		
?>
 <ol class="breadcrumb">
  <li><a href="index.php">Start</a></li>
    <li class="active">Zarządzaj zespołami laboratoriów</li>
</ol>
<a class="btn btn-warning" href="index.php?menu=30">Dodaj zespół laboratoriów</a>
<br /><br />

	</table><table class="table table-striped">
	<?php
		if($result=$DB->query('SELECT * FROM Zespol ORDER BY nazwa')){
			while($row=$result->fetch(PDO::FETCH_ASSOC)){
				?><tr>
					<td>
						<a href="view_zespol.php?id=<?php echo $row['id']; ?>"><?php echo $row['nazwa']; ?></a>
					</td>
					<td>
						<form action="index.php?menu=47" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
							<input class="btn btn-warning" type="submit" name="submitted" value="Edytuj" />
						</form>
					</td>
					<td>
						<form action="index.php?menu=31" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
							<input class="btn btn-danger" type="submit" name="del_zespol" value="Usuń" />
						</form>
					</td>
				</tr><?php
			}
		}
	?>
	</table><br /><br />
<?php
	}
	else {
		echo '<br>Nie jesteś zalogowany.<br />
		<a href="index.php?menu=10">Zaloguj się</a><br><br> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
	}
	?>
