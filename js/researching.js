/*
*/
$(document).ready(function() {

	$('#tdGerar').click(function() {
		$('[name=detail]').unbind('click');
	
		$.ajax({
			url: 'load.php',
			type: 'post',
			dataType: 'json',
			data: { 
				load: "listaresultados",
				search: $("[name=optFiltros]:checked").val(),
				nome: $("#txtNomePessoa").val(),
				id: $("#cmbSearch").val(),
				opcao: $("#cmbPontuacao").val(),
				menor: $("#txtValorMenor").val(),
				maior: $("#txtValorMaior").val()
			},
			success: function(response) {
				if (response.load){
					$("#divPrintInfo").html(response.html).show();
					
					$('[name=detail]').bind('click', function() {
						$.ajax({
							url: 'load.php',
							type: 'post',
							dataType: 'json',
							data: { 
								load: "detail",
								search: $("[name=optFiltros]:checked").val(),
								userID: $(this).attr('pessoa')
							},
							success: function(response) {
								if (response.load){
									$( "#dialog-message" )
										.html(response.html)
										.dialog({
											title: response.title,
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

				} else {
					$("#divPrintInfo").hide();
				};
			}
		});
	});
	
	$( "#cmbPontuacao" ).change( function(){
		var val = $(this).val();
		if ( val == "" ) {
			$( "#lbltxtValorMaior" ).hide();
			$( "#txtValorMenor" ).val("").hide();
			$( "#txtValorMaior" ).val("").hide();
		} else if ( val == "entre" ) {
			$( "#lbltxtValorMaior" ).show();
			$( "#txtValorMenor" ).val("").show();
			$( "#txtValorMaior" ).val("").show();
		} else {
			$( "#lbltxtValorMaior" ).hide();
			$( "#txtValorMenor" ).val("").show();
			$( "#txtValorMaior" ).val("").hide();
		}
	});
	
	$('[name=filtros]').change( function() {
		botoesInit();
	});
	$('[name=optFiltros]').change( function() {
		var val = $(this).val();
		if ( val == "dons" ) {
			$("#lblcmbSearch").html("Dom:")
			$("#lblcmbPontuacao").html("Pontua&ccedil;&atilde;o:")
		} else {
			$("#lblcmbSearch").html("Minist&eacute;rio:")
			$("#lblcmbPontuacao").html("Nota:")
		}
		$('#tdLimpar').click();
	});

	//PREPARACAO DA TELA
	$('#tdLimpar').click(function() {
		botoesInit();
		$("#txtNomePessoa").val("");
		$("#cmbSearch").html("");
		loadComboSearch();
		$("#cmbPontuacao").val("").change();
	});

	$("#radio").buttonset();
	$("#tdLimpar").click();

});

function botoesInit(){
	$('#tdGerar').show();
	$('#tdLimpar').show();
	$("#divPrintInfo").html("").hide();
	$("#printFrame").attr('src','none.php?');
};

function loadComboSearch(){
	$.ajax({
		url: 'load.php',
		type: 'post',
		dataType: 'json',
		data: { 
			load: $("[name=optFiltros]:checked").val()
		},
		success: function(response) {
			if (response.load){
				$("#cmbSearch").html(response.html);
			};
		}
	});
};