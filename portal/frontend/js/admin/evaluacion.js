$(document).ready(function () {
	$(window).on('load', function () {
		Cookies.remove('modulo')
		Cookies.remove('leccion')
	});

	var moduloid = Cookies.get('modulo');
	var leccionid = Cookies.get('leccion');
	
	if (moduloid != "" && leccionid != "") {
		cargar_tabla(Cookies.get('modulo'), Cookies.get('leccion'));
		cargar_lecciones(moduloid);
		$("#modulo").val(moduloid);
		$("#leccion").val(leccionid);
	}
	
	$("#modulo").change(function () {
		$("#mensaje").hide();
		$("#mensaje").html("");
		$("#tabla").dataTable().fnDestroy();
		var modulo = $(this).val();
		if (modulo.trim() === '') {
			cargar_tabla("", "");
			$("#leccion").html('<option value="">Todos las lecciones</option>');
		} else {
			cargar_tabla(modulo, "");
			cargar_lecciones(modulo);
		}
	});

	$("#leccion").change(function () {
		$("#mensaje").hide();
		$("#mensaje").html("");
		$("#tabla").dataTable().fnDestroy();
		cargar_tabla($("#modulo").val(), $(this).val());

		Cookies.set('modulo', $("#modulo").val());
		Cookies.set('leccion', $(this).val());
	})
});

function cargar_tabla(modulo, leccion) {
	$.ajax({
		type: "POST",
		url: context+"admin/mostrarEvaluaciones",
		data: {modulo: modulo, leccion: leccion},
		dataType: 'json',
		beforeSend: function () {
			$("#tabla tbody").html("");
		},
		success: function (resp) {
			// console.log(resp);
			$("#tabla tbody").html(resp.contenido);
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
				},
				"order": [[ 0, "asc" ]], //or asc 
				columnDefs: [{ type: 'de_date', targets: 3 }]
			});
		}
	});
}

function cargar_lecciones(modulo) {
	// console.log("Modulo "+ $('select[id=modulos]').val())
	$.ajax({
		type: 'POST',
		url: context+"admin/obtenerLecciones",
		data: {clave: modulo},
		dataType: 'json',
		success: function (resp) {
			$("#leccion").html(resp.contenido);
		}
	});
}

function eliminar(evaluacion) {
	var confirma = confirm("¿Est\u00E1s seguro de desactivar esta evaluaci\u00F3n?");
	if (confirma) {
		$.ajax({
			type: "POST",
			url: context+"admin/accionEvaluacion",
			data: {evaluacion: evaluacion, estatus: 0},
			dataType: 'json',
	        success: function (resp) {
	        	// console.log(resp)
	        	if (resp.error) {
	        		$("#mensaje").show();
	        		$('#mensaje').removeClass("alert-success");
					$('#mensaje').addClass("alert-warning");
					$('#mensaje').show("swing");
					$('#mensaje').html('<b>' + resp.error + '</b>');
	        	} else {
	        		$("#mensaje").show();
	        		$('#mensaje').addClass("alert-success");
					$('#mensaje').removeClass("alert-warning");
					$('#mensaje').show("swing");
					$('#mensaje').html('<b>' + resp.mensaje + '</b>');
					cargar_tabla($("#modulo").val(), $("#leccion").val());
					$("#tabla").dataTable().fnDestroy();
					setTimeout(function () {
						$("#mensaje").hide();
					}, 2000)
	        	}
	        }
		});
	}
}

function activar(evaluacion) {
	var confirma = confirm("¿Est\u00E1s seguro de activar esta evaluaci\u00F3n?");
	if (confirma) {
		$.ajax({
			type: "POST",
			url: context+"admin/accionEvaluacion",
			data: {evaluacion: evaluacion, estatus: 1},
			dataType: 'json',
	        success: function (resp) {
	        	// console.log(resp)
	        	if (resp.error) {
	        		$("#mensaje").show();
	        		$('#mensaje').removeClass("alert-success");
					$('#mensaje').addClass("alert-warning");
					$('#mensaje').show("swing");
					$('#mensaje').html('<b>' + resp.error + '</b>');
	        	} else {
	        		$("#mensaje").show();
	        		$('#mensaje').addClass("alert-success");
					$('#mensaje').removeClass("alert-warning");
					$('#mensaje').show("swing");
					$('#mensaje').html('<b>' + resp.mensaje + '</b>');
					cargar_tabla($("#modulo").val(), $("#leccion").val());
					$("#tabla").dataTable().fnDestroy();
					setTimeout(function () {
						$("#mensaje").hide();
					}, 2000)
	        	}
	        }
		});
	}
}