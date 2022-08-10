$(document).ready(function () {
	$("#guardar").click(function (e) {
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: context+'admin/saveGrupo',
			data: {
				institucion: $("#institucion").val(), nivel: $("#nivel").val(), grupo: $("#nombre").val(),
				docente: $("#docente").val(), ciclo: $("#ciclo").val(), idgrupo: $("#grupo").val()
			},
			dataType: 'json',
		    success: function (resp) {
		    	// console.log(resp)
		    	if (resp.error) {
		    		$('#mensaje').removeClass("alert-success");
					$('#mensaje').addClass("alert-warning");
					$('#mensaje').show("swing");
					$('#mensaje').html('<b>' + resp.error + '</b>');
		    	} else {
		    		$('#addGroup')[0].reset();
		    		$('#mensaje').addClass("alert-success");
					$('#mensaje').removeClass("alert-warning");
					$('#mensaje').show("swing");
					$('#mensaje').html('<b>' + resp.mensaje + '</b>');
					setTimeout(function () {
						window.location = context+"admin/groups";
					}, 3000);
		    	}
		    }
		});
	});
});