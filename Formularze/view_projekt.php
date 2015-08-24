<?php
	if(user::isLogged()){
		if($lvl<2){
			breadcrumbs('Szczegóły projektu',array('index.php?menu=17' => 'Zarządzanie projektami'));
			echo '<h1 class="font20">Szczegóły projektu</h1>';
			if($st=$DB->prepare('SELECT * FROM Projekt WHERE id=?')){
				if($st->execute(array($_GET['id']))){
					if($row=$st->fetch(PDO::FETCH_ASSOC)){
						?>
						<form action="index.php?menu=44" method="post" accept-charset="utf-8" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
							<input class="btn btn-warning margin_bottom_10" type="submit" value="Edytuj" />
						</form>
						<table class="table table-striped">
							<tbody>
								<tr>
									<th>Nazwa:</th>
									<td><?php echo $row['nazwa']; ?></td>
								</tr>
								<tr>
									<th>Data rozpoczęcia:</th>
									<td><?php echo $row['data_rozp']; ?></td>
								</tr>
								<tr>
									<th>Data Zakończenia:</th>
									<td><?php echo $row['data_zakoncz']; ?></td>
								</tr>
								<tr>
									<th>Opis:</th>
									<td><?php echo htmlspecialchars($row['opis'],ENT_QUOTES|ENT_HTML5,'UTF-8',false); ?></td>
								</tr>
								<tr>
									<th>Logo:</th>
									<td><a href="<?php echo $row['logo']; ?>"><img src="<?php echo $row['logo']; ?>" width="200" alt="" /></a></td>
								</tr>
							</tbody>
						</table><?php
					}
				}
				else echo '<p>Nastąpił błąd przy pobieraniu informacji o projekcie: '.implode(' ',$st->errorInfo()).'</p>';
			}
			else echo '<p>Nastąpił błąd przy pobieraniu informacji o projekcie: '.implode(' ',$DB->errorInfo()).'</p>';
?>
<a class="btn btn-warning margin_bottom_10" href="index.php?menu=17">Wróć do strony zarządzania projektami</a>
<?php
		}
		else require 'mod_cred_req.php';
	}
	else require 'not_logged_in.php';
?>
