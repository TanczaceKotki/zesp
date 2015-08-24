<?php breadcrumbs('Zespoły laboratoriów'); ?>
<h1 class="font20">Zespoły laboratoriów</h1>
<?php
	if($result=$DB->query('SELECT id,nazwa FROM Zespol ORDER BY nazwa')){
?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Nazwa</th>
		</tr>
	</thead>
	<tbody>
		<?php
			while($row=$result->fetch(PDO::FETCH_ASSOC)){
				?>
				<tr>
					<td>
						<a href="index.php?menu=58&amp;id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['nazwa'],ENT_QUOTES|ENT_HTML5,'UTF-8',false); ?></a>
					</td>
				</tr>
				<?php
			}
		?>
	</tbody>
</table>
<?php
	}
	else echo '<p>Nastąpił błąd przy pobieraniu informacji o zespołach laboratoriów.</p>';
?>
