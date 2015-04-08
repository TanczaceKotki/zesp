<?php
	require 'common.php';
	top();
	if(isset($_POST['id'])){
		require 'DB.php';
		$DB=dbconnect();
		if($st=$DB->prepare('SELECT * FROM Laboratorium WHERE id=?')){
			if($st->execute(array($_POST['id']))){
				$row=$st->fetch(PDO::FETCH_ASSOC);
?>
<form action="view_lab.php?id=<?php echo $row['id']; ?>" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
	<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
	<input type="hidden" name="old_nazwa" value="<?php echo $row['nazwa']; ?>" />
	<input type="hidden" name="old_zespol" value="<?php echo $row['zespol']; ?>" />
	<div>
		<label for="nazwa">Nazwa: </label>
		<input type="text" name="nazwa" id="nazwa" value="<?php echo $row['nazwa']; ?>" size="16" maxlength="64" required />
	</div>
	<div>
		<label for="zespol">Zespół: </label>
		<select name="zespol" id="zespol">
			<?php
				if($row['zespol']==="") echo '<option value="" selected>-</option>';
				else echo '<option value="">-</option>';
				if($result=$DB->query('SELECT id,nazwa FROM Zespol ORDER BY nazwa')){
					while($row2=$result->fetch(PDO::FETCH_ASSOC)){
						if($row['zespol']===$row2['id']) echo '<option value="'.$row2['id'].'" selected>'.$row2['nazwa'].'</option>';
						else echo '<option value="'.$row2['id'].'">'.$row2['nazwa'].'</option>';
					}
				}
			?>
		</select>
	</div>
	<div>
		<input type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<?php
			}
			else echo 'Nie udało się pobrać danych z bazy danych: '.implode(' ',$st->errorInfo()).'<br /><br />';
		}
		else echo 'Nie udało się pobrać danych z bazy danych: '.implode(' ',$DB->errorInfo()).'<br /><br />';
	}
	else echo 'Nie podano osoby do edycji.';
	bottom();
?>
