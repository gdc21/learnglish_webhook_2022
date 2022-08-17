function dar_accion_botones_preview(){
	$(".modal_previsualizar").click(function(){
		URL = this.getAttribute('url');

		enlaceA = context+"home/navegar/"+URL;

		window.open(enlaceA, '_blank').focus();

	})
}


$(document).ready(function () {



	$(window).on('load', function () {
		Cookies.remove('modulo')
		Cookies.remove('leccion')
	})




	var moduloid = Cookies.get('modulo');
	var leccionid = Cookies.get('leccion');
	// console.log("modulo "+moduloid)
	// console.log("leccion "+leccionid)
	if (moduloid != "" && leccionid != "") {
		cargar_tabla(Cookies.get('modulo'), Cookies.get('leccion'));
		cargar_lecciones(moduloid);
		$("#modulo").val(moduloid);
		$("#leccion").val(leccionid);
	}

	if ($("#modulo").val().trim() === '') {
		$("#leccion").html('<option value="">Todos las lecciones</option>');
	}

	$("#modulo").change(function () {
		$("#mensaje").hide();
		$("#mensaje").html("");
		$("#tabla").dataTable().fnDestroy();
		$("#ordenar").hide();
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

	$("#ordenar").click(function (e) {
		e.preventDefault();
		if ($("#modulo").val() != "" && $("#leccion").val() != "") {
			$(".modal-ordenamiento").modal("show");

			ordenamiento($("#modulo").val(), $("#leccion").val());
		}
	})

	$(".modal-ordenamiento").on('hidden.bs.modal', function () {
		$("#tabla").dataTable().fnDestroy();
		cargar_tabla($("#modulo").val(), $("#leccion").val());
    });
});

function cargar_tabla(modulo, leccion) {
	$.ajax({
		type: "POST",
		url: context+"admin/mostrarObjetos",
		data: {modulo: modulo, leccion: leccion},
		dataType: 'json',
		beforeSend: function () {
			$("#tabla tbody").html("");
		},
		success: function (resp) {
			if (resp.resultado) {
				$("#ordenar").show();
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

				/*Al dar clic en previsualizar se mostrara el modal con la seccion oculta*/
				dar_accion_botones_preview();
				$(".paginate_button").click(function(){
					console.log("dsa", this);
					dar_accion_botones_preview();
				});
			} else {
				$("#ordenar").hide();
				$("#tabla").dataTable().fnDestroy();
			}
		}
	});
}

function cargar_lecciones(modulo) {
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

function borrarObjeto(objeto){
	var confirma = confirm("¿Est\u00E1s seguro de ELIMINAR este objeto?");
	if (confirma) {
		$.ajax({
			type: "POST",
			url: context+"admin/borrarObjeto",
			data: {objeto: objeto},
			dataType: 'json',
			success: function (resp) {
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
					$("#tabla").dataTable().fnDestroy();
					cargar_tabla($("#modulo").val(), $("#leccion").val());
					setTimeout(function () {
						$("#mensaje").hide();
					}, 2000)
				}
			}
		});
	}
}

function eliminar(objeto) {
	var confirma = confirm("¿Est\u00E1s seguro de desactivar este objeto?");
	if (confirma) {
		$.ajax({
			type: "POST",
			url: context+"admin/accionObjeto",
			data: {objeto: objeto, estatus: 0},
			dataType: 'json',
	        success: function (resp) {
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

					$("#tabla").dataTable().fnDestroy();
					cargar_tabla($("#modulo").val(), $("#leccion").val());

					setTimeout(function () {
						$("#mensaje").hide();
					}, 2000)
	        	}
	        }
		});
	}
}

function activar(objeto) {
	var confirma = confirm("¿Est\u00E1s seguro de activar estw objeto?");
	if (confirma) {
		$.ajax({
			type: "POST",
			url: context+"admin/accionObjeto",
			data: {objeto: objeto, estatus: 1},
			dataType: 'json',
	        success: function (resp) {
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
					$("#tabla").dataTable().fnDestroy();
					cargar_tabla($("#modulo").val(), $("#leccion").val());
					setTimeout(function () {
						$("#mensaje").hide();
					}, 2000)
	        	}
	        }
		});
	}
}

function ordenamiento(modulo, leccion) {
	$.ajax({
		type: "POST",
		url: context+"admin/listarObjetos",
		data: {modulo: modulo, leccion: leccion},
		dataType: 'json',
		async: true,
		success: function (resp) {
			if (resp.resultado) {
				$("#lista").html(resp.lista);
				$("#sortable").html(resp.contenido);
				$("#tituloModal").html(resp.titulo);
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
						var nuevo = $('#sortable').children('li'),
						cambio = parseInt(ui.item[0].dataset.id),
						iden = parseInt(ui.item[0].dataset.iden),
						new_position = 0,
						identificador = ui.item[0].id,
						i= parseInt(ui.item[0].dataset.inicia),
						move = 0,
						id=0;
						console.log("i", i);

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



						//console.log("ui.item[0].dataset", ui.item[0].dataset);
						//console.log("cambio: "+cambio+" iden: "+iden+" ID: "+id+" Nueva posicion: "+new_position+" move: "+move);

						if(move != 0){

							if(!confirm("Confirmar cambios y aplicar en servidor?")){
								$('#sortable').sortable('cancel');
								return;
							}

							var datos = "";
							var variable={
								posicion : new_position,
								id : identificador
							}
							data = getInfoAjax('ordenarObjetos', variable,"admin");
							console.log("data 2 246", data);

							if(move == 1){
								var sons = $('#sortable').children('li');
								$.each(sons, function(){
									orden = parseInt(this.dataset.order);
									if(orden >= new_position && orden < cambio){
										var id = $('#'+this.id).attr('data-iden');
										$('#'+this.id).attr('data-order',(orden+1));
										$('#'+this.id).attr('data-id',(orden+1));
										var posicion = (orden+1);
										var variable = {
											id: id,
											posicion: posicion
										};
										$('#span_'+this.id+'').html(posicion+' )');
										var data = getInfoAjax('ordenarObjetos', variable,"admin");
										console.log("data 2 262", data);
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
										var variable = {
											id: id,
											posicion: posicion
										};
										$('#span_'+this.id+'').html(posicion+' )');
										data = getInfoAjax('ordenarObjetos', variable,"admin");
										console.log("data 2 284", data);
									}
								});
								$('#'+identificador).attr('data-order',new_position);
								$('#'+identificador).attr('data-id',new_position);
								$('#span_'+identificador+'').html(new_position+' )');
							}
						}
					}
				});
			} else {
				$("#contenido").html("");
			}
		}
	});
}