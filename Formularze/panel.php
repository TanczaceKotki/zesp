<?php
	if(user::isLogged()){
		if($lvl===0){
			breadcrumbs('Zarządzanie użytkownikami');
			echo '<h1 class="font20">Zarządzanie użytkownikami</h1>';
			?>
			<div class="margin_ver_15"><a class="btn btn-warning" href="index.php?menu=14">Zarejestruj nowego użytkownika</a></div>
			<?php
				if($result=$DB->query('SELECT id,login,lvl FROM Uzytkownicy')){
			?>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Użytkownik</th>
						<th>Poziom uprawnień</th>
						<th colspan="3"></th>
					</tr>
				</thead>
				<tbody>
					<?php
						while($row=$result->fetch(PDO::FETCH_ASSOC)){
							?>
							<tr>
								<td>
									<?php
										if($row['lvl']==='2') echo '<a href="mailto:'.$row['login'].'">'.$row['login'].'</a>';
										else echo $row['login'];
									?>
								</td>
								<td>
									<?php
										if($row['lvl']==='2') echo 'Osoba kontaktowa';
										else if($row['lvl']==='1') echo 'Moderator';
										else if($row['lvl']==='0') echo 'Administrator';
									?>
								</td>
								<td>
									<a class="btn btn-warning" href="index.php?menu=118&amp;id=<?php echo $row['id']; ?>"><span class="color_white">Pokaż</span></a>
								</td>
								<td>
									<form action="index.php?menu=43" method="post" accept-charset="utf-8" enctype="application/x-www-form-urlencoded">
										<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
										<input class="btn btn-warning" type="submit" value="Edytuj" />
									</form>
								</td>
								<td>
									<form action="index.php?menu=31" method="post" accept-charset="utf-8" enctype="application/x-www-form-urlencoded">
										<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
										<input class="btn btn-danger" type="submit" name="del_uzytkownika" value="Usuń" />
									</form>
								</td>
							</tr>
							<?php
						}
					?>
				</tbody>
			</table>
			<?php
				}
				else echo '<p>Nie udało się pobrać danych z bazy danych: '.implode(' ',$DB->errorInfo()).'</p>';
		}
		else require 'admin_cred_req.php';
	}
	else require 'not_logged_in.php';
?>
