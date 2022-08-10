<section class="container">
	<section id="contenido">
		<?php echo $this->temp['encabezado']; ?>
		<div class="separador">
			<div class="row">
				<div class="col-lg-6">
					<h1 class="title-section">Grupos registrados de la institución <?php echo $this->temp['nombre_institucion']; ?></h1>
				</div>

				<!-- <?php print_r($_SESSION); ?> -->

				<div class="col-lg-3 offset-lg-3">
					<br>
					<button class="btn btn-lg registro" data-bs-toggle="modal" data-bs-target="#modalGrupos">Nuevo grupo</button>
					<br><br>
					<a href="<?php echo CONTEXT ?>admin/instituciones"><button class="btn btn-lg registro">Regresar</button></a>
				</div>
			</div>
		</div>
		
		<div class="page">
			<div class="row">
				<div class="col-lg-12 table-responsive">
					<table class="table tabla" id="tabla">
						<thead>
							<th>Institución</th>
							<th>Grupo</th>
							<th>Número de alumnos</th>
							<th>Acciones</th>
						</thead>
						<tbody>
							<?php foreach ($this->temp['lista'] as $grupo): ?>
								<tr>
									<td><?php echo $grupo['LGF0270002']; ?></td>
									<td><?php echo $grupo['LGF0290002']; ?></td>
									<td>
										<?php 
											if ($grupo['totalAlumnos'] == 1) {
												echo $grupo['totalAlumnos']." alumno";
											} else {
												echo $grupo['totalAlumnos']." alumnos";
											}
										?>
									</td>
									<td>
										<span><a onclick="mostrar(<?php echo $grupo['LGF0290001']; ?>)">
											<i class="fa fa-pencil" aria-hidden="true"></i> Editar</a>
										</span>
										<span><a onclick="eliminar(<?php echo $grupo['LGF0290001']; ?>)">
											<i class="fa fa-trash" aria-hidden="true"></i> Eliminar</a>
										</span>
									</td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>

					<div class="alert alert-danger" id="mensaje1" role="alert" style="margin-top: 20px; display: none;"></div>
				</div>
			</div>
		</div>
	</section>
</section>

<!-- Modal -->
<div class="modal fade" id="modalGrupos" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><b id="tituloModal">Crear grupo</b></h5>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST" id="form-grupo" autocomplete="off">
				<input type="hidden" name="institucion" value="<?php echo $this->temp['institucion_id'] ?>">
				<input type="hidden" name="idgrupo" id="idgrupo">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="grupo">Nombre del Grupo</label>
								<input type="text" name="grupo" id="grupo" class="form-control" placeholder="Ingresa el nombre del grupo">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="nivel">Selecciona un Grado Académico</label>
								<select name="nivel" id="nivel" class="form-control">
									<option value=0>Selecciona un grado académico</option>
										<?php foreach ($this->temp['modulos'] as $modulo): ?>
											<option value="<?php echo $modulo['id']; ?>"><?php echo $modulo['nombre'];?></option>
										<?php endforeach ?>
								</select>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="grupo">Selecciona un Docente</label>
								<select name="docente" id="docente" class="form-control">
									<option value=0>Selecciona un docente</option>
										<?php foreach ($this->temp['docentes'] as $docente): ?>
											<option value="<?php echo $docente['clave']; ?>"><?php echo $docente['nombre'];?></option>
										<?php endforeach ?>
								</select>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="ciclo">Ciclo Escolar</label>
								<!-- <input type="text" name="ciclo" id="ciclo" class="form-control" placeholder="Ciclo Escolar"> -->
								<select name="ciclo" id="ciclo" class="form-control">
									<option value="">Selecciona un ciclo escolar</option>
									<?php foreach ($this->temp['cicloEscolar'] as $es): ?>
										<option value="<?php echo $es['LGF0350001'] ?>"><?php echo $es['LGF0350002'] ?></option>
									<?php endforeach ?>
								</select>
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group">
								<div class="alert alert-danger" id="mensaje" role="alert" style="margin-top: 20px; display: none;"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" id="guardar">Guardar</button>
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
				</div>
			</form>
		</div>
	</div>
</div>