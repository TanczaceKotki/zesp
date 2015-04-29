$(document).ready(function(){
	webshims.polyfill('forms');
	var form_ajax_ok=false;
	var ajax_wait=false;
	ask_db_middle_table('laborat_w_zaklad',$('#laboratorium').val(),$('#zaklad').val(),'Ta informacja o laboratorium w zakładzie jest już w bazie danych.','#laborat_w_zaklad_error');
});