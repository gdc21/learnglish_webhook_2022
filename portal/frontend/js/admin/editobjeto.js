$(document).ready(function () {
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

	$("#formObjetoUp").validate({
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
			var confirma = confirm("¿Est\u00E1s seguro de realizar los cambios?");
			if (confirma) {
				var data = new FormData($("#formObjetoUp")[0]);
				data.set('opcion', 0);
				$.ajax({
					type: 'POST',
					url: context+'admin/updateObjeto',
					data: data,
					// dataType: 'json',
					contentType:false,
	                processData:false,
	                cache:false,
	                async: true,
	                success: function (resp) {

	                	if (resp.error) {
	                		// $('#formObjetoUp')[0].reset();
	                		$('#mensaje').removeClass("alert-success");
							$('#mensaje').addClass("alert-warning");
							$('#mensaje').show("swing");
							$('#mensaje').html('<b>' + resp.error + '</b>');
	                	} else {
	                		// $('#formObjetoUp')[0].reset();
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
		}
	});

	$(".audio").click(function (e) {
		e.preventDefault();
		var lg = $(this).data("lg");
		$("#audio_"+lg).click();

		$("#audio_"+lg).change(function (e) {
			$("#play_"+lg).hide();
			var file = document.querySelector("#audio_"+lg).files[0];
			var aux = file.name.split(".");
			if (aux[1] != "mp3") {
				console.log("Solo se permiten archivos mp3");
				$("#play_"+lg).hide();
			} else {
				getBase64(file, "#play_"+lg);
				$("#play_"+lg).show();
			}
		});
	});

	$(".imgInst").click(function (e) {
		e.preventDefault();
		$("#imagen").click();

		$("#imagen").change(function (e) {
			var file = document.querySelector("#imagen").files[0];
			var aux = file.name.split(".");
			if (aux[1].toLowerCase() == "png" || aux[1].toLowerCase() == "jpg" || aux[1].toLowerCase() == "jpeg") {
				getBase64(file, "#preview_img");
			} else {
				console.log("Solo se permiten archivos con formato de imagen ["+aux[1]+"]");
			}
		});
	});
});

function eliminar_audio(valor, opc, lg) {
	var confirma = confirm("¿Est\u00E1s seguro de eliminar el audio?");
	if (confirma) {
		var data = {opcion:opc,objeto:valor,lg:lg}
		$.ajax({
			type: 'POST',
			url: context+'admin/updateObjeto',
			data: data,
			dataType: 'json',
	        success: function (resp) {
	        	if (lg == 'es') {
	        		$("#dlt_audio_es").hide();
	        		$("#rep_audio_es").hide();
	        	} else if (lg == "en") {
	        		$("#dlt_audio_en").hide();
	        		$("#rep_audio_en").hide();
	        	} else {
	        		$("#dlt_img_inst").hide();
	        		$("#preview_img").attr("src", "");
	        	}

	        	$('#mensaje').addClass("alert-success");
				$('#mensaje').removeClass("alert-warning");
				$('#mensaje').show("swing");
				$('#mensaje').html('<b>' + resp.mensaje + '</b>');

	        	setTimeout(function () {
					$("#mensaje").hide();
					$("#mensaje").html("");
				}, 2500);
	        }
		});
	}
}