<section class="container">
	<section id="contenido">
		<?php echo $this->temp['encabezado']; ?>
		<div class="separador">
			<div class="row">
				<div class="col-lg-6">
					<h1 class="title-section">Usuarios Registrados</h1>
				</div>

				<div class="col-lg-3 offset-lg-3">
					<?php if ($_SESSION['perfil'] != 6) { ?>
						<br>
						<a href="<?php echo CONTEXT ?>admin/addUsuario"><button class="btn btn-lg registro">Nuevo usuario</button></a>
						<br><br>
						<!-- <br>
						<button class="btn btn-lg registro" data-bs-toggle="modal" data-bs-target="#carga">Cargar usuarios</button>
						<br><br> -->
					<?php } ?>
					<select name="institucion" id="institucion" class="form-control" style="border-radius: 15px;">
						<?php if ($_SESSION['perfil'] == 1 || $_SESSION['perfil'] == 3) { ?>
							<option value="">Selecciona una institución</option>
							<?php foreach ($this->temp['instituciones'] as $inst){ ?>
								<option value="<?php echo $inst['LGF0270001'] ?>"><?php echo $inst['LGF0270002'] ?></option>
							<?php } 
						} else if($_SESSION['perfil'] == 4) { ?>
							<option value="<?php echo $_SESSION['idUsuario'] ?>" selected><?php echo $_SESSION['nombre'] ?></option>
						<?php } else if($_SESSION['perfil'] == 6) { ?>
							<option value="<?php echo $this->temp['info'][0]['idInstitucion']; ?>"><?php echo $this->temp['info'][0]
							['nombreInstitucion']; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
		</div>

		<div class="page">
			<div class="row">
				<div class="col-lg-12 table-responsive">
					<table class="table tabla" id="tabla">
						<thead>
							<th>Nombre</th>
							<th>Institución</th>
							<th>Grupo</th>
							<th>Fecha</th>
							<th>Usuario</th>
							<th>Contraseña</th>
							<?php if($_SESSION['perfil'] != 6) { ?>
								<th>Acciones</th>
							<?php } ?>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="offset-lg-9 col-lg-3">
					<a class="regresar basico menu-principal" href='<?php echo CONTEXT ?>admin/manager/'>Regresar</a>
				</div>
			</div>
		</div>
	</section>
</section>

<div class="modal fade" id="carga" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Carga de usuarios</h5>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" style="margin-top: -22px;">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="exportar" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-6">
							<input type="hidden" id="opcion" name="opcion" value="1">
							<input type="file" id="archivo" name="archivo" style="display: none;">
							<button id="file" class="btn btn-primary-btn-lg">Cargar archivo</button>
						</div>
						<div class="col-lg-6">
							<a id="download" class="btn btn-primary-btn-lg" href="<?php echo CONTEXT ?>portal/archivos/ejemplo.csv" download>Descargar ejemplo</a>
						</div>
					</div>
					<div class="row" style="margin-top: 15px; display: none;" id="complemento">
						<div class="col-lg-6">
							<select name="institucionexp" id="institucionexp" class="form-control" style="border-radius: 15px;">
								<option value="">Selecciona una institución</option>
								<?php foreach ($this->temp['instituciones'] as $inst): ?>
									<option value="<?php echo $inst['LGF0270001'] ?>"><?php echo $inst['LGF0270002'] ?></option>
								<?php endforeach ?>
							</select>
						</div>

						<div class="col-lg-6">
							<select name="moduloexp" id="moduloexp" class="form-control" style="border-radius: 15px;">
								<option value="">Selecciona un grado escolar</option>
								<?php foreach ($this->temp['grados'] as $value): ?>
									<option value="<?php echo $value['LGF0150001'] ?>"><?php echo $value['LGF0150002'] ?></option>
								<?php endforeach ?>
							</select>
						</div>

						<div class="col-lg-6 grupoxp" style="margin-top: 15px; display: none;">
							<select name="grupoxp" id="grupoxp" class="form-control" style="border-radius: 15px;">
								<option value="">Selecciona un grupo</option>
							</select>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" id="guardar" style="display: none;">Guardar</button>
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
					<div class="alert " id="mensaje" role="alert" style="display: none; text-align: left; margin-top: 10px;"></div>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	$("#file").click(function (e) {
		e.preventDefault();
		$("#archivo").trigger("click");
	});

	$("#archivo").on('change', function (e) {
		var file = document.querySelector('#archivo').files[0];
		var aux = file.name.split(".");
		if (aux[1] != "csv") {
			$('#exportar')[0].reset();
			$("#complemento").hide();
			$("#mensaje").addClass("alert-danger");
			$("#mensaje").html("Formato no permitido, solo se permiten archivos CSV");
			$("#mensaje").toggle("slow");
			return false;
		}
		$("#mensaje").hide();
		$("#complemento").show();
		// var fileN = getBase64(file, "#imagenPerfil");
	});

	$("#moduloexp").change(function () {
		if ($(this).val() != "") {
			$.ajax({
				type: "POST",
				url: context+"admin/obtenerGrupos",
				data: {grado: $(this).val(), id: $("#institucionexp").val()},
				success: function (resp) {
					console.log(resp)
					var lista = '<option value="">Selecciona un grupo</option>';
					$(".grupoxp").show();
					if (!$.isEmptyObject(resp.lista)) {
						$.each(resp.lista, function (i, value) {
							lista+='<option value="'+value.LGF0290001+'">'+value.LGF0290002+'</option>';
						});
						$("#grupoxp").html(lista);
						$("#guardar").show();
					} else {
						$("#grupoxp").html(lista);
						// $("#guardar").hide();
					}
				}
			});
		}
	})

	$("#guardar").click(function (e) {
		e.preventDefault();
		var form = new FormData($('#exportar')[0]);
        $.ajax({
        	url: context+'admin/importar_datos',
        	type: "post",
            data : form,
            processData: false,
            contentType: false,
            beforeSend: function () {
            	$("#mensaje").hide();
            	$("#mensaje").removeClass("alert-success");
            	$("#mensaje").removeClass("alert-danger");
            },
            success: function(data) {
                console.log(data);
                if (data.data != "") {
                	generarCSV(data.data, true);
                }
                if (data.error == 0) {
                	$("#mensaje").addClass("alert-success");
                } else {
                	$("#mensaje").addClass("alert-danger");
                }
                $("#mensaje").show();
                $("#mensaje").html(data.mensaje);
            }
        });
	});

	$('#carga').on('hidden.bs.modal', function(){
		$('#exportar')[0].reset();
	    $("#grupoxp").html('<option value="">Selecciona un grupo</option>');
	    $("#mensaje").hide();
    	$("#mensaje").removeClass("alert-success");
    	$("#mensaje").removeClass("alert-danger");
    });

    function generarCSV(JSONData, ShowLabel) {
	    var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;
	    var CSV = '';    
	    
	    if (ShowLabel) {
	      var row = "";
	      
	      for (var index in arrData[0]) {
	        row += index + ',';
	      }
	      row = row.slice(0, -1);
	      CSV += row + '\r\n';
	    }
	    
	    for (var i = 0; i < arrData.length; i++) {
	      var row = "";
	      for (var index in arrData[i]) {
	        row += '"' + arrData[i][index] + '",';
	      }
	      row.slice(0, row.length - 1);
	      CSV += row + '\r\n';
	    }

	    if (CSV == '') {
	      alert("Invalid data");
	      return;
	    }

	    var fileName = "Usuarios_no_registrados";
	    var uri = 'data:text/csv;charset=utf-8,' + escape(CSV);
	    var link = document.createElement("a");
	    link.href = uri;
	    link.style = "visibility:hidden";
	    link.download = fileName + ".csv";
	    document.body.appendChild(link);
	    link.click();
	    document.body.removeChild(link);
	}
</script>
<script src="//cdn.datatables.net/plug-ins/1.10.19/sorting/date-de.js"></script>