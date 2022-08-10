$(document).ready(function () {
	if ($("#modulo").val().trim() === '') {
		$("#leccion").html('<option value="">Selecciona un módulo</option>');
	}

	$("#modulo").change(function () {
		$("#tabla").dataTable().fnDestroy();
		var modulo = $(this).val();
		if (modulo.trim() === '') {
			$("#leccion").html('<option value="">Todos las lecciones</option>');
		} else {
			$.ajax({
				type: 'POST',
				url: context+"admin/obtenerLecciones",
				data: {clave: modulo},
				dataType: 'json',
				success: function (resp) {
					$("#leccion").html(resp.contenido);
				}
			});
		}
	});

	$("#leccion").change(function () {
		if ($(this).val() !== '') {
			var modulo = $("#modulo").val();
			var leccion = $(this).val();
			var texto_m = $("#modulo option:selected").text();
			var texto_l = $("#leccion option:selected").text();
			$.ajax({
				type: "POST",
				url: context+"admin/verificarevaluacion",
				data: {modulo: modulo, leccion: leccion},
				success: function (resp) {
					// console.log(resp)
					if (resp.mensaje) {
						$("#guardar").prop("disabled", true);
						$("#mensaje").show("swing");
						$('#mensaje').removeClass("alert-success");
						$('#mensaje').addClass("alert-warning");
						var enlaces = '';
						var texto = '';
						$.each(resp.urls, function (e) {
							if (e == 0) {
								texto = 'tiene registrada la siguiente evaluación<br>';
								enlaces='<strong><a href="'+resp.urls[e].url+'">'+resp.urls[e].nombre+'</a></strong>';
							} else {
								texto = 'tienen registradas las siguientes evaluaciones: <br>';
								enlaces+=', <strong><a href="'+resp.urls[e].url+'">'+resp.urls[e].nombre+'</a></strong>';
							}
						});
						$("#mensaje").html('El módulo <b>'+texto_m+'</b> y la lección <b>'+texto_l+'</b> '+texto+enlaces);
					} else {
						$("#mensaje").hide();
						$("#mensaje").html("");
						$('#mensaje').addClass("alert-success");
						$('#mensaje').removeClass("alert-warning");
						$("#guardar").prop("disabled", false);
					}
				}
			});
		}
	});

	$("#formEvaluacion").validate({
		rules:{
			nombre:{
				required: true
			},
			modulo:{
				required: true
			},
			leccion:{
				required: true
			},
			preguntas:{
				required: true
			}
		},
		messages:{
			nombre:{
				required : '*Este campo es requerido'
			},
			modulo:{
				required : '*Este campo es requerido'
			},
			leccion:{
				required : '*Este campo es requerido'
			},
			preguntas:{
				required : '*Este campo es requerido'
			},
		},
		errorPlacement : function(error, element) {
			error.appendTo(element.parents('td').children('span.error'));
		},
		submitHandler: function() {
			// console.log("Ajax")
			var data = $("#formEvaluacion").serialize();
			$.ajax({
				type: 'POST',
				url: context+'admin/saveAddEvaluacion',
				data: data,
				dataType: 'json',
                success: function (resp) {
                	// console.log(resp)
                	if (resp.error) {
                		$('#mensaje').removeClass("alert-success");
						$('#mensaje').addClass("alert-warning");
						$('#mensaje').show("swing");
						$('#mensaje').html('<b>' + resp.error + '</b>');
                	} else {
                		$('#formEvaluacion')[0].reset();
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