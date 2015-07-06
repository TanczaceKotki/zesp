<?php
	
	
	$DB=dbconnect();
	
	if(isset($_POST['submitted'])){
		$send=False;
		$params=array();
		$sql='UPDATE Uzytkownicy SET';
		$sql.=' login=?';
		$params[]=$_POST['login'];
		if($_POST['pass'] == $_POST['pass_v']){
			$pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
			if($pass!==$_POST['old_pass2']){
				$sql.=', pass=?';
				$params[]=$pass;
				$send=True;
			}
			else echo 'Hasło jest takie samo jak wcześniejsze<br /><br />';
		}
		else echo 'Wpisane hasła nie są takie same<br /><br />';
					
		if($send) $sql.=',';
		$sql.=' lvl=?';
		$params[]=$_POST['lvl'];
		
		
		if($send){
			$sql.=' WHERE id=?';
			$params[]=$_POST['id'];
			if($st=$DB->prepare($sql)){
				if($st->execute($params)) echo 'Osoba została pomyślnie zmodyfikowana.<br /><br />';
				else echo 'Nastąpił błąd przy modyfikowaniu osoby1: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
			else echo 'Nastąpił błąd przy modyfikowaniu osoby2: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
	}
	if($st=$DB->prepare('SELECT * FROM Uzytkownicy WHERE id=?')){
		if($st->execute(array($_POST['id']))){
			if($row=$st->fetch(PDO::FETCH_ASSOC)){
						?><form action="panel.php" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
							<input type="submit" name="del_uzytkownika" value="Usuń" />
						</form>
						<form action="edit_user.php" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
							<input type="submit" value="Edytuj" />
						</form><br />
						<table>
							<tbody>
								<tr>
									<td>Login</td>
									<td><?php echo $row['login']; ?></td>
								</tr>
								<tr>
									<td>Prawa dostępu:</td>
									<td><?php 
										if($row['lvl'] == 0) echo "Administrator";
										elseif($row['lvl'] == 1) echo "Moderator";
										elseif($row['lvl'] == 2) echo "Osoba kontaktowa";
									?></td>
								</tr></tbody>
				</table><?php 
			}
			else echo 'Nastąpił błąd przy edytowaniu1: '.implode(' ',$st->errorInfo()).'<br /><br />';
		}
		else echo 'Nastąpił błąd przy edytowaniu2: '.implode(' ',$st->errorInfo()).'<br /><br />';
	}
	else echo 'Nastąpił błąd przy edytowaniu3: '.implode(' ',$DB->errorInfo()).'<br /><br />';
	?><br /><?php
	
	
?>
