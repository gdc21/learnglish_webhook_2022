$(function() {
	var original = [], nuevo = [], nivel = 0, modulo = 0, leccion = 0, seccion = 0;
	$(document).ready(function() {
		var perfil = $('#perfil option:selected').val(), data;
		data = getInfoAjax('GetPerfiles', null, "admin");	
						
		var pop = '';
		$.each(data, function() {
		pop += '<option value="' + this.LGF0020001 + '">'
							+ this.LGF0020002 + '</option>';
		});
		$("#perfil").html('<option value="0">Seleccione un perfil</option>'+ pop);	
			
	});
	// Carga las opciones del combo de modulo
	$("#nivel").change(
			function() {
				var nivel = $('#nivel option:selected').val(), data;
				if (nivel != 0) {
					data = getInfoAjax('GETModulos', {
						nivel : nivel
					}, "admin");
					if (data.error) {
						// console.log(data.error);
					} else {
						var pop = '';
						$.each(data, function() {
							pop += '<option value="' + this.LGF0150001 + '">'
									+ this.LGF0150002 + '</option>';
						});
						$("#modulo").html(
								'<option value="0">Seleccione un Módulo</option>'
										+ pop);
						$("#add_modul").show();
					}
				} else {
					$("#modulo").html(
							'<option value="0">Seleccione un Nivel</option>');
					$("#add_modul").hide();
				}
			});
	// carga la opciones del combo de leccion
	$("#modulo").change(
			function() {
				var modulo = $('#modulo option:selected').val(), data;
				if (modulo != 0) {
					data = getInfoAjax('GETLecciones', {
						modulo : modulo
					}, "admin");
					if (data.error) {
						// console.log(data.error);
					} else {
						var pop = '';
						$.each(data, function() {
							pop += '<option value="' + this.LGF0160001 + '">'
									+ this.LGF0160002 + '</option>';
						});
						$("#leccion").html(
								'<option value="0">Seleccione una Lección</option>'
										+ pop);
						$("#add_lesson").show();
					}
				} else {
					$("#leccion").html(
							'<option value="0">Seleccione un módulo</option>');
					$("#add_lesson").hide();
				}
			});
	
	// add the rule here
	 $.validator.addMethod("valueNotEquals", function(value, element, arg){
	  return arg !== value;
	 }, "*Este campo es requerido");
	$('#nuevoUsuario')
			.validate(
					{
						rules : {
							nombre : {
								required : true,
								maxlength: 30
							},							
							lastnamep : {
								required : true,
								maxlength: 30
							},
							lastnamem : {
								required : true,
								maxlength: 30
							},
							user : {
								required : true,
								maxlength: 16
							},
							password : {
								required : true,
								minlength: 5,
								maxlength: 120
							},
							passwordconfirm : {
								required: "#password",
								minlength: 5,
								equalTo: "#password",
								maxlength: 120
							},
							perfil : {
								valueNotEquals: "0"
							},						
							sexo : {
								valueNotEquals: "0"
							},
							nivel : {
								valueNotEquals: "0"
							},
							modulo : {
								valueNotEquals: "0"
							},
							leccion : {
								valueNotEquals: "0"
							},
							archivoImg: { required: true, accept: "image/*", extension: "png|jpg" 
							}, 
						},
						messages : {
							nombre : {
								required : '*Este campo es requerido'
							},
							lastnamep : {
								required : '*Este campo es requerido'
							},
							lastnamem : {
								required : '*Este campo es requerido'
							},
							user : {
								required : '*Este campo es requerido'
							},
							password : {
								required : '*Este campo es requerido',minlength: 'Longitud mínima de 5 caracteres'
							},
							passwordconfirm : {
								required : '*Este campo es requerido',minlength: 'Longitud mínima de 5 caracteres',equalTo:'Debe ser igual a la contraseña'
							},
							perfil : {
								required : '*Este campo es requerido'
							},
							sexo : {
								required : '*Este campo es requerido'
							},
							nivel : {
								required : '*Este campo es requerido'
							},
							modulo : {
								required : '*Este campo es requerido'
							},
							leccion : {
								required : '*Este campo es requerido'
							},						
							archivoImg: {required: '*La imagen principal es requerida',  accept: '*Formato de imagen no válido', extension: '*La extensión no es valida (sólo: imágenes)'},

						},
						errorPlacement : function(error, element) {
							error.appendTo(element.parents('td').children(
									'span.error'));
						},
						submitHandler: function() {
			                
					         
			                 var parameters = new FormData($('#nuevoUsuario')[0]);
			                 if($('#password').val()!='') { parameters.append('password',CryptoJS.SHA1($('#password').val()).toString());}	
			                 
      
			              
			              	 $.ajax({
			                    url: context+'admin/saveUsuario',
			                    dataType: 'json',
			                    type: 'post',
			                    async: true,
			                    data: parameters,
			                    contentType:false,
			                    processData:false,
			                    cache:false
			                }).done(function(data){
			                	  // console.log(data);
//			                        $('#showAlert .modal-header').html('Alta de contenido');
//			                        var msg = '';
//
//			                        if(data.mensaje){
//			                            msg = data.mensaje;
//			                            $('#showAlert .btn-default').attr('data-action','r');
//			                        }else{
//			                            msg = data.error;
//			                        }
//			                            
			                	  if(data.error){
			                		  	$('#mensaje').removeClass("alert-success");
										$('#mensaje').addClass("alert-warning");
										$('#mensaje').show("swing");
										$('#mensaje').html('<b>' + data.error + '</b>');     		  
			                		
			                           
			                        }else{
			                        	
			                        	$('#mensaje').addClass("alert-success");
										$('#mensaje').removeClass("alert-warning");
										$('#mensaje').show("swing");
										$('#mensaje').html('<b>' + data.mensaje + '</b>');
			                            
			                        }			                            
			                        
			                    }).fail(function(jqXHR, textStatus,errorThrown ){
			                        // console.log( "Request failed: " + textStatus+errorThrown +jqXHR.status );
			                    });

			            }
					});

});
