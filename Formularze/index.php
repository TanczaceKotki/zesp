<?php session_start(); 
	require_once 'user.class.php';
	require 'common.php';
require 'DB.php';
$DB=dbconnect();

	
	?>
<!DOCTYPE html>
<html lang="pl">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!-- TemplateBeginEditable name="doctitle" -->
<title>Tanczace kotki 2015</title>
<!-- TemplateEndEditable -->
<!-- TemplateBeginEditable name="head" -->
<!-- TemplateEndEditable -->
<link href="oneColLiqCtrHdr.css" rel="stylesheet" type="text/css" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js" type="text/javascript"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js" type="text/javascript"></script>
    <![endif]-->
	 <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div class="container">
  <div id= "header"class="header"> 
    <div align="left"><a href="index.php"><img src="logo_atomin.png" alt="Insert Logo Here" name="Insert_logo" width="546" height="74" id="Insert_logo" style="background-color: #white; display:block;" /><a href="#"></a></div>
   <div id="zaloguj" align="right" style>
    <?php if (user::isLogged()) { ?>        
        <a href="index.php?menu=15"><button  class="btn btn-warning"" type="button">wyloguj</button></a>
        <?php }
        else { ?> <a href="index.php?menu=10"><button  class="btn btn-warning" type="button">zaloguj</button></a> <?php } ?></div><br>
<div id="wyszukiwarka" align="right"><?php include("search_bar.php"); ?></div></div>
    <!-- end .header -->
  <div class="menu">
  <nav id="navigation">


<ul class="menu_niezalogowany">
<li> <a href="index.php?menu=1">O projekcie</a> </li>
<li> <a href="index.php?menu=2">Komunikaty</a> </li>
<li> <a href="index.php?menu=4">Aparatura</a> </li>
<li> <a href="index.php?menu=3">Laboratoria</a> </li>
<li> <a href="index.php?menu=5">Zespoły lab</a> </li>
<li> <a href="index.php?menu=107">Projekty</a> </li>
<li> <a href="index.php?menu=6">Kontakt</a> </li>
</ul>

<?php if (user::isLogged()) { ?>
<ul class="menu_admin">
<li> <a href="index.php?menu=12">Zarządzanie newsami</a> </li>
<li> <a href="index.php?menu=7">Zarządzanie laboratoriami</a> </li>
<li> <a href="index.php?menu=8">Zarządzanie aparaturą</a> </li>
<li> <a href="index.php?menu=9">Zarządzanie zespołami lab</a> </li>
<li> <a href="index.php?menu=17">Zarządzanie projektami</a> </li>
<li> <a href="index.php?menu=100">Zarządzanie użytkownikami</a> </li>
<li> <a href="index.php?menu=13">Zarządzanie uprawnieniami dostępu</a> </li>
<li> <a href="index.php?menu=12">Zarządzanie zdjęciami</a> </li>

</ul>
    </nav>
   </div> <?php } ?>
    <div id="content">


<?php
 
switch ($_GET['menu'])
{
	case 1:
		include('home.php');
	break;
 
	case 2:
		include('komunikaty.php');
	break;
 
	case 3:
		include('view_labs.php');
	break;
 case 4:
		include('view_sprzety.php');
	break;
 case 107:
		include('view_projekty.php');
	break;
	case 5:
		include('view_zespoly.php');
	break;
	case 6:
		include('kontakt.php');
	break;
 
	case 10:
		include('login.php');
	break;
case 7:
		include('zarzadzaj_lab.php');
	break;
 
	case 8:
		include('zarzadzaj_sprzet.php');
	break;
 case 9:
		include('zarzadzaj_grupy.php');
	break;
 
	case 100:
		include('zarzadzaj_osoby.php');
	break;
	
	case 17:
		include('zarzadzaj_projekty.php');
	break;
	case 12:
		include('zarzadzaj_zdjecia.php');
	break;
	
	case 15:
		include('wyloguj.php');
	break;
 
	case 11:
		include('login.php');
	break;
	case 13:
		include('panel.php');
	break;
	case 14:
		include('rejestracja.php');
	break;
	case 16:
		include('search_result.php');
	break;
	case 118:
		include('view_user.php');
	break;
	
	
	
	
	 case 20:
		include('add_kontakt.php');
	break;
 
	case 21:
		include('add_lab.php');
	break;
	
	case 22:
		include('add_laborat_w_zaklad.php');
	break;
		case 23:
		include('add_osoba.php');
	break;
 
	case 24:
		include('add_projekt.php');
	break;
	
	case 25:
		include('add_sprzet.php');
	break;
 
	case 26:
		include('add_tag.php');
	break;
	case 27:
		include('add_tagi_sprzetu.php');
	break;
 
	case 28:
		include('add_zaklad.php');
	break;
	case 29:
		include('add_zdjecie.php');
	break;
 
	case 30:
		include('add_zespol.php');
	break;
	case 31:
		include('usun.php');
	break;
	case 32:
		include('add_tagi_sprzetu.php');
	break;
	case 33:
		include('add_tag.php');
	break;
	
	 case 40:
		include('view_lab.php');
	break;
 
	case 41:
		include('edit_lab.php');
	break;
	
	case 42:
		include('edit_osoba.php');
	break;
		case 43:
		include('edit_user.php');
	break;
 
	case 44:
		include('edit_projekt.php');
	break;
	
	case 45:
		include('edit_sprzet.php');
	break;
 
	case 46:
		include('edit_tag.php');
	break;
	
	case 47:
		include('edit_zespol.php');
	break;
	case 48:
		include('edit_zaklad.php');
	break;
 
	case 51:
		include('view_projekt.php');
	break;	
	case 52:
		include('view_sprzet.php');
	break;

	
	default:
		include('home.php');
	break;
}
?>
</div>
  <div id="footer"><p>
© 2015 TańcząceKotki ||
<a href="mailto:mail@admin">administrator strony</a></p>
    <!-- end .footer --></div>
  <!-- end .container --></div>
</body>
</html>
