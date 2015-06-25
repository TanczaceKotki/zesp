<?php
	session_start();
	require_once 'user.class.php';
	top();
	$DB=dbconnect();
	if (user::isLogged()) {
		$user = user::getData('', '');
		if(isset($_POST['del_sprzet'])){
			if($st=$DB->prepare('DELETE FROM Sprzet WHERE id=?')){
				if($st->execute(array($_POST['id']))) echo 'Sprzęt został usunięty.<br /><br />';
				else echo 'Nastąpił błąd przy usuwaniu sprzętu: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
			else echo 'Nastąpił błąd przy usuwaniu sprzętu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
?>

<a href="add_sprzet.php">Dodaj sprzęt</a><br />

<table><tr><td colspan="2">Sprzęt</td></tr>
	<?php
		if($result=$DB->query('SELECT id,nazwa FROM Sprzet ORDER BY nazwa')){
			while($row=$result->fetch(PDO::FETCH_ASSOC)){
				?>
				<tr>
					<td>
						<a href="view_sprzet.php?id=<?php echo $row['id']; ?>"><?php echo $row['nazwa']; ?></a>
					</td>
					<td>
						<form action="index.php?menu=8" method="post" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
							<input type="submit" name="del_sprzet" value="Usuń" />
						</form>
					</td>
				</tr><?php
			}
		}
	?>
	</table><br /><br />
<?php
	}
	else {
		echo '<br />Nie jesteś zalogowany.<br />
		<a href="login.php">Zaloguj się</a><br /><br /> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
	}
	bottom();
?>
