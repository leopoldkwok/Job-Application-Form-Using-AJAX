 $(document).ready(function() {
	

	$("#male").click(function(){
	    $('tbody > tr:not(.male)').toggle();
	});

	$('#female').click(function(){
	    $('tbody > tr:not(.female)').toggle();
	}); 

	$('#all').click(function(){
	     $('tbody > tr').show();
	}); 
});



// It's good to place items outside the DOM so it does not get bloated on load */
