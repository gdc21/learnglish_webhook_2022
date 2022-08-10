<section class="container">
	<section id="contenido">
		<?php echo $this->temp['encabezado']; ?>
		<div class="separador">
			<div class="row">
				<div class="col-lg-6">
					<h1 class="title-section">Lecciones registradas</h1>
				</div>
			</div>
			<div class="separador"></div>
			<div class="row">
				<div class="col-lg-3 offset-lg-2">
					<br>
					<button class="btn btn-lg registro" onclick="editar('','');">Nueva lección</button>
				</div>
				<div class="col-lg-3">
					<br>
					<button class="btn btn-lg registro" onclick="migrar()">Migrar lecciones</button>
				</div>
				<div class="col-lg-3">
					<br>
					<a class="btn btn-lg registro" href='<?php echo CONTEXT ?>admin/objeto/'>Objetos registrados</a>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-3 offset-lg-2">
					<br>
					<a class="btn btn-lg registro" href='<?php echo CONTEXT ?>admin/guides/'>Guías de Estudio</a>
				</div>
				<div class="col-lg-3">
					<br>
					<a class="btn btn-lg registro" href='<?php echo CONTEXT ?>admin/means/'>Recursos Digitales</a>
				</div>
			</div>
		</div>

		<div class="separador">
			<div class="row">
				<div class="col-lg-4 offset-lg-4">
					<select name="modulo" id="modulo" class="form-control">
						<option value="">Todos los módulos</option>
						<?php 
							foreach ($this->temp['modulos'] as $modulo) { ?>
								<option value="<?php echo $modulo['id']; ?>"><?php echo $modulo['nombre']; ?></option>
							<?php }
						?>
					</select>
				</div>
			</div>
		</div>

		<div class="separador">
			<div class="row">
				<div class="col-lg-4 offset-lg-4">
					<button type="button" id="ordenar" class="btn registro" style="display: none;">Ordenar lecciones</button>
				</div>
			</div>
		</div>

		<div class="page">
			<div class="row">
				<div class="col-lg-12 table-responsive">
					<table class="table tabla" id="tabla">
						<thead>
							<th># Lección</th>
							<th>Grada Escolar</th>
							<th>Nombre</th>
							<th>Icono</th>
							<th>Icono miniatura</th>
							<th>Estatus</th>
							<th>Acciones</th>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>

			<div class="row">
			    <div class="col-lg-4 offset-lg-8">
			    	<a class="regresar basico menu-principal" href='<?php echo CONTEXT ?>admin/manager/'>Regresar al menú principal</a>
			    </div>
			</div>
		</div>
	</section>

	<div id="m-lecciones" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg">
			<form id="formL" autocomplete="off" enctype="multipart/form-data">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"><b id="tituloModal"></b></h5>
						<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" style="margin-top: -10px !important;">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-lg-6">
								<label class="form-label">Nombre de la lección</label>
								<input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ingresa el nombre">
								<input type="hidden" name="clave" id="clave" class="form-control">
								<input type="hidden" name="seccion" id="seccion" class="form-control">
								<input type="hidden" name="orden" id="orden" class="form-control">
							</div>
							<div class="col-lg-6" id="newM" style="display: none;">
								<label class="form-label">Selecciona un módulo</label>
								<select name="nmodulo" id="nmodulo" class="form-control">
									<option value="">Todos los módulos</option>
									<?php 
										foreach ($this->temp['modulos'] as $modulo) { ?>
											<option value="<?php echo $modulo['id']; ?>"><?php echo $modulo['nombre']; ?></option>
										<?php }
									?>
								</select>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-lg-6">
								<label class="form-label">Icono</label>
								<input type="file" name="iconoP" id="iconoP" style="display: none;">
								<img src="<?php echo CONTEXT; ?>portal/archivos/iconosLecciones/icono_temporal.png" class="img-fluid" id="imgP">
								<button class="btn btn-lg btn-primary" id="btnP">Cambiar icono</button>
							</div>

							<div class="col-lg-6">
								<label class="form-label">Icono miniatura</label>
								<input type="file" name="iconoS" id="iconoS" style="display: none;">
								<img src="<?php echo CONTEXT; ?>portal/archivos/iconosLecciones/icono_temporal.png" class="img-fluid" id="imgS" style="background: #a7a7a770;">
								<button class="btn btn-lg btn-primary" id="btnS">Cambiar icono</button>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-3">
								<label class="form-label">Estatus</label>
								<select name="status" id="status" class="form-control">
									<option value="">Selecciona una opción</option>
									<option value="1">Activar</option>
									<option value="0">Desactivar</option>
								</select>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<div class="alert alert-success" id="mensaje" role="alert" style="display: none; text-align: left; margin-top: 10px;"></div>
						<button type="button" class="btn btn-primary" id="save" style="margin-right: 10px !important;">Guardar</button>
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Cerrar</button>
					</div>
				</div>
			</form>
		</div>
	</div>

	<div class="modal fade bd-example-modal-lg modal-ordenamiento" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><b id="tituloModal"></b></h5>
					<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" style="margin-top: -10px !important;">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<ul class='list-group' id='sortable'></ul>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Cerrar</button>
				</div>
			</div>
		</div>
	</div>

	<div id="l-migrar" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg">
			<form id="formM" autocomplete="off" enctype="multipart/form-data">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"><b id="tituloModal"></b></h5>
						<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" style="margin-top: -10px !important;">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-lg-4" id="newM">
								<label class="form-label">Selecciona un módulo</label>
								<select name="smodulo" id="smodulo" class="form-control">
									<option value="">Todos los módulos</option>
									<?php 
										foreach ($this->temp['modulos'] as $modulo) { ?>
											<option value="<?php echo $modulo['id']; ?>"><?php echo $modulo['nombre']; ?></option>
										<?php }
									?>
								</select>
							</div>

							<div class="col-lg-6" id="newM">
								<label class="form-label">Selecciona el nuevo módulo de la(s) leccion(es)</label>
								<select name="nmigrar" id="nmigrar" class="form-control">
									<option value="">Todos los módulos</option>
									<?php 
										foreach ($this->temp['modulos'] as $modulo) { ?>
											<option value="<?php echo $modulo['id']; ?>"><?php echo $modulo['nombre']; ?></option>
										<?php }
									?>
								</select>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-lg-12">
								<div id="contenedor"></div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<div class="alert alert-success" id="mensajeM" role="alert" style="display: none; text-align: left; margin-top: 10px;"></div>
						<button type="button" class="btn btn-primary" id="migrar" style="margin-right: 10px !important; ">Guardar</button>
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Cerrar</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>