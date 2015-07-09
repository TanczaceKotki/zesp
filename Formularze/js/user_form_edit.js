function check_login_edit(){
	if($('#login').val()!==$('#old_login').val()) check_login();
	else $('#login')[0].setCustomValidity('');
}
