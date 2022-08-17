$(document).ready(function () {
	if ($("#modulo").val().trim() === '') {
		$("#leccion").html('<option value="">Todos las lecciones</option>');
	}

	if ($("#mod_id").val() != "" && $("#mod_id").val() != "a") {
		cargar_lecciones($("#mod_id").val());
	} else {
		$("#leccion").html('<option value="">Todos las lecciones</option>');
	}

	$("#modulo").change(function () {
		$("#mensaje").hide();
		$("#mensaje").html("");
		var modulo = $(this).val();
		if (modulo.trim() === '') {
			$("#leccion").html('<option value="">Todos las lecciones</option>');
		} else {
			cargar_lecciones(modulo);
		}
	});

	$("#archivo").click(function (e) {
		e.preventDefault();
		$("#file").click();
	});

	$("#file").change(function (e) {
		var file = document.querySelector('#file').files[0];

		$("#mensaje-archivo").hide();
		$("#mensaje-archivo").html("");
		if (file.type == "application/x-zip-compressed" || file.type == "application/zip") {
			$("#guardar").prop("disabled", false);
			$("#mensaje-archivo").hide();
			$("#mensaje-archivo").html("");

			$("#archivo_texto").val(file.name);
		} else {
			$("#mensaje-archivo").show();
			$("#mensaje-archivo").html("Solo puedes subir archivos con extensión <b>zip</b>");
			$("#archivo_texto").val("");
			$("#guardar").prop("disabled", true);
		}
	});

	$("#formObjeto").validate({
		rules:{
			seccion:{
				required: true
			},
			modulo:{
				required: true
			},
			leccion:{
				required: true
			},
			file:{
				required: true
			},
			estatus:{
				required: true
			}
		},
		messages:{
			seccion:{
				required : '*Este campo es requerido'
			},
			modulo:{
				required : '*Este campo es requerido'
			},
			leccion:{
				required : '*Este campo es requerido'
			},
			file:{
				required : '*Este campo es requerido'
			},
			estatus:{
				required: "*Este campo es requerido"
			}
		},
		errorPlacement : function(error, element) {
			error.appendTo(element.parents('td').children('span.error'));
		},
		submitHandler: function() {
			var data = new FormData($("#formObjeto")[0]);
			$.ajax({
				type: 'POST',
				url: context+'admin/saveObjeto',
				data: data,
				dataType: 'json',
				contentType:false,
                processData:false,
                cache:false,
                async: true,
                success: function (resp) {
                	if (resp.error) {
                		$('#formObjeto')[0].reset();
                		$('#mensaje').removeClass("alert-success");
						$('#mensaje').addClass("alert-warning");
						$('#mensaje').show("swing");
						$('#mensaje').html('<b>' + resp.error + '</b>');
                	} else {
                		$('#formObjeto')[0].reset();
                		var imagen = $("#imagen").val();
                		$("#imgPrin").attr("src", imagen);
                		$('#mensaje').addClass("alert-success");
						$('#mensaje').removeClass("alert-warning");
						$('#mensaje').show("swing");
						$('#mensaje').html('<b>' + resp.mensaje + '</b>');
						setTimeout(function function_name(argument) {
							window.location = window.location.href+'?eraseCache=true';
						}, 2500);
                	}
                }
			});
		}
	});
});

function cargar_lecciones(modulo) {
	$.ajax({
		type: 'POST',
		url: context+"admin/obtenerLecciones",
		data: {clave: modulo},
		dataType: 'json',
		success: function (resp) {
			$("#leccion").html(resp.contenido);
			if ($("lec_id").val() != "" && $("lec_id").val() != "b" && $("#lec_id").val() != "undefined") {
				$("#leccion").val($("#lec_id").val());
			}
		}
	});
}