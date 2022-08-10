$(document).ready(function () {
	if ($("#tipo").val().trim() === '') {
		$(".optionmultiple").hide();
		$(".vf").hide();
	} else if ($("#tipo").val() == 1) {
		$(".optionmultiple").show();
		$(".vf").hide();
	} else {
		$(".optionmultiple").hide();
		$(".vf").show();
	}

	ocultarPreviews();

	$("#tipo").change(function () {
		mostrarPreviewOriginal();
		if ($(this).val().trim() === "") {
			$(".optionmultiple").hide();
			$(".vf").hide();
		} else if ($(this).val() == 1) {
			$(".optionmultiple").show();
			$(".vf").hide();
		} else {
			$(".optionmultiple").hide();
			$(".vf").show();
		}
	});

	$(".subir").click(function (e) {
		e.preventDefault();
		var num = $(this).data("num");
		$("#imagen"+num).click();
		abrir(num);
	});

	$("#guardar").click(function (e) {
		e.preventDefault();
		var estatus = true;
		for (var i = 2; i <=7; i++) {
			if ($("#img_texto"+i).is(':visible')) {
				if ($("#texto_default"+i).val() == "default") {
					$("#error"+i).show("swing");
					$("#error"+i).html('<b>Selecciona una imagen</b>')
					estatus = false;
				} else {
					$("#error"+i).hide("swing");
					$("#error"+i).html('')
				}
			}
		}
		if (estatus) {
			// console.log("Continua")
			var data = new FormData($("#formPregunta")[0]);
			$.ajax({
				type: "POST",
				url: context+'admin/updateQuestion',
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
	            		$('#mensaje').addClass("alert-success");
						$('#mensaje').removeClass("alert-warning");
						$('#mensaje').show("swing");
						$('#mensaje').html('<b>' + resp.mensaje + '</b>');
	            	}

	            	setTimeout(function () {
	            		$('#mensaje').hide();
	            		$('#mensaje').html("");
	            	}, 3000);
	            }
			});
		}
	});

	$("#cancelar").click(function (e) {
		e.preventDefault();
		window.history.back();
	});
})

function ocultarPreviews() {
	for (var i = 2; i <= 7; i++) {
		$("#preview_carga"+i).hide();
	}
}

function mostrarPreviewOriginal() {
	var imagen = $("#imgDefault").val();
	for (var i = 2; i <= 7; i++) {
		$("#preview"+i).attr("src", imagen);
		// $("#preview_carga"+i).hide();
		$("#imagen"+i).val('');
		$("#respuesta"+i).val('');
		$("#texto_default"+i).val("default");
	}
}

function abrir(numero) {
	// console.log(numero)
	$("#imagen"+numero).change(function () {
		if (numero == 1) {
			$("#video"+numero).hide();
			$("#audio"+numero).hide();
			$("#preview"+numero).hide();
		}
		var file = document.querySelector("#imagen"+numero).files[0];
		var aux = file.name.split(".");
		if (validar_extension(file.name, numero)){
			if (aux[1].toLowerCase() == "png" || aux[1].toLowerCase() == "jpeg") {
				$("#preview_carga"+numero).show();
				$("#preview_audio"+numero).hide();
				$("#preview_video"+numero).hide();
				getBase64(file, "#preview_carga"+numero);
			} else if (aux[1].toLowerCase() == "mp3") {
				$("#preview_carga"+numero).hide();
				$("#preview_audio"+numero).show();
				$("#preview_video"+numero).hide();
				getBase64(file, "#preview_audio"+numero);
			} else if (aux[1].toLowerCase() == "mp4") {
				$("#preview_carga"+numero).css("display","none");
				$("#preview_audio"+numero).hide();
				$("#preview_video"+numero).show();
				getBase64(file, "#preview_video"+numero);
			}

			if (numero != 1) {
				$("#img_texto"+numero).val(file.name);
			}

			$("#texto_default"+numero).val("");
			$("#error"+numero).hide();
			$("#error"+numero).html('');

			$("#guardar").prop("disabled", false);
			$("#filePrincipal").hide();
			$("#filePrincipal").html("");
		} else {
			$("#preview"+numero).show();

			if (numero == 1) {
				$("#filePrincipal").show();
				$("#filePrincipal").html("Solo puedes subir archivos con extensión <b>png/jpg</b>, <b>mp3</b> o <b>mp4</b>");
			} else {
				$("#error"+numero).show();
				$("#error"+numero).html("Solo puedes subir imágenes");
			}
			$("#guardar").prop("disabled", true);
		}
	});
}

function getBase64(file, target) {
	var reader = new FileReader();
	reader.readAsDataURL(file);
	reader.onload = function () {
		$(target).attr("src", reader.result);
	};
	reader.onerror = function (error) {
		console.log('Error: ', error);
	};
	return reader.result;
}

function validar_extension(tipo, numero) {
	var aux = tipo.split(".");
	tipo = aux[1].toLowerCase();
	// console.log(tipo)
	if (numero >= 1 || numero <= 5) {
		if (tipo == "png" || tipo == "jpeg" || tipo == "mp3" || tipo == "mp4") {
			return true;
		} else {
			return false;
		}
	} else {
		if (tipo == "png" || tipo == "jpeg") {
			return true;
		} else {
			return false;
		}
	}
}