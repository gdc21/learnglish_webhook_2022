$(document).ready(function () {
	$(".datPer").hide();
	$("#cUser").hide();
	$("#cambiar").on('click', function (e) {
		e.preventDefault();
		$("#foto").click();
	});

	$("#foto").on('change', function (e) {
		var file = document.querySelector('#foto').files[0];
		var fileN = getBase64(file, "#imagenPerfil");
	});

	$("#guardar").click(function (e) {
		e.preventDefault();
		var data = new FormData($('#formP')[0]);
			
		if($('#password').val()!='') { 
			data.append('password',CryptoJS.SHA1($('#password').val()).toString());
			data.set('pass', data.get('password'));
		}
		$.ajax({
			type: 'POST',
			url: context+'home/profile',
			data: data,
			dataType: 'json',
			contentType:false,
	        processData:false,
	        cache:false,
	        async: true,
	        beforeSend: function () {
	         	$("#cUser").hide();
	         	$(".datPer").hide();
	         	var usuario = $("#cUser").val();
	         	var name = $("#uName").val();
	         	var apat = $("#uPat").val();
	         	var amat = $("#uMat").val();
	         	
	         	var perfil = $("#perfil").val();
	         	if (perfil == 3) {
	         		var nombre = name;
	         	} else if (perfil == 4) {
	         		var nombre = name;
	         	} else {
	         		var nombre = "";
	         		if (name != "") {
	         			nombre+=name;
	         		}
	         		if (apat != "") {
	         			nombre+=" "+apat;
	         		}
	         		if (amat != "") {
	         			nombre+=" "+amat;
	         		}
	         	}
	         	if (usuario != "") {
	         		$("#usuario").html(usuario);
	         	}
	         	if (nombre == "" || nombre == null) {
	         		
	         	} else {
	         		$("#nombre").html(nombre);
	         	}
	        },
	        success: function (resp) {
	         	$("#mensaje").toggle(1000);
	         	$("#mensaje").html(resp.mensaje);
	         	setTimeout(function () {
	         		$("#mensaje").hide();
	         		$("#mensaje").html("");
	         	}, 4000);
	        }
		});
	});

	$("#uDatos").click(function () {
		$(".datPer").show();
		$("#xDatos").show();
		informacion();
	});

	$("#uUser").click(function () {
		$("#xUser").show();
		$("#cUser").show();
		informacion();
	});

	$(".uDatos").click(function () {
		$.ajax({
			type: "POST",
			data: {informacion: 1},
			url: context+"home/profile",
			dataType: "json",
			success: function (resp) {
				var aux = resp.datos.split("|");
				$("#uName").val((aux[0] == "" || aux[0] == null) ? "" : aux[0]);
				$("#uPat").val((aux[1] == "" || aux[1] == null) ? "" : aux[1]);
				$("#uMat").val((aux[2] == "" || aux[2] == null) ? "" : aux[2]);
				$("#cUser").val((aux[3] == "" || aux[3] == null) ? "" : aux[3]);
			}
		});
	});

	$("#xDatos").click(function () {
		$(".datPer").hide();
		$("#xDatos").hide();
	});

	$("#xUser").click(function () {
		$("#xUser").hide();
		$("#cUser").hide();
	});

	$("#cUser").blur(function () {
		$.ajax({
			type: "POST",
			data: {informacion: 3, user: $(this).val()},
			url: context+"home/profile",
			dataType: "json",
			beforeSend: function () {
				$("#guardar").attr("disabled", true);
				$("#cUserMsj").hide();
			},
			success: function (resp) {
				if (resp.error == 0) {
					$("#guardar").attr("disabled", false);
				} else {
					$("#cUserMsj").html("Ya existe ese nombre de usuario");
					$("#cUserMsj").show();
				}
			}
		});
	});
});

function informacion() {
	$.ajax({
		type: "POST",
		data: {informacion: 1},
		url: context+"home/profile",
		dataType: "json",
		success: function (resp) {
			var aux = resp.datos.split("|");
			$("#uName").val((aux[0] == "" || aux[0] == null) ? "" : aux[0]);
			$("#uPat").val((aux[1] == "" || aux[1] == null) ? "" : aux[1]);
			$("#uMat").val((aux[2] == "" || aux[2] == null) ? "" : aux[2]);
			$("#cUser").val((aux[3] == "" || aux[3] == null) ? "" : aux[3]);
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