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
					<a href="<?php echo CONTEXT ?>admin/objeto"><button class="btn btn-lg registro">Objetos registrados</button></a>
				</div>
			</div>
		</div>
		<?php $objeto = $this->temp['objeto']; ?>
		<div class="page">
			<div class="row">
				<div class="col-lg-12">
					<form id="formObjetoUp" enctype="multipart/form-data" novalidate="novalidate" autocomplete="off">
						<input type="hidden" name="objeto" value="<?php echo $objeto['objeto']; ?>">
						<table class="FormularioStyle align_left" id="A_t_Neval">
							<tbody>
								<tr>
									<td class="nameCampo">Nombre</td>
									<td>
										<select name="seccion" id="seccion" class="form-control select">
											<option value="">Selecciona un módulo</option>
											<?php 
												foreach ($this->temp['secciones'] as $seccion) { ?>
													<option value="<?php echo $seccion['id']; ?>" <?php if($objeto['seccion'] == $seccion['id']){echo "selected";} ?>><?php echo $seccion['nombre']; ?></option>
												<?php }
											?>
										</select>
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Módulo</td>
									<td>
										<select name="modulo" id="modulo" class="form-control select" readonly>
											<option selected><?php echo $objeto['modulo']; ?></option>
										</select>
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Lección</td>
									<td>
										<select name="leccion" id="leccion" class="form-control select" readonly>
											<option selected><?php echo $objeto['leccion'] ?></option>
										</select>
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Archivo zip</td>
									<td>
										<div class="row col-lg-12">
											<input type="text" id="archivo_texto" placeholder="Archivo zip" style="width: 40%; margin-left: 12px;" readonly>
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
											<option value="1" <?php if($objeto['estatus']==1){echo "selected";} ?>>Activo</option>
											<option value="0" <?php if($objeto['estatus']==0){echo "selected";} ?>>Inactivo</option>
										</select>
										<span class="error"></span>
									</td>
								</tr>

								<!--<tr>
									<th class="nameCampo">Instrucciones</th>
									<td>
										<div class="row">
											<div class="col-lg-6">
												<label for="texto_es" class="form-label">Instrucciones en español</label>
												<textarea class="form-control" id="texto_es" name="texto_es" rows="3" style="resize: none;" placeholder="Ingresa las instrucciones de la lección en español..."><?php /*echo $objeto['texto_es']; */?></textarea>
											</div>
											<div class="col-lg-6">
												<label for="texto_en" class="form-label">Instrucciones en inglés</label>
												<textarea class="form-control" id="texto_en" name="texto_en" rows="3" style="resize: none;" placeholder="Ingresa las instrucciones de la lección en inglés..."><?php /*echo $objeto['texto_en']; */?></textarea>
											</div>
										</div>
									</td>
								</tr>-->

								<!--<tr>
									<th class="nameCampo">Instrucciones en audio</th>
									<td colspan="2">
										<div class="row">
											<div class="col-lg-6">
												<label for="texto_es" class="form-label">Audio en español</label>
												<br>
												<input type="file" name="audio_es" id="audio_es" style="display: none;">
												<?php /*if ($objeto['audio_es'] != "") { */?>
													<a onclick="reproductor('rep_audio_es')" id="rep_audio_es" data-enlace="<?php /*echo $objeto['audio_es']; */?>" style="text-shadow: none; font-size: 24px; margin-right: 10px;" title="Reproducir audio en español"><i class="fa fa-play" aria-hidden="true"></i></a>

													<a onclick="eliminar_audio(<?php /*echo $objeto['objeto'] */?>, 1,'es')" id="dlt_audio_es" style="text-shadow: none; font-size: 24px; margin-right: 10px;" title="Eliminar audio en español"><i class="fa fa-trash" aria-hidden="true"></i></a>
												<?php /*} */?>
												<button class="btn btn-lg registro audio" data-lg="es" style="width: 60% !important; margin-bottom: 10px !important;">Cargar audio <i class="fa fa-upload" aria-hidden="true"></i></button>
												<audio controls id="play_es" style="display: none;"></audio>
											</div>
											<div class="col-lg-6">
												<label for="texto_en" class="form-label">Audio en inglés</label>
												<br>
												<input type="file" name="audio_en" id="audio_en" style="display: none;">
												<?php /*if ($objeto['audio_en'] != "") { */?>
													<a onclick="reproductor('rep_audio_en')" id="rep_audio_en" data-enlace="<?php /*echo $objeto['audio_en']; */?>" style="text-shadow: none; font-size: 24px; margin-right: 10px;" title="Reproducir audio en inglés"><i class="fa fa-play" aria-hidden="true"></i></a>

													<a onclick="eliminar_audio(<?php /*echo $objeto['objeto'] */?>, 1,'en')" id="dlt_audio_en" style="text-shadow: none; font-size: 24px; margin-right: 10px;" title="Eliminar audio en inglés"><i class="fa fa-trash" aria-hidden="true"></i></a>
												<?php /*} */?>
												<button class="btn btn-lg registro audio" data-lg="en" style="width: 60% !important; margin-bottom: 10px !important;">Cargar audio <i class="fa fa-upload" aria-hidden="true"></i></button>
												<audio controls id="play_en" style="display: none;"></audio>
											</div>
										</div>
									</td>
								</tr>
-->
								<!--<tr>
									<th class="nameCampo">Instrucciones imagen</th>
									<td colspan="2">
										<div class="row">
											<div class="col-lg-6">
												<br>
												<input type="file" name="imagen" id="imagen" style="display: none;">

												<?php /*if ($objeto['img_instruccion'] != "") { */?>
													<a onclick="eliminar_audio(<?php /*echo $objeto['objeto'] */?>, 1,'img')" id="dlt_img_inst" style="text-shadow: none; font-size: 24px; margin-right: 10px;" title="Eliminar imagen"><i class="fa fa-trash" aria-hidden="true"></i></a>
												<?php /*} */?>
												
												<button class="btn btn-lg registro imgInst" style="width: 60% !important; margin-bottom: 10px !important;">Cargar imagen <i class="fa fa-upload" aria-hidden="true"></i></button>
											</div>

											<div class="col-lg-6">
												<div style="width: 97px; height: 90px;">
													<img id="preview_img" src="<?php /*echo ($objeto['img_instruccion'] == "") ? "" : $objeto['img_instruccion'] */?>">
												</div>
											</div>
										</div>
									</td>
								</tr>-->
								<tr>
                                    <td colspan="2">
                                        Para la carga de instrucciones pruebe el siguiente módulo
                                        <br>
                                        <a href="<?php echo CONTEXT; ?>admin/cargarinstruccionessecciones/" target="_blank">Cargar instrucciones</a>
                                    </td>
                                </tr>
								<tr>
									<td class="nameCampo">Fecha de registro</td>
									<td>
									<input type="text" value="<?php echo $objeto['fecha']; ?>" style="width: 100%;" readonly>
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