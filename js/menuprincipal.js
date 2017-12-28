/*
*/
$(document).ready(function() {

	$('[name=menu]').click( function() {
		window.location.replace($(this).attr('to'));
	});

});