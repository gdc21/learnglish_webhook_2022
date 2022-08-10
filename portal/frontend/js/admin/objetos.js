$(document).ready(function(){
	// console.log(context);
$("#file-4").fileinput({
 	'allowedFileExtensions' : ['zip','rar'],    
 	uploadAsync: true,
    language: "es",
    previewFileIcon: '<i class="fa fa-file"></i>',
    allowedPreviewTypes: null, // set to empty, null or false to disable preview for all types
    previewFileIconSettings: {
        'docx': '<i class="fa fa-file-word-o text-primary"></i>',
        'xlsx': '<i class="fa fa-file-excel-o text-success"></i>',
        'pptx': '<i class="fa fa-file-powerpoint-o text-danger"></i>',
        'jpg': '<i class="fa fa-file-photo-o text-warning"></i>',
        'pdf': '<i class="fa fa-file-pdf-o text-danger"></i>',
        'zip': '<i class="fa fa-file-archive-o text-muted"></i>',
     	'rar': '<i class="fa fa-file-archive-o text-muted"></i>',
    },
    maxFileCount: 1,
    autoReplace: true,
    overwriteInitial: true,
    'msgInvalidFileExtension' : 'Solo son permitidos archivos de tipo .zip y/o .rar',
	'uploadUrl' : context + 'admin/' +'UploadFiles',
    uploadExtraData: function (previewId, index) {
            var info = {'id' : $( "#edit_seccion" ).data( "id") , 'id_sec' : $( "#edit_seccion" ).data( "id_sec"), 'id_modulo' : $( "#edit_seccion" ).data( "id_modulo"), 'id_leccion' : $( "#edit_seccion" ).data( "id_leccion"), 'sec_name_sele' : $("#sec_name_sele").data("key")};
            return info;
	}    
});
$('#file-4').on('fileuploaded', function(event, data, previewId, index) {
    var form = data.form, files = data.files, extra = data.extra,
        response = data.response, reader = data.reader;
    // console.log('File uploaded triggered');
    mostrarAlert('','Elemento alamacenado');
    botonOkModal();
      $('#modalAlertBotonOk').on("click", function(){
    	$('#file-4').fileinput('reset');
    	$('#file-4').fileinput('clear');
    });

});
var originalState = $("#file-4").clone();    
$(".btn-warning").on('click', function() {
    if ($('#file-4').attr('disabled')) {
        $('#file-4').fileinput('enable');
    } else {
        $('#file-4').fileinput('disable');
    }
});    

$("#cerrar").on("click", function(){ $('#add_seccion').hide('100'); });
$("#cerrar_2").on("click", function(){ $('#edit_seccion').hide('100'); });

var original=[], 
	nuevo=[],nivel = 0,modulo = 0,leccion = 0, seccion = 0;
//boton para desplegar el formulario de agregar nueva seccion a la estructura de navegacion
$('.add_sec_btn').click(function(){
	$(".field_position span").show();
	$('#add_seccion').show();
	list = data = getInfoAjax('GETListSec',null,"admin");
	lista ="";
	$.each(list, function(){
		lista += '<option value="'+this.LGF0170001+'">'+ this.LGF0170002 +'</option>';
	});
	$('#new_seccion').html('<option value="0">Seleccione nombre de la sección</option>'+lista);
	nivel = $('#nivel option:selected').val(),
	modulo = $('#modulo option:selected').val(),
	leccion = $('#leccion option:selected').val();
	data = getInfoAjax('GETSecciones', {nivel : nivel, modulo : modulo, leccion : leccion},"admin");
	if(data.length != 0){
		lista2="";
		for(i=1; i<=data.length;i++){
			lista2 += '<option value="'+i+'">'+ i +'</option>';
		}
		$('#num_seccion').html(lista2);
	}else{
		$(".field_position span").hide();
	}
});
//Habilita/deshabilita el combo con las secciones del formulario de agregar nueva seccion a la estructura
$('[name="posicion"]').click(function(){	
	if(this.value == "C"){		
		$('#num_seccion').prop( "disabled", false );
	}else{
		$('#num_seccion').prop( "disabled", true );
	}
});
//Carga las opciones del combo de modulo
$("#nivel").change(function(){
        var nivel = $('#nivel option:selected').val(), data;
        if (nivel != 0){
        	data = getInfoAjax('GETModulos', {nivel : nivel},"admin");
        	if(data.error){
                  // console.log(data.error);
           }else{
        	   var pop = '';
        	   $.each(data, function(){
        		   pop += '<option value="'+this.LGF0150001+'">'+ this.LGF0150002 +'</option>';
        	   });
        	   $("#modulo").html('<option value="0">Seleccione un Módulo</option>'+pop);
        	   $("#add_modul").show();
           }
        }else{
        	$("#modulo").html('<option value="0">Seleccione un Nivel</option>');
        	$("#add_modul").hide();
        }
        seleccionadora();
});
//carga la opciones del combo de leccion
$("#modulo").change(function(){
    var modulo = $('#modulo option:selected').val(), data;
    if (modulo != 0){
    	data = getInfoAjax('GETLecciones', {modulo : modulo},"admin");
    	if(data.error){
              // console.log(data.error);
       }else{
    	   var pop = '';
    	   $.each(data, function(){
    		   pop += '<option value="'+this.LGF0160001+'">'+ this.LGF0160002 +'</option>';
    	   });
    	   $("#leccion").html('<option value="0">Seleccione una Lección</option>'+pop); 
    	   $("#add_lesson").show();
       }
    }else {
    	$("#leccion").html('<option value="0">Seleccione un módulo</option>');
    	$("#add_lesson").hide();
    }
    seleccionadora();
});
//carga el listado de secciones de una leccion en especifico
$("#leccion").change(function(){
    nivel = $('#nivel option:selected').val(),
	modulo = $('#modulo option:selected').val(),
	leccion = $('#leccion option:selected').val();
    if(leccion != 0){
    	$('.add_sec_btn').show();
    	var data;
        if (nivel != 0 && modulo != 0 && leccion != 0){
        	data = getInfoAjax('GETSecciones', {nivel : nivel, modulo : modulo, leccion : leccion},"admin");
        	if(data.error){
                  // console.log(data.error);
           }else{
        	   constructor_list(data);
           }
        }else{
        	$('#list_secciones').html('Seleccione una lección.');
        }
    }else{
    	seleccionadora();
    }
});
// muestra/oculta elementos
function seleccionadora(){
	nivel = $('#nivel option:selected').val(),
	modulo = $('#modulo option:selected').val(),
	leccion = $('#leccion option:selected').val();
	if(nivel == 0 || modulo == 0 || leccion == 0){
		$('.add_sec_btn').hide();
    	$('#slides').html('');
    	$('#add_seccion').hide();
	}
}
//Construye el listado de las secciones y genera los elementos drag & drop
function constructor_list(data){
	var pop = '', i=0,
		size = data.length;
	//console.log(data);
	   $.each(data, function(){
		   //pop += this.LGF0180001+' Seccion:'+ this.LGF0180005 +' Orden:'+ this.LGF0180006+'<br>';
		   i++;
		   pop += '<li class="slide slide1" id="slide-'+this.id+'" data-iden="'+this.id+'" data-id="'+i+'" data-order="'+this.orden
		   +'" data-nivel="'+$('#nivel').val()+'" data-modulo="'+$('#modulo').val()+'" data-leccion="'+$('#leccion').val()+'" ><span id="spanslide-'+this.orden+'">'+this.orden+'.-</span> <text class="etiqueta">'+this.seccion+'</text><div class="edit_sec" data-id="'+this.id+'" data-sec="'+this.ID_seccion+'" data-nivel="'+$('#nivel').val()+'" data-modulo="'+$('#modulo').val()+'" data-leccion="'+$('#leccion').val()+'" data-estatus="'+this.estatus+'">Editar</div></li>';
		   original[i]=[this.id,this.orden];
		   
	   });
	   //console.log(nivel, modulo, leccion, size, original);
	   $("#slides").html(pop);
	   
	   $(".slides").sortable({
		    placeholder: 'slide-placeholder',
		   axis: "y",
		   revert: 150,
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
		   stop: function(e, ui) {
			   
			   var nuevo = $('#slides').children('li'),
			   cambio = parseInt(ui.item[0].dataset.id),
			   iden = parseInt(ui.item[0].dataset.iden),
			   new_position = 0,
			   identificador = ui.item[0].id,
			   i=0,
			   move = 0,
			   id=0;
			   //console.log(ui, nuevo);
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
			   if(move != 0){
				   //console.log(id, new_position, cambio, move);
				   var variable={
							nivel : nivel,
							modulo : modulo,
							leccion : leccion,
							seccion : cambio,
							posicion : new_position,
							id : iden,
							move : move
						}
				   data = getInfoAjax('SETOrderSection', variable,"admin");
				   // console.log(data);
				   if(data){
				   	// console.log('Entre');
					   if(move == 1){
						   var sons = $('#slides').children('li');
						   $.each(sons, function(){
							   orden = parseInt(this.dataset.order); 
							   if(orden >= new_position && orden < cambio){
								   //console.log(this.id+' '+parseInt(this.dataset.order)+1);
								   $('#'+this.id).attr('data-order',orden+1);
								   $('#'+this.id).attr('data-id',orden+1);
								   $('#'+this.id+' span').html(orden+1+'.- ');

								   // console.log(this.id)
							   }
						   });
						   $('#'+identificador).attr('data-order',new_position);
						   $('#'+identificador).attr('data-id',new_position);
						   $('#'+identificador+' span').html(new_position+'.- ');

					   }else if(move == -1){
						   var sons = $('#slides').children('li');
						   $.each(sons, function(){
							   orden = parseInt(this.dataset.order); 
							   if(orden <= new_position && orden > cambio){
								   //console.log(this.id+' '+parseInt(this.dataset.order)+1);
								   $('#'+this.id).attr('data-order',orden-1);
								   $('#'+this.id).attr('data-id',orden-1);
								   $('#'+this.id+' span').html(orden-1+'.- ');
								   // console.log(this.id)

							   }
						   });
						   $('#'+identificador).attr('data-order',new_position);
						   $('#'+identificador).attr('data-id',new_position);
						   $('#'+identificador+' span').html(new_position+'.- ');
					   }
				   }else{
					   /*alert('Error en mla base de datos');*/
				   }
				   
				   //1.- Tomar el id y actualizar con new_position en el campo de orden de la tabla 18,
				   //2.- si move = 1, entonces, actualizar todos los orden a +1 que sean mayor o igual a new_position a excepcion del id actualizado en el punto 1 y menor que cambio
				   //3.- si move = -1, entonces, actualizar todos los orden a -1 que sean mayor o igual a cambio excepcion del id que se actualizo en el punto 1 y menor a new_position
			   }
		       $(".slide-placeholder-animator").remove();
		       
		   },
		});
	   $(".edit_sec").click(function(){
	   		$('#file-4').fileinput('clear');
	   		$('#file-4').fileinput('reset');
		   edit_sec(this.dataset.id,this.dataset.sec,this.dataset.nivel,this.dataset.modulo,this.dataset.leccion,this.dataset.estatus);
		});
}
//Agrega nueva secccion en la estructura de navegacion
$('#new_sec_nav').click(function(){
	// console.log('hi');
	var n_sec = $('#new_seccion').val(),
	nivel = $('#nivel option:selected').val(),
	modulo = $('#modulo option:selected').val(),
	leccion = $('#leccion option:selected').val();
	if(n_sec > 0){
		data = getInfoAjax('SETSeccion', { nivel : nivel, modulo : modulo, leccion : leccion, seccion : n_sec },"admin");
		// console.log(data);
    	if(data.error){
            // console.log(data.error);
       }else{
    	   constructor_list(data);
    	   lista2="";
    	   for(i=1; i<=data.length;i++){
	   			lista2 += '<option value="'+i+'">'+ i +'</option>';
	   		}
    	   $('#num_seccion').html(lista2);
    	   mostrarAlert('','Elemento alamacenado');
    	   botonOkModal();
    	   $('#add_seccion').hide('100'); 
       }
	}else{
		mostrarAlert('','Seleccione una Sección');
		botonOkModal();
	}
	
});

function edit_sec(id, id_sec,id_nivel,id_modulo,id_leccion,estatus){
	$('#edit_seccion').show();
	$( "#edit_seccion" ).data( "id", id );
	$( "#edit_seccion" ).data( "id_sec", id_sec );
	$( "#edit_seccion" ).data( "id_modulo", id_modulo );
	$( "#edit_seccion" ).data( "id_leccion", id_leccion );

	// console.log($( "#edit_seccion" ).data());
	
	
	lista = getInfoAjax('GETListSec',null,"admin");
	seccion = $('#slide-'+id).data('order');
	var pop = '';
	   $.each(lista, function(){
		   if(this.LGF0170001 == id_sec){
			   pop += '<option value="'+this.LGF0170001+'" selected>'+ this.LGF0170002 +'</option>';
		   }else{
			   pop += '<option value="'+this.LGF0170001+'">'+ this.LGF0170002 +'</option>';
		   }
		   
	   });

	   $('#sec_name_sele').attr('data-key', id);
	   $("#sec_name_sele").html(pop);
	   if(estatus ==1){
	   $('#estatus').prop('checked',true);
	   }else{
	   $('#estatus').prop('checked',false);
	   	
	   }

}


  
	   

$("#estatus").on('change', function() {
	/*alert('hi');*/
	var data1 = new FormData($('#frm_file')[0]);
     		data1.append('id' , $( "#edit_seccion" ).data( "id") );
            data1.append('id_sec' , $( "#edit_seccion" ).data( "id_sec"));
            data1.append('id_modulo' , $( "#edit_seccion" ).data( "id_modulo"));
            data1.append('id_leccion' , $( "#edit_seccion" ).data( "id_leccion"));
            data1.append('sec_name_sele' ,$("#sec_name_sele").data("key"));
            data1.append('estatus',($('#estatus').prop('checked')) ? "1" : "0");
			for (var value of data1.values()) {
				// console.log(value); 
			}
    		$.ajax({
                    url: context + 'admin/' +'EstatusSection',
                    dataType: 'json',
                    type: 'post',
                    async: true,
                    data: data1,
                    contentType:false,
                    processData:false,
                    cache:false
                }).done(function(data){
                        //Codigo blabal
                    }).fail(function(jqXHR, textStatus){
                        // console.log( "Request failed: " + textStatus );
                    });

            


    });	

$('#sec_name_sele').change(function(){
	 var id_sec = $('#sec_name_sele option:selected').val(), 
	 id = $("#sec_name_sele").data("key"),
	 texto = $('#sec_name_sele option:selected').text();
	 
	 data = getInfoAjax('UpdateSection', {id:id, id_sec:id_sec},"admin");
 	 if(data.error){
           // console.log(data.error);
     }else{
 	   if(data == true){
 		  $('#slide-'+id+' .etiqueta').html(texto);
 	   }
 	   
     }
});


// funciones del drag and drop de archivos***************************


//getElementById
function $id(id) {
	return document.getElementById(id);
}
//getElementByClass
function $class(id) {
	return document.getElementsByClassName(id);
}

// output information
function Output(msg) {
	var m = $id("messages");
	//m.innerHTML = msg + m.innerHTML;
}


// file drag hover
function FileDragHover(e) {
	e.stopPropagation();
	e.preventDefault();
	e.target.className = (e.target.id == e.target.id  ? "filedrag-hover" : "");
	//$("#"+e.target.id).toggleClass( "filedrag-hover" );
}
//file drag leave
function FileDragLeave(e) {
	e.stopPropagation();
	e.preventDefault();
	e.target.className = (e.target.id == e.target.id  ? "filedrag" : "");
	//$("#"+e.target.id).toggleClass( "filedrag-hover" );
}

// file selection
function FileSelectHandler(e) {
	
	var formData = new FormData();
	
	// cancel event and hover styling
	FileDragHover(e);
	var tipo = e.target.dataset.type;
	// fetch FileList object
	var files = e.target.files || e.dataTransfer.files;
	
	str_pos = files[0].name.lastIndexOf(".");
	str_tipo = files[0].name.substring(str_pos+1, files[0].name.length);
	
	//console.log(str_tipo+' '+nivel+' '+modulo+' '+leccion+' '+seccion);
	if(tipo == str_tipo && nivel > 0 && modulo > 0 && leccion > 0 && seccion > 0){
		formData.append("tipo",tipo);
		formData.append("archivo", files[0]);
		formData.append("nivel",nivel);
		formData.append("modulo",modulo);
		formData.append("leccion",leccion);
		formData.append("seccion",seccion);
		
		var request = new XMLHttpRequest();
		request.open("POST", "UploadFiles");
		request.send(formData);
	}else{
		alert("No es un archivo de tipo "+tipo);
	}
	
	$("#"+e.target.id).toggleClass( "filedrag-hover" );
	e.target.className = (e.target.id == e.target.id  ? "filedrag" : "");
	
	// process all File objects
	/*for (var i = 0, f; f = files[i]; i++) {
		ParseFile(f);
	}*/

}


// output file information
function ParseFile(file) {

	Output(
		"<p>File information: <strong>" + file.name +
		"</strong> type: <strong>" + file.type +
		"</strong> size: <strong>" + file.size +
		"</strong> bytes</p>"
	);

}
//initialize
function Init() {

	var fileselect = $class("fileselect"),
		filedragx = $class("filedrag");
	//console.log(filedrag);
	// file select
	for(i=0; i < fileselect.length; i++){
		fileselect[i].addEventListener("change", FileSelectHandler, false);
	}
	//fileselect.addEventListener("change", FileSelectHandler, false);

	// is XHR2 available?
	var xhr = new XMLHttpRequest();
	if (xhr.upload) {

		// file drop
		for(i=0; i < filedragx.length; i++){
			filedrag = $id(filedragx[i].id);
			filedrag.addEventListener("dragover", FileDragHover, false);
			filedrag.addEventListener("dragleave", FileDragLeave, false);
			filedrag.addEventListener("drop", FileSelectHandler, false);
			filedrag.style.display = "block";
		}
		

		// remove submit button
		//submitbutton.style.display = "none";
	}

}
//call initialization file
if (window.File && window.FileList && window.FileReader) {
	Init();
}




});








































