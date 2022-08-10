$(document).ready(function () {
	cargar_tabla($("#modulo").val());
	$("#modulo").change(function () {
		var modulo = $(this).val();
		if (modulo.trim() === '') {
			cargar_tabla("");
			$("#ordenar").hide();
		} else {
			cargar_tabla(modulo);
			$("#ordenar").show();
		}
	});

	$("#btnP").click(function (e) {
		e.preventDefault();
		$("#iconoP").trigger("click");
	});
	$("#btnS").click(function (e) {
		e.preventDefault();
		$("#iconoS").trigger("click");
	});

	$("#iconoP").on('change', function (e) {
		var file = document.querySelector('#iconoP').files[0];
		var fileN = getBase64(file, "#imgP");
	});

	$("#iconoS").on('change', function (e) {
		var file = document.querySelector('#iconoS').files[0];
		var fileN = getBase64(file, "#imgS");
	});

	$("#m-lecciones").on('hidden.bs.modal', function () {
		$("#formL")[0].reset();
		$("#iconoP").val("");
		$("#iconoS").val("");
		$("#imgP").attr("src", context+"portal/archivos/iconosLecciones//icono_temporal.png");
		$("#imgS").attr("src", context+"portal/archivos/iconosLecciones//icono_temporal.png");
		$("#newM").hide();
		cargar_tabla($("#modulo").val());
   });

	$("#save").click(function (e) {
		e.preventDefault();
		var form = new FormData($('#formL')[0]);
		$.ajax({
        	url: context+'admin/accionesLeccion',
        	type: "post",
         data : form,
         processData: false,
         contentType: false,
         success: function(data) {
         	// console.log(data.mensaje);
         	$("#mensaje").toggle(1000);
         	$("#mensaje").html(data.mensaje);
         	setTimeout(function () {
         		$("#mensaje").html("");
         		$('#mensaje').hide(1000);
         	}, 4000);
         }
     	});
	});

	$("#ordenar").click(function (e) {
		e.preventDefault();
		if ($("#modulo").val() != "") {
			$(".modal-ordenamiento").modal("show");

			ordenamiento($("#modulo").val());
		}
	})

	$(".modal-ordenamiento").on('hidden.bs.modal', function () {
		cargar_tabla($("#modulo").val());
    });

	$("#l-migrar").on('hidden.bs.modal', function () {
		$("#formM")[0].reset();
		$("#contenedor").html("");
   });

   $("#migrar").click(function (e) {
   	e.preventDefault();
	   if ($("#smodulo").val() != "" && $("#nmigrar").val() != "") {
	   	if ($("#smodulo").val() != $("#nmigrar").val()) {
	   		var lecciones = "";
		   	var array = [];
		   	$(".modulos").each(function () {
		   		var id = $(this).attr("id");
		   		if ($('#'+id).is(':checked')) {
		   			array.push($(this).val())
		   		}
		   	})

		   	if (array.length > 0) {
		   		$.each(array, function (i, val) {
		   			if (i == 0) {
		   				lecciones=val;
		   			} else {
		   				lecciones+=","+val;
		   			}
		   		});
		   	}
		   	
		   	$.ajax({
		   		type: "POST",
		   		data: {oldM: $("#smodulo").val(), newM: $("#nmigrar").val(), leccion: lecciones},
		   		url: context+"admin/migrarLecciones1",
		   		success: function (res) {
		   			$("#mensajeM").show();
		   			$("#mensajeM").removeClass("alert-danger");
				   	$("#mensajeM").addClass("alert-success");
				   	$("#mensajeM").html(res.res);
		   			$.ajax({
							type: "POST",
							url: context+"admin/mostrarLecciones",
							data: {modulo: $("#smodulo").val(), accion: 3},
							dataType: 'json',
							async: true,
							beforeSend: function () {
								$("#contenedor").html("");
							},
							success: function (resp) {
								$("#contenedor").html(resp.contenido);
							}
						});
		   		}
		   	});
	   	} else {
	   		$("#mensajeM").toggle();
	   		setTimeout(function () {
	   			$("#mensajeM").hide();
	   		}, 3000)
	   		$("#mensajeM").removeClass("alert-success");
		   	$("#mensajeM").addClass("alert-danger");
		   	$("#mensajeM").html("No se puede migrar la(s) leccion(es) en el mismo modulo");
	   	}
	   } else {
	   	$("#mensajeM").toggle();
	   	setTimeout(function () {
	   		$("#mensajeM").hide();
	   	}, 3000)
	   	$("#mensajeM").removeClass("alert-success");
	   	$("#mensajeM").addClass("alert-danger");
	   	$("#mensajeM").html("Selecciona los módulos");
	   }
   });
});

function cargar_tabla(modulo) {
	$.ajax({
		type: "POST",
		data: {modulo: modulo, accion: 1},
		url: context+"admin/mostrarLecciones",
		dataType: "json",
		beforeSend: function () {
			$("#tabla").dataTable().fnDestroy();
			var nColumnas = $("#tabla thead tr:first th").length
			var tabla = "<tr>";
			for (var i = 1; i <= nColumnas; i++) {
				if (i==1) {
					tabla+="<td style='font-size: 8px;'><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></td>";
				} else {
					tabla+="<td style='font-size: 8px;'><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></td>";
				}
			}
			tabla+="</tr>";
			$("#tabla tbody").html(tabla);
		},
		success: function (resp) {
			$("#tabla tbody").html(resp.contenido)
			$('#tabla').DataTable({
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
		}
	});
}

function editar(valor, posicion) {
	$("#m-lecciones").modal("show");
	if (valor == "") {
		$("#tituloModal").html("Registrar Lección ");
		$("#newM").show();
	} else {
		$("#tituloModal").html("Editar información - Lección "+posicion);
	}
	$.ajax({
		type: "POST",
		data: {valor: valor},
		url: context+"admin/informacionLeccion",
		dataType: "json",
		success: function (resp) {
			var info = resp.info;
			$("#clave").val(valor);
			$("#seccion").val(info.modulo);
			$("#orden").val(posicion);
			$("#nombre").val(info.nombre);
			$("#imgP").attr("src", info.icono);
			$("#imgS").attr("src", info.icono2);
			$("#status").val(info.status);
		}
	});
}

function getBase64(file, target) {
   var reader = new FileReader();
   reader.readAsDataURL(file);
   reader.onload = function () {
		$(target).attr("src", reader.result);
   };
   reader.onerror = function (error) {
		console.log('Error: ', error);
   };
   return reader.result;
}

function ordenamiento(modulo) {
	$.ajax({
		type: "POST",
		url: context+"admin/mostrarLecciones",
		data: {modulo: modulo, accion: 2},
		dataType: 'json',
		async: true,
		success: function (resp) {
			$("#sortable").html(resp.contenido);
			$('#sortable').sortable({
				axis: "y",
				start: function(e, ui){
					placeholderHeight = ui.item.outerHeight();
					ui.placeholder.height(placeholderHeight + 15);
					$('<div class="slide-placeholder-animator" data-height="' + placeholderHeight + '"></div>').insertAfter(ui.placeholder);
				},
				change: function(event, ui) {
					ui.placeholder.stop().height(0).animate({
						height: ui.item.outerHeight() + 15
					}, 300);
					placeholderAnimatorHeight = parseInt($(".slide-placeholder-animator").attr("data-height"));
					$(".slide-placeholder-animator").stop().height(placeholderAnimatorHeight + 15).animate({
						height: 0
					}, 300, function() {
						$(this).remove();
						placeholderHeight = ui.item.outerHeight();
						$('<div class="slide-placeholder-animator" data-height="' + placeholderHeight + '"></div>').insertAfter(ui.placeholder);
					});
				},
				stop: function (event, ui) {
					// console.log(ui.item[0].id)
					var nuevo = $('#sortable').children('li'),
					cambio = parseInt(ui.item[0].dataset.id),
					iden = parseInt(ui.item[0].dataset.iden),
					position_original = parseInt(ui.item[0].dataset.order),
					modulo = parseInt(ui.item[0].dataset.modulo),
					old_position = 0,
					new_position = 0,
					identificador = ui.item[0].id,
					i= parseInt(ui.item[0].dataset.inicia),
					move = 0,
					id=0;

					// console.log("cambio: "+cambio+" iden: "+iden+" ID: "+id+" Posicion: "+new_position+" move: "+move);

					$.each(nuevo, function(){
						i++;
						if(this.dataset.order == cambio){
							new_position = i;
							id = this.dataset.id;
							if(i < cambio){
								move = 1;
							}else if(i > cambio){
								move = -1;
							}else{
								move = 0;
							}
							return;
						}
					});

					// console.log("cambio: "+cambio+" iden: "+iden+" ID: "+id+" Nueva posicion: "+new_position+" move: "+move);
					var ids = "";
					var oldPositions = "";
					var newPositions = "";
					if(move != 0){
						/*var variable={
							old: position_original,
							posicion : new_position,
							id : identificador
						}*/
						ids = identificador;
						oldPositions = position_original;
						newPositions = new_position;
						// data = getInfoAjax('ordenarLecciones', variable,"admin");
						
						if(move == 1){
							var sons = $('#sortable').children('li');
							$.each(sons, function(){
								orden = parseInt(this.dataset.order);
								if(orden >= new_position && orden < cambio){
									var id = $('#'+this.id).attr('data-iden');
									$('#'+this.id).attr('data-order',(orden+1));
									$('#'+this.id).attr('data-id',(orden+1));
									var posicion = (orden+1);
									/*var variable = {
										id: id,
										old: orden,
										posicion: posicion
									};*/
									$('#span_'+this.id+'').html(posicion+' )');
									ids+=","+id;
									oldPositions+=","+orden;
									newPositions+=","+posicion;
									// var data = getInfoAjax('ordenarLecciones', variable,"admin");
								}
							});
							$('#'+identificador).attr('data-order',new_position);
							$('#'+identificador).attr('data-id',new_position);
							$('#span_'+identificador+'').html(new_position+' )');
						}else if(move == -1){
							var sons = $('#sortable').children('li');
							$.each(sons, function(){
								orden = parseInt(this.dataset.order);
								if(orden <= new_position && orden > cambio){
									var id = $('#'+this.id).attr('data-iden');
									$('#'+this.id).attr('data-order',(orden-1));
									$('#'+this.id).attr('data-id',(orden-1));
									var posicion = (orden-1);
									/*var variable = {
										id: id,
										old: orden,
										posicion: posicion
									};*/
									$('#span_'+this.id+'').html(posicion+' )');
									ids+=","+id;
									oldPositions+=","+orden;
									newPositions+=","+posicion;
									// data = getInfoAjax('ordenarLecciones', variable,"admin");
								}
							});
							$('#'+identificador).attr('data-order',new_position);
							$('#'+identificador).attr('data-id',new_position);
							$('#span_'+identificador+'').html(new_position+' )');
						}
					}
					// console.log("IDS: "+ids+"\nOld: "+oldPositions+"\nNew: "+newPositions)
					var variable={
						old: oldPositions,
						posicion : newPositions,
						id : ids,
						modulo: modulo
					}
					data = getInfoAjax('ordenarLecciones', variable,"admin");
				}
			});
		}
	});
}

function migrar() {
	$("#l-migrar").modal("show");
	$("#smodulo").change(function () {
		$.ajax({
			type: "POST",
			url: context+"admin/mostrarLecciones",
			data: {modulo: $(this).val(), accion: 3},
			dataType: 'json',
			async: true,
			beforeSend: function () {
				$("#contenedor").html("");
			},
			success: function (resp) {
				$("#contenedor").html(resp.contenido);
			}
		});
	})
}