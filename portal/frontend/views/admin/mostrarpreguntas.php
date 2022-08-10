<section class="container">
	<section id="contenido">
		<?php echo $this->temp['encabezado']; ?>
		<div class="separador">
			<div class="row">
				<div class="col-lg-6 col-md-12 col-sm-12">
					<h1 class="title-section">Preguntas Registradas</h1>
				</div>

				<div class="col-lg-4 col-md-12 col-sm-12 offset-lg-2">
					<br>
					<a href="<?php echo CONTEXT ?>admin/evaluacion"><button class="btn btn-lg registro">Evaluaciones Registradas</button></a>
				</div>
			</div>
		</div>
		<?php $info = $this->temp['informacion']; ?>
		<div class="page">
			<div class="row">
				<div class="separador">
					<div class="col-lg-12">
						<table class="table tabla">
							<thead>
								<tr>
									<th>Evaluacion</th>
									<td><strong style="font-size: 18px;"><?php echo $info['nombre_evaluacion']; ?></strong></td>
									<th>Evaluados</th>
									<td><strong style="font-size: 18px;"><?php echo $info['evaluados']; ?></strong></td>
									<th>Aprobados</th>
									<td><strong style="font-size: 18px;"><?php echo $info['aprobados']; ?></strong></td>
									<th>Reprobados</th>
									<td><strong style="font-size: 18px;"><?php echo $info['reprobados']; ?></strong></td>
								</tr>
							</thead>
						</table>
					</div>
				</div>
				<div class="col-lg-12">
					<table class="table tabla" id="tabla">
						<thead>
							<th>Pregunta</th>
							<th>Categoría</th>
							<th>Tipo</th>
							<th>Aciertos</th>
							<th>Errores</th>
							<th>Acciones</th>
						</thead>
						<tbody>
							<?php foreach ($info['preguntas'] as $pregunta) {
								if ($pregunta['tipo'] == 1) {
								 	$tipo = "Opción multiple";
								 } else if ($pregunta['tipo'] == 2) {
								 	$tipo = "Verdadero o Falso";
								 } else {
								 	$tipo = "N/A";
								 }
								 if (empty($pregunta['pregunta'])) {
								  	$nombre = "N/A";
								 } else {
								 	$nombre = $pregunta['pregunta'];
								 }
								 if (empty($pregunta['categoria'])) {
								  	$categoria = "N/A";
								 } else {
								 	$categoria = $pregunta['categoria'];
								 } ?>
								<tr>
									<td><?php echo $nombre ?></td>
									<td><?php echo $categoria; ?></td>
									<td><?php echo $tipo; ?></td>
									<td><?php echo $pregunta['aciertos']; ?></td>
									<td><?php echo $pregunta['errores']; ?></td>
									<td><span><a href="<?php echo CONTEXT ?>admin/editQuestion/<?php echo $pregunta['pregunta_id']; ?>"><i class='fa fa-pencil' aria-hidden='true'></i> Editar</a></span></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
					<div class="alert" id="mensaje" style="display: none;"></div>
				</div>
				<div class="separador">
					<div class="col-lg-4 offset-lg-4">
						<a href="<?php echo CONTEXT ?>admin/addQuestion/<?php echo $info['id_evaluacion']; ?>"><button class="btn btn-lg registro">Agregar pregunta</button></a>
					</div>
				</div>
			</div>
		</div>
	</section>
</section>