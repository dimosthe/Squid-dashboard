$('body').on('dragend', 'li', function(){
	//$("ul[id$='sortable'").trigger('sortupdate');
	$("#sortable1-sortable").trigger('sortupdate');
	$("#sortable2-sortable").trigger('sortupdate');
});