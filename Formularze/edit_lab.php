<?php
	if(user::isLogged()){
		if(isset($_POST['submitted'])){
			$send=False;
			$params=array();
			$sql='UPDATE Laboratorium SET';
			if($_POST['nazwa']!==$_POST['old_nazwa']){
				$sql.=' nazwa=?';
				$params[]=$_POST['nazwa'];
				$send=True;
			}
			if($_POST['zespol']!==$_POST['old_zespol']){
				if($send) $sql.=',';
				if($_POST['zespol']==="") $sql.=' zespol=NULL';
				else{
					$sql.=' zespol=?';
					$params[]=$_POST['zespol'];
				}
				$send=True;
			}
			if($send){
				$sql.=' WHERE id=?';
				$params[]=$_POST['id'];
				if($st=$DB->prepare($sql)){
					if($st->execute($params)){
						header('Location:index.php?menu=40&id='.$_POST['id']);
						die();
					}
					else echo 'Nastąpił błąd przy modyfikowaniu laboratorium: '.implode(' ',$st->errorInfo()).'<br /><br />';
				}
				else echo 'Nastąpił błąd przy modyfikowaniu laboratorium: '.implode(' ',$DB->errorInfo()).'<br /><br />';
			}
		}
		if(isset($_POST['id'])){
			if($st=$DB->prepare('SELECT * FROM Laboratorium WHERE id=?')){
				if($st->execute(array($_POST['id']))){
					if($row=$st->fetch(PDO::FETCH_ASSOC)){
?>
<ol class="breadcrumb">
	<li><a href="index.php">Start</a></li>
	<li><a href="index.php?menu=40&id=<?php echo $_POST['id']; ?>">Szczegóły laboratorium</a></li>
	<li><a href="index.php?menu=7">Zarządzaj laboratoriami</a></li>
	<li class="active">Edytuj laboratorium</li>
</ol>
<form action="index.php?menu=41" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
	<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
	<input type="hidden" name="old_nazwa" value="<?php echo $row['nazwa']; ?>" />
	<input type="hidden" name="old_zespol" value="<?php echo $row['zespol']; ?>" />
	<div>
		<label for="nazwa">Nazwa<span class="color_red">*</span>: </label>
		<input class="form-control" type="text" name="nazwa" id="nazwa" value="<?php echo $row['nazwa']; ?>" size="16" maxlength="64" required="required" /><br />
		<span id="nazwa_counter"></span>
	</div>
	<div>
		<label for="zespol">Zespół: </label>
		<select class="form-control" name="zespol" id="zespol">
			<option value=""<?php if($row['zespol']==="") echo ' selected="selected"'; ?>>-</option>
			<?php
				if($result=$DB->query('SELECT id,nazwa FROM Zespol ORDER BY nazwa')){
					if($rows=$result->fetchAll(PDO::FETCH_ASSOC)){
						$first_letter=$rows[0]['nazwa'][0];
						echo '<optgroup label="'.$first_letter.'">';
						foreach($rows as $row2){
							if($first_letter!==$row2['nazwa'][0]){
								$first_letter=$row2['nazwa'][0];
								echo '</optgroup><optgroup label="'.$first_letter.'">';
							}
							echo '<option value="'.$row2['id'].'"';
							if($row['zespol']===$row2['id']) echo ' selected="selected"';
							echo '>'.$row2['nazwa'].'</option>';
						}
						echo '</optgroup>';
					}
				}
			?>
		</select>
	</div>
	<div><br />
		<input class="btn btn-primary" type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<span class="color_red">*</span> - wymagane pola.
<script src="js/remaining_char_counter.js" type="text/javascript"></script>
<?php
					}
					else echo 'Nie znaleziono laboratorium o podanym identyfikatorze.<br /><br />';
				}
				else echo 'Nie udało się pobrać danych z bazy danych: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
			else echo 'Nie udało się pobrać danych z bazy danych: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
		else echo 'Nie podano osoby do edycji.';
	}
	else echo '<br />Nie jesteś zalogowany.<br /><a href="login.php">Zaloguj się</a><br /><br />Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
?>
