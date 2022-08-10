$(document).ready(function () {
	cargar_tabla($("#modulo").val());

	$("#modulo").change(function () {
		$("#tblAdminG").dataTable().fnDestroy();
		cargar_tabla($(this).val());
	});

	$("#addRegistro").click(function () {
		$("#modal-guides").modal("show");
		$("#modal-guidesLabel").html("Agregar nueva guía");
	});

	$("#grado").change(function () {
		cargar_lecciones($(this).val(), "");
	});

	$("#tipoG").change(function () {
		if ($(this).val() == 0) {
			$("#leccion").hide();
			$("#leccion").removeClass("validar");
		} else {
			$("#leccion").show();
			$("#leccion").addClass("validar");
		}
	});

	$(".validar").change(function () {
		$(this).css({"border-color":"#ced4da"});
	});

	$(".estatus").click(function () {
		if ($(".estatus").is(":checked")) {
	    	$(".form-check-input").css({"border-color":"#ced4da"});
	    }
	});

	$("#saveG").click(function (e) {
		e.preventDefault();
		console.log("Hola")

		var cambio = true;
		if ($(".validar").is(":visible")) {
			$(".validar").each(function () {
		    	if ($(this).val() == "") {
		    		$(this).css({"border-color":"#ff0000"});
		    		cambio = false;
		    	} else {
		    		$(this).css({"border-color":"#ced4da"});
		    	}
		    });
		}

	    if ($(".estatus").length > 0) {
	    	if (!$(".estatus").is(":checked")) {
		    	$(".form-check-input").css({"border-color":"#ff0000"});
		    	cambio = false;
		    } else {
		    	$(this).css({"border-color":"#ced4da"});
		    }
	    }

	    if (cambio) {
	    	console.log("Hola 1")
	    	var data = new FormData($('#formGuia')[0]);
	    	$.ajax({
				type: 'POST',
				url: context+'admin/saveGuide',
				data: data,
				dataType: 'json',
				contentType:false,
		        processData:false,
		        cache:false,
		        async: true,
		        beforeSend: function () {
		         	console.log("Enviando......................");
		         },
		        success: function (resp) {
		         	$("#mensaje").toggle("slow");
		         	if (resp.error == 0) {
		         		$("#mensaje").removeClass("alert-danger");
		         		$("#mensaje").addClass("alert-success");
						$("#mensaje").html(resp.mensaje);
						
						setTimeout(function () {
							$("#modal-guides").modal("hide");
						}, 3000);
		         	} else {
		         		$("#mensaje").removeClass("alert-success");
		         		$("#mensaje").addClass("alert-danger");
						$("#mensaje").html(resp.mensaje);
		         	}
		        }
			});
	    }
	});

	$("#modal-guides").on('hidden.bs.modal', function () {
		$("#tblAdminG").dataTable().fnDestroy();
		$("#formGuia")[0].reset();
		$(".form-check-input").addClass("estatus");
		$("#leccion").addClass("validar");
		$("#fileG").addClass("validar");
		$(".estatus").attr("checked", false);
		$(".validar").css({"border-color":"#ced4da"});
		$(".estatus").css({"border-color":"#ced4da"});
		$("#mensaje").html("");
		$("#mensaje").hide();
		$("#leccion").html("<option value=''>Selecciona una lección</option")
		cargar_tabla($("#modulo").val())
	});
});

function cargar_lecciones(modulo, leccion) {
	if (modulo == "") {
		$("#leccion").html("<option value=''>Selecciona una lección</option>");
	} else {
		$.ajax({
			type: "POST",
			data: {clave: modulo},
			url: context+"admin/cargar_lecciones",
			dataType: "json",
			success: function (resp) {
				var lista = "";
				if (leccion == "") {
					lista = "<option value=''>Selecciona una lección</option>";
				}
				$.each(resp.data, function (pos, val) {
					if (leccion == "") {
						lista+= "<option value='"+val.cvl+"'>"+val.nombre+"</option>";
					} else {
						if (leccion == val.cvl) {
							lista+= "<option value='"+val.cvl+"'>"+val.nombre+"</option>";
						}
					}
				});
				$("#leccion").html(lista);
				$("#leccion").val(leccion);
			}
		});
	}
}

function cargar_tabla(modulo) {
	$.ajax({
		type: "POST",
		url: context+'admin/obtenerGuias',
		data: {modulo: modulo},
		dataType: 'json',
		success: function (resp) {
			console.log(resp)
			var tabla = "";
			var tipo = "";
			var estado = "";
			var url = "";
			$.each(resp.data, function (pos, val) {
				if (val.guia == "") {
					url = '<i class="fa fa-lock" aria-hidden="true" style="font-size: 50px;"></i>';
				} else {
					if (val.urlG == "") {
						url = "<a title='La guía no se encuentra disponible'><i class='fa fa-file-pdf-o' aria-hidden='true' style='font-size: 50px;'></i></a>";
					} else {
						url = "<a href='"+val.urlG+"' target='_blank'><i class='fa fa-file-pdf-o' aria-hidden='true' style='font-size: 50px;'></i></a>";
					}
				}
				if (val.tipo == 0) {
					tipo = "Guía general";
				} else if (val.tipo == 1) {
					tipo = "Guía del alumno";
				} else if (val.tipo == 2) {
					tipo = "Guía del docente";
				}
				if (val.estatus == 0) {
					estado = "Desactivada";
				} else {
					estado = "Activada";
				}
				tabla+="<tr><td><img class='img-thumbnail' src='"+val.icono+"'></td><td>"+val.moduloname+"</td><td>"+val.leccion+"</td><td>"+url+"</td><td>"+tipo+"</td>><td>"+estado+"</td><td><a onclick='editarGuia("+val.clave+", "+val.tipo+", "+val.modulo+","+val.leccionid+", "+val.estatus+")'><i class='fa fa-pencil' aria-hidden='true'></i> Editar</a></td></tr>";
			});

			$("#tblAdminG tbody").html(tabla);

			$('#tblAdminG').dataTable({
				searching: true,
				paging: true,
				ordering: false,
				info: false,
				"language": {
					"paginate": {
						"next": "Siguiente",
						"previous": "Anterior"
					},
					"info": "Mostrando _START_ de _END_",
					"search": "Buscar"
				}
			});
		}
	});
}

function editarGuia(valor, tipo, modulo, leccion, estatus) {
	$("#fileG").removeClass("validar");
	$(".form-check-input").removeClass("estatus");
	$("#modal-guides").modal("show");
	$("#modal-guidesLabel").html("Actualizar información de guía");

	$("#tipoG").val(tipo);
	if (tipo == 0) {
		$("#leccion").hide();
		$("#leccion").removeClass("validar");
	} else {
		cargar_lecciones(modulo, leccion)
		$("#leccion").show();
	}
	$("#grado").val(modulo)
	if (estatus == 1) {
		$("#estatus1").attr("checked", true);
	} else {
		$("#estatus2").attr("checked", true);
	}
}