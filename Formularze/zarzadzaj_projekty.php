  <ol class="breadcrumb">
  <li><a href="index.php">Start</a></li>
    <li class="active">zarządzaj projektami</li>
</ol>
<a href="index.php?menu=24">Dodaj projekt</a>

</table><table class="table table-striped">
	<?php
		if($result=$DB->query('SELECT * FROM Projekt ORDER BY nazwa')){
			while($row=$result->fetch(PDO::FETCH_ASSOC)){
				?><tr>
					<td>
						<a href="view_projekt.php?id=<?php echo $row['id']; ?>"><?php echo $row['nazwa']; ?></a>
					</td>
					
					<td>
						<form action="index.php?menu=44" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
							<input class="btn btn-warning" type="submit" name="submitted" value="Edytuj" />
						</form>
					</td>
					<td>
						<form action="index.php?menu=31" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
							<input class="btn btn-danger" type="submit" name="del_projekt" value="Usuń" />
						</form>
					</td>
				</tr><?php
			} }
		
	?>
	</table><br /><br />
<?php
	
	
	?>
