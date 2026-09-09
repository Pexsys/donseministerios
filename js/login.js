/*
*/
$(document).ready(function() {

	//FORM
	$("#frmLogin").keypress(function (e){
		var code = (e.keyCode ? e.keyCode : e.which);
		if ( code == 13 ) {
			 $('#submitButton').click();
		};
  });

	//SUBMIT-BOTTOM
	$('#submitButton').click(function() {
		$.ajax({
			url: 'logincheck.php',
			type: 'post',
			dataType: 'json',
			data: { 
				txtLoginUser : $('#txtLoginUser').val(),
				txtLoginPass : $.sha1($('#txtLoginPass').val())
			},
			success: function(response) {
				if (response.login) {
					window.location.replace(response.page);
				} else {
					alert(response.page);
				}
			}
		});
	});

});