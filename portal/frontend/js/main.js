$(function(){
	var preg=1;

	set_AumentaPregunta= function(){
		return preg++;
	}

	reset_Pregugunta=function(){
		preg=1;
	}

	total_Pregunta= function(){
		return preg;
	}

	/* ;;;;;;;;;;;;;;;;;;;;;;;;; New :::::::::::::::::::::::::::::::::::::*/
	$('.menu_second .dropdown ').on('click', 'li', function(event) {
		// event.preventDefault();
		/* Act on the event */
		// location.href= context+'informacion/'+$(this)[0].children[0].className;
	});

	$('.menu_inicio').on('click', '.inicio', function(event) {
		event.preventDefault();
		/* Act on the event */
		location.href= context+'Home/index';
	});

	$('.menu_inicio').on('click', '.inicio_m', function(event) {
		event.preventDefault();
		/* Act on the event */
		location.href= context+'Home/menu';
	});

	var menu=['Estructura','Duración','Metodología','Público Objetivo','Actividades y Evaluaciones','Recursos de Aprendizaje'],
	opcion=['estructura','duracion','metodologia','publico','actividades','recursos'];

	menuLateral = function(opc){
		var opciones = $('<ul />',{class: 'lateral'}), li='', div = $('<div />').append( $( '<h3 />',{text: "Características",class: 'titulo'}));
		for (var i = 0; i < menu.length; i++) {
			var clase= (i== opc)?' active titulo':'';
			li= $('<li />',{class: clase}).append( $('<a />',{class: opcion[i],text: menu[i]}) );
			opciones.append(li[0]);
		}
		div.append( opciones[0].outerHTML)
		$('.menuLateral').append( div[0].outerHTML );
	}

	$('.menuLateral').on('click', 'li', function(event) {
		event.preventDefault();
		location.href= context+'informacion/'+$(this)[0].children[0].classList[0];
		//console.log("var : %O", $(this)[0].children[0].classList[0] );
	});

	//Login
	$('#loginBtn').on('click', function(event) {
		event.preventDefault();
		/* Act on the event */
		$('#btnLogin').trigger('click');
	});

	//Lanzamos el modal del login	
	$('#menu').on('click','#loginBtn', function(e){
		e.preventDefault();
		$('#loginForm').modal('show');
		$('#loginForm').on('shown.bs.modal', function () {
			$('#uname').focus();
		})
	});

	//Logout
	$('#logoutBtn').on('click', function(event) {
		event.preventDefault();
		// alert(context+'auth/logout')
		/* Act on the event */
		location.href=context+'auth/logout'
	});

	$('.mas').on('click', function(event) {
		event.preventDefault();
		/* Act on the event */
		location.href=context+'informacion/estructura';
	});

	$("#continuar_modal").on('click', function (e) {
		location.href=context+$(this).data('avance');
	})

	/* ;;;;;;;;;;;;;;;;;;;;;;;;; New :::::::::::::::::::::::::::::::::::::*/

	/*
	|
	|	Summary: Variable para determinar si hay error en la respuesta
	|
	*/
	hasError = false;
	//________________________________________________________________________________________________________
	/*
	|
	|	By: Fabian Perez
	|	Date: 18/08/2014
	|	Summary: Funcion de acceso global, para interaccion con los scripts que conectan con la BD
	|
	*/

	var section = $('body').attr('rel');
	section = section.charAt(0).toUpperCase() + section.substr(1);

	getInfoAjax = function(path, parameters, seccion){
		info = '';
		var uri = seccion ? context + seccion + '/'+path : context+ section + '/'+path;
		/*tipo = contentType ? contentType : true,
		dato = processData ? processData : true,
		Cache = cache ? cache : true;*/
		$.ajax({
			url: uri,
			dataType: 'json',
			type: 'post',
			async: false,
			data: parameters,
			/*contentType:false,
			processData:false,
			cache:false
			*/
		}).done(function(data){
			if(data){
				info = data;
			}
		}).fail(function(jqXHR, textStatus){
			console.log( "Request failed: " + textStatus );
			console.log(uri);
		});
		return info;
	}
	
	getInfoAjaxFiles = function(path, parameters, seccion, contentType, processData, cache){
		info = '';
		var uri = seccion ? context + seccion + '/'+path : context+ section + '/'+path;
		/*tipo = contentType ? contentType : true,
		dato = processData ? processData : true,
		Cache = cache ? cache : true;*/
		//console.log(uri);
		$.ajax({
			url: uri,
			dataType: 'json',
			type: 'post',
			async: false,
			data: parameters,
			contentType:false,
			processData:false,
			cache:false
			
		}).done(function(data){
			if(data){
				info = data;
			}
		}).fail(function(jqXHR, textStatus){
			console.log( "Request failed: " + textStatus );
		});
		return info;
	}

	getInfoAjaxFilesII = function(path, parameters, parametros, seccion){
		info = '';
		var uri = seccion ? context + seccion + '/'+path : context+ section + '/'+path;
		/*tipo = contentType ? contentType : true,
		dato = processData ? processData : true,
		Cache = cache ? cache : true;*/
		//console.log(uri);
		$.ajax({
			url: uri,
			dataType: 'json',
			type: 'post',
			async: false,
			data: {parameters: parameters,parametros: parametros},
			contentType:false,
			processData:false,
			cache:false
			
		}).done(function(data){
			if(data){
				info = data;
			}
		}).fail(function(jqXHR, textStatus){
			console.log( "Request failed: " + textStatus );
		});
		return info;
	}

	getInfoAjaxComplete = function(path, parameters, method, seccion){
		var uri = seccion ? context + seccion + '/'+path : context + section + '/'+path;
		$.ajax({
			url: uri ,
			dataType: 'json',
			type: 'post',
			async: true,
			data: parameters
		}).done(function(data){
			eval(method+'(data)');
		}).fail(function(jqXHR, textStatus){
			console.log( "Request failed: " + textStatus );
		});
	}

	/*
	|
	|	Summary: Implementacion del componente 'datatable'
	|
	*/
	if(window.innerWidth < 750){
		scrollX = true;
	}else{
		scrollX = false;
	}

	/*
	|
	|	Summary: Objeto para controlar el login
	|
	*/
	isAndroid = function(){
		return /android/i.test( navigator.userAgent.toLowerCase());
	}
	
	/*if( isAndroid() ){
	    $('#pw').attr('type','password');
	}*/
		
	accessKey = function(){
		var char = '';
		this.obj = '';
		
		this.setChar = function(key){
			char += String.fromCharCode(key);
			if( !isAndroid() ){
				this.editBox(char);
			}
		}
			
		this.editBox = function(char){
			var txt = $(this.obj).val();
			//$(this.obj).val(txt + 'XXX');
			$(this.obj).val(char);
		}
			
		this.getPass = function(){
			if( char ){
				return CryptoJS.SHA1( char ).toString();
			}else{
				return CryptoJS.SHA1( $(this.obj).val() ).toString();
			}
		}
		
		this.resetPass = function(){
			char = '';
		}
		
		this.drop = function(){
			char = char.substring(char, char.length-1);
		}
			
		this.size = function(){
			return char.length;
		}
	}
	
	password = new accessKey();
	password.obj = '#startSession #pw';
		 
	/*$('#startSession #pw').on('keypress', function( event ){
		if(event.which != 13 && event.which != 88){
			event.preventDefault();
			password.setChar(event.which);
		}
	}).on('paste', function(){
		return true;
	}).on('keydown', function( event ){
		if(event.which == 8){
			event.preventDefault();
			if( !isAndroid() ){
				var txt = $('#startSession #pw').val().substring(0, $('#startSession #pw').val().length-1);
				$('#startSession #pw').val(txt);
			}
			password.drop();
		}
	});*/

	$('#ver').click(function(){
		alert(password.getPass());
	});
	//_______________________________________________________________________________________________________
	
	/*
	|
	|	Summary: Validacion para el login, logout y registro nuevo (lado del cliente)
	|
	*/
	//Login
	$('#startSession').validate({
		rules: {
			uname: { required: true },
			pw: { required: true }
		},
		messages: {
			uname: { required: '*Este campo es requerido' },
			pw: { required: '*Este campo es requerido' } 
		},
		errorPlacement: function(error, element){
			error.appendTo(element.parent('div').children('span.error'));
		},
		submitHandler: function(){
			var data = getInfoAjax('login', {uname: $('#startSession #uname').val(), pw: password.getPass()},'auth');
			password.resetPass();
			$('#startSession #pw').val("");
			if(data){
				if(data.error){
					$(".error-login").html('**' + data.error);
				}else{
					//console.log(path_context + data[0]+'/'+data[1]);
					location.href = data;
				}
			}
		}
	});

	//Logout
	$('#logoutAction').on('click', function(){
		location.href = '/auth/logout';
	});
	//perfil
	$('#perfilAction').on('click', function(){
		location.href = '/auth/actualiza_informacion';
	});
	
	//Especificamos las funciones para la validacion del formulario
	$.validator.addMethod("sizeR", function() {
		var bandera = false;
		
		if(eval(passObjR).size() >= 6)
			bandera = true;
			
		  return bandera;
	},'*Su contraseña debe tener minimo 6 caracteres');
	
	$.validator.addMethod("equalsR", function() {
		if(!(pass1 instanceof accessKey) || !(pass1 instanceof accessKey)) return false;
		  return pass1.getPass() == pass2.getPass();
	}, '*Las contraseñas no son iguales.');
	
	//Registro
	$('#newUser').validate({
		rules: {
			name:  { required: true },
			user:  { required: true },
			email:  { required: true, email: true },
			pass1: { required: true, sizeR: true},
			pass2: { equalsR: true }
		},
		messages: {
			name:  { required: '*Este campo es requerido' },
			user:  { required: '*Este campo es requerido' },
			email:  { required: '*Este campo es requerido', email: 'Formato de correo invalido' },
			pass1: { required: '*Este campo es requerido', sizeR: '*Su contraseña debe tener minimo 6 caracteres' },
			pass2: { equalsR: '*Las contraseñas no son iguales' }
		},
		errorPlacement: function(error, element){
			error.appendTo(element.parent('td').children('span.error'));
		},
		submitHandler: function() { 
			var data = getInfoAjax('registrarUsuario','email='+$('#mail_reg').val()+'&password='+pass1.getPass()+'&usuario='+$('#user_reg').val()+'&nombre='+$('#name_reg').val(),'auth');
			if( data.error ){
				$(".error-newUser").html('**' + data.error);
			}else{
				$(".error-newUser").html('');
				$("#newUser").html('<p style="padding: 10px; text-align:justify;">'+data.mensaje+'</p>');
			}
		}	
	});
	
	passObjR = '';
	
	function encodePassR(obj, char){
		if(!(eval(passObjR) instanceof accessKey)){
			eval(passObjR + "= new accessKey()");
			eval(passObjR).obj = obj;
		}
		eval(passObjR).setChar(char);
	}
	
	function deletePassR(){
		eval(passObjR).drop();
	}
	
	$('.changePassR').on('keypress', function( event ){
		if(event.which != 13 && event.which != 32){
			event.preventDefault();
			passObjR = $(this).attr('id');
			encodePassR($(this), event.which);
		}else if(event.which == 32){
			return false;
		}
	}).on('paste', function(){
		return false;
	}).on('keydown', function( event ){
		if(event.which == 8){
			event.preventDefault();
			var txt = $(this).val().substring(0, $(this).val().length-3);
			deletePassR();
			$(this).val(txt);
		}
	});
	
	//Antes de mostrar el LB del registro, escondemos el de login
	$('#login').on('click','#closeLoginForm',function(){
		$('.close').trigger('click');
	});
	
	//Olvido password
	$('#startLostPassword').validate({
		rules: {
			mail:  { required: true, email: true }
		},
		messages: {
			mail:  { required: '*Este campo es requerido', email: '*Formato de correo invalido' }
		},
		errorPlacement: function(error, element){
			error.appendTo(element.parent('td').children('span.error'));
		},
		submitHandler: function() { 
			var restart = getInfoAjax('recuperaUsuario','email='+$('#emailRestart').val(),'auth');
			if( restart.error ){
				$(".error-passRestart").html('**' + restart.error);
			}else{
				$(".error-passRestart").html('');
				$("#startLostPassword").html('<p style="padding: 10px; text-align:justify;">'+restart.mensaje+'</p>');
			}
		}
	});

	//________________________________________________________________________________________________________
	//Mostramos al usuario el modal con la informacion de la respuesta
	modalAjaxResponse = function(title, msg){
		//Personalizamos el mensaje del modal
		$('#showAlert #myModalLabel').html(title);
		$('#showAlert .modal-body').html(msg);
		
		//Mostramos el modal
		$('#showAlertAction').trigger('click');
		$('#showAlert').modal('show');
	}
	//________________________________________________________________________________________________________
	
	/*
	|
	|	Summary: Funcion para resetear algun formulario
	|
	*/
	formReset = function(form){
		$(form).each (function(){
			this.reset();
		});
	}
	//________________________________________________________________________________________________________

	//Accion para los tabs
	$('#novedades a').on('click',function (e) {
	  	e.preventDefault();
	 	$(this).tab('show');
	});

	
	//Quitamos clases basura de los elementos
	deleteClass = function(element, nameClass){
		$(element).each(function(){
			$(this).removeClass(nameClass);
		});
	} 
	
	jQuery.validator.addMethod("alpha",
		function(value, element) {
			return /^[a-zA-Z0-9]/.test(value);
		},
	   "Nada de caracteres especiales, por favor"
	);
	
	
	/*
	|	
	|	Summary: Damos foramto a las fechas 
	|
	*/
	dateFormat = function(date){
		return date == '0000-00-00 00:00:00' ? '' : $.format.date(date,'yyyy/MM/dd');
	}
	//________________________________________________________________________________________________________
	decimalAdjust = function(type, value, exp) {
		// If the exp is undefined or zero...
		if (typeof exp === 'undefined' || +exp === 0) {
		  return Math[type](value);
		}
		value = +value;
		exp = +exp;
		// If the value is not a number or the exp is not an integer...
		if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0)) {
		  return NaN;
		}
		// Shift
		value = value.toString().split('e');
		value = Math[type](+(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp)));
		// Shift back
		value = value.toString().split('e');
		return +(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp));
	}

	Math.ceil10 = function(value, exp) {
		return decimalAdjust('ceil', value, exp);
	};

	/*
	|	
	|	Date: 05/05/15
	|	Summary: Solo numeros
	|
	*/	
	$('.only_number').on('keypress',function(e){
		if(e.which > 57 || e.which < 48){
			e.preventDefault();		
		}
	});
	//________________________________________________________________________________________________________

	/** Guardado de lecciones **/
	$(".retroseso").click(function () {
		$.ajax({
			type: "POST",
			data: {i: Math.random()},
			url: context+"home/time",
			success: function (res) {
				console.log(res);
			}
		});
	});

	$("#loginForm").on('hidden.bs.modal', function () {
		$("#startSession")[0].reset();
		$("#nav-login").addClass("active show");
		$("#nav-recover").removeClass("active show");
	});

	$("#recoverpass a").click(function (e) {
		e.preventDefault();
		$("#nav-login").removeClass("active show");
		$("#nav-recover").addClass("active show");
	});

	$("#login-form a").click(function (e) {
		e.preventDefault();
		$("#nav-recover").removeClass("active show");
		$("#nav-login").addClass("active show");
		$("#ruser").val("");
		$("#mensaje-recuperar").hide();
		$("#mensaje-recuperar").html("");
		$("#mensaje-recuperar").addClass("bg-warning");
	});

	$("#ruser").keypress(function (event) {
		if(event.which == 13){
			return false;
		}
	});

	$("#ruser").focus(function (e) {
		$("#mensaje-recuperar").hide();
		$("#mensaje-recuperar").html("");
		$("#mensaje-recuperar").addClass("bg-warning");
		$("#mensaje-recuperar").removeClass("bg-info");
		$("#mensaje-recuperar").removeClass("bg-danger");
	});

	$("#recuperar").click(function (e) {
		e.preventDefault();
		var usuario = $("#ruser").val();
		if (usuario == "") {
			$("#mensaje-recuperar").show();
			$("#mensaje-recuperar").html("Es necesario ingresar un usuario");
		} else {
			var data = getInfoAjax('recuperaUsuario',{usuario: usuario},'auth');
			$("#mensaje-recuperar").show();
			$("#mensaje-recuperar").removeClass("bg-warning");
			if (data.respuesta == 1) {
				$("#mensaje-recuperar").html(data.mensaje);
				$("#mensaje-recuperar").addClass("bg-danger");
			} else {
				$("#mensaje-recuperar").addClass("bg-info");
				$("#mensaje-recuperar").html(data.mensaje);
			}
		}
	});
});

/*
Funcion para los mensajes actualizado
*/
mostrarAlert = function(titulo,msg, close_btn, submit_btn, sesion){
	//Seteamos las variables si no estan definidas
	void 0==close_btn&&(close_btn=!0),$(".modal-dialog .close").show();
	void 0==submit_btn&&(submit_btn=!0),$(".modal-footer #CustomBtn").show();
	void 0==sesion&&(sesion=!1),$(".modal-footer #GenericBtn").show();
	
	0==close_btn&&$(".modal-dialog .close").hide(); //Oculta el icono de cerrar
	0==submit_btn&&$(".modal-footer #CustomBtn").hide(); //Oculta los botones extras
	1==sesion&&$(".modal-footer #GenericBtn").hide(); //Oculta el boton de aceptar
	
	// mostramos el contenido en la modal
	$('#modalAlert .modal-title').html(titulo);
	$('#modalAlert .modal-body').html(msg);
	$('#modalAlert').modal('show');
}
	
botonOkModal = function(tipo,url){
	//console.log(tipo)
	if(tipo){
		$('#modalAlertBotonOk').on('click',function(){
			location.href = url;
		});
	}else{
		$('#modalAlertBotonOk').on('click',function(){
			$('#modalAlert').modal('hide');
		});
	}
}

function muestraPassword(){
    if (document.getElementById("check").checked) {
        document.getElementById("pw").setAttribute("type", "text");
    }else
    document.getElementById("pw").setAttribute("type", "password");
}

function clear() {
	clearRadioGroup("selector");
}

function clearRadioGroup(GroupName) {
	var ele = document.getElementsByName(GroupName);
	for(var i=0;i<ele.length;i++)
		ele[i].checked = false;
}
var audio_reproduciendo = null;
function reproductor_imagen(ruta_audio){

	var audio = new Audio();
	audio.src = ruta_audio;

	if(audio_reproduciendo != null){
		audio_reproduciendo.pause();
		audio_reproduciendo.currentTime = 0;
	}
	audio_reproduciendo = audio;

	audio.play();
}

function reproductor(elemento) {
	console.log("elemento", elemento);
	var audio = $("#"+elemento).data("enlace");
	$("#"+elemento).css({"text-shadow":"0 0 30px #00fff3"});
	var sound = new Howl({
      src: [audio],
      volume: 1.0,
      onend: function () {
        $("#"+elemento).css({"text-shadow":"none"});
      }
    });
    sound.play()
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