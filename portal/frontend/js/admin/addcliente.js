$(document).ready(function () {
	$("#formCliente").validate({
		rules:{
			nombre:{
				required: true
			},
			contacto:{
				required: true
			},
			email:{
				required: true,
				email: true
			},
			usuario:{
				required: true
			},
			password:{
				required: true
			},
			telefono:{
				required: true
			},
			direccion:{
				required : true
			}
		},
		messages:{
			nombre:{
				required : '*Este campo es requerido'
			},
			contacto:{
				required : '*Este campo es requerido'
			},
			email:{
				required : '*Este campo es requerido',
				email: "Ingresa un correo valido"
			},
			usuario:{
				required : '*Este campo es requerido'
			},
			password:{
				required : '*Este campo es requerido',
				minlength: 'Longitud mínima de 5 caracteres'
			},
			telefono:{
				required : '*Este campo es requerido'
			},
			direccion:{
				required : '*Este campo es requerido'
			}
		},
		errorPlacement : function(error, element) {
			error.appendTo(element.parents('td').children('span.error'));
		},
		submitHandler: function() {
			var data = new FormData($('#formCliente')[0]);
			if($('#password').val()!='') {
				data.set('pass', data.get('password'));
				data.append('password',CryptoJS.SHA1($('#password').val()).toString());
			}
			// console.log(data);
			$.ajax({
				type: 'POST',
				url: context+'admin/saveCliente',
				data: data,
				dataType: 'json',
				contentType:false,
                processData:false,
                cache:false,
                async: true,
                success: function (resp) {
                	// console.log(resp)
                	if (resp.error) {
                		$('#mensaje').removeClass("alert-success");
						$('#mensaje').addClass("alert-warning");
						$('#mensaje').show("swing");
						$('#mensaje').html('<b>' + resp.error + '</b>');
                	} else {
                		$('#formCliente')[0].reset();
                		$('#mensaje').addClass("alert-success");
						$('#mensaje').removeClass("alert-warning");
						$('#mensaje').show("swing");
						$('#mensaje').html('<b>' + resp.mensaje + '</b>');
                	}
                }
			});
		}
	});
});

function aceptNum(evt){
	var nav4 = window.Event ? true : false;
	var key = nav4 ? evt.which : evt.keyCode;
	return (key <= 13 || (key>= 48 && key <= 57));
}