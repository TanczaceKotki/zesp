<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- TemplateBeginEditable name="doctitle" -->
<title>Tanczace kotki 2015</title>
<!-- TemplateEndEditable -->
<!-- TemplateBeginEditable name="head" -->
<!-- TemplateEndEditable -->
<link href="oneColLiqCtrHdr.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div class="container">
  <div class="header"> 
    <div align="left"><a href="#"><img src="logo_atomin.png" alt="Insert Logo Here" name="Insert_logo" width="546" height="74" id="Insert_logo" style="background-color: #white; display:block;" /><a href="#"></a></div>
<div id="wyszukiwarka"><?php include("search_bar.php"); ?></div>
        <div id="logowanie" align="right"><a href="index.php?menu=10"></a>
    </a> 
    <!-- end .header --></div>
  <div class="menu">
  <nav align="center" id="navigation">


<ul class="menu_niezalogowany">
<li> <a href="index.php?menu=1">O projekcie</a> </li>
<li> <a href="index.php?menu=2">Komunikaty</a> </li>
<li> <a href="index.php?menu=3">Labolatoria</a> </li>
<li> <a href="index.php?menu=4">Aparatura</a> </li>
<li> <a href="index.php?menu=5">Zespoły</a> </li>
<li> <a href="index.php?menu=6">Kontakt</a> </li>
</ul>
<ul class="menu_admin">
<li> <a href="index.php?menu=12">Zarządzanie newsami</a> </li>
<li> <a href="index.php?menu=7">Zarządzanie labolatoriami</a> </li>
<li> <a href="index.php?menu=8">Zarządzanie aparaturą</a> </li>
<li> <a href="index.php?menu=9">Zarządzanie zespołami</a> </li>
<li> <a href="index.php?menu=100">Zarządzanie użytkownikami</a> </li>
<li> <a href="index.php?menu=12">Zarządzanie zdjęciami</a> </li>

</ul>
    </nav>
   </div>
    <div id="content">


<?php
 
switch ($_GET['menu'])
{
	case 1:
		include('home.php');
	break;
 
	case 2:
		include('home.php');
	break;
 
	case 3:
		include('view_labs.php');
	break;
 case 4:
		include('view_sprzety.php');
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
	
	case 12:
		include('zarzadzaj_zdjecia.php');
	break;
 
	case 11:
		include('login.php');
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
