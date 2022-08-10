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
		$("#" + $(this).data('kind') + "IMG").prop("disabled", false);
		$(".displayIMG_" + $(this).data('kind')).html("");
		$("#" + this.id).hide();
	});

	$.validator.addMethod('respuestas', function(value, element, param) {
		// Your Validation Here

		return isValid; // return bool here if valid or not.
	}, '*Este campo es requerido');

	jQuery.validator
			.addMethod(
					"require_from_groupx",
					function(value, element, options) {
						var elemento = $(element).data("kind");
						var selected = $('#tipo').val();
						elementoTXT = $('#' + elemento + 'TXT').val(),
								elementoIMG = $('#' + elemento + 'IMG').val();
						imagen = $('#IMG_' + elemento).length;
						// console.log(elemento);
						// console.log(imagen);
						// console.log('#IMG_'+elemento);
						// console.log(selected);
						if (selected == 2
								&& (elemento == "incorrecta2" || elemento == "incorrecta3")) {
							return true;
						} else {
							if ((elementoTXT != "" && elementoIMG != "")
									|| (elementoTXT == "" && elementoIMG == "" && imagen <= 0)) {
								// if(value.length > 0 || value != ""){

								return false;
							} else {
								return true;
							}
						}

					},
					"*Este campo es requerido y no se pueden cargar texto e imagen");

	$('#preguntaN')
			.validate(
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
						// requerido' },
						// preguntaIMG: { require_from_group: '*Este campo es
						// requerido' },
						},
						errorPlacement : function(error, element) {
							error.appendTo(element.parents('td').children(
									'span.error'));
						},
						submitHandler : function(form) {
							var parameters = new FormData($(form)[0]), id = $(
									"#NewPreg").attr('eval');
							parametros = {
								id_preg : id,
								preguntaTXT : $("#preguntaTXT").val(),
								preguntaIMG : $("#preguntaIMG").val(),
								tipo : $("#tipo").val(),
								correcta_ID : $("#correctaTXT").attr('data-id'),
								correctaTXT : $("#correctaTXT").val(),
								correctaIMG : $("#correctaIMG").val(),
								incorrecta1_ID : $("#incorrecta1TXT").attr(
										'data-id'),
								incorrecta1TXT : $("#incorrecta1TXT").val(),
								incorrecta1IMG : $("#incorrecta1IMG").val(),
								incorrecta2_ID : $("#incorrecta2TXT").attr(
										'data-id'),
								incorrecta2TXT : $("#incorrecta2TXT").val(),
								incorrecta2IMG : $("#incorrecta2IMG").val(),
								incorrecta3_ID : $("#incorrecta3TXT").attr(
										'data-id'),
								incorrecta3TXT : $("#incorrecta3TXT").val(),
								incorrecta3IMG : $("#incorrecta3IMG").val(),
								inc_IMG1 : $('.displayIMG_incorrecta1').find(
										'img').length > 0 ? 1 : 0,
								inc_IMG2 : $('.displayIMG_incorrecta2').find(
										'img').length > 0 ? 1 : 0,
								inc_IMG3 : $('.displayIMG_incorrecta3').find(
										'img').length > 0 ? 1 : 0,
								correcta_IMG : $('.displayIMG_correcta').find(
										'img').length > 0 ? 1 : 0
							};
							// console.log(parametros);
							// return false;
							var data = getInfoAjaxFiles('updatePregunta/' + id,
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
								$('#mensaje').html(
										'<b>' + data.mensaje.msg + '</b>');
								context = context+'admin/'+data.mensaje.url;
								setTimeout(
										"location.href = context;",
										3000);
							}
						}
					});
});