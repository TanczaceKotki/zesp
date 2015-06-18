function level_2(){
	if($('#kont').is(':checked')){
		$('#login_label').html('Adres email<span class="color_red">*</span>:');
		$('#login').attr('type','email');
		$('#login').attr('onchange','check_email(\'#login\')');
		$('#register_form').attr('onsubmit','return ajax_check()');
	}
	else{
		$('#login_label').html('Login<span class="color_red">*</span>:');
		$('#login').attr('type','text');
		$('#login').removeAttr('onchange');
		$('#register_form').removeAttr('onsubmit');
	}
}

function compare_pass(){
	var pass=$('#pass').val();
	var pass_v=$('#pass_v').val();
	if(pass!=='' && pass_v!==''){
		if(pass!==pass_v){
			$('#pass')[0].setCustomValidity('Hasła się nie zgadzają.');
			$('#pass_v')[0].setCustomValidity('Hasła się nie zgadzają.');
		}
	}
	else{
		$('#pass')[0].setCustomValidity('');
		$('#pass_v')[0].setCustomValidity('');
	}
}


$(document).ready(function(){
	var ajax_wait=false;
	level_2();
});