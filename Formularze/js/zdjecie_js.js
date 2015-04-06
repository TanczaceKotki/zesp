window.onload = function(){
	if(document.getElementById('picture_new').checked){
		document.getElementById('picture_link_form').style.display='none';
		document.getElementById('link').required=false;
		document.getElementById('new_picture_form').style.display='inline';
		document.getElementById('plik').required=true;
	}
	else if(document.getElementById('picture_link').checked){
		document.getElementById('new_picture_form').style.display='none';
		document.getElementById('plik').required=false;
		document.getElementById('picture_link_form').style.display='inline';
		document.getElementById('link').required=true;
	}
};

function toggleDisplay(val)
{
	if(val=='new'){
		document.getElementById('picture_link_form').style.display='none';
		document.getElementById('link').required=false;
		document.getElementById('new_picture_form').style.display='inline';
		document.getElementById('plik').required=true;
	}
	else if(val=='link'){
		document.getElementById('new_picture_form').style.display='none';
		document.getElementById('plik').required=false;
		document.getElementById('picture_link_form').style.display='inline';
		document.getElementById('link').required=true;
	}
};