
$(document).ready(function() {
	//iCheck for radio inputs
    $('input[type="radio"]').iCheck({
    	radioClass: 'iradio_minimal-blue'
    });
    
	$('input').on('ifChecked', function(event){
		if($(this).attr('name') == 'DelayGroup[bandwidth]')
		{
			var value = $(this).val();
			if(value == "1")
				$("#bandwidth").show();
			else
				$("#bandwidth").hide();
		}
	});
});