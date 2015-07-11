<?php
	 if(user::isLogged()){
	 	 if(isset($_POST['submitted'])){
	 	 	 if($_POST['nazwa']!==$_POST['old_nazwa']){
	 	 	 	 if($st=$DB->prepare('UPDATE Tag SET nazwa=? WHERE id=?')){
	 	 	 	 	 if($st->execute(array($_POST['nazwa'],$_POST['id']))){
	 	 	 	 	 	 header('Location:index.php?menu=60&id='.$_POST['id']);
	 	 	 	 	 	 die();
	 	 	 	 	 }
	 	 	 	 	 else echo 'Nastąpił błąd przy modyfikowaniu słowa kluczowego: '.implode(' ',$st->errorInfo()).'<br /><br />';
	 	 	 	 }
	 	 	 	 else echo 'Nastąpił błąd przy modyfikowaniu słowa kluczowego: '.implode(' ',$DB->errorInfo()).'<br /><br />';
	 	 	 }
	 	 }
	 	 if(isset($_POST['id'])){
	 	 	 if($st=$DB->prepare('SELECT * FROM Tag WHERE id=?')){
	 	 	 	 if($st->execute(array($_POST['id']))){
	 	 	 	 	 if($row=$st->fetch(PDO::FETCH_ASSOC)){
?>
<ol class="breadcrumb">
	 <li><a href="index.php">Start</a></li>
	 <li><a href="index.php?menu=60&id=<?php echo $_POST['id']; ?>">Szczegóły słowa kluczowego</a></li>
	 <li class="active">Edytuj słowo kluczowe</li>
</ol>
<form action="index.php?menu=46" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded" onsubmit="return ajax_check()">
	 <input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
	 <input type="hidden" name="old_nazwa" id="old_nazwa" value="<?php echo $row['nazwa']; ?>" />
	 <div>
	 	 <label for="nazwa">Nazwa<span class="color_red">*</span>: </label>
	 	 <input type="text" name="nazwa" id="nazwa" value="<?php echo $row['nazwa']; ?>" size="32" maxlength="32" spellcheck="true" onchange="check_tag_2()" required="required" />
	 	 <span id="nazwa_counter"></span>
	 	 <div id="tag_error"></div>
	 </div>
	 <div>
	 	 <input class="btn btn-primary" type="submit" name="submitted" value="Prześlij" />
	 </div>
</form>
<span class="color_red">*</span> - wymagane pola.
<?php
	 	 	 	 	 	 foreach(array('js/ask_db.js','js/remaining_char_counter.js','js/check_tag.js','js/tag_form_edit.js') as $script){
	 	 	 	 	 	 	 echo '<script src="'.$script.'" type="text/javascript"></script>';
	 	 	 	 	 	 }
	 	 	 	 	 }
	 	 	 	 	 else echo 'Nie znaleziono słowa kluczowego o podanym identyfikatorze.<br /><br />';
	 	 	 	 }
	 	 	 	 else echo 'Nie udało się pobrać danych z bazy danych: '.implode(' ',$st->errorInfo()).'<br /><br />';
	 	 	 }
	 	 	 else echo 'Nie udało się pobrać danych z bazy danych: '.implode(' ',$DB->errorInfo()).'<br /><br />';
	 	 }
	 	 else echo 'Nie podano słowa kluczowego do edycji.';
	 }
	 else echo '<br />Nie jesteś zalogowany.<br /><a href="login.php">Zaloguj się</a><br /><br />Jeśli nie masz konta, skontaktuj z administratorem w celu jego utworzenia.';
?>
