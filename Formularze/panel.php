<?php
	 if(user::isLogged()){
	 	 if($st=$DB->prepare('SELECT lvl FROM Uzytkownicy WHERE login=?'))
	 	 	 if($st->execute(array($_SESSION["login"])))
	 	 	 	 if($row=$st->fetch(PDO::FETCH_ASSOC)){
	 	 	 	 	 if($row['lvl']==='0'){
	 	 	 	 	 	 ?>
	 	 	 	 	 	 <ol class="breadcrumb">
	 	 	 	 	 	 	 <li><a href="index.php">Start</a></li>
	 	 	 	 	 	 	 <li class="active">Zarządzanie uprawnieniami dostępu</li>
	 	 	 	 	 	 </ol>
	 	 	 	 	 	 <a class="btn btn-warning" href="index.php?menu=14">Zarejestruj nowego użytkownika</a>
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
	 	 	 	 	 	 	 	 	 if($result=$DB->query('SELECT id,login,lvl FROM Uzytkownicy')){
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
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 if($row['lvl']==='0') echo 'Administrator';
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 else if($row['lvl']==='1') echo 'Moderator';
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 else if($row['lvl']==='2') echo 'Osoba kontaktowa';
	 	 	 	 	 	 	 	 	 	 	 	 	 	 ?>
	 	 	 	 	 	 	 	 	 	 	 	 	 </td>
	 	 	 	 	 	 	 	 	 	 	 	 	 <td>
	 	 	 	 	 	 	 	 	 	 	 	 	 	 <form action="index.php?menu=118" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 <input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 <input class="btn btn-warning" type="submit" value="Pokaż" />
	 	 	 	 	 	 	 	 	 	 	 	 	 	 </form>
	 	 	 	 	 	 	 	 	 	 	 	 	 </td>
	 	 	 	 	 	 	 	 	 	 	 	 	 <td>
	 	 	 	 	 	 	 	 	 	 	 	 	 	 <form action="index.php?menu=43" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 <input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 <input class="btn btn-warning" type="submit" value="Edytuj" />
	 	 	 	 	 	 	 	 	 	 	 	 	 	 </form>
	 	 	 	 	 	 	 	 	 	 	 	 	 </td>
	 	 	 	 	 	 	 	 	 	 	 	 	 <td>
	 	 	 	 	 	 	 	 	 	 	 	 	 	 <form action="index.php?menu=31" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 <input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 <input class="btn btn-danger" type="submit" name="del_uzytkownika" value="Usuń" />
	 	 	 	 	 	 	 	 	 	 	 	 	 	 </form>
	 	 	 	 	 	 	 	 	 	 	 	 	 </td>
	 	 	 	 	 	 	 	 	 	 	 	 </tr>
	 	 	 	 	 	 	 	 	 	 	 <?php
	 	 	 	 	 	 	 	 	 	 }
	 	 	 	 	 	 	 	 	 	 if(isset($_POST['del_uzytkownika'])){
	 	 	 	 	 	 	 	 	 	 	 if($st=$DB->prepare('DELETE FROM Uzytkownicy WHERE id=?')){
	 	 	 	 	 	 	 	 	 	 	 	 if($st->execute(array($_POST['id']))){ 
	 	 	 	 	 	 	 	 	 	 	 	 	 echo 'Użytkownik został usunięty.<br />';
	 	 	 	 	 	 	 	 	 	 	 	 	 echo '<a href="index.php?menu=13">Odśwież panel</a><br /><br />';
	 	 	 	 	 	 	 	 	 	 	 	 }
	 	 	 	 	 	 	 	 	 	 	 	 else echo 'Nastąpił błąd przy usuwaniu użytkownika: '.implode(' ',$st->errorInfo()).'<br /><br />';
	 	 	 	 	 	 	 	 	 	 	 }
	 	 	 	 	 	 	 	 	 	 	 else echo 'Nastąpił błąd przy usuwaniu użytkownika: '.implode(' ',$DB->errorInfo()).'<br /><br />';
	 	 	 	 	 	 	 	 	 	 }
	 	 	 	 	 	 	 	 	 }
	 	 	 	 	 	 	 	 ?>
	 	 	 	 	 	 	 </tbody>
	 	 	 	 	 	 </table>
	 	 	 	 	 	 <?php
	 	 	 	 	 }
	 	 	 	 	 else echo 'Dostęp do panelu administracyjnego dozwolony jest tylko z uprawnieniami administratora.<br /><br />';
	 	 	 	 }
	 }
	 else echo '<br />Nie jesteś zalogowany.<br /><a href="login.php">Zaloguj się</a><br /><br /> Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
?>
