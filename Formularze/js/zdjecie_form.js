function process_images(){
	check_wait=true;
	input.setCustomValidity('');
	img_msg_view.empty();
	image_ok=[];
    if(input.files && input.files[0]){
		for(var i=0;i<input.files.length;++i){
			image_ok.push(false);
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
	img_msg_view.append('<div class="img_prev"><div id="img_msg_'+num+'"></div><img src="'+e.target.result+'" id="podglad'+num+'" onerror="img_error('+num+',\''+file.name+'\')" class="d_none" alt="" /></div>');
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
		input.setCustomValidity('Niektóre pliki są niepoprawne.');
		$('#img_msg_'+num1).html('Zdjęcie w pliku '+file1.name+' jest za małe. Minimalna rozdzielczość: 800x600.');
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
		$('#podglad'+num1).attr({'width':width,'height':height,'class':'d_inline'});
		$('#img_msg_'+num1).html('Podgląd zdjęcia '+file1.name+':');
		image_ok[num1]=true;
	}
}

function image_check(){
	if(check_wait) return false;
	for(var i=0;i<input.files.length;++i){
		if(!image_ok[i]) return false;
		else if(i===input.files.length-1) return true;
	}
	return false;
}

function img_error(i,filename){
	input.setCustomValidity('Niektóre pliki są niepoprawne.');
	$('#img_msg_'+i).html('Plik '+filename+' nie jest zdjęciem.');
}

$(document).ready(function(){
	image_ok=[];
	check_wait=false;
	input=$('#pliki')[0];
	img_msg_view=$('#img_msg_view');
	process_images();
});
