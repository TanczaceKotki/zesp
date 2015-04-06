<?php
	require 'common.php';
	top();
	if(isset($_POST['submitted'])){
		require 'DB.php';
		$DB=dbconnect();
		if($st=$DB->prepare('INSERT INTO Tag VALUES(NULL,?)')){
			if($st->execute(array($_POST['nazwa']))){
				echo 'Tag został pomyślnie wstawiony.<br /><br />';
			}
			else{
				echo 'Nastąpił błąd przy dodawaniu tagu: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
		}
		else{
			echo 'Nastąpił błąd przy dodawaniu tagu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
	}
	else{
?>
<form action="add_tag.php" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
	<div>
		<label for="nazwa">Nazwa: </label>
		<input type="text" name="nazwa" id="nazwa" value="" size="16" maxlength="64" required />
	</div>
	<div>
		<input type="submit" name="submitted" value="Prześlij" />
	</div>
</form>
<?php
	}
	bottom();
?>
