<?php
	if(user::isLogged()){
		breadcrumbs('Zarządzanie aparaturą');
?>
<h1 class="font20">Zarządzanie aparaturą</h1>
<?php
	if($lvl<2){
		?>
		<div class="margin_ver_15"><a class="btn btn-warning" href="index.php?menu=25">Dodaj aparaturę</a></div>
		<div class="margin_ver_15"><a class="btn btn-warning" href="index.php?menu=20">Przypisz aparaturę do osoby kontaktowej</a></div>
		<div class="margin_ver_15"><a class="btn btn-warning" href="index.php?menu=32">Przypisz słowo kluczowe do aparatury</a></div>
		<?php
	}
	if($result=$DB->query('SELECT id,nazwa FROM Sprzet ORDER BY nazwa')){
?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Nazwa</th>
			<?php
				if($lvl<2) echo '<th colspan="2"></th>';
				else echo '<th></th>';
			?>
		</tr>
	</thead>
	<tbody>
		<?php
			while($row=$result->fetch(PDO::FETCH_ASSOC)){
				?>
				<tr>
					<td>
						<a href="index.php?menu=52&amp;id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['nazwa'],ENT_QUOTES|ENT_HTML5,'UTF-8',false); ?></a>
					</td>
					<td>
						<form action="index.php?menu=45" method="post" accept-charset="utf-8" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
							<input class="btn btn-warning" type="submit" value="Edytuj" />
						</form>
					</td>
					<?php
						if($lvl<2){
					?>
					<td>
						<form action="index.php?menu=31" method="post" accept-charset="utf-8" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
							<input class="btn btn-danger" type="submit" name="del_sprzet" value="Usuń" />
						</form>
					</td>
					<?php
						}
					?>
				</tr>
				<?php
			}
		?>
	</tbody>
</table>
<?php
		}
		else echo '<p>Nastąpił błąd przy pobieraniu informacji o aparaturze: '.implode(' ',$DB->errorInfo()).'.</p>';
	}
	else require 'not_logged_in.php';
?>
