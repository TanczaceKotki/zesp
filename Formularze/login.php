<?php
	breadcrumbs('Logowanie');
	echo '<h1 class="font20">Logowanie</h1>'.$message;
	if($displayform){
?>
<form action="index.php?menu=10" method="post" accept-charset="utf-8" enctype="application/x-www-form-urlencoded">
	<label for="login">Login<span class="color_red">*</span>:</label>
	<input class="form-control" type="text" name="login" id="login" value="" size="100" maxlength="254" required="required" />
	<div id="login_counter"></div>
	<div class="margin_top_10">
		<label for="pass">Hasło<span class="color_red">*</span>:</label>
		<input class="form-control" type="password" name="pass" id="pass" value="" size="100" maxlength="512" required="required" />
		<div id="pass_counter"></div>
	</div>
	<div class="margin_top_10">
		<input class="btn btn-primary" type="submit" name="send" value="Zaloguj" />
	</div>
</form>
<p class="margin_top_10"><span class="color_red">*</span> - wymagane pola.</p>
<script src="js/remaining_char_counter.js" type="text/javascript"></script>
<?php
	}
?>
