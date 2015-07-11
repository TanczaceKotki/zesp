 <?php
	if(user::isLogged()){
?>
<ol class="breadcrumb">
	<li><a href="index.php">Start</a></li>
	<li class="active">Zarządzanie słowami kluczowymi</li>
</ol>
<a class="btn btn-warning" href="index.php?menu=33">Dodaj słowo kluczowe</a><br /><br />
<a class="btn btn-warning" href="index.php?menu=32">Przypisz słowo kluczowe do aparatury</a><br /><br />
<table class="table table-striped">
	<thead>
		<tr>
			<th>Nazwa</th>
			<th colspan="2"></th>
		</tr>
	</thead>
	<tbody>
		 <?php
			if($result=$DB->query('SELECT id,nazwa FROM Tag ORDER BY nazwa')){
				while($row=$result->fetch(PDO::FETCH_ASSOC)){
					?>
					<tr>
						<td>
							<a href="index.php?menu=60&amp;id= <?php echo $row['id']; ?>"> <?php echo htmlspecialchars($row['nazwa'],ENT_QUOTES|ENT_HTML5,'UTF-8',false); ?></a>
						</td>
						<td>
							<form action="index.php?menu=46" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
								<input type="hidden" name="id" value=" <?php echo $row['id']; ?>" />
								<input class="btn btn-warning" type="submit" value="Edytuj" />
							</form>
						</td>
						<td>
							<form action="index.php?menu=31" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
								<input type="hidden" name="id" value=" <?php echo $row['id']; ?>" />
								<input class="btn btn-danger" type="submit" name="del_tag" value="Usuń" />
							</form>
						</td>
					</tr>
					 <?php
				}
			}
		?>
	<tbody>
</table>
 <?php
	}
	else echo '<br />Nie jesteś zalogowany.<br /><a href="login.php">Zaloguj się</a><br /><br />Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
?>
