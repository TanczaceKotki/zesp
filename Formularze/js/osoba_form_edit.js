function check_email(){
	ajax_wait=true;
	email=$('#email').val();
	if(email!==''){
		if(/^([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22))*\x40([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d))*$/.test(email)){
			if(email!==$('[name=old_email]').val()){
				ask_db('osoba',email,'Podany adres email jest już w bazie danych.','#email_error','#email');
			}
			else{
				$('#email_error').html('');
				form_ajax_ok=true;
				ajax_wait=false;
				$('#email').css('box-shadow','');
				$('#email').css('border','');
			}
		}
		else{
			$('#email_error').html('Adres email jest niepoprawny.');
			form_ajax_ok=false;
			ajax_wait=false;
			$('#email').css('box-shadow','0 0 3px red');
			$('#email').css('border','1px solid red');
		}
	}
	else{
		$('#email_error').html('');
		form_ajax_ok=false;
		ajax_wait=false;
		$('#email').css('box-shadow','');
		$('#email').css('border','');
	}
}

$(document).ready(function(){
	webshims.polyfill('forms');
	var form_ajax_ok=false;
	var ajax_wait=false;
	check_email();
	init_counters();
});
