function ask_db_middle_table(dest,query1,query2,message,error_id){
	if(dest==='kontakt'){
		var addr='ajax_query_kontakt.php';
	}
	else if(dest==='tagi_sprzetu'){
		var addr='ajax_query_tagi_sprzetu.php';
	}
	else if(dest==='laborat_w_zaklad'){
		var addr='ajax_query_laborat_w_zaklad.php';
	}
	post_request=$.post(addr,{q1: query1,q2: query2});
	post_request.done(function(data){
		if(data==='0'){
			$(error_id).html('');
			form_ajax_ok=true;
			ajax_wait=false;
		}
		else{
			$(error_id).html(message);
			form_ajax_ok=false;
			ajax_wait=false;
		}
	});
}

function ajax_check(){
	return form_ajax_ok && !ajax_wait;
}
