$(document).ready(function () {
	$("#imgPrincipal").click(function (e) {
		e.preventDefault();
		$("#imagenprincipal").click();
	});

	$("#imagenprincipal").on('change', function (e) {
		var file = document.querySelector('#imagenprincipal').files[0];
		var aux = file.name.split(".");
		if (validar_extension(file.name)){
			if (aux[1] == "png" || aux[1] == "jpeg") {
				$("#imgPrin").show();
				$("#audiopregunta").hide();
				$("#videopregunta").hide();
				// var fileN = getBase64(file, "#imgPrin");
				getBase64(file, "#imgPrin");
			} else if (aux[1] == "mp3" || aux[1] == "mpeg") {
				$("#imgPrin").hide();
				$("#audiopregunta").show();
				$("#videopregunta").hide();
				getBase64(file, "#audiopregunta");
			} else {
				$("#imgPrin").hide();
				$("#audiopregunta").hide();
				$("#videopregunta").show();
				getBase64(file, "#videopregunta");
			}
			$("#guardar").prop("disabled", false);
			$("#filePincipal").hide();
			$("#filePincipal").html("");
		} else {
			$("#filePincipal").show();
			$("#filePincipal").html("Solo puedes subir archivos con extensión <b>png/jpg</b>, <b>mp3</b> o <b>mp4</b>");
			$("#guardar").prop("disabled", true);
		}
	});

	$(".incorrecta").click(function (e) {
		e.preventDefault();
		var num = $(this).data("i");
		$("#imgincorrecta"+num).click();
		abrir(num);
	});

	$("#imagenCorrecta").click(function (e) {
		e.preventDefault();
		$("#imgcorrecta").click();
	});

	$("#imgcorrecta").on('change', function (e) {
		var file = document.querySelector('#imgcorrecta').files[0];
		$("#imgcorrecta_texto").val(file.name);
		// var fileN = getBase64(file, "#imgPrin");
	});

	$("#imgcorrectV").click(function (e) {
		e.preventDefault();
		$("#fileV").hide();
		$("#fileV").html("");
		$("#imgcorrectaV").click();
	});

	$("#imgcorrectaV").on('change', function (e) {
		console.clear();
		var file = document.querySelector('#imgcorrectaV').files[0];
		$("#imgcorrecta_textoV").val(file.name);
	});

	$("#incorrectaF").click(function (e) {
		e.preventDefault();
		$("#fileF").hide();
		$("#fileF").html("");
		$("#imgincorrectaF").click();
	});

	$("#imgincorrectaF").on('change', function (e) {
		var file = document.querySelector('#imgincorrectaF').files[0];
		if (validar_extension(file.name)){
			$("#imgcorrecta_textoF").val(file.name);
			$("#extension_archivoF").val(file.type);
			$("#guardar").prop("disabled", false);
		} else {
			$("#fileF").show();
			$("#fileF").html("Solo puedes subir archivos con extensión <b>png/jpg</b>, <b>mp3</b> o <b>mp4</b>");
			$("#guardar").prop("disabled", true);
		}
	});

	$("#cancelar").click(function (e) {
		e.preventDefault();
		$('#formPregunta')[0].reset();
		var imagen = $("#imagen").val();
		$("#imgPrin").attr("src", imagen);
	});

	$("#tipo").change(function () {
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

	$("#formPregunta").validate({
		rules:{
			texto:{
				required: true
			},
			categoria:{
				required: true
			},
			tipo:{
				required: true
			},
			correcta:{
				required: "#correcta:visible"
			}
		},
		messages:{
			texto:{
				required : '*Este campo es requerido'
			},
			categoria:{
				required : '*Este campo es requerido'
			},
			tipo:{
				required : '*Este campo es requerido'
			},
			correcta:{
				required : '*Este campo es requerido'
			}
		},
		errorPlacement : function(error, element) {
			error.appendTo(element.parents('td').children('span.error'));
		},
		submitHandler: function() {
			var data = new FormData($("#formPregunta")[0]);
			$.ajax({
				type: 'POST',
				url: context+'admin/saveQuestion',
				data: data,
				// dataType: 'json',
				contentType:false,
                processData:false,
                cache:false,
                async: true,
                success: function (resp) {
                	// console.log(resp)
                	if (resp.error) {
                		$('#formPregunta')[0].reset();
                		$('#mensaje').removeClass("alert-success");
						$('#mensaje').addClass("alert-warning");
						$('#mensaje').show("swing");
						$('#mensaje').html('<b>' + resp.error + '</b>');
                	} else {
                		$('#formPregunta')[0].reset();
                		var imagen = $("#imagen").val();
                		$("#imgPrin").attr("src", imagen);
                		$('#mensaje').addClass("alert-success");
						$('#mensaje').removeClass("alert-warning");
						$('#mensaje').show("swing");
						$('#mensaje').html('<b>' + resp.mensaje + '</b>');
						setTimeout(function function_name(argument) {
							history.back();
						}, 2500);
                	}
                }
			});
		}
	});
})

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

function abrir(num) {
	$("#imgincorrecta"+num).on('change', function (e) {
		var file = document.querySelector("#imgincorrecta"+num).files[0];
		$("#imgincorrecta_texto"+num).val(file.name);
		// var fileN = getBase64(file, "", "#imgrespin"+num);
	});
}

function validar_extension(tipo) {
	var aux = tipo.split(".");
	tipo = aux[1];
	if (tipo == "png" || tipo == "jpeg" || tipo == "mp3" || tipo == "mp4" || tipo == "mpeg") {
		return true;
	} else {
		return false;
	}
}