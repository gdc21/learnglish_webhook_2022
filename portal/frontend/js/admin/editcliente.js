$(document).ready(function () {
	$("#actualizar").on('click', function (e) {
		e.preventDefault();
		var confirma = confirm("¿Est\u00E1s seguro de realizar los cambios?");
		if (confirma) {
			var data = new FormData($('#formCliente')[0]);
			if($('#password').val()!='') {
				data.set('pass', data.get('password'));
				data.append('password',CryptoJS.SHA1($('#password').val()).toString());
			}
			// console.log(data);
			$.ajax({
				type: 'POST',
				url: context+'admin/updateCliente',
				data: data,
				dataType: 'json',
				contentType:false,
                processData:false,
                cache:false,
                async: true,
				success: function (resp) {
					if (resp.error) {
                		$('#mensaje').removeClass("alert-success");
						$('#mensaje').addClass("alert-warning");
						$('#mensaje').show("swing");
						$('#mensaje').html('<b>' + resp.error + '</b>');
                	} else {
                		$('#mensaje').addClass("alert-success");
						$('#mensaje').removeClass("alert-warning");
						$('#mensaje').show("swing");
						$('#mensaje').html('<b>' + resp.mensaje + '</b>');
                	}
				}
			});
		}
	})
})

function aceptNum(evt){
	var nav4 = window.Event ? true : false;
	var key = nav4 ? evt.which : evt.keyCode;
	return (key <= 13 || (key>= 48 && key <= 57));
}