$(function() {
	// $.getScript("http://localhost/learnglish/portal/frontend/js/jquery-ui.min.js",function(){
	// });
	var original = [], nuevo = [], nivel = 0, modulo = 0, leccion = 0, seccion = 0;

	// Carga las opciones del combo de modulo
	$("#nivel").change(
			function() {
				var nivel = $('#nivel option:selected').val(), data;
				if (nivel != 0) {
					data = getInfoAjax('GETModulos', {
						nivel : nivel
					}, "admin");
					if (data.error) {
						// console.log(data.error);
					} else {
						var pop = '';
						$.each(data, function() {
							pop += '<option value="' + this.LGF0150001 + '">'
									+ this.LGF0150002 + '</option>';
						});
						$("#modulo").html(
								'<option value="0">Seleccione un Módulo</option>'
										+ pop);
						$("#add_modul").show();
					}
				} else {
					$("#modulo").html(
							'<option value="0">Seleccione un Nivel</option>');
					$("#add_modul").hide();
				}
			});
	// carga la opciones del combo de leccion
	$("#modulo").change(
			function() {
				var modulo = $('#modulo option:selected').val(), data;
				if (modulo != 0) {
					data = getInfoAjax('GETLecciones', {
						modulo : modulo
					}, "admin");
					if (data.error) {
						// console.log(data.error);
					} else {
						var pop = '';
						$.each(data, function() {
							pop += '<option value="' + this.LGF0160001 + '">'
									+ this.LGF0160002 + '</option>';
						});
						$("#leccion").html(
								'<option value="0">Seleccione una Lección</option>'
										+ pop);
						$("#add_lesson").show();
					}
				} else {
					$("#leccion").html(
							'<option value="0">Seleccione un módulo</option>');
					$("#add_lesson").hide();
				}
			});

	$('#nuevaEvaluacion')
			.validate(
					{
						rules : {
							nombre : "required",
							nivel : {
								required : true,
								min : 1
							},
							modulo : {
								required : true,
								min : 1
							},
							leccion : {
								required : true,
								min : 1
							},
							numPreguntas : {
								required : true,
								min : 1
							},
						},
						messages : {
							nombre : {
								required : '*Este campo es requerido'
							},
							nivel : {
								required : '*Este campo es requerido'
							},
							modulo : {
								required : '*Este campo es requerido'
							},
							leccion : {
								required : '*Este campo es requerido'
							},
							numPreguntas : '*Este campo es requerido',

						},
						errorPlacement : function(error, element) {
							error.appendTo(element.parents('td').children(
									'span.error'));
						},
						submitHandler : function(form) {
							var data = getInfoAjax('saveEvaluacion', $(form)
									.serialize(), "admin");
							// titulo = 'Nueva evaluación',
							// mns = data.error || data.mensaje.msg;
							// console.log(data);
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
								setTimeout(
										"location.href = context+'admin/evaluaciones';",
										3000);
							}
						}
					});

});
