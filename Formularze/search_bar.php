<form role="search" class="form-inline" method="get" action="index.php" id="searchform" accept-charset="utf-8" enctype="application/x-www-form-urlencoded">
	<input type="hidden" name="menu" value="16" />
	<select class="form-control input-xsm" name="category" required="required">
		<option value="" selected="selected">Wybierz kategorię</option>
		<option value="Aparatura">Aparatura</option>
		<option value="Osoba">Osoba</option>
		<option value="Laboratorium">Laboratorium</option>
		<option value="Słowo_Kluczowe">Słowo Kluczowe</option>
		<option value="Zespol">Zespół Laboratoriów</option>
		<option value="Zaklad">Zakład</option>
		<option value="Projekt">Projekt</option>
	</select>
	<div class="input-group">
		<input class="form-control input-xsm" type="text" name="keyword" maxlength="49990" required="required" />
		<span class="input-group-btn">
			<button class="btn btn-default input-xsm" type="submit" value="Szukaj"><i class="glyphicon glyphicon-search"></i></button>
		</span>
	</div>
</form>
