$(document).ready(function () {
	$(".datepicker").datepicker({
		format: 'dd/mm/yyyy'
	});
	// $(".periodos").attr("disabled", true);
	$(".fechas").hide();
	if ($("#institucion").val() != "") {
		var texto = $('#institucion option:selected').text();
		if (texto != "") {
			$("#titulo").html("Institución: <b>"+texto+"</b>");
		}
	}
	$("#institucion").change(function () {
		var opcion = $("#opcion").val();
		var seccion = $("#seccion").val();
		var texto = $('#institucion option:selected').text();
		
		var inicia = $("#fInicial").val();
		var final = $("#fFinal").val();
		if (inicia != "" && final != "") {
			var periodo = inicia+"*"+final;
		} else {
			var periodo = null;
		}
		if ($(this).val().trim() !== '') {
			if (texto != "") {
				$("#titulo").html("Institución: <b>"+texto+"</b>");
			}
			if (opcion != "" && seccion != "") {
				mostrar_resultados(seccion, opcion, $(this).val(), "", periodo);
			}
		} else {
			$("#titulo").html("");
			mostrar_resultados(seccion, opcion, "", "", periodo);
		}
	})

	$("#cliente").change(function () {
		var opcion = $("#opcion").val();
		var seccion = $("#seccion").val();
		var texto = $('#cliente option:selected').text();
		
		var inicia = $("#fInicial").val();
		var final = $("#fFinal").val();
		if (inicia != "" && final != "") {
			var periodo = inicia+"*"+final;
		} else {
			var periodo = null;
		}

		if ($(this).val().trim() !== '') {
			$("#titulo").html("Cliente: <b>"+texto+"</b>");
			if (opcion != "" && seccion != "") {
				mostrar_resultados(seccion, opcion, "", $(this).val(), periodo);
			}
		} else {
			$("#titulo").html("");
			mostrar_resultados(seccion, opcion, "", "", periodo);
		}
	})

	$(".seccion").click(function () {
		var seccion = $(this).data("opcion");
		$("#seccion").val(seccion);
		var opcion = $("#opcion").val();
		var institucion = $("#institucion").val();
		var cliente = $("#cliente").val();
		
		// var periodo = $("#periodo").val();
		var inicia = $("#fInicial").val();
		var final = $("#fFinal").val();
		if (inicia != "" && final != "") {
			var periodo = inicia+"*"+final;
		} else {
			var periodo = null;
		}

		if (opcion != "") {
			mostrar_resultados(seccion, opcion, institucion, cliente, periodo);
		}
		if (seccion == 1) {
			$("#tabla_evaluaciones").show();
			$("#tabla_habilidades").hide();
		} else {
			$("#tabla_evaluaciones").hide();
			$("#tabla_habilidades").show();
		}
	})

	$(".opcion").click(function () {
		var opcion = $(this).data("opcion");
		var seccion = $("#seccion").val();
		$("#opcion").val(opcion);
		var institucion = $("#institucion").val();
		var cliente = $("#cliente").val();
		
		// var periodo = $("#periodo").val();

		var inicia = $("#fInicial").val();
		var final = $("#fFinal").val();
		if (inicia != "" && final != "") {
			var periodo = inicia+"*"+final;
		} else {
			var periodo = null;
		}

		if (opcion != "") {
			mostrar_resultados(seccion, opcion, institucion, cliente, periodo);
		}
	})

	$(".opcion").bind('click', function() {
		var opcion = $(this).data("opcion");
		if (opcion == 1) {
			$('.op1').addClass('registro');
			$('.op2').removeClass('registro');
			$('.op3').removeClass('registro');
			// $(".seccion").addClass('registro');
		}

		if (opcion == 2) {
			$('.op1').removeClass('registro');
			$('.op2').addClass('registro');
			$('.op3').removeClass('registro');
			// $(".seccion").addClass('registro');
		}

		if (opcion == 3) {
			$('.op1').removeClass('registro');
			$('.op2').removeClass('registro');
			$('.op3').addClass('registro');
			// $(".seccion").addClass('registro');
		}
	})

	$(".seccion").bind('click', function() {
		var opcion = $(this).data("opcion");
		if (opcion == 1) {
			$(".sec1").addClass('registro1');
			$(".sec1").removeClass('inhabilitar');
			$(".sec2").removeClass('registro1');
			$(".sec2").addClass('inhabilitar');
		}

		if (opcion == 2) {
			$(".sec1").removeClass('registro1');
			$(".sec2").removeClass('inhabilitar');
			$(".sec2").addClass('registro1');
			$(".sec1").addClass('inhabilitar');
		}
	})

	$("#tiempos").click(function () {
		if ($("#tiempos").is(':checked')) {
			// $(".periodos").attr("disabled", false);
			$(".fechas").show();
		} else {
			$(".fechas").hide();
			/*clear();
			$(".periodos").attr("disabled", true);*/

			var opcion = $("#opcion").val();
			var seccion = $("#seccion").val();
			var institucion = $("#institucion").val();
			var cliente = $("#cliente").val();
			mostrar_resultados(seccion, opcion, institucion, cliente, null);
		}
	});

	$(".periodos").click(function () {
		var opcion = $("#opcion").val();
		var seccion = $("#seccion").val();
		var institucion = $("#institucion").val();
		var cliente = $("#cliente").val();

		if ($(".periodos").is(":checked")) {
			$("#periodo").val($(this).val());
		} else {
			$("#periodo").val();
		}

		var periodo = $("#periodo").val();

		mostrar_resultados(seccion, opcion, institucion, cliente, periodo);
	});

	$(".datepicker").change(function () {
		var opcion = $("#opcion").val();
		var seccion = $("#seccion").val();
		var institucion = $("#institucion").val();
		var cliente = $("#cliente").val();

		var inicia = $("#fInicial").val();
		var final = $("#fFinal").val();

		if (inicia != "" && final != "") {
			var fecha = inicia+"*"+final;
			// console.log(fecha)
			mostrar_resultados(seccion, opcion, institucion, cliente, fecha);
		}
	});
})

function mostrar_resultados(seccion, opcion, institucion, cliente, fecha) {
	// console.clear();
	if (seccion != "" && opcion != "") {
		$.ajax({
			type: "POST",
			url: context+'admin/mostrar_resultados',
			data: {seccion: seccion, opcion: opcion, institucion: institucion, cliente: cliente, fecha: fecha},
			dataType: 'json',
			beforeSend: function () {
				$("#tabla_evaluaciones").dataTable().fnDestroy();
				$("#tabla_habilidades").dataTable().fnDestroy();
				if (seccion == 1) {
					var nColumnas = $("#tabla_evaluaciones thead tr:first th").length
					var tabla = "<tr>";
					for (var i = 1; i <= nColumnas; i++) {
						if (i==1) {
							tabla+="<td style='font-size: 8px;'><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></td>";
						} else {
							tabla+="<td style='font-size: 8px;'><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></td>";
						}
					}
					tabla+="</tr>";
					$("#tabla_evaluaciones tbody").html(tabla);
				} else {
					// $("#tabla_habilidades").dataTable().fnDestroy();
					var tabla = "<tr>";
					for (var i = 1; i <= 8; i++) {
						if (i==1) {
							tabla+="<td style='font-size: 8px;'><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></td>";
						} else {
							tabla+="<td style='font-size: 8px;'><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></td>";
						}
					}
					tabla+="</tr>";
					$("#tabla_habilidades tbody").html(tabla);
				}
			},
			success: function (resp) {
				// console.log($.isEmptyObject(resp.contenido))
				if (!$.isEmptyObject(resp.contenido)) {
					if (seccion == 1) {
						if (opcion == 3) {
							$(".columna1").html("Alumno");
							$(".columna2").html("Grupo");
						} else if (opcion == 2) {
							$(".columna1").html("Grupo");
							$(".columna2").html("Alumnos");
						} else {
							$(".columna1").html("Institución");
							$(".columna2").html("Alumnos");
						}

						$("#tabla_evaluaciones tbody").html(resp.contenido);
						$("#tabla_habilidades tbody").html("");

						if (!$.fn.DataTable.isDataTable('#tabla_evaluaciones')) {
							$('#tabla_evaluaciones').DataTable({
								searching: false,
								paging: true,
								"language": {
									"paginate": {
										"next": "Siguiente",
										"previous": "Anterior"
									},
									"info": "Mostrando _START_ de _END_",
								},
								dom: 'Bfrtip',
						        buttons: [
						            {
						                extend: 'excelHtml5',
						                title: 'Reporte de Evaluaciones ('+formatoFecha()+')',
						                className: 'btn btn-lg btn-primary'
						            }
						        ]
							});
						}
					} else {
						if (opcion == 3) {
							$(".columna1").html("Alumno");
							$(".columna2").html("Grupo");
						} else if (opcion == 2) {
							$(".columna1").html("Grupo");
							$(".columna2").html("Alumnos");
						} else {
							$(".columna1").html("Institución");
							$(".columna2").html("Alumnos");
						}
						$("#tabla_evaluaciones tbody").html("");
						$("#tabla_habilidades tbody").html(resp.contenido);

						$('#tabla_habilidades').dataTable({
							searching: false,
							paging: true,
							"language": {
								"paginate": {
									"next": "Siguiente",
									"previous": "Anterior"
								},
								"info": "Mostrando _START_ de _END_",
							},
							dom: 'Bfrtip',
					        buttons: [
					            {
					                extend: 'excelHtml5',
					                title: 'Reporte de Habilidades ('+formatoFecha()+')',
					                className: 'btn btn-lg btn-primary'
					            }
					        ]
						});
					}
				} else {
					$("#tabla_evaluaciones").html("");
					$("#tabla_habilidades").html("");
					
					$("#tabla_evaluaciones").hide();
					$("#tabla_habilidades").hide();
				}
			}
		});
	}
}

function formatoFecha() {
	var f = new Date();
	var dia = f.getDate();
	var mes = f.getMonth();
	var year = f.getFullYear()
	if (dia < 10) {
		dia = "0"+dia;
	}
	if (mes < 10) {
		mes = "0"+mes;
	}
    return  dia+ "-" + mes + "-" + year;
}

function reporteDetail(id) {
	$("#estadisticas_evaluaciones").html("");
	$("#estadisticas_evaluaciones").hide();
	$("#estadisticas_habilidades").show();
	
	$("#modalReporte").modal("show");

	$.ajax({
		type: "POST",
		url: context+"admin/habilidades_alumno",
		data: {clave: id},
		dataType: 'json',
		success: function (resp) {
			var vocabulary = resp.contenido.vocabulary;
			var grammar = resp.contenido.grammar;
			var reading = resp.contenido.reading;
			var listening = resp.contenido.listening;
			var speaking = resp.contenido.speaking;
			var total = resp.contenido.total;
			
			$("#nombre").html(resp.contenido.alumno);
			$("#grupo").html("Grupo: "+resp.contenido.grupo);

			$("#imagenPerfil").attr('src', resp.contenido.foto);

			$("#gramatica1").html(vocabulary+" %");
			$("#gramatica2").html(grammar+" %");
			$("#servicios").html(reading+" %");
			$("#profesional").html(listening+" %");
			$("#speaking").html(speaking+" %");
			
			$("#total").html(total+" %");
			if (parseInt(vocabulary) == 0) {
				$("#gramatica1").css({"background":"#fff","color":"#000"});
			} else {
				var width = $('#gramatica1').width();
				var parentWidth = $('#gramatica1').offsetParent().width();
				var percent = parseInt(vocabulary)*width/parentWidth;
				$("#gramatica1").css({"width":percent+"%","background":"#2ebebb","color":"#fff","display":"block", "position":"absolute", "height": "48px", "padding-top":"15px"});
			}

			if (parseInt(grammar) == 0) {
				$("#gramatica2").css({"background":"#fff","color":"#000"});
			} else {
				var width = $('#gramatica2').width();
				var parentWidth = $('#gramatica2').offsetParent().width();
				var percent = parseInt(grammar)*width/parentWidth;
				$("#gramatica2").css({"width":percent+"%","background":"#2ebebb","color":"#fff","display":"block", "position":"absolute", "height": "48px", "padding-top":"15px"});
			}

			if (parseInt(reading) == 0) {
				$("#servicios").css({"background":"#fff","color":"#000"});
			} else {
				var width = $('#servicios').width();
				var parentWidth = $('#servicios').offsetParent().width();
				var percent = parseInt(reading)*width/parentWidth;
				$("#servicios").css({"width":percent+"%","background":"#2ebebb","color":"#fff","display":"block", "position":"absolute", "height": "48px", "padding-top":"15px"});
			}

			if (parseInt(listening) == 0) {
				$("#profesional").css({"background":"#fff","color":"#000"});
			} else {
				var width = $('#profesional').width();
				var parentWidth = $('#profesional').offsetParent().width();
				var percent = parseInt(listening)*width/parentWidth;
				$("#profesional").css({"width":percent+"%","background":"#2ebebb","color":"#fff","display":"block", "position":"absolute", "height": "48px", "padding-top":"15px"});
			}

			if (parseInt(speaking) == 0) {
				$("#speaking").css({"background":"#fff","color":"#000"});
			} else {
				var width = $('#speaking').width();
				var parentWidth = $('#speaking').offsetParent().width();
				var percent = parseInt(speaking)*width/parentWidth;
				$("#speaking").css({"width":percent+"%","background":"#2ebebb","color":"#fff","display":"block", "position":"absolute", "height": "48px", "padding-top":"15px"});
			}

			if (parseInt(total) == 0) {
				$("#total").css({"background":"#fff","color":"#000"});
			} else {
				var width = $('#total').width();
				var parentWidth = $('#total').offsetParent().width();
				var percent = parseInt(total)*width/parentWidth;
				$("#total").css({"width":percent+"%","background":"#2ebebb","color":"#fff","display":"block", "position":"absolute", "height": "48px", "padding-top":"15px"});
			}
		}
	});
}

function detalleCalificaciones(id) {
	$("#estadisticas_habilidades").hide();
	$("#estadisticas_evaluaciones").show();
	$("#modalReporte").modal("show");
	$.ajax({
		type: "POST",
		url: context+'admin/estadisticasCalificaciones',
		data: {clave: id},
		dataType: 'json',
		success: function (resp) {
			$("#estadisticas_evaluaciones").html(resp.contenido);
		}
	});
}