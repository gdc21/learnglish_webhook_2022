<section class="container">
	<section id="contenido">
		<?php echo $this->temp['encabezado']; ?>

		<div class="row">
			<div class="col-lg-6">
				<h1 class="title-section">Instituciones Registradas</h1>
			</div>

			<?php if ($_SESSION['perfil'] == 1) { ?>
				<div class="col-lg-3 offset-lg-3">
					<br>
					<a href="<?php echo CONTEXT ?>admin/addInstitucion"><button class="btn btn-lg registro">Nueva institución</button></a>

					<!-- <br><br>
					<button class="btn btn-lg registro" data-bs-toggle="modal" data-bs-target="#carga">Cargar instituciones</button> -->
					<br><br>
				</div>
			<?php } ?>
		</div>
		<div class="page">
			<div class="row">
				<div class="col-lg-12 table-responsive">
					<table class="table tabla" id="tabla">
						<thead>
							<th>Instituciones</th>
							<th>C.C.T</th>
							<th>Contacto</th>
							<th>Alumnos</th>
							<th>Fecha</th>
							<th>Cliente</th>
							<th>Grupos</th>
							<th>Acciones</th>
						</thead>
						<tbody>
							<?php 
								if (count($this->temp['lista']) > 0) {
									foreach ($this->temp['lista'] as $inst) { ?>
										<tr>
											<td><?php echo $inst['LGF0270002']; ?></td>
											<td><?php echo $inst['LGF0270028']; ?></td>
											<td>
												<?php 
													if (empty($inst['contacto'])) {
														echo "----";
													} else {
														echo $inst['contacto'];
													}
												?>
											</td>
											<td><?php echo $inst['total']; ?></td>
											<td>
												<?php 
													$aux = explode(" ", $inst['LGF0270013']);
													$fecha = date('d-m-Y', strtotime($aux[0]));
													echo $fecha;
												?>
											</td>
											<td>
												<?php 
													if (empty($inst['cliente'])) {
														echo "----";
													} else {
														echo $inst['cliente'];
													}
												?>
											</td>
											<td>
												<a href="<?php echo CONTEXT ?>admin/grupos/<?php echo $inst['LGF0270001']; ?>"><?php echo $inst['totalGrupos']; ?></a>
											</td>
											<td>
												<span><a href="<?php echo CONTEXT ?>admin/editInstitucion/<?php echo $inst['LGF0270001']; ?>">
													<i class="fa fa-pencil" aria-hidden="true"></i> Editar</a>
												</span>
												<?php if ($_SESSION['perfil'] != 4) { ?>
													<span><a href="#" onclick="eliminar(<?php echo $inst['LGF0270001']; ?>)">
														<i class="fa fa-trash" aria-hidden="true"></i> Eliminar</a>
													</span>
												<?php } ?>
											</td>
										</tr>
									<?php }
								} else { ?>
									<tr>
										<td colspan="6">No hay registros</td>
									</tr>
							<?php } ?>
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
				<h5 class="modal-title" id="exampleModalLabel">Carga de instituciones</h5>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" style="margin-top: -22px;">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="exportar" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-6">
							<input type="hidden" id="opcion" name="opcion" value="2">
							<input type="file" id="archivo" name="archivo" style="display: none;">
							<button id="file" class="btn btn-primary-btn-lg">Cargar archivo</button>
						</div>
						<div class="col-lg-6">
							<a id="download" class="btn btn-primary-btn-lg" href="<?php echo CONTEXT ?>portal/archivos/importar_instituciones_ejemplo.xlsx" download>Descargar ejemplo</a>
						</div>
					</div>
					<div class="row" style="margin-top: 15px; display: none;" id="complemento">
						<div class="col-lg-6">
							<select name="clienteexp" id="clienteexp" class="form-control" style="border-radius: 15px;">
								<option value="">Selecciona un cliente</option>
								<?php foreach ($this->temp['clientes'] as $value): ?>
									<option value="<?php echo $value['LGF0280001'] ?>"><?php echo $value['LGF0280002'] ?></option>
								<?php endforeach ?>
							</select>
						</div>
						<div class="col-lg-6">
							<select name="paisexp" id="paisexp" class="form-control" style="border-radius: 15px;">
								<option value="">Selecciona un país</option>
								<option value="1">México</option>
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
		console.log(aux)
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

	$("#clienteexp").change(function () {
		if ($(this).val() != "") {
			$("#guardar").show();
		} else {
			$("#guardar").hide();
		}
	});

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
</script>
<script src="<?php echo CONTEXT ?>portal/frontend/js/institucion.js"></script>