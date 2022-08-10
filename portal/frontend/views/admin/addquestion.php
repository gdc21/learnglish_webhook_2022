<section class="container">
	<section id="contenido">
		<?php echo $this->temp['encabezado']; ?>
		<div class="separador">
			<div class="row">
				<div class="col-lg-7 col-md-12 col-sm-12">
					<h1 class="title-section">Configuración de la pregunta</h1>
				</div>

				<div class="col-lg-4 col-md-12 col-sm-12 offset-lg-1">
					<br>
					<a href="<?php echo CONTEXT ?>admin/mostrarPreguntas/<?php echo $this->temp['pregunta_id']; ?>"><button class="btn btn-lg btn-primary registro">Preguntas Registradas</button></a>
				</div>
			</div>
		</div>
		
		<div class="page">
			<div class="row">
				<div class="col-lg-12">
					<form id="formPregunta" enctype="multipart/form-data" novalidate="novalidate" autocomplete="off">
						<input type="hidden" name="id" value="<?php echo $this->temp['pregunta_id']; ?>">
						<input type="hidden" id="imagen" value="<?php echo IMG ?>preview.png">
						<table class="FormularioStyle align_left" id="A_t_Neval">
							<tbody>
								<tr>
									<td class="nameCampo">Evaluación</td>
									<td>
										<label><?php echo $this->temp['nombre_evaluacion']; ?></label>
									</td>
								</tr>
								<tr>
									<td class="nameCampo color1">Texto de la pregunta</td>
									<td>
										<textarea name="texto" id="texto" cols="100" rows="5" style="resize: none; border: none;" placeholder="Ingresa el texto de la pregunta"></textarea>
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo color1">Imagen de la pregunta</td>
									<td>
										<div class="row">
											<div class="col-lg-4">
												<img src="<?php echo IMG ?>preview.png" id="imgPrin" style="width: 200px; height: 150px; border: none;">
												<!-- <audio controls id="audiopregunta" style="display: none;"><source id="audioPrin" src="" type="audio/mpeg"></audio> -->
												<audio id="audiopregunta" src="" preload="auto" controls controlsList="nodownload" style="display: none;"></audio>
												<video  src="" width="320" height="240" controls controlsList="nodownload" id="videopregunta" style="display: none;"></video>
											</div>
											<div class="col-lg-5">
												<br><br>
												<button class="btn btn-lg btn-primary subir" id="imgPrincipal" style="margin-left: 70px !important;">Cargar</button>
												<input type="file" name="imagenprincipal" id="imagenprincipal" style="display: none;">
											</div>
										</div>
										<span class="error"></span>
										<span class="error" id="filePincipal" style="display: none;"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo color1">Categoría de evaluación</td>
									<td>
										<select name="categoria" id="categoria" class="form-control select">
											<option value="">Selecciona un categoría</option>
											<?php foreach ($this->temp['categorias'] as $categoria): ?>
												<option value="<?php echo $categoria['clave']; ?>"><?php echo $categoria['nombre']; ?></option>
											<?php endforeach ?>
										</select>
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo color1">Tipo de pregunta</td>
									<td>
										<select name="tipo" id="tipo" class="form-control select">
											<option value="">Selecciona el tipo de pregunta</option>
											<option value="1">Opción multiple</option>
											<option value="2">Verdadero o Falso</option>
										</select>
										<span class="error"></span>
									</td>
								</tr>
								<tr class="optionmultiple" style="display: none;">
									<td class="nameCampo color2">Pregunta correcta</td>
									<td>
										<div class="row">
											<div class="col-lg-12">
												<img alt="" src="<?php echo IMG ?>admin/opcion_correcta.png">
												<input type="text" name="correcta" id="correcta" placeholder="Ingresa la respuesta correcta" style="width: 80%; margin-left: 25px;">
											</div>
											<div class="col-lg-12" style="margin-top: 20px;">
												<span style="font-size: 30px;"><i class="fa fa-upload" aria-hidden="true"></i></span>
												<input type="text" id="imgcorrecta_texto" placeholder="Adjuntar archivo" style="width: 40%; margin-left: 25px;" readonly>
												<button class="btn btn-lg btn-primary subir" id="imagenCorrecta">Cargar</button>
												<input type="file" name="imgcorrecta" id="imgcorrecta" style="display: none;">
											</div>
										</div>
										<span class="error"></span>
									</td>
								</tr>
								<tr class="optionmultiple" style="display: none;">
									<td class="nameCampo color3">Opciones incorrectas</td>
									<td>
										<div class="row">
											<div class="col-lg-12">
												<img alt="" src="<?php echo IMG ?>admin/opcion_incorrecta.png">
												<input type="text" name="respuestaincorrecta1" id="respuestaincorrecta1" placeholder="Ingresa una respuesta incorrecta" style="width: 80%; margin-left: 25px;">
											</div>
											<div class="col-lg-12" style="margin-top: 20px;">
												<span style="font-size: 30px;"><i class="fa fa-upload" aria-hidden="true"></i></span>
												<input type="text" id="imgincorrecta_texto1" placeholder="Adjuntar archivo" style="width: 40%; margin-left: 25px;" readonly>
												<button class="btn btn-lg btn-primary subir incorrecta" data-i="1">Cargar</button>
												<input type="file" name="imgcorrecta1" id="imgincorrecta1" style="display: none;">
											</div>
								
											<div class="col-lg-12" style="margin-top: 20px;">
												<img alt="" src="<?php echo IMG ?>admin/opcion_incorrecta.png">
												<input type="text" name="respuestaincorrecta2" id="respuestaincorrecta2" placeholder="Ingresa una respuesta incorrecta" style="width: 80%; margin-left: 25px;">
											</div>
											<div class="col-lg-12" style="margin-top: 20px;">
												<span style="font-size: 30px;"><i class="fa fa-upload" aria-hidden="true"></i></span>
												<input type="text" id="imgincorrecta_texto2" placeholder="Adjuntar archivo" style="width: 40%; margin-left: 25px;" readonly>
												<button class="btn btn-lg btn-primary subir incorrecta" data-i="2">Cargar</button>
												<input type="file" name="imgcorrecta2" id="imgincorrecta2" style="display: none;">
											</div>
								
											<div class="col-lg-12" style="margin-top: 20px;">
												<img alt="" src="<?php echo IMG ?>admin/opcion_incorrecta.png">
												<input type="text" name="respuestaincorrecta3" id="respuestaincorrecta3" placeholder="Ingresa una respuesta incorrecta" style="width: 80%; margin-left: 25px;">
											</div>
											<div class="col-lg-12" style="margin-top: 20px;">
												<span style="font-size: 30px;"><i class="fa fa-upload" aria-hidden="true"></i></span>
												<input type="text" id="imgincorrecta_texto3" placeholder="Adjuntar archivo" style="width: 40%; margin-left: 25px;" readonly>
												<button class="btn btn-lg btn-primary subir incorrecta" data-i="3">Cargar</button>
												<input type="file" name="imgcorrecta3" id="imgincorrecta3" style="display: none;">
											</div>
										</div>
										<span class="error"></span>
									</td>
								</tr>
								<tr class="vf" style="display: none;">
									<td class="nameCampo color2">Pregunta correcta</td>
									<td>
										<div class="row">
											<div class="col-lg-12">
												<img alt="" src="<?php echo IMG ?>admin/opcion_correcta.png">
												<input type="text" name="correctaV" id="correctaV" placeholder="Ingresa la respuesta correcta" style="width: 80%; margin-left: 25px;">
											</div>
											<div class="col-lg-12" style="margin-top: 20px;">
												<span style="font-size: 30px;"><i class="fa fa-upload" aria-hidden="true"></i></span>
												<input type="text" id="imgcorrecta_textoV" placeholder="Adjuntar archivo" style="width: 40%; margin-left: 25px;" readonly>
												<input type="hidden" id="extension_archivoV" name="imgcorrecta_extension_archivoV">
												<button class="btn btn-lg btn-primary subir" id="imgcorrectV">Cargar</button>
												<input type="file" name="imgcorrectaV" id="imgcorrectaV" style="display: none;">
											</div>
										</div>
									</td>
								</tr>
								<tr class="vf" style="display: none;">
									<td class="nameCampo color3">Opciones incorrectas</td>
									<td>
										<div class="row">
											<div class="col-lg-12">
												<img alt="" src="<?php echo IMG ?>admin/opcion_incorrecta.png">
												<input type="text" name="respuestaincorrectaF" id="respuestaincorrectaF" placeholder="Ingresa una respuesta incorrecta" style="width: 80%; margin-left: 25px;">
											</div>
											<div class="col-lg-12" style="margin-top: 20px;">
												<span style="font-size: 30px;"><i class="fa fa-upload" aria-hidden="true"></i></span>
												<input type="text" id="imgcorrecta_textoF" placeholder="Adjuntar archivo" style="width: 40%; margin-left: 25px;" readonly>
												<input type="hidden" id="extension_archivoF" name="imgcorrecta_extension_archivoF">
												<button class="btn btn-lg btn-primary subir" id="incorrectaF">Cargar</button>
												<input type="file" name="imgcorrectaF" id="imgincorrectaF" style="display: none;">
											</div>
										</div>
										<span class="error" id="fileF" style="display: none;"></span>
									</td>
								</tr>
							</tbody>
						</table>
						<div class="alert" id="mensaje" style="display: none;"></div>
						<br />
						<div class="row">
							<!-- <input type="submit" value="GUARDAR" class="btGuardar btGuardarR"> -->
							<div class="col-lg-4 offset-lg-2">
								<button type="submit" id="guardar" class="btn btn-lg btn-primary registro text-center">Guardar pregunta</button>
							</div>

							<div class="col-lg-4">
								<button class="btn btn-lg btn-primary registro text-center" id="cancelar">Cancelar</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
</section>