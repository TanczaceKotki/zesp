<?php
	if(user::isLogged()){
		if($lvl<2){
			$msg="";
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
						else $msg='<p>Nastąpił błąd przy modyfikowaniu laboratorium: '.implode(' ',$st->errorInfo()).'</p>';
					}
					else $msg='<p>Nastąpił błąd przy modyfikowaniu laboratorium: '.implode(' ',$DB->errorInfo()).'</p>';
				}
			}
			if(isset($_POST['id'])){
				if($st=$DB->prepare('SELECT * FROM Laboratorium WHERE id=?')){
					if($st->execute(array($_POST['id']))){
						if($row=$st->fetch(PDO::FETCH_ASSOC)){
							breadcrumbs('Edytowanie laboratorium',array('index.php?menu=7' => 'Zarządzanie laboratoriami',"index.php?menu=40&amp;id=$_POST[id]" => 'Szczegóły laboratorium'));
							echo "<h1 class=\"font20\">Edytowanie laboratorium</h1>$msg";
?>
<form action="index.php?menu=41" method="post" accept-charset="utf-8" enctype="application/x-www-form-urlencoded">
	<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
	<input type="hidden" name="old_nazwa" value="<?php echo $row['nazwa']; ?>" />
	<input type="hidden" name="old_zespol" value="<?php echo $row['zespol']; ?>" />
	<label for="nazwa">Nazwa<span class="color_red">*</span>:</label>
	<input class="form-control" type="text" name="nazwa" id="nazwa" value="<?php echo $row['nazwa']; ?>" size="16" maxlength="64" required="required" /><br />
	<div id="nazwa_counter"></div>
	<div class="margin_top_10">
		<label for="zespol">Zespół:</label>
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
	<div class="margin_top_10">
		<input class="btn btn-primary" type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<p class="margin_top_10"><span class="color_red">*</span> - wymagane pola.</p>
<script src="js/remaining_char_counter.js" type="text/javascript"></script>
<?php
						}
						else{
							breadcrumbs('Edytowanie laboratorium',array('index.php?menu=7' => 'Zarządzanie laboratoriami'));
							echo '<h1 class="font20">Błąd</h1><p>Nie znaleziono laboratorium o podanym identyfikatorze.</p>';
						}
					}
					else{
						breadcrumbs('Edytowanie laboratorium',array('index.php?menu=7' => 'Zarządzanie laboratoriami'));
						echo '<h1 class="font20">Błąd</h1><p>Nie udało się pobrać danych z bazy danych: '.implode(' ',$st->errorInfo()).'</p>';
					}
				}
				else{
					breadcrumbs('Edytowanie laboratorium',array('index.php?menu=7' => 'Zarządzanie laboratoriami'));
					echo '<h1 class="font20">Błąd</h1><p>Nie udało się pobrać danych z bazy danych: '.implode(' ',$DB->errorInfo()).'</p>';
				}
			}
			else{
				breadcrumbs('Edytowanie laboratorium',array('index.php?menu=7' => 'Zarządzanie laboratoriami'));
				echo '<h1 class="font20">Błąd</h1><p>Nie podano laboratorium do edycji.</p>';
			}
		}
		else require 'mod_cred_req.php';
	}
	else require 'not_logged_in.php';
?>
