$(document).ready(function () {
	// cargar_tabla($("#buscar").val());
	$("#tabla_clientes").dataTable({
		searching: false,
		paging: true,
		"language": {
			"paginate": {
				"next": "Siguiente",
				"previous": "Anterior"
			},
			"info": "Mostrando _START_ de _END_",
		}
	});
});

function eliminar(id) {
	var confirma = confirm("¿Est\u00E1s seguro de eliminar este registro?");
	if (confirma) {
		// console.log("Eliminado")
		$.ajax({
			type: 'POST',
			url: context+'admin/deleteCliente',
			data: {id: id},
			dataType: 'json',
			success: function(resp) {
				// console.log(resp)
				if (resp.error) {
            		alert(resp.error);
            	} else {
            		alert(resp.mensaje);
            		location.reload();
            	}
			}
		});
	}
}