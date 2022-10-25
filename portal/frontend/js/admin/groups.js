$(document).ready(function () {
	cargar_grupos();
});

function cargar_grupos() {
	$.ajax({
		type: "POST",
		url: context+"admin/mostrar_grupos",
		data: {},
		dataType: "json",
		beforeSend: function () {
			var nColumnas = $("#tbl_informe thead tr:first th").length
			var tabla = "<tr>";
			for (var i = 1; i <= nColumnas; i++) {
				if (i==1) {
					tabla+="<td style='font-size: 8px;'><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></td>";
				} else {
					tabla+="<td style='font-size: 8px;'><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></td>";
				}
			}
			tabla+="</tr>";
			$("#tbl_informe tbody").html(tabla);
		},
		success: function (resp) {
			// console.log(resp);
			$("#tbl_informe tbody").html(resp.contenido);

			$('#tbl_informe').dataTable({
				searching: true,
				paging: true,
				searching: false,
				"language": {
					"paginate": {
						"next": "Siguiente",
						"previous": "Anterior"
					},
					"info": "Mostrando _START_ de _END_",
					"search": "Buscar"
				},
				"order": false,
				"lengthChange": false
			});
		}
	});
}