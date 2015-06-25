<?php
	session_start();
	require_once 'user.class.php';
	top();
	$DB=dbconnect();
	if (user::isLogged()) {
		$user = user::getData('', '');
		if(isset($_POST['del_zdjecie'])){
			if($st=$DB->prepare('DELETE FROM Zdjecie WHERE id=?')){
				if($st->execute(array($_POST['id']))) echo 'Zdjęcie zostało usunięte.<br /><br />';
				else echo 'Nastąpił błąd przy usuwaniu zdjęcia: '.implode(' ',$st->errorInfo()).'<br /><br />';
			}
			else echo 'Nastąpił błąd przy usuwaniu zdjęcia: '.implode(' ',$DB->errorInfo()).'<br /><br />';
		}
?>

<a href="add_zdjecie.php">Dodaj zdjęcie</a><br />

<table><tr><td colspan="2">Zdjęcia</td></tr>
	<?php
		if($result=$DB->query('SELECT id,link FROM Zdjecie ORDER BY link')){
			while($row=$result->fetch(PDO::FETCH_ASSOC)){
				?><tr>
					<td>
						<a href="view_zdjecie.php?id=<?php echo $row['id']; ?>"><img src="uploads/<?php echo $row['link']; ?>" width="200" alt="" /></a>
					</td>
					<td>
						<form action="index.php?menu=12" method="post" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
							<input type="submit" name="del_zdjecie" value="Usuń" />
						</form>
					</td>
				</tr><?php
			}
		}
	?>
</table>
<?php
	}
	else {
		echo '<br />Nie jesteś zalogowany.<br />
		<a href="login.php">Zaloguj się</a><br /><br /> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
	}
	bottom();
?>
