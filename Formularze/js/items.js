$(document).ready(function(){
	var items=$('.items');
	for(var i=0;i<items.length;++i){
		$(items[i]).on('mouseenter','.item',function(){
			var sub_items=$(this).closest('.items').find('.item');
			for(var j=0;j<sub_items.length;++j) $(sub_items[j]).addClass('underline');
		});
		$(items[i]).on('mouseleave','.item',function(){
			var sub_items=$(this).closest('.items').find('.item');
			for(var j=0;j<sub_items.length;++j) $(sub_items[j]).removeClass('underline');
		});
	}
});
