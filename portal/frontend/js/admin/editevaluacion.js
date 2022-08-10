$(document).ready(function () {
	$("#modulo").change(function () {
		$("#tabla").dataTable().fnDestroy();
		var modulo = $(this).val();
		if (modulo.trim() === '') {
			$("#leccion").html('<option value="">Todos las lecciones</option>');
		} else {
			$.ajax({
				type: 'POST',
				url: context+"admin/obtenerLecciones",
				data: {clave: modulo},
				dataType: 'json',
				success: function (resp) {
					$("#leccion").html(resp.contenido);
				}
			});
		}
	});

	$.ajax({
		type: 'POST',
		url: context+"admin/obtenerLecciones",
		data: {clave: $("#modulo").val()},
		dataType: 'json',
		success: function (resp) {
			$("#leccion").html(resp.contenido);
			$("#leccion").val($("#leccion_id").val());
		}
	});

	$("#guardar").click(function (e) {
		e.preventDefault();
		var data = $("#formEvaluacion").serialize();
		$.ajax({
			type: "POST",
			url: context+"admin/upEvaluacion",
			data: data,
			dataType: 'json',
            success: function (resp) {
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
});

function aceptNum(evt){
	var nav4 = window.Event ? true : false;
	var key = nav4 ? evt.which : evt.keyCode;
	return (key <= 13 || (key>= 48 && key <= 57));
}