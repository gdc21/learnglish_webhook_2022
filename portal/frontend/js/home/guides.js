$(document).ready(function () {
	cargar_tabla($("#nivel").val(), $("#docente").val());

	$("#add").click(function (e) {
		e.preventDefault();
		$("#mdlGuias").modal("show");
		cargar_lecciones("");
	});

	$("#sLecciones").change(function () {
		$(this).css({"border-color":"#ced4da"});
		if ($(this).val() != "") {
			var img = $("#sLecciones option:selected").data('img');
			$("#imagenL").attr("src", img);
		} else {
			$("#imagenL").attr("src", "");
		}
	});

	$("#fileG").change(function () {
		$(this).css({"border-color":"#ced4da"});
		var file = document.querySelector('#fileG').files[0];
		var aux = file.name.split(".");
		if (aux[1].toLowerCase() != "pdf") {
			$(".mensaje").show();
			$("#msjFile").addClass("alert-danger");
			$("#msjFile").html("Solo puedes cargar archivos PDF");
		} else {
			$(".mensaje").hide();
			$("#msjFile").removeClass("alert-danger");
		}
	});

	$(".estatus").click(function () {
		if ($(".estatus").is(":checked")) {
	    	$(".form-check-input").css({"border-color":"#ced4da"});
	    }
	});

	$("#saveF").click(function (e) {
		e.preventDefault();
		var actividad = $("#actividad").val()
		if (actividad == 1) {
			var cambio = true;
			var accion = $("#accion").val();
			if (accion == 2) {
				$("#fileG").removeClass("campos");
			}
		    $(".campos").each(function () {
		    	if ($(this).val() == "") {
		    		$(this).css({"border-color":"#ff0000"});
		    		cambio = false;
		    	} else {
		    		$(this).css({"border-color":"#ced4da"});
		    	}
		    });

		    if (!$(".estatus").is(":checked")) {
		    	$(".form-check-input").css({"border-color":"#ff0000"});
		    	cambio = false;
		    } else {
		    	$(this).css({"border-color":"#ced4da"});
		    }

		    if (cambio) {
		    	var data = new FormData($('#frmGuias')[0]);
		    	$.ajax({
					type: 'POST',
					url: context+'admin/admguias',
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
			         	console.log(resp)
			         	if (resp.error == 0) {
			         		$("#msjFile").removeClass("alert-danger");
			         		$("#msjFile").addClass("alert-success");
							$("#msjFile").html(resp.mensaje);
							
							setTimeout(function () {
								$("#mdlGuias").modal("hide");
							}, 3000);
			         	} else {
			         		$("#msjFile").removeClass("alert-success");
			         		$("#msjFile").addClass("alert-danger");
							$("#msjFile").html(resp.mensaje);
			         	}
			        }
				});
		    }
		} else {
			var modulo = $("#smodulo").val();
			var activos = "";
			var inactivos = "";
			$.each($(".lguia"), function () {
				var id = $(this).attr("id")
				var aux = id.split("_");
				if ($(this).is(":checked")) {
					activos+=aux[1]+",";
				} else {
					inactivos+=aux[1]+",";
				}
			});

			if (activos != "") {
				activos = activos.slice(0, -1);
			}

			if (inactivos != "") {
				inactivos = inactivos.slice(0, -1);
			}

			var cadena = modulo+"|"+activos+"|"+inactivos;
			$.ajax({
				type: "POST",
				data: {cadena: cadena, accion: 2},
				url: context+"home/obtenerGuias",
				dataType: "json",
				success: function (resp) {
					console.log(resp)
				}
			});
		}
	});
	$("#mdlGuias").on('hidden.bs.modal', function () {
		$(this).find('form')[0].reset();
		$(".estatus").attr("checked", false);
		$("#nav-home-tab").addClass("active");
		$("#nav-home").addClass("active");
		$("#nav-home").addClass("show");
		$("#nav-activar-tab").removeClass("active");
		$("#nav-activar").removeClass("active");
		$("#nav-activar").removeClass("show");
		$("#nav-activar").addClass("fade");
		$("#accion").val(1);
		$("#fileG").addClass("campos");
		$("#imagenL").attr("src", "");
		$(".campos").css({"border-color":"#ced4da"});
		$(".estatus").css({"border-color":"#ced4da"});
		cargar_tabla($("#nivel").val(), $("#docente").val());
		$("#tablaguias").dataTable().fnDestroy();
	});

	$("#nav-home-tab").click(function () {
		$("#actividad").val(1);
	});

	$("#nav-activar-tab").click(function () {
		$("#actividad").val(2);
		$("#contenedorL").html("Hola")
		cargar_lista_guias();
	});
});

function editar_leccion(valor, leccion) {
	$("#mdlGuias").modal("show");
	$("#accion").val(2);
	$("#valor").val(valor);
	cargar_lecciones(leccion);
	$("#sLecciones").val(leccion)
	$.ajax({
		type: "POST",
		data: {valor: valor, accion: 2},
		url: context+"home/obtenerLecciones",
		dataType: "json",
		success: function (resp) {
			if (resp.data.estatus == 1) {
				$("#estatus1").attr("checked", true);
			} else {
				$("#estatus2").attr("checked", true);
			}
		}
	});
}

function cargar_lecciones(leccion) {
	$.ajax({
		type: "POST",
		data: {nivel: $("#nivel").val(), accion: 1},
		url: context+"home/obtenerLecciones",
		dataType: "json",
		success: function (resp) {
			var lista = "";
			if (leccion == "") {
				lista = "<option value=''>Selecciona una lección</option>";
			}
			$.each(resp.data, function (pos, val) {
				if (leccion == "") {
					lista+= "<option value='"+val.cvl+"' data-img='"+val.img+"' >"+val.nombre+"</option>";
				} else {
					if (leccion == val.cvl) {
						lista+= "<option value='"+val.cvl+"' data-img='"+val.img+"' >"+val.nombre+"</option>";
					}
				}
			});
			$("#sLecciones").html(lista);
			$("#sLecciones").val(leccion);

			var img = $("#sLecciones option:selected").data('img');
			$("#imagenL").attr("src", img);
		}
	});
}

function cargar_lista_guias() {
	$.ajax({
		type: "POST",
		data: {nivel: $("#nivel").val(), accion: 1},
		url: context+"home/obtenerGuias",
		dataType: "json",
		success: function (resp) {
			var checked = "";
			var lista = "<div class='row'>";
			$.each(resp.data, function (pos, val) {
				lista+= "<div class='col-lg-4 list-group'><label class='list-group-item' for='lguia_"+val.cvl+"'>";
				if (val.estatus == 1) {
					lista+="<input type='checkbox' class='form-check-input me-1 lguia' name='lguia_"+val.cvl+"' id='lguia_"+val.cvl+"' value='"+val.cvl+"' checked='"+checked+"'> Lección "+val.orden+") "+val.nombre+"</label>";
				} else {
					lista+="<input type='checkbox' class='form-check-input me-1 lguia' name='lguia_"+val.cvl+"' id='lguia_"+val.cvl+"' value='"+val.cvl+"'> Lección "+val.orden+") "+val.nombre+"</label>";
				}
				lista+="</div>";
			});
			lista+="</div>";
			$("#contenedorL").html(lista);
		}
	});
}

function cargar_tabla(nivel, docente) {
	// console.clear();
	$.ajax({
		type: "POST",
		url: context+'admin/guias',
		data: {nivel: nivel, docente: docente, origen: 2},
		dataType: 'json',
		beforeSend: function () {
			$("#tablaguias tbody").html("");
		},
		success: function (resp) {
			// console.log(resp)
			$("#tablaguias tbody").html(resp.contenido);
			$('#tablaguias').dataTable({
			    searching: false,
				paging: true,
				ordering: false,
				info: true,
				"language": {
					"paginate": {
						"next": "Siguiente",
						"previous": "Anterior"
					},
					"info": "Mostrando _START_ de _END_",
				}
			});
		}
	});
}