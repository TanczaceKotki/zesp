function check_tag(){
	ajax_wait=true;
	var tag=$('#nazwa').val();
	if(tag!==''){
		ask_db('tag',tag,'Podany tag jest już w bazie danych.','#tag_error','#nazwa');
	}
	else{
		$('#tag_error').html('');
		form_ajax_ok=false;
		ajax_wait=false;
		$('#nazwa').css('box-shadow','');
		$('#nazwa').css('border','');
	}
}

$(document).ready(function(){
	webshims.polyfill('forms');
	var form_ajax_ok=false;
	var ajax_wait=false;
	check_tag();
	init_counters();
});
