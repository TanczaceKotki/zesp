function process_images(){
	check_wait=true;
	var input=$('#pliki')[0];
	$('#img_msg_view').empty();
	$('#pliki')[0].setCustomValidity('');
    if(input.files && input.files[0]){
		image_ok=true;
		for(var i=0;i<input.files.length;++i){
			var reader = new FileReader();
			reader.onload = (function(file,num) {
				return function(e) {
					process_image(e,file,num);
				};
			})(input.files[i],i);
			reader.readAsDataURL(input.files[i]);
		}
    }
	check_wait=false;
}

function process_image(e,file,num){
	var msg = $('<div id="img_msg_'+num+'">');
	var img = $('<img src="'+e.target.result+'" id="podglad'+num+'" onerror="img_error('+num+',\''+file.name+'\')" style="display:none" alt="">');
	msg.appendTo('#img_msg_view');
	img.appendTo('#img_msg_view');
	var image = new Image();
	image.src = e.target.result;
	image.onload = (function(file1,num1,image_obj) {
		return function() {
			image_inner_processing(file1,num1,image_obj);
		};
	})(file,num,image);
}

function image_inner_processing(file1,num1,image){
	if(image.width<800 || image.height<600){
		$('#img_msg_'+num1).html('Zdjęcie w pliku '+file1.name+' jest za małe. Minimalna rozdzielczość: 800x600.');
		$('#pliki')[0].setCustomValidity('Niektóre pliki są niepoprawne.');
		image_ok=false;
	}
	else{
		if(image.width>image.height){
			var width=200;
			var height=parseInt(image.height*(200/image.width),10);
		}
		else if(image.width<image.height){
			var width=parseInt(image.width*(200/image.height),10);
			var height=200;
		}
		else{
			var width=200;
			var height=200;
		}
		$('#podglad'+num1).attr('width',width);
		$('#podglad'+num1).attr('height',height);
		$('#img_msg_'+num1).html('Podgląd zdjęcia '+file1.name+':');
		$('#podglad'+num1).css('display','inline');
	}
}

function image_check(){
	return image_ok && !check_wait;
}

function img_error(i,filename){
	$('#img_msg_'+i).html('Plik '+filename+' nie jest zdjęciem.');
	$('#pliki')[0].setCustomValidity('Niektóre pliki są niepoprawne.');
	image_ok=false;
}

$(document).ready(function(){
	webshims.polyfill('forms');
	var image_ok=false;
	var check_wait=false;
	process_images();
});
