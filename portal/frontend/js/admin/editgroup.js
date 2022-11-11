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

	$("#institucion").change(function(){
		$.ajax({
			type: "POST",
			data: {institucion: $("#institucion").val()},
			url: context+"admin/gruposyprofesoresdeinstitucion",
			dataType: "json",
			success: function (resp) {
				console.log("Hola")
				var lista = "";

				lista = "<option value=''>Selecciona un docente</option>";

				$.each(resp.docentes, function (pos, val) {
					lista+= "<option value='"+val.id+"' >"+val.cct_docente+" "+val.nombre+"</option>";
				});
				$("#docente").html("");
				$("#docente").html(lista);
			}
		});

	});
});