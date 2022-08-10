<section class="container">
	<section id="contenido">
		<?php echo $this->temp['encabezado']; ?>
		<div class="separador">
			<div class="row">
				<div class="col-lg-7">
					<h1 class="title-section">Actualizar información</h1>
				</div>

				<div class="col-lg-4 offset-lg-1">
					<br>
					<a href="<?php echo CONTEXT ?>admin/evaluacion"><button class="btn btn-lg registro">Evaluaciones registradas</button></a>
				</div>
			</div>
		</div>

		<?php $datos = $this->temp['info']; ?>

		<div class="page">
			<div class="row">
				<div class="col-lg-12">
					<form id="formEvaluacion" enctype="multipart/form-data" novalidate="novalidate" autocomplete="off">
						<input type="hidden" id="leccion_id" value="<?php echo $datos['leccion']; ?>">
						<input type="hidden" name="evaluacion" value="<?php echo $datos['evaluacion']; ?>">
						<table class="FormularioStyle align_left" id="A_t_Neval">
							<tbody>
								<tr>
									<td class="nameCampo">Nombre</td>
									<td>
										<input type="text" name="nombre" id="nombre" value="<?php echo $datos['nombre']; ?>" placeholder="Ingresa el nombre de la evaluación" >
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Módulo</td>
									<td>
										<select name="modulo" id="modulo" class="form-control select">
											<option value="">Selecciona un módulo</option>
											<?php 
												foreach ($this->temp['modulos'] as $modulo) { ?>
													<option value="<?php echo $modulo['id']; ?>" <?php if($datos['modulo'] == $modulo['id']){echo "selected";} ?>><?php echo $modulo['nombre']; ?></option>
												<?php }
											?>
										</select>
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Lección</td>
									<td>
										<select name="leccion" id="leccion" class="form-control select"></select>
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Preguntas a mostrar</td>
									<td>
										<input type="text" name="preguntas" id="preguntas" value="<?php echo $datos['preguntas']; ?>" placeholder="Ingresa el numero de preguntas" onkeypress="return aceptNum(event)" >
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Tiempo de evaluación</td>
									<td>
										<input type="text" name="tiempo" id="tiempo" placeholder="hh/mm" disabled="">
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Estatus</td>
									<td>
										<input type="radio" name="estatus" id="estatus1" value="1" <?php if($datos['estatus'] == 1){echo "checked";} ?> style="margin-left: 20px;">
										<label for="estatus1">Activa</label>
										<input type="radio" name="estatus" id="estatus2" value="0" <?php if($datos['estatus'] == 0){echo "checked";} ?> style="margin-left: 20px;">
										<label for="estatus2">Inactiva</label>
										<br><span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Fecha de registro</td>
									<td>
										<input type="text" value="<?php echo date("d-m-Y"); ?>"  readonly>
									</td>
								</tr>
							</tbody>
						</table>
						<div class="alert" id="mensaje" style="display: none;"></div>
						<br />
						<div class="row">
							<!-- <input type="submit" value="GUARDAR" class="btGuardar btGuardarR"> -->
							<div class="col-lg-4 offset-lg-4">
								<button type="submit" id="guardar" class="btn btn-lg registro text-center">Guardar</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
</section>