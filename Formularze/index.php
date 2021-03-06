<?php
	ob_start();
	session_start();
	require 'user.class.php';
	require 'DB.php';
	require 'breadcrumbs.php';
	$DB=dbconnect();
?><!DOCTYPE html>
<html lang="pl">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Tanczace kotki 2015</title>
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="css/oneColLiqCtrHdr.css" rel="stylesheet" type="text/css" />
		<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />
		<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
		<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js" type="text/javascript"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js" type="text/javascript"></script>
		<![endif]-->
	</head>
	<body role="document">
		<?php
			if(isset($_GET['menu'])){
				$menu=(int)$_GET['menu'];
				if($menu===15){
					session_unset();
					session_destroy();
					session_write_close();
					setcookie(session_name(),'',0,'/');
					session_regenerate_id(true);
				}
				else if($menu===10){
					$displayform=True;
					$message="";
					if(isset($_POST['send'])){
						$login=$_POST['login'];
						$pass=$_POST['pass'];
						if($login==="") $message.='<p class="font15">Wypełnij pole z loginem!</p>';
						else if($pass==="") $message.='<p class="font15">Wypełnij pole z hasłem!</p>';
						else{
							if($st=$DB->prepare('SELECT pass FROM Uzytkownicy WHERE login=?')){
								if($st->execute(array($login))){
									$userInfo = $st->fetch(PDO::FETCH_ASSOC);
									if(password_verify($pass,$userInfo['pass'])){
										$_SESSION['login'] = $login;
										$_SESSION['pass'] = $pass;
										$message.='<div class="font15"><p>Zostałeś zalogowany pomyślnie.</p><p>Przejdź do <a href="index.php">strony głównej</a>.</p></div>';
										$displayform=False;
									}
									else $message.='<p class="font15">Użytkownik o podanym loginie i haśle nie istnieje.</p>';
								}
								else $message.='<p class="font15">Nastąpił błąd przy pobieraniu danych z bazy danych.</p>';
							}
							else $message.='<p class="font15">Nastąpił błąd przy pobieraniu danych z bazy danych.</p>';
						}
					}
				}
			}
			else $menu=1;
		?>
		<div class="container">
			<header role="banner">
				<div id="header" class="header">
					<div id="logo_and_name">
						<div id="logo">
							<a href="http://www.uj.edu.pl/" title="Uniwersytet Jagielloński">
								<img src="logo_atomin.png" width="45" height="72" alt="" />
							</a>
						</div>
						<div id="page_name">
							<a href="index.php" id="page_name_main" class="page_name_link">Baza sprzętu laboratoryjnego</a>
							<a href="http://www.fais.uj.edu.pl/" id="page_name_sub" class="page_name_link">
								Wydziału Fizyki, Astronomii i Informatyki Stosowanej
							</a>
						</div>
					</div>
					<?php
						if (user::isLogged()){
					?>
					<a class="btn btn-warning btn-xs loginout" href="index.php?menu=15">wyloguj</a>
					<?php
						}
						else{
					?>
					<a class="btn btn-warning btn-xs loginout" href="index.php?menu=10">zaloguj</a>
					<!-- search bar -->
					<?php
						}
						require 'search_bar.php';
					?>
				</div>
				<nav role="navigation">
					<ul class="nav nav-justified menu_niezalogowany">
						<li><a href="index.php?menu=1">O projekcie</a></li>
						<li><a href="index.php?menu=2">Komunikaty</a></li>
						<li><a href="index.php?menu=4">Aparatura</a></li>
						<li><a href="index.php?menu=3">Laboratoria</a></li>
						<li><a href="index.php?menu=5">Zespoły laboratoriów</a></li>
						<li><a href="index.php?menu=107">Projekty</a></li>
						<li><a href="index.php?menu=6">Kontakt</a></li>
					</ul>
					<?php
						if(user::isLogged()){
							if($st=$DB->prepare('SELECT lvl FROM Uzytkownicy WHERE login=?')){
								if($st->execute(array($_SESSION['login']))){
									if($row=$st->fetch(PDO::FETCH_ASSOC)){
										$lvl=(int)$row['lvl'];
									}
								}
							}
					?>
					<ul class="nav nav-justified menu_admin">
						<?php
							if($lvl<2){
								?>
								<li class="vertical_align"><a href="index.php?menu=12">Zarządzanie newsami</a></li>
								<?php
							}
						?>
						<li class="vertical_align"><a href="index.php?menu=8">Zarządzanie aparaturą</a></li>
						<?php
							if($lvl===2){
								if($st=$DB->prepare('SELECT id FROM Osoba WHERE email=?')){
									if($st->execute(array($_SESSION['login']))){
										if($row=$st->fetch(PDO::FETCH_ASSOC)){
											?>
												<li class="vertical_align"><a href="index.php?menu=54&amp;id=<?php echo $row['id']; ?>">Twoje dane</a></li>
											<?php
										}
									}
								}
							}
							else if($lvl<2){
								?>
									<li class="vertical_align"><a href="index.php?menu=67">Zarządzanie słowami kluczowymi</a></li>
									<li class="vertical_align"><a href="index.php?menu=7">Zarządzanie laboratoriami</a></li>
									<li class="vertical_align"><a href="index.php?menu=66">Zarządzanie zakładami</a></li>
									<li class="vertical_align"><a href="index.php?menu=9">Zarządzanie zespołami laboratoriów</a></li>
									<li class="vertical_align"><a href="index.php?menu=17">Zarządzanie projektami</a></li>
									<li class="vertical_align"><a href="index.php?menu=100">Zarządzanie osobami kontaktowymi</a></li>
									<?php
										if($lvl===0){
											?>
												<li class="vertical_align"><a href="index.php?menu=13">Zarządzanie użytkownikami</a></li>
											<?php
										}
									?>
								<li class="vertical_align"><a href="index.php?menu=12">Zarządzanie zdjęciami</a></li>
								<?php
							}
						?>
					</ul>
					<?php
						}
					?>
				</nav>
				<?php
					switch ($menu){
						case 1:
							require 'home.php';
							break;
						case 2:
							require 'komunikaty.php';
							break;
						case 3:
							require 'view_labs.php';
							break;
						case 4:
							require 'view_sprzety.php';
							break;
						case 5:
							require 'view_zespoly.php';
							break;
						case 6:
							require 'kontakt.php';
							break;
						case 7:
							require 'zarzadzaj_lab.php';
							break;
						case 8:
							require 'zarzadzaj_sprzet.php';
							break;
						case 9:
							require 'zarzadzaj_grupy.php';
							break;
						case 10:
							require 'login.php';
							break;
						case 11:
							require 'login.php';
							break;
						case 12:
							require 'zarzadzaj_zdjecia.php';
							break;
						case 13:
							require 'panel.php';
							break;
						case 14:
							require 'rejestracja.php';
							break;
						case 15:
							require 'logged_out.php';
							break;
						case 16:
							require 'search_result.php';
							break;
						case 17:
							require 'zarzadzaj_projekty.php';
							break;
						case 20:
							require 'add_kontakt.php';
							break;
						case 21:
							require 'add_lab.php';
							break;
						case 22:
							require 'add_laborat_w_zaklad.php';
							break;
						case 23:
							require 'add_osoba.php';
							break;
						case 24:
							require 'add_projekt.php';
							break;
						case 25:
							require 'add_sprzet.php';
							break;
						case 26:
							require 'add_tag.php';
							break;
						case 27:
							require 'add_tagi_sprzetu.php';
							break;
						case 28:
							require 'add_zaklad.php';
							break;
						case 29:
							require 'add_zdjecie.php';
							break;
						case 30:
							require 'add_zespol.php';
							break;
						case 31:
							require 'usun.php';
							break;
						case 32:
							require 'add_tagi_sprzetu.php';
							break;
						case 33:
							require 'add_tag.php';
							break;
						case 40:
							require 'view_lab.php';
							break;
						case 41:
							require 'edit_lab.php';
							break;
						case 42:
							require 'edit_osoba.php';
							break;
						case 43:
							require 'edit_user.php';
							break;
						case 44:
							require 'edit_projekt.php';
							break;
						case 45:
							require 'edit_sprzet.php';
							break;
						case 46:
							require 'edit_tag.php';
							break;
						case 47:
							require 'edit_zespol.php';
							break;
						case 48:
							require 'edit_zaklad.php';
							break;
						case 51:
							require 'view_projekt.php';
							break;
						case 52:
							require 'view_sprzet.php';
							break;
						case 53:
							require 'view_zespol.php';
							break;
						case 54:
							require 'view_osoba.php';
							break;
						case 55:
							require 'view_zdjecie.php';
							break;
						case 56:
							require 'view_sprzet_NZ.php';
							break;
						case 57:
							require 'view_lab_NZ.php';
							break;
						case 58:
							require 'view_zespol_NZ.php';
							break;
						case 59:
							require 'view_projekt_NZ.php';
							break;
						case 60:
							require 'view_tag.php';
							break;
						case 61:
							require 'view_zaklad.php';
							break;
						case 62:
							require 'view_zdjecie_NZ.php';
							break;
						case 63:
							require 'view_zaklad_NZ.php';
							break;
						case 64:
							require 'view_tag_NZ.php';
							break;
						case 65:
							require 'view_osoba_NZ.php';
							break;
						case 66:
							require 'zarzadzaj_zaklady.php';
							break;
						case 67:
							require 'zarzadzaj_tagi.php';
							break;
						case 100:
							require 'zarzadzaj_osoby.php';
							break;
						case 107:
							require 'view_projekty.php';
							break;
						case 118:
							require 'view_user.php';
							break;
						default:
							require 'home.php';
					}
				?>
				</div>
			</main>
		</div>
		<footer id="footer">
			<div class="container">
				<div class="text-muted">
					© 2015 TańcząceKotki || <address style="display:inline"><a href="mailto:mail@admin">administrator strony</a></address>
				</div>
			</div>
		</footer>
		<?php
			foreach(array('js/modernizr.js','js/js-webshim/minified/polyfiller.js','js/default_form.js') as $script){
				echo '<script src="'.$script.'" type="text/javascript"></script>';
			}
		?>
	</body>
</html>
