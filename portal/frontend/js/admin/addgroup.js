$(document).ready(function () {
	$("#addGroup").validate({
		rules:{
			institucion:{
				required: true
			},nivel:{
				required: true
			},
			ciclo:{
				required: false
			},nombre:{
				required: true
			},
			docente:{
				required: false
			}
		},
		messages:{
			institucion:{
				required : '*Este campo es requerido'
			},nivel:{
				required : '*Este campo es requerido'
			},
			ciclo:{
				required : '*Este campo es requerido'
			},
			nombre:{
				required : '*Este campo es requerido'
			},
			docente:{
				required : '*Este campo es requerido'
			}
		},
		errorPlacement : function(error, element) {
			error.appendTo(element.parents('td').children('span.error'));
		},
		submitHandler: function() {
			$.ajax({
				type: 'POST',
				url: context+'admin/saveGrupo',
				data: {
					institucion: $("#institucion").val(), nivel: $("#nivel").val(),
					grupo: $("#nombre").val(), docente: $("#docente").val(), ciclo: $("#ciclo").val()
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
		}
	});
});