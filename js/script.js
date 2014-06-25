$(function() {
});

$(document).ready(function(){
	// Sort
    $( "#sortable" ).sortable({
		update: function( event, ui ){
		
			var new_sort = [];
			$.each($(this).find("li"), function(k,v){
				new_sort[k] = $(v).attr('id');
			});
			
			$.post('?action=sort', {sort:new_sort});
		}
	});
    $( "#sortable" ).disableSelection();
	
	// Date
	var datepicker_options = {
		dateFormat: 'yy-mm-dd',
		constrainInput: true,
		minDate: null,
		maxDate: null,
		beforeShow: function(){
			
			var ymd, orientir = $("input#dateStart"), optionName = "minDate", duration = 1;

			if( this.id == 'dateStart' )
				orientir = $("input#dateEnd"), optionName = "maxDate", duration = -1;
				
			ymd = orientir.val().split("-");
			$(this).datepicker("option", optionName, new Date(ymd[0], parseInt(ymd[1]) - 1, parseInt(ymd[2]) + duration ));
		}
	};
	
	$( "#dateStart" ).datepicker(datepicker_options);
	$( "#dateEnd" ).datepicker(datepicker_options);
	
	$( "#timeStart" ).timepicker();
	$( "#timeEnd" ).timepicker();
	
	$(".errors, .success").click(function(){ $(this).hide(); });
	
	var lazy_img = $("img.lazy");
	if( lazy_img.length > 0 ){

		$.each( lazy_img, function(k,v){
			
			var parent_a = $(v).parent("a");
			
			$.get("imgload.php", {src:$(v).attr('alt')}, function(data){
				
				parent_a.html(data);
			}).done(function(){
			
				console.log("done");
			});
		} );
	}
});

