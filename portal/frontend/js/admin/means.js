$(document).ready(function () {
	cargar_tabla($("#modulo").val());

	$("#modulo").change(function () {
		$("#tblAdminR").dataTable().fnDestroy();
		cargar_tabla($(this).val());
	});

	$("#grado").change(function () {
		cargar_lecciones($(this).val(), "");
	});

	$("#addRegistro").click(function () {
		$("#modal-sinews").modal("show");
	});

	$(".validar").change(function () {
		$(this).css({"border-color":"#ced4da"});
	});

	$(".estatus").click(function () {
		if ($(".estatus").is(":checked")) {
	    	$(".form-check-input").css({"border-color":"#ced4da"});
	    }
	});

	$("#upRec1").change(function () {
		var file = document.querySelector('#upRec1').files[0];
		var name = file.name;
		var aux = name.split(".");
		//if (aux[1].toLowerCase()  == "mp3" || aux[1].toLowerCase()  == "zip" || aux[1].toLowerCase()  == "application/x-zip-compressed") {
		if (aux[1].toLowerCase()  == "mp3") {
			$("#msjAudio").hide();
			$(this).css({"border-color":"#ced4da"});
			$("#save").attr("disabled", false);
		} else {
			$("#msjAudio").show();
			$(this).css({"border-color":"#ff0000"});
			$("#save").attr("disabled", true);
		}
	});

	$("#save").click(function (e) {
		e.preventDefault();
		var cambio = true;

		/*Aquellos que tengan la clase validar se verificara su valor*/
		$(".validar").each(function () {
	    	if ($(this).val() == "") {
	    		$(this).css({"border-color":"#ff0000"});
	    		cambio = false;
	    	} else {
	    		$(this).css({"border-color":"#ced4da"});
	    	}
	    });
		/*Aquellos que tengan la clase validar se verificara su valor*/
		var alMenosUno = false;
		$(".validAlMenosUno").each(function () {
			if ($(this).val() != "") {
				alMenosUno = true;
			}
		});

		/*El usuario debera cargar por lo menos un archivo para proceder*/
		if(!alMenosUno){
			cambio = false;
			$("#mensaje").show();
			$("#mensaje").addClass("alert-danger");
			$("#mensaje").removeClass("alert-success");
			$("#mensaje").html("Debes cargar por lo menos un recurso");
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
	    	var data = new FormData($('#formRecurso')[0]);
	    	$.ajax({
				type: 'POST',
				url: context+'admin/saveRecurso',
				data: data,
				dataType: 'json',
				contentType:false,
		        processData:false,
		        cache:false,
		        async: true,
		        beforeSend: function () {
		        	$("#mensaje").hide();
		        	$("#mensaje").html("");
		        	$("#mensaje").removeClass("alert-danger");
		        	$("#mensaje").removeClass("alert-success");
		        },
		        success: function (resp) {
		         	$("#mensaje").show();
		         	if (resp.error == 0) {
		         		$("#mensaje").removeClass("alert-danger");
		         		$("#mensaje").addClass("alert-success");
						$("#mensaje").html(resp.mensaje);
						
						setTimeout(function () {
							$("#modal-sinews").modal("hide");
						}, 1000);
		         	} else {
		         		$("#mensaje").removeClass("alert-success");
		         		$("#mensaje").addClass("alert-danger");
						$("#mensaje").html(resp.mensaje);
		         	}
		        }
			});
	    }
	});

	$("#modal-sinews").on('hidden.bs.modal', function () {
		$("#tblAdminR").dataTable().fnDestroy();
		$("#formRecurso")[0].reset();
		$("#modal-sinewsLabel").html("Registrar recurso");
		$(".form-check-input").addClass("estatus");

		$(".estatus").attr("checked", false);
		$(".validar").css({"border-color":"#ced4da"});
		$(".estatus").css({"border-color":"#ced4da"});
		$("#mensaje").html("");
		$("#mensaje").hide();
		$("#leccion").html("<option value=''>Selecciona una lección</option")
		cargar_tabla($("#modulo").val())
	});
});

function cargar_tabla(modulo) {
	$.ajax({
		type: "POST",
		url: context+'admin/obtenRecursos',
		data: {modulo: modulo},
		dataType: 'json',
		success: function (resp) {
			var tabla = "";
			var rec1 = "", rec2 = "", rec3 = "", rec4 = "", rec5 = "";
			$.each(resp.data, function (pos, val) {
				if (val.rec1 == "") {
					rec1 = "<i class='fa fa-lock' aria-hidden='true' style='font-size: 50px;'></i>";
					/*rec1 = 0;*/
				} else {
					var aux = val.rec1.split("/");
					var aux1 = aux.pop();
					var aux2 = aux1.split(".");
					if (aux2[1] == "mp3") {
						rec1 = "<a onclick='reproducir("+val.leccion+")' id='recurso_"+val.leccion+"' data-enlace='"+val.rec1+"'><i class='fa fa-play' aria-hidden='true' style='font-size: 50px;'></i></a><a href='"+val.rec1+"' download><i class='fa fa-download' aria-hidden='true' style='float: right;'></i></a>";
					} else {
						rec1 = "<a href='"+val.rec1+"'><i class='fa fa-file-archive-o' aria-hidden='true' style='font-size: 50px;'></i></a>";
						/*rec1 = 1;*/
					}
				}

				if (val.rec2 == "") {
					rec2 = "<i class='fa fa-lock' aria-hidden='true' style='font-size: 50px;'></i>";
					/*rec2 = 0;*/
				} else {
					rec2 = "<a href='"+val.rec2+"' target='_blank'><i class='fa fa-file-pdf-o' aria-hidden='true' style='font-size: 50px;'></i></a>";
					/*rec2 = 1;*/
				}

				if (val.rec3 == "") {
					rec3 = "<i class='fa fa-lock' aria-hidden='true' style='font-size: 50px;'></i>";
					/*rec3 = 0;*/
				} else {
					rec3 = "<a href='"+val.rec3+"' target='_blank'><i class='fa fa-file-pdf-o' aria-hidden='true' style='font-size: 50px;'></i></a>";
					/*rec3 = 1;*/
				}

				if (val.rec5 == "") {
					rec5 = "<i class='fa fa-lock' aria-hidden='true' style='font-size: 50px;'></i>";
					/*rec5 = 0;*/
				} else {
					rec5 = "<a href='"+val.rec5+"' target='_blank'><i class='fa fa-file-pdf-o' aria-hidden='true' style='font-size: 50px;'></i></a>";
					/*rec5 = 1;*/
				}

				if (val.rec4 == "") {
					rec4 = "<i class='fa fa-lock' aria-hidden='true' style='font-size: 50px;'></i>";
					/*rec4 = 0;*/
				} else {
					rec4 = "<a href='"+val.rec4+"' target='_blank'><i class='fa fa-file-pdf-o' aria-hidden='true' style='font-size: 50px;'></i></a>";
					/*rec4 = 1;*/
				}
				tabla+="<tr><td><img class='img-thumbnail' src='"+val.icono+"'></td><td>"+val.moduloname+"</td><td>"+val.name+"</td><td>"+(val.tipo == 1 ? "Recurso del alumno" : "Recurso del docente")+"</td><td>"+rec1+"</td><td>"+rec2+"</td><td>"+rec3+"</td><td>"+rec5+"</td><td>"+rec4+"</td><td>"+(val.estatus == 1 ? "Activa": "Inactiva")+"</td><td><a onclick='editar_recurso("+val.clave+")'><i class='fa fa-pencil' aria-hidden='true'></i> Editar</td></a></tr>";
			});
			$("#tblAdminR tbody").html(tabla);

			$('#tblAdminR').dataTable({
				searching: false,
				paging: true,
				pageLength: 50,
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
	});
}

function reproducir(valor) {
	var audio = $("#recurso_"+valor).data("enlace");
	$("#recurso_"+valor).css({"text-shadow":"0 0 30px #00fff3"});
	var sound = new Howl({
      src: [audio],
      volume: 1.0,
      onend: function () {
        $("#recurso_"+valor).css({"text-shadow":"none"});
      }
    });
    sound.play()
}

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
				// $("#leccion").val(leccion);
			}
		});
	}
}

function editar_recurso(valor) {
	$("#modal-sinews").modal("show");
	$("#modal-sinewsLabel").html("Actualizar recurso");
	$(".form-check-input").removeClass("estatus");
	$("#upRec1").removeClass("validar");
	$("#upRec2").removeClass("validar");
	$("#upRec3").removeClass("validar");
	$("#upRec4").removeClass("validar");
	$.ajax({
		type: "POST",
		data: {valor: valor},
		url: context+"admin/informacionRecurso",
		dataType: "json",
		success: function (resp) {
			var info = resp.data[0];
			$("#tipoR").val(info.tipoR);
			$("#grado").val(info.modulo);
			cargar_lecciones(info.modulo, info.leccion);
			if (info.estatus == 1) {
				$("#estatus1").attr("checked", true);
			} else {
				$("#estatus2").attr("checked", true);
			}
		}
	});
}