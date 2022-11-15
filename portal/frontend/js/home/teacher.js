$(document).ready(function () {
	console.log("function hola");
	cargar_grupos();








	$("#saveGL").click(function (e) {
		e.preventDefault();
		var inputs = $(".form-check-input");
		var lecciones = "";
		var i = 0;
		$.each(inputs, function (argument) {
			if( $(this).is(":checked") ) {
				//if (i>0) {
					if ( lecciones == '' ) {
						lecciones+=$(this).val();
					} else {
						lecciones+=","+$(this).val();
					}
				//}
				i++;
			}
		});
		var data = $("#formGL").serialize();
		data+="&lecciones="+lecciones
		
		$.ajax({
			type: "POST",
			url: context+"home/saveAccesosL",
			data: data,
			dataType: "json",
			success: function (resp) {
				// $("#mensaje").slideToggle(3000);
				$("#mensaje").slideToggle( "fast", function() {
				    $("#mensaje").html(resp.mensaje);
				    setTimeout(function () {
				    	$("#mensaje").fadeOut("fast");
				    	$("#mensaje").html("");
				    }, 3000);
				});
			}
		});
	});

	$("#all").change(function (e) {
		e.preventDefault();
		var inputs = $(".form-check-input");
		if ($(this).is(":checked")) {
			$.each(inputs, function (argument) {
				$(this).attr("checked", true)
			})
		} else {
			$.each(inputs, function (argument) {
				$(this).attr("checked", false)
			})
		}
	});
});

function cargar_grupos() {
	$.ajax({
		type: "POST",
		url: context+'home/mostrar_grupos',
		data: {grupos: 'grupos'},
		dataType: 'json',
		success: function (resp) {
			console.log(resp)
			$("#contenido_tabla tbody").html(resp.contenido);
			$('#contenido_tabla').dataTable({
				searching: false,
				paging: false,
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



			$(".boton-mostrar-alumnos").click(function(){

				var id_grupo = this.getAttribute('grupo');
				var listadoAlumnosModal = $("#listadoAlumnosModal")[0];

				var data2 = getInfoAjax('listar_alumnos_grupo_especifico', {id: id_grupo}, 'admin');

				if(data2){
					listadoAlumnosModal.innerHTML = '';

					var tablaAlumnos = document.createElement('table');
					tablaAlumnos.classList.add('table');
					tablaAlumnos.classList.add('tabla');
					tablaAlumnos.id = 'tabla';

					var campos_tabla = ['nombre', 'institucion', 'curp', 'CCT'];

					var tbody = document.createElement('tbody');
					var thead = document.createElement('thead');

					data2['lista'].forEach(function(item, indiceArray){
						var tr = document.createElement('tr');
						tbody.append(tr);

						campos_tabla.forEach(function(elemento, indice_campos){
							if (indiceArray == 0){
								var th = document.createElement('th');
								th.innerHTML = elemento;
								thead.append(th);

								if(indice_campos == campos_tabla.length-1){
									var th = document.createElement('th');
									th.innerHTML = "Acciones";
									thead.append(th);

									tablaAlumnos.append(thead);
									tablaAlumnos.append(tbody);
								}
							}
							var td = document.createElement('td');
							td.innerHTML = item[elemento];
							tr.append(td);

						});
					});

					listadoAlumnosModal.append(tablaAlumnos);

				}
			});
		}
	});
}

function gestionar_lecciones(modulo, grupo, docente) {
	$("#mensaje").hide();
	$("#modulo").val(modulo);
	$("#grupo").val(grupo);
	$("#docente").val(docente);
	$("#all").prop("checked", false);
	$.ajax({
		type: "POST",
		data: {grupo: grupo, nivel: modulo, docente: docente},
		dataType: "json",
		url: context+"home/accesosLecciones",
		success: function (resp) {
			$("#moduloL").html(resp.modulo);
			$("#ModalLabel").html(resp.grupo);
			var contenidoL = '<div class="row">';
			var contador = 0;
			var total = resp.lecciones.length;
			$.each(resp.lecciones, function (pos, val) {
				if (val.activo == 1) {
					contador++;
					check = "checked";
				} else {
					check = "";
				}
				contenidoL+='<div class="col-lg-6"><div class="form-check">';
				contenidoL+='<input class="form-check-input" type="checkbox" value="'+val.cvl+'" id="leccion'+val.cvl+'" '+check+'>';
				contenidoL+='<label class="form-check-label" for="leccion'+val.cvl+'">'+val.nombre+'</label>';
				contenidoL+='</div></div>';
			})
			contenidoL+='</div>';
			$("#lecciones").html(contenidoL);
			if (total == contador) {
				$("#all").prop("checked", true);
			}
		}
	});
	$("#modalLecciones").modal("show");
}