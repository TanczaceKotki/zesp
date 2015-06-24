function check_email(email_id){
	if(typeof email_id==='undefined') email_id='#email';
	ajax_wait=true;
	email=$(email_id).val();
	if(email!==''){
		if(/^([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22))*\x40([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d))*$/.test(email)){
			var parts=email.split('@');
			if(parts[0].length>64){
				ajax_wait=false;
				$(email_id)[0].setCustomValidity('Indetyfikator użytkownika w adresie email nie może mieć więcej niż 64 znaki długości.');
			}
			else ask_db('osoba',email,'Podany adres email jest już w bazie danych.',email_id);
		}
		else{
			ajax_wait=false;
			$(email_id)[0].setCustomValidity('Adres email jest niepoprawny.');
		}
	}
	else{
		ajax_wait=false;
		$(email_id)[0].setCustomValidity('');
	}
}