<?php
	if(user::isLogged()){
		if($lvl===0){
			breadcrumbs('Szczegóły użytkownika',array('index.php?menu=13' => 'Zarządzanie użytkownikami'));
			if($st=$DB->prepare('SELECT id,login,lvl FROM Uzytkownicy WHERE id=?')){
				if($st->execute(array($_GET['id']))){
					if($row=$st->fetch(PDO::FETCH_ASSOC)){
						?>
						<form action="index.php?menu=43" method="post" accept-charset="utf-8" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
							<input class="btn btn-warning margin_bottom_10" type="submit" value="Edytuj" />
						</form>
						<table class="table table-striped">
							<tbody>
								<tr>
									<th>Login</th>
									<td>
										<?php
											if($row['lvl']==='2') echo '<a href="mailto:'.$row['login'].'">'.$row['login'].'</a>';
											else echo $row['login'];
										?>
									</td>
								</tr>
								<tr>
									<th>Prawa dostępu</th>
									<td>
										<?php
											if($row['lvl']==='2') echo 'Osoba kontaktowa';
											else if($row['lvl']==='1') echo 'Moderator';
											else if($row['lvl']==='0') echo 'Administrator';
										?>
									</td>
								</tr>
							</tbody>
						</table>
						<?php
					}
					else echo '<p>Nie znaleziono użytkownika o podanym identyfikatorze.</p>';
				}
				else echo '<p>Nie udało się pobrać danych z bazy danych: '.implode(' ',$st->errorInfo()).'</p>';
			}
			else echo '<p>Nie udało się pobrać danych z bazy danych: '.implode(' ',$DB->errorInfo()).'</p>';
		}
		else require 'admin_cred_req.php';
?>
<a class="btn btn-warning margin_bottom_10" href="index.php?menu=13">Wróć do strony zarządzania użytkownikami</a>
<?php
	}
	else require 'not_logged_in.php';
?>
