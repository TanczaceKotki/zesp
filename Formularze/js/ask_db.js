function ask_db(dest,query,message,input_id){
	ajax_wait=true;
	if(dest==='tag') var addr='ajax_query_tag.php';
	else if(dest==='osoba') var addr='ajax_query_osoba.php';
	else if(dest==='login') var addr='ajax_query_login.php';
	post_request=$.post(addr,{q:query});
	post_request.done(function(data){
		ajax_wait=false;
		if(data==='0') $(input_id)[0].setCustomValidity('');
		else $(input_id)[0].setCustomValidity(message);
	});
}

function ajax_check(){
	return !ajax_wait;
}
