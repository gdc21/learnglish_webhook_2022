<section class="container">
	<section id="contenido">
		<?php echo $this->temp['encabezado']; ?>
		<div class="separador">
			<div class="row">
				<div class="col-lg-7">
					<h1 class="title-section">Nuevo objeto</h1>
				</div>

				<div class="col-lg-4 offset-lg-1">
					<br>
					<a href="<?php echo CONTEXT ?>admin/objeto"><button class="btn btn-lg registro">Objetos registrados</button></a>
				</div>
			</div>
		</div>

		<div class="page">
			<div class="row">
				<div class="col-lg-12">
					<form id="formObjeto" enctype="multipart/form-data" novalidate="novalidate" autocomplete="off">
						<?php 
							$mod_id = $this->temp['modulo'];
							$leccion = $this->temp['leccion'];
						?>
						<table class="FormularioStyle align_left" id="A_t_Neval">
							<input type="hidden" id="lec_id" value="<?php echo $leccion; ?>">
							<input type="hidden" id="mod_id" value="<?php echo $mod_id; ?>">
							<tbody>
								<tr>
									<td class="nameCampo">Nombre</td>
									<td>
										<select name="seccion" id="seccion" class="form-control select">
											<option value="">Selecciona un módulo</option>
											<?php 
												foreach ($this->temp['secciones'] as $seccion) { ?>
													<option value="<?php echo $seccion['id']; ?>"><?php echo $seccion['nombre']; ?></option>
												<?php }
											?>
										</select>
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
													<option value="<?php echo $modulo['id']; ?>" <?php if (!empty($mod_id)) {
														if ($modulo['id'] == $mod_id) {
															echo "selected";
														}
													} ?> ><?php echo $modulo['nombre']; ?></option>
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
									<td class="nameCampo">Archivo zip</td>
									<td>
										<div class="row col-lg-12">
											<input type="text" id="archivo_texto" placeholder="Selecciona un archivo" style="width: 40%; margin-left: 12px;" readonly>
											<button class="btn btn-lg registro" id="archivo" style="width: 25% !important;">Cargar <i class="fa fa-upload" aria-hidden="true"></i></button>
											<input type="file" name="file" id="file" style="display: none;">
										</div>
										<span class="error" id="mensaje-archivo"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Estatus</td>
									<td>
										<select name="estatus" id="estatus" class="form-control select">
											<option value="">Selecciona una opción</option>
											<option value="1">Activo</option>
											<option value="0">Inactivo</option>
										</select>
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Fecha de registro</td>
									<td>
										<input type="text" value="<?php echo date("d-m-Y"); ?>" style="width: 100%;" readonly>
									</td>
								</tr>
							</tbody>
						</table>
						<div class="alert" id="mensaje" style="display: none; font-size: 14px;"></div>
						<br />
						<div class="row">
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