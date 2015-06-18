$(document).ready(function(){
	$('[maxlength]').each(function(){
		var remaining=$(this).attr('maxlength')-$(this).val().length;
		if(remaining>4 || remaining===0){
			$('#'+$(this).attr('id')+'_counter').html('Zostało '+remaining+' znaków.');
		}
		else if(remaining===1){
			$('#'+$(this).attr('id')+'_counter').html('Został 1 znak.');
		}
		else if(remaining<5){
			$('#'+$(this).attr('id')+'_counter').html('Zostały '+remaining+' znaki.');
		}
		$(this).bind('oninput' in document.createElement('input') ? 'input' : 'keyup', function() {
			var remaining=$(this).attr('maxlength')-$(this).val().length;
			if(remaining>4 || remaining===0){
				$('#'+$(this).attr('id')+'_counter').html('Zostało '+remaining+' znaków.');
			}
			else if(remaining===1){
				$('#'+$(this).attr('id')+'_counter').html('Został 1 znak.');
			}
			else if(remaining<5){
				$('#'+$(this).attr('id')+'_counter').html('Zostały '+remaining+' znaki.');
			}
		});
	});
});
