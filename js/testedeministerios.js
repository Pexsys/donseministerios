/*
*/
var resultado = 0;

$(document).ready(function() {

	$('[name=cmbMinisterio]').each(function() {
		var value = $(this).attr('basevalue');
		if (value != ""){
			$(this).val(value);
		};
	});
	
	$('[name=hrefPage]').click( function() {
		var toAttr = $(this).attr('to');
		if ( toAttr != ""){
			$.ajax({
				url: 'asministerios.php',
				type: 'post',
				dataType: 'json',
				data: { 
					showRes: resultado,
					toUrl: toAttr,
					userID: $('#userID').val(),
					data: mapRespostas()
				},
				success: function(response) {
					if (response.page) {
						window.location.replace(response.page);
					};
				}
			});
		};
	});
	
	$('#result').click ( function() {
		if (confirm('Confirma final do teste?')) {
			resultado = 1;
			$('[name=hrefPage]:first').click();
		};
	});
	
	$('[name=btnClose]').click ( function() {
		resultado = -1;
		$('[name=hrefPage]:first').click();
	});

	$('[name=cmbMinisterio]:first').focus();

});

function mapRespostas(){
	var jsonObj = [];
	$('[name=cmbMinisterio]').each(function() {
		jsonObj.push({
			ministerio: $(this).attr('ministerio'),
			resposta: $(this).val()
		});
	});
	return jsonObj;
};