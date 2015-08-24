<?php
	function breadcrumbs($current,$links=array()){
		?>
		<ol class="breadcrumb font15">
			<li><a href="index.php">Start</a></li>
			<?php
				foreach($links as $link => $name){
					echo "<li><a href=\"$link\">$name</a></li>";
				}
				echo "<li class=\"active\">$current</li>";
			?>
		</ol>
	</header>
	<main id="content" role="main">
		<div class="font15">
		<?php
	}
?>