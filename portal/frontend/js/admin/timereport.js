$(document).ready(function () {
	cargar_tabla("", "");
	$(".seccion").click(function () {
		$("#seccion").val($(this).data("opcion"));
		var opcion = $("#institucion").val();
		if ($(this).data("opcion") == 1) {
			cargar_tabla(1, opcion);
			$("#tabla_general").show();
			$("#tabla_lecciones").hide();
		} else {
			cargar_tabla(2, opcion);
			$("#tabla_general").hide();
			$("#tabla_lecciones").show();
		}
	});

	$(".seccion").click(function () {
		var opcion = $(this).data("opcion");
		if (opcion == 1) {
			$(".sec1").addClass('registro');
			$(".sec1").removeClass('inhabilitar');
			$(".sec2").removeClass('registro');
			$(".sec2").addClass('inhabilitar');
		}

		if (opcion == 2) {
			$(".sec1").removeClass('registro');
			$(".sec2").removeClass('inhabilitar');
			$(".sec2").addClass('registro');
			$(".sec1").addClass('inhabilitar');
		}
	})

	$("#institucion").change(function () {
		var seccion = $("#seccion").val();
		cargar_tabla(seccion, $(this).val());
	});
});

function cargar_tabla(tipo, combo) {
	if (tipo == "") {
		tipo = 1;
	}
	$.ajax({
		type: "POST",
		data: {tipo: tipo, combo: combo},
		url: context+"admin/reportime",
		beforeSend: function () {
			$("#tabla_general").dataTable().fnDestroy();
			$("#tabla_lecciones").dataTable().fnDestroy();
			if (tipo == 1) {
				var nColumnas = $("#tabla_general thead tr:first th").length
				var tabla = "<tr>";
				for (var i = 1; i <= nColumnas; i++) {
					if (i==1) {
						tabla+="<td style='font-size: 8px;'><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></td>";
					} else {
						tabla+="<td style='font-size: 8px;'><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></td>";
					}
				}
				tabla+="</tr>";
				$("#tabla_general tbody").html(tabla);
			} else {
				var nColumnas = $("#tabla_lecciones thead tr:first th").length
				var tabla = "<tr>";
				for (var i = 1; i <= nColumnas; i++) {
					if (i==1) {
						tabla+="<td style='font-size: 8px;'><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></td>";
					} else {
						tabla+="<td style='font-size: 8px;'><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></td>";
					}
				}
				tabla+="</tr>";
				$("#tabla_lecciones tbody").html(tabla);
			}
		},
		success: function (resp) {
			var tabla = "";
			$.each(resp.res, function (pos, val) {
				// console.log(pos+" -> "+val.id)
				if (tipo == 1) {
					tabla+="<tr><td>"+val.nombre+"</td><td>"+val.curp+"</td><td>"+val.cct+"</td><td>"+val.ins+"</td><td>"+val.tiempo+"</td></tr>";
				} else {
					tabla+="<tr><td>"+val.nombre+"</td><td>"+val.curp+"</td><td>"+val.cct+"</td><td>"+val.ins+"</td><td>"+val.tiempo+"</td><td>"+val.modulo+"</td><td>"+val.leccion+"</td></tr>";
				}
			});
			if (tipo == 1) {
				$("#tabla_general tbody").html(tabla);
				$('#tabla_general').dataTable({
					searching: true,
					paging: true,
					"pageLength": 100,
					"language": {
						"paginate": {
							"next": "Siguiente",
							"previous": "Anterior"
						},
						"info": "Mostrando _START_ de _END_",
						"search": "Buscar"
					},
					"order": [[ 4, "asc" ]],
					dom: 'Bfrtip',
			        buttons: [
			            {
			                extend: 'excelHtml5',
			                title: 'Reporte de tiempos por usuarios ('+formatoFecha()+')',
			                className: 'btn btn-lg btn-primary'
			            }
			        ]
				});
			} else {
				$("#tabla_lecciones tbody").html(tabla);
				$('#tabla_lecciones').dataTable({
					searching: true,
					paging: true,
					"pageLength": 100,
					"language": {
						"paginate": {
							"next": "Siguiente",
							"previous": "Anterior"
						},
						"info": "Mostrando _START_ de _END_",
						"search": "Buscar"
					},
					dom: 'Bfrtip',
			        buttons: [
			            {
			                extend: 'excelHtml5',
			                title: 'Reporte de tiempos por usuarios ('+formatoFecha()+')',
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