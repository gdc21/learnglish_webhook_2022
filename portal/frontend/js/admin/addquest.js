/**
 * 
 */
$(function() {
	$('#tipo').change(function() {
		$(".noTF").toggle();
	});
	$('.addQuest').keyup(function() {
		if ($(this).val().length > 0) {
			$("#" + $(this).data('kind') + "IMG").prop("disabled", true);
		} else {
			$("#" + $(this).data('kind') + "IMG").prop("disabled", false);
		}
	});
	$('.addQuest2').change(function() {
		if ($(this).val().length > 0) {
			$("#" + $(this).data('kind') + "TXT").prop("disabled", true);
			$("#" + $(this).data('kind') + '_clearBTN').show();
		} else {
			$("#" + $(this).data('kind') + "TXT").prop("disabled", false);
		}
	});
	$('.clearBTN').click(function() {
		var control = $("#" + $(this).data('kind') + "IMG");
		control.replaceWith(control.val('').clone(true));
		$("#" + $(this).data('kind') + "TXT").prop("disabled", false);
		$("#" + this.id).hide();
	});
	jQuery.validator.setDefaults({
		debug : true,
		success : "valid"
	});
	$.validator.addMethod('respuestas', function(value, element, param) {
		// Your Validation Here

		return isValid; // return bool here if valid or not.
	}, '*Este campo es requerido');

	jQuery.validator
			.addMethod(
					"require_from_groupx",
					function(value, element, options) {
						var elemento = $(element).data("kind"), selected = $(
								'#tipo').val(), elementoTXT = $(
								'#' + elemento + 'TXT').val(), elementoIMG = $(
								'#' + elemento + 'IMG').val();

						// console.log(elemento);
						// console.log(selected);
						// console.log(value);
						// console.log(options);
						// console.log(elementoTXT+' - '+elementoIMG);
						if (selected == 2
								&& (elemento == "incorrecta2" || elemento == "incorrecta3")) {
							return true;
						} else {
							if (elementoTXT != "" || elementoIMG != "") {
								// if(value.length > 0 || value != ""){
								return true;
							} else
								return false;
						}

					}, "*Este campo es requerido");

	$('#preguntaN').validate(
			{
				groups : {
					tin : "preguntaTXT preguntaIMG"
				},
				rules : {
					preguntaTXT : {
						require_from_group : [ 1, ".input_pregunta" ]
					},
					preguntaIMG : {
						require_from_group : [ 1, ".input_pregunta" ]
					},

					correctaTXT : {
						require_from_groupx : [ 1, ".input_correcta" ]
					},
					correctaIMG : {
						require_from_groupx : [ 1, ".input_correcta" ]
					},

					incorrecta1TXT : {
						require_from_groupx : [ 1, ".input_incorrecta1" ]
					},
					incorrecta1IMG : {
						require_from_groupx : [ 1, ".input_incorrecta1" ]
					},
					incorrecta2TXT : {
						require_from_groupx : [ 1, ".input_incorrecta2" ]
					},
					incorrecta2IMG : {
						require_from_groupx : [ 1, ".input_incorrecta2" ]
					},
					incorrecta3TXT : {
						require_from_groupx : [ 1, ".input_incorrecta3" ]
					},
					incorrecta3IMG : {
						require_from_groupx : [ 1, ".input_incorrecta3" ]
					}
				},
				messages : {
				// preguntaTXT: { require_from_group: '*Este campo es
				// requerido'
				// },
				// preguntaIMG: { require_from_group: '*Este campo es
				// requerido'
				// },
				},
				errorPlacement : function(error, element) {
					error
							.appendTo(element.parents('td').children(
									'span.error'));
				},
				submitHandler : function(form) {
					var parameters = new FormData($(form)[0]), id = $(
							"#NewPreg").attr('eval');
					/*
					 * $.ajax({ type: 'POST', url: '../savePregunta', data:
					 * parameters, dataType : 'json', contentType:false,
					 * processData:false, cache:false }) .done(function
					 * (response) { console.log(response); if (response.success ==
					 * 'success') { alert('success'); } else { alert('fail'); }
					 * }); return false; //alert('listo'); //return;
					 */
					var data = getInfoAjaxFiles('savePregunta/' + id,
							parameters, "admin"), titulo = 'Nueva Pregunta';
					// mns = data.error || data.mensaje.msg;

					if (data.error) {
						$('#mensaje').removeClass("alert-success");
						$('#mensaje').addClass("alert-warning");
						$('#mensaje').show("swing");
						$('#mensaje').html('<b>' + data.error + '</b>');
					} else {
						$('#mensaje').addClass("alert-success");
						$('#mensaje').removeClass("alert-warning");
						$('#mensaje').show("swing");
						$('#mensaje').html('<b>' + data.mensaje.msg + '</b>');
						context = context + 'admin/preguntas/' + id;
						setTimeout("location.href = context;", 3000);
					}
				}
			});
});