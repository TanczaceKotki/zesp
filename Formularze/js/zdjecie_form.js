function process_image(){
	check_wait=true;
	var input=$('#plik')[0];
    if(input.files && input.files[0]){
		$('#podglad').css('display','none');
		$('#img_msg').html('');
        var reader = new FileReader();
        reader.onload = function (e) {
			$('#podglad').attr('src',e.target.result);
			var image = new Image();
			image.src = e.target.result;
			image.onload = function(){
				if(this.width<800 || this.height<600){
					$('#img_msg').html('Zdjęcie jest za małe. Minimalna rozdzielczość: 800x600.');
					image_ok=false;
					check_wait=false;
				}
				else{
					if(this.width>this.height){
						var width=200;
						var height=parseInt(this.height*(200/this.width),10);
					}
					else if(this.width<this.height){
						var width=parseInt(this.width*(200/this.height),10);
						var height=200;
					}
					else{
						var width=200;
						var height=200;
					}
					$('#podglad').attr('width',width);
					$('#podglad').attr('height',height);
					$('#img_msg').html('Podgląd:');
					$('#podglad').css('display','inline');
					image_ok=true;
					check_wait=false;
				}
			};
        }
        reader.readAsDataURL(input.files[0]);
    }
	else{
		image_ok=false;
		check_wait=false;
	}
}

function image_check(){
	return image_ok && !check_wait;
}

function img_error(){
	if($('#podglad').attr('src')!='#') $('#img_msg').html('Plik nie jest zdjęciem.');
	image_ok=false;
	check_wait=false;
}

$(document).ready(function(){
	webshims.polyfill('forms');
	var image_ok=false;
	var check_wait=false;
	process_image();
});
