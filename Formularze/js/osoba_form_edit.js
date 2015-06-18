function check_email_2(){
	ajax_wait=true;
	if($('#email').val()!==$('#old_email').val()){
		check_email();
	}
	else{
		$('#email')[0].setCustomValidity('');
		ajax_wait=false;
	}
}

$(document).ready(function(){
	var ajax_wait=false;
	check_email_2();
});
