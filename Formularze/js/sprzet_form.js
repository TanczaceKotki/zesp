function initWartosc(){
	$("#wartosc").spinner();
	$("#wartosc").spinner( "option", "min", 0 );
	$("#wartosc").spinner( "option", "max", 9223372036854775807 );
	$("#wartosc").spinner( "option", "step", 1 );
}

function check_if_number(val){
	var reg = /^\d+$/;
	if(reg.test(val) || val===''){
		document.getElementById('numerror').innerHTML='';
		return true;
	}
	else{
		document.getElementById('numerror').innerHTML='Podana wartość nie jest dodatnią liczbą całkowitą.';
		return false;
	}
}

$(document).ready(function(){
	webshims.polyfill('forms');
	if(!Modernizr.inputtypes.number){
		initWartosc();
	}
	init_counters();
	day_switch_with_required_year('data_zakupu_dzien','data_zakupu_miesiac','data_zakupu_rok');
	day_switch_with_optional_year('data_uruchom_dzien','data_uruchom_miesiac','data_uruchom_rok');
});
