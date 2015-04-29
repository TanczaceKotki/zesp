$(document).ready(function(){
	webshims.polyfill('forms');
	var form_ajax_ok=false;
	var ajax_wait=false;
	ask_db_middle_table('tagi_sprzetu',$('#sprzet').val(),$('#tag').val(),'Ta informacja o tagu sprzętu jest już w bazie danych.','#tag_error');
});