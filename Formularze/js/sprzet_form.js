function day_switch_with_required_year(){
	var cur_day=day_sel_zakupu.val();
	var cur_month=month_sel_zakupu.val();
	var cur_year=rok_sel_zakupu.val();
	var prev_opt=day_sel_zakupu.find('option');
	if(prev_opt.length>1) previous_zakupu=cur_day;
	prev_opt.remove();
	if(previous_zakupu==='') var options='<option value="" selected="selected">-</option>';
	else var options='<option value="">-</option>';
	if(cur_month!=='' && cur_year!==''){
		var days_in_month=new Date(cur_year,cur_month,0).getDate();
		for(var i=1;i<=days_in_month;++i){
			if(i===parseInt(previous_zakupu,10)){
				if(i<10) options+='<option value="0'+i+'" selected="selected">'+i+'</option>';
				else options+='<option value="'+i+'" selected="selected">'+i+'</option>';
			}
			else{
				if(i<10) options+='<option value="0'+i+'">'+i+'</option>';
				else options+='<option value="'+i+'">'+i+'</option>';
			}
		}
	}
	day_sel_zakupu.append(options);
}
function day_switch_with_optional_year(day,month,year){
	var cur_day=day_sel_uruchom.val();
	var cur_month=month_sel_uruchom.val();
	var cur_year=rok_sel_uruchom.val();
	if(day_sel_uruchom.find('option').length>1) previous_uruchom=cur_day;
	day_sel_uruchom.find('option').remove();
	if(previous_uruchom==='') var options='<option value="" selected="selected">-</option>';
	else var options='<option value="">-</option>';
	if(cur_month!==''){
		rok_sel_uruchom.attr('required','required');
		if(cur_year!==''){
			var days_in_month=new Date(cur_year,cur_month,0).getDate();
			for(var i=1;i<=days_in_month;++i){
				if(i===parseInt(previous_uruchom,10)){
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
	else rok_sel_uruchom.removeAttr('required');
	day_sel_uruchom.append(options);
}

function check_if_number(){
	if(/^$|^\d+$/.test(wart_input.val())){
		wart_input[0].setCustomValidity('');
		return true;
	}
	else{
		wart_input[0].setCustomValidity('Podana wartość nie jest nieujemną liczbą całkowitą.');
		return false;
	}
}

$(document).ready(function(){
	if(!Modernizr.inputtypes.number){
		$('#wartosc').spinner().spinner('option','min',0).spinner('option','max',9223372036854775807).spinner('option','step',1);
	}
	day_sel_zakupu=$('#data_zakupu_dzien');
	month_sel_zakupu=$('#data_zakupu_miesiac');
	rok_sel_zakupu=$('#data_zakupu_rok');
	previous_zakupu='';
	day_sel_uruchom=$('#data_uruchom_dzien');
	month_sel_uruchom=$('#data_uruchom_miesiac');
	rok_sel_uruchom=$('#data_uruchom_rok');
	previous_uruchom='';
	wart_input=$('#wartosc');
	day_switch_with_required_year();
	day_switch_with_optional_year();
});
