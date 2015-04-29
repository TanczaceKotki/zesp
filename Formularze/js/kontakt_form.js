$(document).ready(function(){
	webshims.polyfill('forms');
	var form_ajax_ok=false;
	var ajax_wait=false;
	ask_db_middle_table('kontakt',$('#sprzet').val(),$('#osoba').val(),'Ta informacja kontaktowa jest już w bazie danych.','#kontakt_error');
});