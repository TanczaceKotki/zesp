<?php
	function top($css=array()){
?><!DOCTYPE html>
<html lang="pl">
	<head>
		<title>Baza sprzętu laboratoryjnego</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<?php
			foreach($css as $sheet){
				echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"$sheet\">";
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
