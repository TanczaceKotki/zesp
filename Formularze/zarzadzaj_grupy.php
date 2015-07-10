<?php
	if(user::isLogged()){
?>
<ol class="breadcrumb">
	<li><a href="index.php">Start</a></li>
    <li class="active">Zarządzaj zespołami laboratoriów</li>
</ol>
<a class="btn btn-warning" href="index.php?menu=30">Dodaj zespół laboratoriów</a>
<br /><br />
<table class="table table-striped">
	<thead>
		<tr>
			<th>Nazwa</th>
			<th colspan="2"></th>
		</tr>
	</thead>
	<tbody>
		<?php
			if($result=$DB->query('SELECT * FROM Zespol ORDER BY nazwa')){
				while($row=$result->fetch(PDO::FETCH_ASSOC)){
					?>
					<tr>
						<td>
							<a href="index.php?menu=53&amp;id=<?php echo $row['id']; ?>"><?php echo $row['nazwa']; ?></a>
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
					</tr>
					<?php
				}
			}
		?>
	</tbody>
</table>
<?php
	}
	else echo '<br />Nie jesteś zalogowany.<br /><a href="index.php?menu=10">Zaloguj się</a><br /><br /> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
?>
