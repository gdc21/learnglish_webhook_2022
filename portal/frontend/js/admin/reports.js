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
	// console.log("Seccion: "+seccion+" Usuario: "+usuario);
	// if (seccion != "") {
		$.ajax({
			type: "POST",
			url: context+'admin/reporte_resultados',
			data: {seccion: seccion, usuario: usuario},
			dataType: 'json',
			/*beforeSend: function () {
				if (seccion == 1) {
					$("#tabla_evaluaciones tbody").html("<tr><td><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></td><td><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></td><td><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></td><td><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></td><td><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></td><td><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></td><td><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></td><td><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></td></tr>");
				} else {
					$("#tabla_habilidades tbody").html("<tr><td><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></td><td><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></td><td><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></td><td><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></td><td><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></td><td><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></td><td><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></td></tr>");
				}
			},*/
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
						}
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
						}
					});
				}
			}
		});
	// }
}