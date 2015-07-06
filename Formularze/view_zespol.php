<script src="../bootstrap/js/bootstrap.min.js"></script>
 <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
 <meta charset="utf-8">
 <ol class="breadcrumb">
  <li><a href="index.php">Start</a></li>
  <li><a href="index.php?menu=5">Zespoły</a></li>
  <li class="active">Szczegóły zespołu</li>
</ol>

<?php
	require 'common.php';
	require 'DB.php';
	$DB=dbconnect();
	
	if($st=$DB->prepare('SELECT * FROM Zespol WHERE id=?')){
		if($st->execute(array($_GET['id']))){
			if($row=$st->fetch(PDO::FETCH_ASSOC)){
				?>
				<table class="table table-striped">
					<tbody>
						<tr>
							<td>Nazwa:</td>
							<td><?php echo $row['nazwa']; ?></td>
						</tr>
					</tbody>
				</table><?php
			}
			else echo 'Nie znaleziono zespołu o podanym identyfikatorze.<br /><br />';
		}
		else echo 'Nastąpił błąd przy odczytywaniu informacji o zespole: '.implode(' ',$st->errorInfo()).'<br /><br />';
	}
	else echo 'Nastąpił błąd przy odczytywaniu informacji o zespole: '.implode(' ',$DB->errorInfo()).'<br /><br />';
	?><br /><a class="btn btn-warning" href="index.php?menu=9">Wróć do strony z zespołami</a><?php
	
?>
