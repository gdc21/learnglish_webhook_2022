$(document).ready(function () {
	cargar_evaluaciones($("#seccion").val(), $("#grupo").val(), null);

	$(".fechas").hide();

	$(".datepicker").datepicker({
		format: 'dd/mm/yyyy'
	});

	$(".periodos").attr("disabled", true);

	$(".seccion").click(function (e) {
		e.preventDefault();
		opcion = $(this).data("opcion");
		$("#seccion").val(opcion);

		/*if ($(".periodos").is(":checked")) {
			var periodo = $(".periodos").val();
		} else {
			var periodo = null;
		}*/

		var inicia = $("#fInicial").val();
		var final = $("#fFinal").val();
		if (inicia != "" && final != "") {
			var periodo = inicia+"*"+final;
		} else {
			var periodo = null;
		}

		if (opcion == 1) {
			$("#titulo").html("Evaluaciones");
			$("#tabla_evaluaciones").show();
			$("#tabla_habilidades").hide();
			cargar_evaluaciones(opcion, $("#grupo").val(), periodo);
		} else {
			$("#titulo").html("Habilidades");
			$("#tabla_habilidades").show();
			$("#tabla_evaluaciones").hide();
			// console.log("Op: "+opcion)
			cargar_evaluaciones(opcion, $("#grupo").val(), periodo);
		}
	});

	$("#tiempos").click(function () {
		if ($("#tiempos").is(':checked')) {
			// $(".periodos").attr("disabled", false);
			$(".fechas").show();
		} else {
			$(".fechas").hide();
			/*clear();
			$(".periodos").attr("disabled", true);*/

			opcion = $("#seccion").val();
			cargar_evaluaciones(opcion, $("#grupo").val(), null);
		}
	});

	$(".periodos").click(function () {
		opcion = $("#seccion").val();

		if ($(".periodos").is(":checked")) {
			var periodo = $(".periodos").val();
		} else {
			var periodo = null;
		}
		
		cargar_evaluaciones(opcion, $("#grupo").val(), $(this).val());
	});

	$(".datepicker").change(function () {
		opcion = $("#seccion").val();

		var inicia = $("#fInicial").val();
		var final = $("#fFinal").val();

		if (inicia != "" && final != "") {
			var fecha = inicia+"*"+final;
			// console.log(fecha)
			cargar_evaluaciones(opcion, $("#grupo").val(), fecha);
		}
	});
});

function cargar_evaluaciones(seccion, grupo, fecha) {
	$.ajax({
		type: "POST",
		url: context+"home/cargar_registros",
		data: {seccion: seccion, grupo: grupo, fecha: fecha},
		dataType: "json",
		beforeSend: function () {
			$("#tabla_evaluaciones").dataTable().fnDestroy();
			$("#tabla_habilidades").dataTable().fnDestroy();
			if (seccion == 1) {
				var nColumnas = $("#tabla_evaluaciones thead tr:first th").length;
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
				for (var i = 1; i < 8; i++) {
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
			if (seccion == 1) {
				$("#tabla_evaluaciones tbody").html(resp.contenido);
				$('#tabla_evaluaciones').DataTable({
					searching: false,
					info: false,
					dom: 'Bfrtip',
			        buttons: [
			            {
			                extend: 'excelHtml5',
			                title: 'Reporte de Evaluaciones ('+formatoFecha()+')',
			                className: 'btn btn-lg btn-primary'
			            }
			        ]
				});
			} else {
				$("#tabla_habilidades tbody").html(resp.contenido);
				$('#tabla_habilidades').dataTable({
					searching: false,
					info: false,
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
		}
	});
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