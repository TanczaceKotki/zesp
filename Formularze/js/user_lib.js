function check_login(){
	if($('#kont').is(':checked')) check_email('#login');
	else{
		var login=$('#login').val();
		if(login!=='') ask_db('login',login,'Podany login jest już w bazie danych.','#login');
		else $('#login')[0].setCustomValidity('');
	}
}

function check_log(){
	if(typeof check_login_edit==='function') check_login_edit();
	else check_login();
}

function level_2(){
	$('#login_label').html('Adres email<span class="color_red">*</span>:');
	$('#login').attr('type','email');
	$('#kont_inputs').css('display','block');
	$('#imie').attr('required','required');
	$('#nazwisko').attr('required','required');
	check_log();
}

function not_level_2(){
	$('#login_label').html('Login<span class="color_red">*</span>:');
	$('#login').attr('type','text');
	$('#kont_inputs').css('display','none');
	$('#imie').removeAttr('required');
	$('#nazwisko').removeAttr('required');
	check_log();
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
	if($('#kont').is(':checked')) level_2();
	else not_level_2();
	check_log();
});
