function check_tag(){
	ajax_wait=true;
	var tag=$('#nazwa').val();
	if(tag!==''){
		ask_db('tag',tag,'Podany tag jest już w bazie danych.','#nazwa');
	}
	else{
		$('#nazwa')[0].setCustomValidity('');
		ajax_wait=false;
	}
}