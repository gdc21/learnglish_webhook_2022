$(document).ready(function () {
	$("#cambiar").on('click', function (e) {
		$("#foto").click();
	});

	$("#foto").on('change', function (e) {
		var file = document.querySelector('#foto').files[0];
		var fileN = getBase64(file, "#imagenPerfil");
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