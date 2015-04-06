$(function(){
	for (var i=0;i<date_fields.length;i++){
		$("#"+date_fields[i]).datepicker({dateFormat:'yy-mm-dd'});
	}
});