<?php
	require 'common.php';
	top();
	if(isset($_POST['id'])){
		require 'DB.php';
		$DB=dbconnect();
		if($st=$DB->prepare('SELECT * FROM Zdjecie WHERE id=?')){
			if($st->execute(array($_POST['id']))){
				$row=$st->fetch(PDO::FETCH_ASSOC);
?>
<form action="view_zdjecie.php?id=<?php echo $row['id']; ?>" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
	<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
	<input type="hidden" name="old_link" value="<?php echo $row['link']; ?>" />
	<input type="hidden" name="old_sprzet" value="<?php echo $row['sprzet']; ?>" />
	<div>
		<label for="link">Link: </label>
		<input type="text" name="link" id="link" value="<?php echo $row['link']; ?>" size="16" maxlength="1700" required />
	</div>
	<div>
		<label for="sprzet">Sprzęt: </label>
		<select name="sprzet" id="sprzet">
			<?php
				if($row['sprzet']==="") echo '<option value="" selected>-</option>';
				else echo '<option value="">-</option>';
				if($result=$DB->query('SELECT id,nazwa FROM Sprzet ORDER BY nazwa')){
					while($row2=$result->fetch(PDO::FETCH_ASSOC)){
						if($row['sprzet']===$row2['id']) echo '<option value="'.$row2['id'].'" selected>'.$row2['nazwa'].'</option>';
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
	else echo 'Nie podano zdjęcia do edycji.';
	bottom();
?>
