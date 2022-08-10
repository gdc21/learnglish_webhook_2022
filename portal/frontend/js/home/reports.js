$(document).ready(function () {
	var usuario = $("#usuario").val();
	mostrar_resultados(1, usuario);
	$(".seccion").click(function () {
		$("#tabla_evaluaciones").dataTable().fnDestroy();
		$("#tabla_habilidades").dataTable().fnDestroy();
		var seccion = $(this).data("opcion");
		$("#seccion").val(seccion);

		if (seccion == 1) {
			$("#tabla_evaluaciones").show();
			$("#tabla_habilidades").hide();
		} else {
			$("#tabla_evaluaciones").hide();
			$("#tabla_habilidades").show();
		}

		mostrar_resultados(seccion, usuario);
	});
});


function mostrar_resultados(seccion, usuario) {
	console.clear();
	$.ajax({
		type: "POST",
		url: context+'admin/reporte_resultados',
		data: {seccion: seccion, usuario: usuario},
		dataType: 'json',
		success: function (resp) {
			// console.log(resp)
			if (seccion == 1) {
				$("#tabla_evaluaciones").dataTable().fnDestroy();
				$("#tabla_habilidades").dataTable().fnDestroy();
				
				$("#tabla_evaluaciones tbody").html(resp.contenido);
				$("#tabla_habilidades tbody").html("");

				$('#tabla_evaluaciones').dataTable({
					searching: false,
					paging: false,
					ordering: false,
					info: false,
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
			} else {
				$("#tabla_habilidades").dataTable().fnDestroy();
				$("#tabla_evaluaciones").dataTable().fnDestroy();
				
				$("#tabla_evaluaciones tbody").html("");
				$("#tabla_habilidades tbody").html(resp.contenido);
				$('#tabla_habilidades').dataTable({
					searching: false,
					paging: false,
					ordering: false,
					info: false,
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