/*
*/

$(document).ready(function() {

	$('[name=btnClose]').click ( function() {
		window.location.replace('login.php?');
	});
	
	$('[name=caracteristica]').click ( function() {
		$.ajax({
			url: 'asdons.php',
			type: 'post',
			dataType: 'json',
			data: { 
				showRes: 'caracteristica',
				id: $(this).attr('id-dom')
			},
			success: function(response) {
				if (response.dom) {
					$( "#dialog-message" )
						.html(response.ref)
						.dialog({
							title: response.dom,
						 height: 500,
							width: 500,
							modal: true,
							buttons: [
								{
									text: "Fechar",
									click: function() {
										$( this ).dialog( "close" );
									}
								}
							]
						});
				};
			}
		});
	});

	if ( GetURLParameter('print') == 'yes' ) {
		window.self.print();
	};

});

function GetURLParameter(sParam) {
	var sPageURL = window.location.search.substring(1);
	var sURLVariables = sPageURL.split('&');
	for (var i = 0; i < sURLVariables.length; i++) {
		var sParameterName = sURLVariables[i].split('=');
		if (sParameterName[0] == sParam) {
				return sParameterName[1];
		};
	};
};