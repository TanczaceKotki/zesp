<?php
	if(user::isLogged()){
?>
<ol class="breadcrumb">
	<li><a href="index.php">Start</a></li>
    <li class="active">Zarządzaj osobami kontaktowymi</li>
</ol>
<a class="btn btn-warning" href="index.php?menu=23">Dodaj osobę kontaktową</a><br /><br />
<a class="btn btn-warning" href="index.php?menu=20">Przypisz aparaturę do osoby kontaktowej</a><br /><br />
<table class="table table-striped">
	<thead>
		<th>Imię</th>
		<th>Nazwisko</th>
		<th colspan="2"></th>
	</thead>
	<tbody>
		<?php
			if($result=$DB->query('SELECT id,imie,nazwisko,email FROM Osoba ORDER BY nazwisko')){
				while($row=$result->fetch(PDO::FETCH_ASSOC)){
					?>
					<tr class="item">
						<td>
							<a href="index.php?menu=54&amp;id=<?php echo $row['id']; ?>" class="item_1"><?php echo $row['imie']; ?></a>
						</td>
						<td>
							<a href="index.php?menu=54&amp;id=<?php echo $row['id']; ?>" class="item_2"><?php echo $row['nazwisko']; ?></a>
						</td>
						<td>
							<form action="index.php?menu=42" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
								<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
								<input class="btn btn-warning" type="submit" value="Edytuj" />
							</form>
						</td>
						<td>
							<form action="index.php?menu=31" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
								<input type="hidden" name="email" value="<?php echo $row['email']; ?>" />
								<input class="btn btn-danger" type="submit" name="del_osoba" value="Usuń" />
							</form>
						</td>
					</tr><?php
				}
			}
		?>
	</tbody>
</table>
<script src="js/items.js" type="text/javascript"></script>
<?php
	}
	else {
		echo '<br />Nie jesteś zalogowany.<br />
		<a href="index.php?menu=10">Zaloguj się</a><br /><br /> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
	}
?>
