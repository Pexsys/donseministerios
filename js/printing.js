/*
*/
$(document).ready(function() {

	$('[name=filtros]').change( function() {
		botoesInit();
	});
	
	$("#cmbRegiao").change( function() {
		loadCaravana();
		loadDiscipulo();
	});
	
	$("#cmbCaravana").change( function() {
		loadDiscipulo();
	});
	
	$('#tdGerar').click(function() {
		$('[name=rowRegiao]').unbind('click');
		$('[name=rowCaravana]').unbind('click');
		$('[name=print]').unbind('click');

		$.ajax({
			url: 'load.php',
			type: 'post',
			dataType: 'json',
			data: { 
				load: "listaresultados",
				regiao: $("#cmbRegiao").val(),
				caravana: $("#cmbCaravana").val(),
				discipulo: $("#cmbDiscipulo").val()
			},
			success: function(response) {
				if (response.load){
					$("#divPrintInfo").html(response.html).show();
					
					$('[name=rowRegiao]').bind('click', function() {
						var regiao = $(this).attr('regiao');
						var elements = $('[regiao='+regiao+']').filter(function (index) {
							return index > 0;
						});
						if ( $(this).attr('visual') == 'aberto') {
							$(this).attr('visual','');
							elements.each(function(){
								$(this).attr('visual','').hide();
							});
						} else {
							$(this).attr('visual','aberto');
							elements.each(function(){
								$(this).attr('visual','aberto').show();
							});
						};
					});
					
					$('[name=rowCaravana]').bind('click', function() {
						var caravana = $(this).attr('caravana');
						var elements = $('[caravana='+caravana+']').filter(function (index) {
							return index > 0;
						});
						if ( $(this).attr('visual') == 'aberto') {
							$(this).attr('visual','');
							elements.each(function(){
								$(this).attr('visual','').hide();
							});
						} else {
							$(this).attr('visual','aberto');
							elements.each(function(){
								$(this).attr('visual','aberto').show();
							});
						};
					});
					
					$('[name=print]').bind('click', function() {
						$("#printFrame").attr('src','rsdons.php?print=yes&userID='+$(this).attr('pessoa'));
					});

					$("#tdImprimir").show();
				};
			}
		});
	});

	$('#tdImprimir').click(function() {
		var pessoa = "";
		$('[name=print]').each(function() {
			pessoa += ","+$(this).attr('pessoa');
		});
		$("#printFrame").attr('src','rsdons.php?print=yes&pool='+pessoa);
	});
	
	$('#tdLimpar').click(function() {
		botoesInit();
		$("#cmbRegiao").html("");
		$("#cmbCaravana").html("");
		$("#cmbDiscipulo").html("");
		loadRegiao();
		loadCaravana();
		loadDiscipulo();
	});
	
	$('#tdLimpar').click();
	
});

function botoesInit(){
	$('#tdGerar').show();
	$('#tdImprimir').hide();
	$('#tdLimpar').show();
	$("#divPrintInfo").html("").hide();
	$("#printFrame").attr('src','none.php?');
};

function loadRegiao(){
	$.ajax({
		url: 'load.php',
		type: 'post',
		dataType: 'json',
		data: { 
			load: "regiao"
		},
		success: function(response) {
			if (response.load){
				$("#cmbRegiao").html(response.html);
			};
		}
	});
};

function loadCaravana(){
	$.ajax({
		url: 'load.php',
		type: 'post',
		dataType: 'json',
		data: { 
			load: "caravana",
			regiao: $("#cmbRegiao").val()
		},
		success: function(response) {
			if (response.load){
				$("#cmbCaravana").html(response.html);
			};
		}
	});
};

function loadDiscipulo(){
	$.ajax({
		url: 'load.php',
		type: 'post',
		dataType: 'json',
		data: { 
			load: "discipulo",
			regiao: $("#cmbRegiao").val(),
			caravana: $("#cmbCaravana").val()
		},
		success: function(response) {
			if (response.load){
				$("#cmbDiscipulo").html(response.html);
			};
		}
	});
};
