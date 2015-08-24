function date_callback(day1,month1,year1,day2,month2,year2){
	var rozp_day=data_rozp_dzien.val();
	var rozp_month=data_rozp_miesiac.val();
	var rozp_year=data_rozp_rok.val();
	var prev_opt=data_rozp_dzien.find('option');
	if(prev_opt.length>1) previous_rozp=rozp_day;
	prev_opt.remove();
	if(previous_rozp==='') var options='<option value="" selected="selected">-</option>';
	else var options='<option value="">-</option>';
	if(rozp_month!=='' && rozp_year!==''){
		var days_in_month=new Date(rozp_year,rozp_month,0).getDate();
		for(var i=1;i<=days_in_month;++i){
			if(i===parseInt(previous_rozp,10)){
				if(i<10) options+='<option value="0'+i+'" selected="selected">'+i+'</option>';
				else options+='<option value="'+i+'" selected="selected">'+i+'</option>';
			}
			else{
				if(i<10) options+='<option value="0'+i+'">'+i+'</option>';
				else options+='<option value="'+i+'">'+i+'</option>';
			}
		}
	}
	data_rozp_dzien.append(options);
	
	var zak_day=data_zakoncz_dzien.val();
	var zak_month=data_zakoncz_miesiac.val();
	var zak_year=data_zakoncz_rok.val();
	prev_opt=data_zakoncz_dzien.find('option');
	if(prev_opt.length>1) previous_zakoncz=zak_day;
	prev_opt.remove();
	if(previous_zakoncz==='') options='<option value="" selected="selected">-</option>';
	else options='<option value="">-</option>';
	if(zak_month!==''){
		data_zakoncz_rok.attr('required','required');
		if(zak_year!==''){
			var days_in_month=new Date(zak_year,zak_month,0).getDate();
			for(var i=1;i<=days_in_month;++i){
				if(i===parseInt(previous_zakoncz,10)){
					if(i<10) options+='<option value="0'+i+'" selected="selected">'+i+'</option>';
					else options+='<option value="'+i+'" selected="selected">'+i+'</option>';
				}
				else{
					if(i<10) options+='<option value="0'+i+'">'+i+'</option>';
					else options+='<option value="'+i+'">'+i+'</option>';
				}
			}
		}
	}
	else data_zakoncz_rok.removeAttr('required');
	data_zakoncz_dzien.append(options);
	
	if(rozp_day!==''){
		data_zakoncz_miesiac.attr('required','required');
		if(parseInt(rozp_month,10)>=parseInt(zak_month,10)) data_zakoncz_dzien.attr('required','required');
		else data_zakoncz_dzien.removeAttr('required');
	}
	else data_zakoncz_miesiac.removeAttr('required');
}

$(document).ready(function(){
	data_rozp_dzien=$('#data_rozp_dzien');
	data_rozp_miesiac=$('#data_rozp_miesiac');
	data_rozp_rok=$('#data_rozp_rok');
	previous_rozp='';
	data_zakoncz_dzien=$('#data_zakoncz_dzien');
	data_zakoncz_miesiac=$('#data_zakoncz_miesiac');
	data_zakoncz_rok=$('#data_zakoncz_rok');
	previous_zakoncz='';
	date_callback();
});
