function ask_db(dest,query,message,error_id,input_id){
	if(dest==='tag'){
		var addr='ajax_query_tag.php';
	}
	else if(dest==='osoba'){
		var addr='ajax_query_osoba.php';
	}
	post_request=$.post(addr,{q: query});
	post_request.done(function(data){
		if(data==='0'){
			$(error_id).html('');
			form_ajax_ok=true;
			ajax_wait=false;
			$(input_id).css('box-shadow','');
			$(input_id).css('border','');
		}
		else{
			$(error_id).html(message);
			form_ajax_ok=false;
			ajax_wait=false;
			$(input_id).css('box-shadow','0 0 3px red');
			$(input_id).css('border','1px solid red');
		}
	});
}

function ajax_check(){
	return form_ajax_ok && !ajax_wait;
}
