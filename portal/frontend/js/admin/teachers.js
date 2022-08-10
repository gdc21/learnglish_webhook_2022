$(document).ready(function () {
	cargar_tabla("");

	$("#buscar").keydown(function (e) {
		if(e.which == 17 || e.which == 16 || e.which == 18 || e.which == 13) {
		} else {
			setTimeout(function(){
				cargar_tabla($("#buscar").val());
			},1000);
		}
	});
});

function cargar_tabla(buscar) {
	$.ajax({
		type: "POST",
		url: context+"admin/obtenerDocentes",
		data: {buscar: buscar, campo: $("#campo").val()},
		dataType: "json",
		beforeSend: function () {
			var nColumnas = $("#tbl_docentes thead tr:first th").length
			var tabla = "<tr>";
			for (var i = 1; i <= nColumnas; i++) {
				if (i==1) {
					tabla+="<td style='font-size: 8px;'><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></td>";
				} else {
					tabla+="<td style='font-size: 8px;'><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></td>";
				}
			}
			tabla+="</tr>";
			$("#tbl_docentes tbody").html(tabla);
		},
		success: function (resp) {
			console.log("resp", resp);
			// console.log(resp);
			var cuerpo = "";
			$.each(resp.cuerpo, function (i, cont) {
				var aux = cont.grupo.split(",");
				var alumnos = cont.alumnos.split(",");
				var nivel = cont.nivel.split(",");
				var grupoid = cont.gruposid.split(",");
				var moduloid = cont.moduloid.split(",");
				cuerpo+="<tr>";
		        cuerpo+=
					"<td rowspan="+aux.length+" style='vertical-align: middle;'>" +
						"<a href='"+context+"admin/estadisticasSistema/"+cont.usuarioid+"/docentes'>Reporte grupal</a>" +
					"</td>";
		        cuerpo+="<td rowspan="+aux.length+" style='vertical-align: middle;'>"+cont.nombre+"</td>";
	          	cuerpo+="<td class='"+((aux[0] == "" || aux[0] == null) ? 'complemento' : '')+"'>";
	          	if ((aux[0] == "" || aux[0] == null)) {
	          		cuerpo+="<a onclick='mostrar_grupo("+cont.usuarioid+")'>Asignar grupo</a>";
	          	} else {
	          		cuerpo+=aux[0];
	          	}
	          	cuerpo+="</td>";
	          	cuerpo+="<td>"+alumnos[0]+"</td>";
	          	cuerpo+="<td class='"+obtener_clase(moduloid[0])+"'>"+((moduloid[0] == "" || moduloid[0] == 0) ? 'Asignar grado' : convertir_modulo_grado(moduloid[0]))+"</td>";
	          	cuerpo+="<td class='"+obtener_clase(moduloid[0])+"'>";
	          	if (grupoid[0] != 0) {
	          		cuerpo+="<a href='"+context+"home/results/"+grupoid[0]+"/"+$("#campo").val()+"' style='text-decoration: none !important;'>Reportes</a>";
	          	} else {
	          		cuerpo+="Sin Reportes";
	          	}
	          	cuerpo+="</td>";
		        cuerpo+="</tr>";
		        if (aux.length > 0) {
		        	for (var i=1; i < aux.length; i++) {
			            cuerpo+="<tr>";
			            cuerpo+="<td class='"+((aux[i] == "" || aux[i] == null) ? 'complemento' : '')+"'>";
			                if (aux[0] == "" || aux[0] == null) {
			                	cuerpo+="<a onclick='mostrar_grupo("+cont.usuarioid+")'>Asignar grupo</a>";
			                } else {
			                	cuerpo+=aux[i];
			                }
		                cuerpo+="</td>";
		                cuerpo+="<td>"+alumnos[i]+"</td>";
		                cuerpo+="<td class='"+obtener_clase(moduloid[i])+"'>"+((moduloid[i] == "" || moduloid[i] == 0) ? 'Asignar grado' : convertir_modulo_grado(moduloid[i]))+"</td>";
						cuerpo+="<td class='"+obtener_clase(moduloid[i])+"'>";
							if (grupoid[i] != 0) {
								cuerpo+="<a href='"+context+"home/results/"+grupoid[i]+"/"+$("#campo").val()+"' style='text-decoration: none !important;'>Reportes</a>";
							} else {
								cuerpo+="Sin Reportes";
							}
						cuerpo+="</td>";
			            cuerpo+="</tr>";
			        }
			    }
			});
			$("#tbl_docentes tbody").html(cuerpo);
			$('#tbl_docentes').dataTable({
				searching: true,
				paging: true,
				"language": {
					"paginate": {
						"next": "Siguiente",
						"previous": "Anterior"
					},
					"info": "Mostrando _START_ de _END_",
					"search": "Buscar"
				},
				"order": [[ 3, "desc" ]], //or asc 
				columnDefs: [{ type: 'de_date', targets: 3 }]
			});
		}
	});
}

function obtener_clase(nivel) {
	if (nivel == 1) {
		clase = "preescolar";
	} else if (nivel >= 2 && nivel <= 7) {
		clase = "primaria";
	} else if (nivel >= 8 && nivel <= 10) {
		clase = "secundaria";
	} else {
		clase = "complemento";
	}
	return clase;
}

function convertir_modulo_grado(modulo) {

	if (modulo == 1) {
		grado = "3° Preescolar";
	} else if (modulo >= 2 && modulo <= 7) {
		grado = (modulo - 1)+"° Primaria";
	} else {
		switch (modulo) {
			case '8':
				grado = "1 ° Secundaria";
			break;
			case '9':
				grado = "2 ° Secundaria";
			break;
			case '10':
				grado = "3 ° Secundaria";
			break;
		}
	}
	return grado;
}