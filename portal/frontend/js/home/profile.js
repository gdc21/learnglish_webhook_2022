$(document).ready(function () {

	$("#foto").on('change', function (e) {
		var file = document.querySelector('#foto').files[0];
		var fileN = getBase64(file, "#imagenPerfil");

		var data = new FormData($('#formP')[0]);
		$.ajax({
			type: 'POST',
			url: context+'home/profile',
			data: data,
			dataType: 'json',
			contentType:false,
			processData:false,
			cache:false,
			async: true,
			success: function (resp) {
				$("#mensaje").toggle(1000);
				$("#mensaje").html(resp.mensaje);
				setTimeout(function () {
					$("#mensaje").hide();
					$("#mensaje").html("");
					location.reload()
				}, 2000);
			}
		});

	});

	$("#cambiar").on('click', function (e) {
		e.preventDefault();
		$("#foto").click();
	});
});


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