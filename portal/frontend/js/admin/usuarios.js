$(document).ready(function () {
	// console.log($("#id").val())
	cargar_usuarios($("#institucion").val());
	cargar_grupos($("#institucionUp").val(), $("#nivel").val());

	if ($("#perfil").val() == 2) {
		$("#grupo").prop("disabled", false);
		$("#nivel").prop("disabled", false);
	} else {
		$("#grupo").prop("disabled", true);
		$("#nivel").prop("disabled", true);
	}

	$("#institucion").on('change', function () {
		$("#tabla").dataTable().fnDestroy();
		cargar_usuarios($(this).val());
	});

	$("#perfil").change(function () {
		if ($(this).val() == 2) {
			$("#nivel").prop("disabled", false);
			$("#grupo").prop("disabled", false);
		} else {
			$("#nivel").prop("disabled", true);
			$("#grupo").prop("disabled", true);
		}
	});

	$("#formUsuario").validate({
		ignore: "not:hidden",
		rules:{
			institucion:{
				required: true
			},
			perfil:{
				required: true
			},
			nombre:{
				required: true
			},
			aPaterno:{
				required: true
			},
			genero:{
				required: true
			},
			nivel:{
				required: true
			},
			usuario:{
				required: true
			},
			password:{
				required : true,
				minlength: 5,
				maxlength: 120
			},
			estatus:{
				required: true
			},
			curp:{
				required: true
			}
		},
		messages:{
			institucion:{
				required : '*Este campo es requerido'
			},
			perfil:{
				required : '*Este campo es requerido'
			},
			nombre:{
				required : '*Este campo es requerido'
			},
			aPaterno:{
				required : '*Este campo es requerido'
			},
			genero:{
				required : '*Este campo es requerido'
			},
			nivel:{
				required : '*Este campo es requerido'
			},
			usuario:{
				required : '*Este campo es requerido'
			},
			password:{
				required : '*Este campo es requerido',
				minlength: 'Longitud mínima de 5 caracteres'
			},
			estatus:{
				required : '*Este campo es requerido'
			},
			curp:{
				required : '*Este campo es requerido'
			}
		},
		errorPlacement : function(error, element) {
			error.appendTo(element.parents('td').children('span.error'));
		},
		submitHandler: function() {
			var data = new FormData($('#formUsuario')[0]);
			
			if($('#password').val()!='') { 
				data.set('pass', data.get('password'));
				data.append('password',CryptoJS.SHA1($('#password').val()).toString());
			}
			$.ajax({
				type: 'POST',
				url: context+'admin/saveAddUsuario',
				data: data,
				dataType: 'json',
				contentType:false,
                processData:false,
                cache:false,
                async: true,
                success: function (resp) {
                	if (resp.error) {
                		$('#mensaje').removeClass("alert-success");
						$('#mensaje').addClass("alert-warning");
						$('#mensaje').show("swing");
						$('#mensaje').html('<b>' + resp.error + '</b>');
                	} else {
                		$('#formUsuario')[0].reset();
                		$('#mensaje').addClass("alert-success");
						$('#mensaje').removeClass("alert-warning");
						$('#mensaje').show("swing");
						$('#mensaje').html('<b>' + resp.mensaje + '</b>');
                	}
                }
			});
		}
	});

	$("#updateUsuario").on('click', function (e) {
		e.preventDefault();
		var data = new FormData($("#formUpUsuario")[0]);
		if($('#password').val()!='') {
			data.set('pass', data.get('password'));
			data.append('password',CryptoJS.SHA1($('#password').val()).toString());
		}
		console.log("data", data);
		$.ajax({
			type: 'POST',
			url: context+'admin/updateUsuario',
			data: data,
			// dataType: 'json',
			contentType:false,
            processData:false,
            cache:false,
            async: true,
            success: function (resp) {
            	// console.log(resp)
            	if (resp.error) {
            		$('#mensaje').removeClass("alert-success");
					$('#mensaje').addClass("alert-warning");
					$('#mensaje').show("swing");
					$('#mensaje').html('<b>' + resp.error + '</b>');
            	} else {
            		$('#mensaje').addClass("alert-success");
					$('#mensaje').removeClass("alert-warning");
					$('#mensaje').show("swing");
					$('#mensaje').html('<b>' + resp.mensaje + '</b>');
            	}
            }
		});
	});

	$("#imagenPerfil").on('click', function (e) {
		$("#foto").click();
	});

	$("#foto").on('change', function (e) {
		var file = document.querySelector('#foto').files[0];
		var fileN = getBase64(file, "#imagenPerfil");
	});

	$("#curp").blur(function (e) {
		// console.log($("#id").val())
		if ($(this).val() != "") {
			$.ajax({
				type: 'POST',
				data: {matricula: $(this).val(), clave: $("#id").val()},
				url: context+'admin/validarMatricula',
				dataType: 'json',
				success: function (resp) {
					if (resp.error == 1) {
						$("#matricula").html("Ya existe un usuario con este CURP registrado");
						$("#save").attr("disabled", true);
						$("#updateUsuario").attr("disabled", true);
					} else {
						$("#matricula").html("");
						$("#save").attr("disabled", false);
						$("#updateUsuario").attr("disabled", false);
					}
				}
			});
		}
	});

	$("#institucionUp").on('change', function (e) {
		e.preventDefault();
		if ($(this).val() != "") {
			$.ajax({
				type: "POST",
				data: {id: $(this).val()},
				url: context+"admin/validarLicencias",
				dataType: 'json',
				success: function (resp) {
					// console.log(resp)
					if (resp.error) {
						// alert(resp.error)
						$('#mensaje').removeClass("alert-success");
						$('#mensaje').addClass("alert-warning");
						$('#mensaje').show("swing");
						$('#mensaje').css("color","#ff0000");
						$("#A_t_Neval tr td").css("border","1px solid #ff0000")
						$('#mensaje').html('<b>' + resp.error + '</b>');
						$(".registro").prop('disabled', true);
					} else {
						$(".registro").prop('disabled', false);
						$("#A_t_Neval tr td").css("border","1px solid #000000")
						$(".nameCampo").css("border","none")
						$('#mensaje').hide();
						$('#mensaje').html("");
					}
				}
			});

			cargar_grupos($(this).val(), $("#nivel").val());
		} else {
			$("#grupo").html('<option value="">Selecciona un grupo</option>');
		}
	});

	$("#nivel").on('change', function (e) {
		e.preventDefault();
		if ($(this).val() != "") {
			$.ajax({
				type: "POST",
				data: {id: $(this).val()},
				url: context+"admin/leccion",
				dataType: 'json',
				success: function (resp) {
					// console.log(resp)
					$("#leccion").val(resp.leccion);
				}
			});

			cargar_grupos($("#institucionUp").val(), $("#nivel").val());
		} else {
			$("#leccion").val("");
		}
	});

})

function cargar_usuarios(id) {
	// crear_tabla("#tabla");
	$.ajax({
		type: 'POST',
		data: {id: id},
		url: context+'admin/obtenerUsuarios',
		dataType: 'json',
		beforeSend: function () {
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
			$("#tabla tbody").html(resp.info);
			/*$.fn.dataTable.moment( 'HH:mm MMM D, YY' );
			$.fn.dataTable.moment( 'dddd, MMMM Do, YYYY' );*/
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
				"order": [[ 3, "desc" ]], //or asc 
				columnDefs: [{ type: 'de_date', targets: 3 }]
			});
			// $("#tabla_filter label").text("Buscar");
		}
	});
}

function cargar_grupos(institucion, grado) {
	var id_grupo = $("#grupo_id").val();
	if (institucion != "" && grado != "") {
		$.ajax({
			type: "POST",
			data: {id: institucion, grado: grado},
			url: context+"admin/obtenerGrupos",
			dataType: 'json',
			success: function (resp) {
				var obj = eval(resp.lista);
				// console.log(obj)
				var option = "<option value=''>Selecciona un grupo</option>";
				var seleccionado = "";
				$.each(obj, function (key, value) {
					// console.log(value.LGF0290001+" -> "+value.LGF0290002+"\n")
					if (id_grupo == value.LGF0290001) {
						seleccionado = "selected";
					} else {
						seleccionado = "";
					}
					option+="<option value='"+value.LGF0290001+"' "+seleccionado+">"+value.LGF0290002+"</option>";
				});
				$("#grupo").html(option);
			}
		});
	}
}
function eliminar(id) {
	var confirma = confirm("¿Est\u00E1s seguro de eliminar este registro?");
	if (confirma) {
		// console.log("Eliminado")
		$.ajax({
			type: 'POST',
			url: context+'admin/deleteUsuario',
			data: {id: id},
			dataType: 'json',
			success: function(resp) {
				// console.log(resp)
				if (resp.error) {
            		alert(resp.error);
            	} else {
            		alert(resp.mensaje);
            		location.reload();
            	}
			}
		});
	} else {
		// console.log("Error")
	}
}

function getBase64(file, target) {
   var reader = new FileReader();
   reader.readAsDataURL(file);
   reader.onload = function () {
		$(target).attr("src", reader.result);
   };
   reader.onerror = function (error) {
		// console.log('Error: ', error);
   };
   return reader.result;
}