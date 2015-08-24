<?php
	if(user::isLogged()){
		if($lvl<2){
			breadcrumbs('Zarządzanie osobami kontaktowymi');
?>
<h1 class="font20">Zarządzanie osobami kontaktowymi</h1>
<div class="margin_ver_15"><a class="btn btn-warning" href="index.php?menu=23">Dodaj osobę kontaktową</a></div>
<div class="margin_ver_15"><a class="btn btn-warning" href="index.php?menu=20">Przypisz aparaturę do osoby kontaktowej</a></div>
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
					<tr class="items">
						<td>
							<a href="index.php?menu=54&amp;id=<?php echo $row['id']; ?>" class="item"><?php echo htmlspecialchars($row['imie'],ENT_QUOTES|ENT_HTML5,'UTF-8',false); ?></a>
						</td>
						<td>
							<a href="index.php?menu=54&amp;id=<?php echo $row['id']; ?>" class="item"><?php echo htmlspecialchars($row['nazwisko'],ENT_QUOTES|ENT_HTML5,'UTF-8',false); ?></a>
						</td>
						<td>
							<form action="index.php?menu=42" method="post" accept-charset="utf-8" enctype="application/x-www-form-urlencoded">
								<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
								<input class="btn btn-warning" type="submit" value="Edytuj" />
							</form>
						</td>
						<td>
							<form action="index.php?menu=31" method="post" accept-charset="utf-8" enctype="application/x-www-form-urlencoded">
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
		else require 'mod_cred_req.php';
	}
	else require 'not_logged_in.php';
?>
