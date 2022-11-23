$(document).ready(function () {
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
function mostrarTablaAlumnos(id_grupo, modal, orden){
	var data2 = getInfoAjax('listar_alumnos_grupo_especifico',
		{id: id_grupo, orden: orden},
		'admin');

	if(data2){
		modal.innerHTML = '';

		if(data2['permiso'] == 1){
			/*Administrar, Se creo el boton en el lado de la vista para validacion de modulo
			permitir edicion a docente este activo*/
			var adminAlumnos = document.createElement('a');
			adminAlumnos.target = '_blank';
			adminAlumnos.href = context + 'home/teacher_students/'+id_grupo;
			adminAlumnos.classList.add('btn');
			adminAlumnos.classList.add('shadow');
			adminAlumnos.classList.add('ms-3');
			adminAlumnos.classList.add('text-white');
			adminAlumnos.classList.add('btn-success');
			adminAlumnos.innerText = "Administrar alumnos";

			modal.append(adminAlumnos);
		}

		var tablaAlumnos = document.createElement('table');
		tablaAlumnos.classList.add('table');
		tablaAlumnos.classList.add('tabla');
		tablaAlumnos.id = 'tablaAlumnos';

		var campos_tabla = ['nombre_simple', 'a_paterno', 'a_materno', 'institucion', 'curp', 'CCT'];

		if(data2['permiso'] == 1){
			campos_tabla = (","+campos_tabla.toString()).split(',');
		}

		var tbody = document.createElement('tbody');
		var thead = document.createElement('thead');
		var trThead = document.createElement('tr');

		if(data2['lista'].length > 0){
			data2['lista'].forEach(function(item, indiceArray){
				var tr = document.createElement('tr');
				tbody.append(tr);

				campos_tabla.forEach(function(elemento, indice_campos){
					if(indice_campos == 0){
						var td = document.createElement('td');
						if(data2['permiso'] == 1){

							var botonEliminar = document.createElement('button');
							botonEliminar.classList.add('btn');
							botonEliminar.classList.add('btn-danger');
							botonEliminar.classList.add('font-1x');
							botonEliminar.innerText = 'Quitar del grupo';
							botonEliminar.setAttribute('grupo', id_grupo);
							botonEliminar.setAttribute('id_alumno', item['id']);
							botonEliminar.onclick = function(){

								if(!confirm("¿Seguro que desear quitar al alumno del grupo?")){
									return;
								}

								var data2 = getInfoAjax('eliminar_alumno_grupo',
									{id_grupo: id_grupo, alumno: item['id']},
									'admin');

								if(data2){
									alert(data2['mensaje']);
									if(data2['status'] == 1){
										location.reload();
									}
								}
							}

							td.append(botonEliminar);
							tr.append(td);
						}
					}
					if (indiceArray == 0){
						var th = document.createElement('th');
						if(elemento == 'nombre_simple'){
							th.innerHTML = 'nombre';
						}else{
							th.innerHTML = elemento;
						}
						trThead.append(th);
						thead.append(trThead);

						if(indice_campos == campos_tabla.length-1){
							tablaAlumnos.append(thead);
							tablaAlumnos.append(tbody);
						}
					}

					if(data2['permiso'] == 1){
						if(indice_campos != 0){
							var td = document.createElement('td');
							td.innerHTML = item[elemento];
							tr.append(td);
						}
					}else{
						var td = document.createElement('td');
						td.innerHTML = item[elemento];
						tr.append(td);
					}
				});
			});

			modal.append(tablaAlumnos);
			$("#tablaAlumnos").dataTable({
				language: {
					search: "Buscar alumno: ",
				}
			});
		}

	}
}
function cargar_grupos() {
	$.ajax({
		type: "POST",
		url: context+'home/mostrar_grupos',
		data: {grupos: 'grupos'},
		dataType: 'json',
		success: function (resp) {
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

			/* Cuando ya se carga la data lista de grupos, hay un boton que dice
			* ver alumnos del grupo, esta cargara un listado en el modal con la
			* funcion mostrarTablaAlumnos*/
			$(".boton-mostrar-alumnos").click(function(){
				var id_grupo = this.getAttribute('grupo');
				var listadoAlumnosModal = $("#listadoAlumnosModal")[0];

				mostrarTablaAlumnos(id_grupo, listadoAlumnosModal, 'LGF0010002');
			});

			$(".eliminar_grupo").click(function(){

				if(confirm("¿Seguro que deseas borrar al grupo?")){

					var grupoId = this.getAttribute('grupo');

					$.ajax({
						url: context+"admin/eliminar_grupo",
						type: "POST",
						data: {grupo: grupoId},
						dataType: "json",
						success: function (resp) {
							alert(resp.respuesta);
							if(resp.recargar){
								location.reload();
							}
						}
					});
				}
			})
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