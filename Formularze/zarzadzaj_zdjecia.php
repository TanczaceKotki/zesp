<?php
	if(user::isLogged()){
		if($lvl<2){
			breadcrumbs('Zarządzanie zdjęciami');
?>
<h1 class="font20">Zarządzanie zdjęciami</h1>
<a class="btn btn-warning margin_ver_15" href="index.php?menu=29">Dodaj zdjęcie</a>
<?php
	if($result=$DB->query('SELECT id,link FROM Zdjecie ORDER BY link')){
?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Zdjęcie</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php
			while($row=$result->fetch(PDO::FETCH_ASSOC)){
				?>
				<tr>
					<td>
						<a href="index.php?menu=55&amp;id=<?php echo $row['id']; ?>"><img src="uploads/<?php echo $row['link']; ?>" width="200" alt="" /></a>
					</td>
					<td>
						<form action="index.php?menu=31" method="post" accept-charset="utf-8" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
							<input class="btn btn-danger" type="submit" name="del_zdjecie" value="Usuń" />
						</form>
					</td>
				</tr>
				<?php
			}
		?>
	</tbody>
</table>
<?php
			}
			else echo '<p>Nastąpił błąd przy pobieraniu informacji o zdjęciach: '.implode(' ',$DB->errorInfo()).'.</p>';
		}
		else require 'mod_cred_req.php';
	}
	else require 'not_logged_in.php';
?>
