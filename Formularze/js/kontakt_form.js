$(document).ready(function(){
	webshims.polyfill('forms');
	var ajax_wait=false;
	ask_db_middle_table('kontakt','#sprzet','#osoba','Ta informacja kontaktowa jest już w bazie danych.');
});