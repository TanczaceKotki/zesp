<?php
	function top($css_or_js=array()){
?><!DOCTYPE html>
<html lang="pl">
	<head>
		<title>Baza sprzętu laboratoryjnego</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="css/sprzet_laboratoryjny.css" />
		<?php
			foreach($css_or_js as $item){
				if(substr($item,-3)==='css') echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"$item\" />";
				else echo "<script type=\"text/javascript\" src=\"$item\"></script>";
			}
		?>
		<style>table,tr,td{border:1px solid #000}</style>
	</head>
	<body>
		<?php
			}
			function bottom($js=array()){
				foreach($js as $script){
					echo "<script type=\"text/javascript\" src=\"$script\"></script>";
				}
		?>
	</body>
</html>
<?php
	}
?>
