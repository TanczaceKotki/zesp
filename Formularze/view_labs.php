<ol class="breadcrumb">
	<li><a href="index.php">Start</a></li>
	<li class="active">Laboratoria</li>
</ol>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Nazwa</th>
		</tr>
	</thead>
	<tbody>
		<?php
			if($result=$DB->query('SELECT id,nazwa FROM Laboratorium ORDER BY nazwa')){
				while($row=$result->fetch(PDO::FETCH_ASSOC)){
					?>
					<tr>
						<td>
							<a href="index.php?menu=57&amp;id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['nazwa'],ENT_QUOTES|ENT_HTML5,'UTF-8',false); ?></a>
						</td>
					</tr>
					<?php
				}
			}
		?>
	</tbody>
</table>
