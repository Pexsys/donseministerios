/*
*/
var resultado = 0;

$(document).ready(function() {

	$('[name=cmbQuestao]').each(function() {
		var value = $(this).attr('basevalue');
		if (value != ""){
			$(this).val(value);
		};
	});
	
	$('[name=cmbQuestao]').change(function() {
		if ($(this).val() == ""){
			$(this).addClass("blank");
		}else{
			$(this).removeClass("blank");
		};
	});
	
	$('[name=hrefPage]').click( function() {
		var toAttr = $(this).attr('to');
		if ( toAttr != ""){
			$.ajax({
				url: 'asdons.php',
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

	$('[name=cmbQuestao]:first').focus();

});

function mapRespostas(){
	var jsonObj = [];
	$('[name=cmbQuestao]').each(function() {
		jsonObj.push({
			questao: $(this).attr('question'),
			resposta: $(this).val()
		});
	});
	return jsonObj;
};