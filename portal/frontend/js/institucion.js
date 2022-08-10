$(document).ready(function () {
	$.validator.addMethod("valueNotEquals", function(value, element, arg){
		return arg !== value;
	}, "*Este campo es requerido");

	$("#nuevaInstitucion").validate({
		rules:{
			nombre:{
				required: true
			},
			/*logotipo:{
				required: true,
				accept: "image/*",
				extension: "png|jpg"
			},*/
			nameCorto:{
				required: true
			},
			pais:{
				required: true
			},
			cliente:{
				required: true
			},
			tipo:{
				required: true
			},
			vigencia:{
				required: true
			},
			lote:{
				required: true
			},
			usuario:{
				required: true
			},
			cct:{
				required: true
			},
			password:{
				required: true
			}
		},
		messages:{
			nombre:{
				required : '*Este campo es requerido'
			},
			/*logotipo:{
				required: '*La imagen principal es requerida',
				accept: '*Formato de imagen no válido',
				extension: '*La extensión no es valida (sólo: imágenes)'
			},*/
			nameCorto:{
				required : '*Este campo es requerido'
			},
			pais:{
				required : '*Este campo es requerido'
			},
			cliente:{
				required : '*Este campo es requerido'
			},
			tipo:{
				required : '*Este campo es requerido'
			},
			vigencia:{
				required : '*Este campo es requerido'
			},
			lote:{
				required : '*Este campo es requerido'
			},
			usuario:{
				required : '*Este campo es requerido'
			},
			cct:{
				required : '*Este campo es requerido'
			},
			password:{
				required : '*Este campo es requerido',
				minlength: 'Longitud mínima de 5 caracteres'
			}
		},
		errorPlacement : function(error, element) {
			error.appendTo(element.parents('td').children('span.error'));
		},
		submitHandler: function() {
			var parameters = new FormData($('#nuevaInstitucion')[0]);
			if($('#password').val()!='') {
				parameters.set('pass', parameters.get('password'));
				parameters.append('password',CryptoJS.SHA1($('#password').val()).toString());
			}
			$.ajax({
				type: 'POST',
				url: context+'admin/saveInstitucion',
				data: parameters,
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
                		$('#nuevaInstitucion')[0].reset();
                		$('#mensaje').addClass("alert-success");
						$('#mensaje').removeClass("alert-warning");
						$('#mensaje').show("swing");
						$('#mensaje').html('<b>' + resp.mensaje + '</b>');
                	}
                }
			})
		}
	});

	$("#actualizar").on('click', function (e) {
		e.preventDefault();
		if ($("#cliente").val() == "") {
			$("#mensaje").css({"background": "#ff0000", "color": "#fff", "font-weight": "bold"});
			$("#mensaje").toggle("swing");
			$("#mensaje").html("Selecciona un cliente");
		} else {
			$("#mensaje").hide();
			$("#mensaje").html("");
			$("#mensaje").css({"background": "#dff0d8", "color": "#3c763d"});
		
			var parameters = new FormData($('#upInstitucion')[0]);
			if($('#password').val()!='') {
				parameters.set('pass', parameters.get('password'));
				parameters.append('password',CryptoJS.SHA1($('#password').val()).toString());
			}
			$.ajax({
				type: 'POST',
				url: context+'admin/updateInstitucion',
				data: parameters,
				dataType: 'json',
				contentType:false,
	            processData:false,
	            cache:false,
	            async: true,
	            success: function (resp) {
	            	console.log(resp)
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
			})
		}
	});

	$("#tabla").DataTable({
		searching: true,
		paging: true,
		"language": {
			"paginate": {
				"next": "Siguiente",
				"previous": "Anterior"
			},
			"info": "Mostrando _START_ de _END_",
			"search": "Buscar"
		}
	});
});

function eliminar(id) {
	var confirma = confirm("¿Est\u00E1s seguro de eliminar este registro?");
	if (confirma) {
		// console.log("Eliminado")
		$.ajax({
			type: 'POST',
			url: context+'admin/deleteInstitucion',
			data: {id: id},
			// dataType: 'json',
			success: function(resp) {
				console.log(resp)
				if (resp.error) {
            		alert(resp.error);
            	} else {
            		alert(resp.mensaje);
            		location.reload();
            	}
			}
		});
	} else {
		console.log("Error")
	}
}

function modulos(id, clave) {
	var accion = "";
	var institucion = $("#idinstitucion").val();
	if($(".modulo"+id).is(":checked")){
		// console.log("Checado")
		accion = "registro";
	} else {
		accion = "eliminar";
		// console.log("Sin checar")
	}

	var data = {
		modulo: id,
		institucion: institucion,
		clave: clave,
		accion: accion
	};

	$.ajax({
		type: "POST",
		data: data,
		url: context+"admin/accionModulos",
		success: function (resp) {
			console.log(resp)
		}
	});
}

function aceptNum(evt){
	var nav4 = window.Event ? true : false;
	var key = nav4 ? evt.which : evt.keyCode;
	return (key <= 13 || (key>= 48 && key <= 57));
}