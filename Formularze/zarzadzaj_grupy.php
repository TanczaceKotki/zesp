<?php
	session_start();
	require_once 'user.class.php';
	top();
	$DB=dbconnect();
	if (user::isLogged()) {
		$user = user::getData('', '');
		if(isset($_POST['del_zespol'])){
			if($st=$DB->prepare('DELETE FROM Zespol WHERE id=?')){
				if($st->execute(array($_POST['id']))) echo 'Zespół został usunięty.<br /><br />';
				else echo 'Nastąpił błąd przy usuwaniu zespołu: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
			else echo 'Nastąpił błąd przy usuwaniu zespołu: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
?>

<a href="add_zespol.php">Dodaj zespół</a><br />
<a href="add_laborat_w_zaklad.php">Dodaj informację o laboratorium w zakładzie</a>
<br /><br />

	</table><br /><br /><table><tr><td colspan="2">Zespoły</td></tr>
	<?php
		if($result=$DB->query('SELECT id,nazwa FROM Zespol ORDER BY nazwa')){
			while($row=$result->fetch(PDO::FETCH_ASSOC)){
				?><tr>
					<td>
						<a href="view_zespol.php?id=<?php echo $row['id']; ?>"><?php echo $row['nazwa']; ?></a>
					</td>
					<td>
						<form action="index.php?menu=9" method="post" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
							<input type="submit" name="del_zespol" value="Usuń" />
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
