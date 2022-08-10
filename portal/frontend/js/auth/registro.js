$(function(){


//nva_cliente
          
           
 $('#nva_cliente').validate({
            rules: {
                nombre:     { required: true },
                usuario:  { required: true },
                email:  { required: true, email: true },
                pass:   { required: true },
                pass2: { required:true, equalTo: "#pass"
                    }
               
            },
            messages: {
                nombre:     { required: '*El nombre es requerido' },
                usuario:    { required: '*El usuario es requerido' },
                email:    { required: '*El correo es requerido', email:'Correo no válido' },
                pass:    { required: '*La contraseña es requerida' },
                pass2: { required: '*La contraseña es requerida', equalTo: "La contraseña no coinciden"
                    }
               
               
                
            },
            errorPlacement: function(error, element){
                error.appendTo(element.parents('div').children('span.error'));

            },
            submitHandler: function() {
            	
                
         
                $('#processingAlert').modal('show');

                  var parameters = new FormData($('#nva_cliente')[0]);
              

                                          
                   if($('#pass').val()!='') parameters.append("password",  CryptoJS.SHA1( $('#pass').val() ).toString() );
                        
                    console.log("parameters : %O", parameters );

                    
                $.ajax({
                    url: context + 'auth/nva_usuario',
                    dataType: 'json',
                    type: 'post',
                    async: true,
                    data: parameters,
                    contentType:false,
                    processData:false,
                    cache:false
                }).done(function(data){
                        $('#modalAlert .modal-header').html('Alta de Usuario');
                        var msg = '';
                        console.log(data);
                        if(data.ok){
                            msg = "El usuario se ha creado";
                            $('#modalAlert').attr('data-r',data.ok);
                        }else{
                            msg = data.error;
                        }
                            
                        $('#modalAlert .modal-body').html('<p>'+msg+'</p>');
                        
                        $('#processingAlert').modal('hide');
                        $('#modalAlert').modal('show');
                    }).fail(function(jqXHR, textStatus){
                        console.log( "Request failed: " + textStatus );
                    });
           
	
            }
    });

 	

 	$('#modalAlertBotonOk').on('click',  function(event) {
 		event.preventDefault();
 		/* Act on the event */
 		 $('#modalAlert').modal('hide');
 		 var url = $('#modalAlert').attr('data-r');

 		 if( url != undefined )
 		 	location.href= url;

 	});

});