<section class="container">
	<section id="contenido">
		<?php echo $this->temp['encabezado']; ?>
		<div class="separador">
			<div class="row">
				<div class="col-lg-6">
					<h1 class="title-section">Evaluaciones Registradas</h1>
				</div>

				<div class="col-lg-3 offset-lg-3">
					<br>
					<a href="<?php echo CONTEXT ?>admin/addevaluacion"><button class="btn btn-lg registro">Nueva evaluación</button></a>
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
			<div class="row" style="margin-top: 1em;">
				<div class="col-lg-4 offset-lg-4">
					<select name="leccion" id="leccion" class="form-control">
						<option value="">Todos las lecciones</option>
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
							<th>Módulo</th>
							<th>Lección</th>
							<th>Preguntas</th>
							<th>Fecha</th>
							<th>Estatus</th>
							<th>Acciones</th>
						</thead>
						<tbody>
						</tbody>
					</table>
					<div class="alert" id="mensaje" style="display: none;"></div>
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