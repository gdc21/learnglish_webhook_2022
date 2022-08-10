$(document).ready(function () {
	cargar_tabla($("#nivel").val(), $("#docente").val());
});

function cargar_tabla(nivel, docente) {
	$.ajax({
		type: "POST",
		url: context+'admin/recursos',
		data: {nivel: nivel, docente: docente},
		dataType: 'json',
		success: function (resp) {
			// console.log(resp)
			$("#tblRecursos tbody").html(resp.contenido);

			$('#tblRecursos').dataTable({
				searching: false,
				paging: true,
				ordering: false,
				info: false,
				"language": {
					"paginate": {
						"next": "Siguiente",
						"previous": "Anterior"
					},
					"info": "Mostrando _START_ de _END_",
				}
			});
		}
	});
}

function reproducir(valor) {
	var audio = $("#recurso_"+valor).data("enlace");
	$("#recurso_"+valor).css({"text-shadow":"0 0 30px #00fff3"});
	var sound = new Howl({
      src: [audio],
      volume: 1.0,
      onend: function () {
        $("#recurso_"+valor).css({"text-shadow":"none"});
      }
    });
    sound.play()
}