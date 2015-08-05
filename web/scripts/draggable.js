$('body').on('dragend', 'li', function(){
$("ul[id$='sortable'").trigger('sortupdate');
});