<form method="get" action="index.php" id="searchform">
	<input type="hidden" name="menu" value="16" />
	<div class="col-lg-5">
		<select class="form-control" name="category" required="required">
			<option value="" selected="selected">Wybierz kategorię</option>
			<option value="Sprzet">Sprzęt</option>
			<option value="Osoba">Osoba</option>
			<option value="Laboratorium">Laboratorium</option>
			<option value="Tag">Tag</option>
			<option value="Zespol">Zespół</option>
			<option value="Zaklad">Zakład</option>
			<option value="Projekt">Projekt</option>
		</select>
	</div>
	<div class="col-lg-5">
		<input class="form-control" rows="2" type="text" name="keyword" required="required" />
	</div>
	<div class="col-lg-2">
		<input class="btn btn-primary" type="submit" value="Szukaj" />
	</div>
</form>
