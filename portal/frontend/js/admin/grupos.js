$(document).ready(function () {
	$('#tabla').dataTable({
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

	$("#guardar").on('click', function (e) {
		e.preventDefault();
		if ($("#grupo").val() == "") {
			$("#mensaje").show('swing');
			$("#mensaje").html("Ingresa el nombre del grupo");
		} else {
			$.ajax({
				type: "POST",
				data: $("#form-grupo").serialize(),
				url: context+'admin/saveGrupo',
				dataType: 'json',
				success: function (resp) {
					if (resp.error) {
						$("#mensaje").show('swing');
						$("#mensaje").html(resp.error);
					} else {
						$("#mensaje").removeClass("alert-danger");
						$("#mensaje").addClass("alert-success");
						$("#mensaje").show('swing');
						$("#mensaje").html(resp.mensaje);
						$("#modalGrupos").find('form')[0].reset();
						setTimeout(function () {
							location.reload();
						}, 2000);
					}
				}
			});
		}
	});

	$("#grupo").on('keyup', function () {
		$("#mensaje").hide();
		$("#mensaje").html("");
	});

	$('.modal').on('hidden.bs.modal', function(){
		$("#modalGrupos").find('form')[0].reset();
		$("#tituloModal").html("");
		$("#tituloModal").html("Crear grupo");
		$("#mensaje").hide();
		$("#mensaje").removeClass("alert-success");
		$("#mensaje").addClass("alert-danger");
		$("#idgrupo").val("");
	});
})

function mostrar(id) {
	$("#modalGrupos").modal('show');
	$("#tituloModal").html("");
	$("#tituloModal").html("Actualizar informacion");
	$("#idgrupo").val(id);
	$.ajax({
		type: "POST",
		data: {id: id},
		url: context+'admin/informacionGrupos',
		dataType: 'json',
		success: function (resp) {
			$("#grupo").val(resp.info[0].nombre);
			if (resp.info[0].docente != "") {
				$("#docente").val(resp.info[0].docente)
			} else {
				$("#docente").val(0)
			}

			if (resp.info[0].modulo != "" || resp.info[0].modulo != null) {
				$("#nivel").val(resp.info[0].modulo)
			} else {
				$("#nivel").val(0)
			}

			if (resp.info[0].ciclo != "" || resp.info[0].ciclo != 0) {
				$("#ciclo").val(resp.info[0].ciclo)
			} else {
				$("#ciclo").val()
			}
		}
	});
}

function eliminar(id) {
	var confirma = confirm("¿Est\u00E1s seguro de eliminar este registro?");
	if (confirma) {
		$.ajax({
			type: "POST",
			data: {id: id},
			url: context+'admin/eliminarGrupo',
			dataType: 'json',
			success: function (resp) {
				if (resp.error) {
					$("#mensaje1").show('swing');
					$("#mensaje1").html(resp.error);
				} else {
					$("#mensaje1").removeClass("alert-danger");
					$("#mensaje1").addClass("alert-success");
					$("#mensaje1").show('swing');
					$("#mensaje1").html(resp.mensaje);
					setTimeout(function () {
						location.reload();
					}, 2000);
				}
			}
		});
	}
}