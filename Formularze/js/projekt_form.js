function date_callback(day1,month1,year1,day2,month2,year2){
	var previous=0;
	for(var i=0;i<document.getElementById(day1).options.length;++i){
		if(document.getElementById(day1).options[i].selected){
			previous=i;
		}
	}
	document.getElementById(day1).options.length=0;
	if(previous==0){
		document.getElementById(day1).options[0]=new Option('-','',true,true);
	}
	else{
		document.getElementById(day1).options[0]=new Option('-','',false,false);
	}
	if(document.getElementById(month1).value!='' && document.getElementById(year1).value!=''){
		for(var i=1;i<=new Date(document.getElementById(year1).value,document.getElementById(month1).value,0).getDate();++i){
			if(i==previous){
				document.getElementById(day1).options[i]=new Option(i,i,true,true);
			}
			else{
				document.getElementById(day1).options[i]=new Option(i,i,false,false);
			}
		}
	}
	previous=0;
	for(var i=0;i<document.getElementById(day2).options.length;++i){
		if(document.getElementById(day2).options[i].selected){
			previous=i;
		}
	}
	document.getElementById(day2).options.length=0;
	if(previous==0){
		document.getElementById(day2).options[0]=new Option('-','',true,true);
	}
	else{
		document.getElementById(day2).options[0]=new Option('-','',false,false);
	}
	if(document.getElementById(month2).value!=''){
		document.getElementById(year2).setAttribute('required','required');
		if(document.getElementById(year2).value!=''){
			for(var i=1;i<=new Date(document.getElementById(year2).value,document.getElementById(month2).value,0).getDate();++i){
				if(i==previous){
					document.getElementById(day2).options[i]=new Option(i,i,true,true);
				}
				else{
					document.getElementById(day2).options[i]=new Option(i,i,false,false);
				}
			}
		}
	}
	else{
		document.getElementById(year2).removeAttribute('required');
	}
	
	if(document.getElementById(month1).value!=''){
		document.getElementById(month2).setAttribute('required','required');
	}
	else{
		document.getElementById(month2).removeAttribute('required');
	}
	if(document.getElementById(day1).value!='' && parseInt(document.getElementById(month1).value,10)>=parseInt(document.getElementById(month2).value,10)){
		document.getElementById(day2).setAttribute('required','required');
	}
	else{
		document.getElementById(day2).removeAttribute('required');
	}
}

$(document).ready(function(){
	date_callback('data_rozp_dzien','data_rozp_miesiac','data_rozp_rok','data_zakoncz_dzien','data_zakoncz_miesiac','data_zakoncz_rok');
});
