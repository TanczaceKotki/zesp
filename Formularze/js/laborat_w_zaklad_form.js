$(document).ready(function(){
	webshims.polyfill('forms');
	var ajax_wait=false;
	ask_db_middle_table('laborat_w_zaklad','#laboratorium','#zaklad','Ta informacja o laboratorium w zakładzie jest już w bazie danych.');
});