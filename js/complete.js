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
	
	$("#emailDS").change( function () {
		var value = $(this).val();
		var twice	= $(this).attr('twice');
		if ( value !== "" ) {
			var emailFilter = /^.+@.+\..{2,}$/;
			var illegalChars = /[\(\)\<\>\,\;\:\\\/\"\[\]]/;
			
			if ( !(emailFilter.test(value)) || value.match(illegalChars) ) {
				alert('Por favor, informe um email válido!');
				$(this).val("");
				$(this).focus();

			} else if ( !twice || twice == "" ) {
				$(this).attr('twice',value);
				$(this).val("");
				alert('Digite seu email novamente!');
				$(this).focus();
				
			} else if ( value !== twice ) {
				$(this).attr('twice',"");
				$(this).val("");
				alert('Primeira digitação difere da segunda. Digite novamente seu email!');
				$(this).focus();
				
			};
		};
	});
	
	$('#submitButton').click( function() {
		if ( confirm('Confirma dados?') ) {

			var qtd = 0;
			 $("form").find("[required=true]").each(function(){
				if ($(this).val() == ""){
					++qtd;
				};
			});
			if ( qtd > 0 ){
				alert('Favor preencher todos os dados!');
				return false;
			};
		
			var dados = { 
				userID: $('#userID').val(),
				complete: true
			};
			if ( $('#corDS').length > 0 ) {
				dados.corDS = $('#corDS').val().toUpperCase();
			};
			if ( $('#discipuloID').length > 0 ) {
				dados.discipuloID = $('#discipuloID').val();
			};
			if ( $('#emailDS').length > 0 ) {
				dados.emailDS = $('#emailDS').val().toLowerCase();
			};

			$.ajax({
				url: 'asdons.php',
				type: 'post',
				dataType: 'json',
				data: dados,
				success: function(response) {
					window.location.replace(response.page);
				}
			});
		};
	});
	
	$('[name=btnClose]').click ( function() {
		window.location.replace('login.php?');
	});

});