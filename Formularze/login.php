<?php
	 echo $message;
	 if($displayform) {
?>
<form action="index.php?menu=10" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
	 <label for="login">Login<span class="color_red">*</span>: </label>
	 <input class="form-control" type="text" name="login" id="login" value="" size="100" maxlength="254" required="required" />
	 <span id="login_counter"></span>
	 <br />
	 <label for="pass">Hasło<span class="color_red">*</span>: </label>
	 <input class="form-control" type="password" name="pass" id="pass" value="" size="100" maxlength="512" required="required" />
	 <span id="pass_counter"></span>
	 <br />
	 <input class="btn btn-primary" type="submit" name="send" value="Zaloguj" />
</form>
<span class="color_red">*</span> - wymagane pola.
<?php
	 	 foreach(array('js/remaining_char_counter.js') as $script){
	 	 	 echo '<script src="'.$script.'" type="text/javascript"></script>';
	 	 }
	 }
?>
