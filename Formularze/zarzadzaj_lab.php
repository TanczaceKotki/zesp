<?php
	if(user::isLogged()){
		if($lvl<2){
			breadcrumbs('Zarządzanie laboratoriami');
?>
<h1 class="font20">Zarządzanie laboratoriami</h1>
<div class="margin_ver_15"><a class="btn btn-warning" href="index.php?menu=21">Dodaj laboratorium</a></div>
<div class="margin_ver_15"><a class="btn btn-warning" href="index.php?menu=22">Dodaj informację o laboratorium w zakładzie</a></div>
<?php
	if($result=$DB->query('SELECT id,nazwa FROM Laboratorium ORDER BY nazwa')){
?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Nazwa</th>
			<th colspan="2"></th>
		</tr>
	</thead>
	<tbody>
		<?php
			while($row=$result->fetch(PDO::FETCH_ASSOC)){
				?>
				<tr>
					<td>
						<a href="index.php?menu=40&amp;id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['nazwa'],ENT_QUOTES|ENT_HTML5,'UTF-8',false); ?></a>
					</td>
					<td>
						<form action="index.php?menu=41" method="post" accept-charset="utf-8" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
							<input class="btn btn-warning" type="submit" value="Edytuj" />
						</form>
					</td>
					<td>
						<form action="index.php?menu=31" method="post" accept-charset="utf-8" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
							<input class="btn btn-danger" type="submit" name="del_lab" value="Usuń" />
						</form>
					</td>
				</tr>
				<?php
			}
		?>
	<tbody>
</table>
<?php
			}
			else echo '<p>Nastąpił błąd przy pobieraniu informacji o laboratoriach: '.implode(' ',$DB->errorInfo()).'.</p>';
		}
		else require 'mod_cred_req.php';
	}
	else require 'not_logged_in.php';
?>
