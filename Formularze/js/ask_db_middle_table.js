function ask_db_middle_table(dest,input1,input2,message){
	if(dest==='kontakt') var addr='ajax_query_kontakt.php';
	else if(dest==='tagi_sprzetu') var addr='ajax_query_tagi_sprzetu.php';
	else if(dest==='laborat_w_zaklad') var addr='ajax_query_laborat_w_zaklad.php';
	post_request=$.post(addr,{q1: $(input1).val(),q2: $(input2).val()});
	post_request.done(function(data){
		if(data==='0'){
			$(input1)[0].setCustomValidity('');
			$(input2)[0].setCustomValidity('');
		}
		else{
			$(input1)[0].setCustomValidity(message);
			$(input2)[0].setCustomValidity(message);
		}
		ajax_wait=false;
	});
}

function ajax_check(){
	return !ajax_wait;
}
