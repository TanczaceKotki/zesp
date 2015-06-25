<?php
	session_start();
	require_once 'user.class.php';
	top();
	$DB=dbconnect();
	if (user::isLogged()) {
		$user = user::getData('', '');
		if(isset($_POST['del_lab'])){
			if($st=$DB->prepare('DELETE FROM Laboratorium WHERE id=?')){
				if($st->execute(array($_POST['id']))) echo 'Laboratorium zostało usunięte.<br /><br />';
				else echo 'Nastąpił błąd przy usuwaniu laboratorium: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
			else echo 'Nastąpił błąd przy usuwaniu laboratorium: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
?>
<a href="add_lab.php">Dodaj laboratorium</a><br />

<a href="add_laborat_w_zaklad.php">Dodaj informację o laboratorium w zakładzie</a>
<br /><br />

	<table><tr><td colspan="2">Laboratoria</td></tr>
	<?php
		if($result=$DB->query('SELECT id,nazwa FROM Laboratorium ORDER BY nazwa')){
			while($row=$result->fetch(PDO::FETCH_ASSOC)){
				?><tr>
					<td>
						<a href="view_lab.php?id=<?php echo $row['id']; ?>"><?php echo $row['nazwa']; ?></a>
					</td>
					<td>
						<form action="index.php?menu=7" method="post" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
							<input type="submit" name="del_lab" value="Usuń" />
						</form>
					</td>
				</tr><?php
			}
		}
	?>
	</table><br />
<?php
	}
	else {
		echo '<br />Nie jesteś zalogowany.<br />
		<a href="login.php">Zaloguj się</a><br /><br /> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
	}
	bottom();
?>
