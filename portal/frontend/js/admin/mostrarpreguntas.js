$(document).ready(function () {
	$('#tabla').dataTable({
		searching: true,
		paging: true,
		"language": {
			"paginate": {
				"next": "Siguiente",
				"previous": "Anterior"
			},
			"info": "Mostrando _START_ de _END_",
			"search": "Buscar"
		}
	});
})