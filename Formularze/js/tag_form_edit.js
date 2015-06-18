function check_tag_2(){
	ajax_wait=true;
	if($('#nazwa').val()!==$('#old_nazwa').val()){
		check_tag();
	}
	else{
		$('#nazwa')[0].setCustomValidity('');
		ajax_wait=false;
	}
}

$(document).ready(function(){
	var ajax_wait=false;
	check_tag_2();
});
