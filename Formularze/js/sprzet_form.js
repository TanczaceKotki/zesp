function day_switch_with_required_year(day,month,year){
	for(var i=0;i<document.getElementById(day).options.length;++i){
		if(document.getElementById(day).options[i].selected){
			var previous=i;
		}
	}
	document.getElementById(day).options.length=0;
	if(previous==0){
		document.getElementById(day).options[0]=new Option('-','',true,true);
	}
	else{
		document.getElementById(day).options[0]=new Option('-','',false,false);
	}
	if(document.getElementById(month).value!='' && document.getElementById(year).value!=''){
		for(var i=1;i<=new Date(document.getElementById(year).value,document.getElementById(month).value,0).getDate();++i){
			if(i<10){
				var val='0'+i;
			}
			else{
				var val=i;
			}
			if(i===previous){
				document.getElementById(day).options[i]=new Option(i,val,true,true);
			}
			else{
				document.getElementById(day).options[i]=new Option(i,val,false,false);
			}
		}
	}
}
function day_switch_with_optional_year(day,month,year){
	for(var i=0;i<document.getElementById(day).options.length;++i){
		if(document.getElementById(day).options[i].selected){
			var previous=i;
		}
	}
	document.getElementById(day).options.length=0;
	if(previous==0){
		document.getElementById(day).options[0]=new Option('-','',true,true);
	}
	else{
		document.getElementById(day).options[0]=new Option('-','',false,false);
	}
	if(document.getElementById(month).value!=''){
		document.getElementById(year).required=true;
		if(document.getElementById(year).value!=''){
			for(var i=1;i<=new Date(document.getElementById(year).value,document.getElementById(month).value,0).getDate();++i){
				if(i<10){
					var val='0'+i;
				}
				else{
					var val=i;
				}
				if(i===previous){
					document.getElementById(day).options[i]=new Option(i,val,true,true);
				}
				else{
					document.getElementById(day).options[i]=new Option(i,val,false,false);
				}
			}
		}
	}
	else{
		document.getElementById(year).required=false;
	}
}


function initWartosc(){
	$("#wartosc").spinner();
	$("#wartosc").spinner( "option", "min", 0 );
	$("#wartosc").spinner( "option", "max", 9223372036854775807 );
	$("#wartosc").spinner( "option", "step", 1 );
}

function check_if_number(val){
	var reg = /^\d+$/;
	if(reg.test(val) || val===''){
		$('#wartosc')[0].setCustomValidity('');
		return true;
	}
	else{
		$('#wartosc')[0].setCustomValidity('Podana wartość nie jest dodatnią liczbą całkowitą.');
		return false;
	}
}

$(document).ready(function(){
	if(!Modernizr.inputtypes.number){
		initWartosc();
	}
	day_switch_with_required_year('data_zakupu_dzien','data_zakupu_miesiac','data_zakupu_rok');
	day_switch_with_optional_year('data_uruchom_dzien','data_uruchom_miesiac','data_uruchom_rok');
});
