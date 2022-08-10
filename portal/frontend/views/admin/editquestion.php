<section class="container">
	<?php 
		$datos = $this->temp['pregunta'];
		$respuestas = $this->temp['respuestas'];
	?>
	<section id="contenido">
		<?php echo $this->temp['encabezado']; ?>
		<div class="separador">
			<div class="row">
				<div class="col-lg-7 col-md-12 col-sm-12">
					<h1 class="title-section">Configuración de la pregunta</h1>
				</div>

				<div class="col-lg-4 col-md-12 col-sm-12 offset-lg-1">
					<br>
					<a href="<?php echo CONTEXT ?>admin/mostrarPreguntas/<?php echo $datos['id_evaluacion']; ?>"><button class="btn btn-lg btn-primary registro">Preguntas Registradas</button></a>
				</div>
			</div>
		</div>
		
		<div class="page">
			<div class="row">
				<div class="col-lg-12">
					<form id="formPregunta" enctype="multipart/form-data" novalidate="novalidate" autocomplete="off">
						<input type="hidden" name="id" value="<?php echo $datos['id_pregunta']; ?>">
						<input type="hidden" id="imgDefault" value="<?php echo IMG ?>preview.png">
						<table class="FormularioStyle align_left" id="A_t_Neval">
							<tbody>
								<tr>
									<td class="nameCampo">Evaluación</td>
									<td>
										<label><?php echo $datos['evaluacion']; ?></label>
									</td>
								</tr>
								<tr>
									<td class="nameCampo color1">Texto de la pregunta</td>
									<td>
										<textarea name="texto" id="texto" cols="100" rows="5" style="resize: none; border: none;" placeholder="Ingresa el texto de la pregunta"><?php echo $datos['texto']; ?></textarea>
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo color1">Imagen de la pregunta</td>
									<td>
										<div class="row">
											<div class="col-lg-4">
												<?php if (strpos($datos['imagen'], 'data:image/png') !== false || strpos($datos['imagen'], 'data:image/jpeg') !== false) { ?>
													<img src="<?php echo $datos['imagen']; ?>" id="preview1" style="width: 200px; border: none; margin-left: 30px;" class="img-thumbnail">
												<?php } else if (strpos($datos['imagen'], 'data:audio/mp3') !== false) { ?>
													<audio src="<?php echo $datos['imagen']; ?>" id="audio1" controls ></audio>
												<?php } else if (strpos($datos['imagen'], 'data:video/mp4') !== false) { ?>
													<video src="<?php echo $datos['imagen']; ?>" width="320" height="240" controls id="video1" style="display: none;"></video>
												<?php } else {
													$extension = explode(".", $datos['imagen']);
													if ($extension[1] == "png" || $extension[1] == "jpg") { ?>
														<img src="<?php echo ARCHIVO_FISICO.$datos['imagen']; ?>" id="preview1" style="width: 200px; border: none; margin-left: 30px;" class="img-thumbnail">
													<?php } else if ($extension[1] == "mp3") { ?>
														<audio src="<?php echo ARCHIVO_FISICO.$datos['imagen']; ?>" id="audio1" controls controlsList="nodownload" ></audio>
													<?php } else { ?>
														<video src="<?php echo ARCHIVO_FISICO.$datos['imagen']; ?>" width="320" height="240" controls controlsList="nodownload" id="video1" style="display: none;"></video>
													<?php }
												} ?>
												
												<img src="" id="preview_carga1" style="width: 200px; border: none; margin-left: 30px; display: none;" class="img-thumbnail">
												<audio src="" controls id="preview_audio1" style="display: none;"></audio>
												<video  src="" width="320" height="240" controls id="preview_video1" style="display: none;"></video>
											</div>
											<div class="col-lg-4">
												<br><br>
												<button class="btn btn-lg btn-primary subir" data-num="1" id="imgPrincipal" style="margin-left: 60px !important;">Cargar imagen</button>
												<input type="file" name="imagen1" id="imagen1" style="display: none;">
											</div>
										</div>
										<span class="error" id="filePrincipal"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo color1">Categoría de evaluación</td>
									<td>
										<select name="categoria" id="categoria" class="form-control select">
											<option value="">Selecciona un categoría</option>
											<?php foreach ($this->temp['categorias'] as $categoria): ?>
												<option value="<?php echo $categoria['clave']; ?>" <?php if($datos['categoria']==$categoria['clave']){echo "selected";} ?>><?php echo $categoria['nombre']; ?></option>
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
											<option value="1" <?php if($datos['tipo_pregunta']==1){echo "selected";} ?>>Opción multiple</option>
											<option value="2" <?php if($datos['tipo_pregunta']==2){echo "selected";} ?>>Verdadero o Falso</option>
										</select>
										<span class="error"></span>
									</td>
								</tr>
								<tr class="optionmultiple" style="display: none;">
									<td class="nameCampo color2">Pregunta correcta</td>
									<td>
										<div class="row">
											<div class="col-lg-6">
												<img alt="" src="<?php echo IMG ?>admin/opcion_correcta.png">
												<input type="hidden" name="respuesta_id2" value="<?php echo $respuestas[0]['id_respuesta']; ?>">
												<input type="text" name="respuesta2" id="respuesta2" value="<?php echo $respuestas[0]['texto_respuesta']; ?>" placeholder="Ingresa la respuesta correcta" style="width: 80%; margin-left: 25px;">

												<br><br><span style="font-size: 30px;"><i class="fa fa-upload" aria-hidden="true"></i></span>
												<input type="text" id="img_texto2" placeholder="Adjuntar archivo" style="width: 40%; margin-left: 25px; margin-top: 30px;">
												<input type="hidden" id="texto_default2">
												<button class="btn btn-lg btn-primary subir" data-num="2" id="incorrectaF">Cargar</button>
												<br><br><span class="error" id="error2"></span>
												<input type="file" name="imagen2" id="imagen2" style="display: none;">
											</div>

											<div class="col-lg-6" style="margin-top: 20px;">
												<!-- <img src="<?php echo $respuestas[0]['imagen_respuesta']; ?>" class="img-thumbnail" id="preview2" style="width: 25%;"> -->
												<?php if (strpos($respuestas[0]['imagen_respuesta'], 'data:image') !== false) { ?>
													<img src="<?php echo $respuestas[0]['imagen_respuesta']; ?>" id="preview2" style="width: 25%; border: none;" class="img-thumbnail">
												<?php } else if (strpos($respuestas[0]['imagen_respuesta'], 'data:audio') !== false) { ?>
													<audio src="<?php echo $respuestas[0]['imagen_respuesta']; ?>" id="audio2" controls></audio>
												<?php } else if (strpos($respuestas[0]['imagen_respuesta'], 'data:video') !== false) { ?>
													<video src="<?php echo $respuestas[0]['imagen_respuesta']; ?>" width="320" height="240" controls id="video2" style="display: none;"></video>
												<?php } else {
													$extension = explode(".", $respuestas[0]['imagen_respuesta']);
													if ($extension[1] == "png" || $extension[1] == "jpg") { ?>
														<img src="<?php echo ARCHIVO_FISICO.$respuestas[0]['imagen_respuesta']; ?>" id="preview2" style="width: 200px; border: none; margin-left: 30px;" class="img-thumbnail">
													<?php } else if ($extension[1] == "mp3") { ?>
														<audio src="<?php echo ARCHIVO_FISICO.$respuestas[0]['imagen_respuesta']; ?>" id="audio2" controls controlsList="nodownload" ></audio>
													<?php } else { ?>
														<video src="<?php echo ARCHIVO_FISICO.$respuestas[0]['imagen_respuesta']; ?>" width="320" height="240" controls controlsList="nodownload" id="video2" style="display: none;"></video>
													<?php }
												} ?>
												<img src="" class="img-thumbnail" id="preview_carga2" style="width: 25%;" style="display: none;">
												<audio id="preview_audio2" src="" controls style="display: none;"></audio>
											</div>
										</div>
									</td>
								</tr>
								<tr class="optionmultiple" style="display: none;">
									<td class="nameCampo color3">Opciones incorrectas</td>
									<td>
										<div class="row">
											<div class="col-lg-6">
												<img alt="" src="<?php echo IMG ?>admin/opcion_incorrecta.png">
												<input type="hidden" name="respuesta_id3" value="<?php echo $respuestas[1]['id_respuesta']; ?>">
												<input type="text" name="respuesta3" id="respuesta3" value="<?php echo $respuestas[1]['texto_respuesta']; ?>" placeholder="Ingresa la respuesta correcta" style="width: 80%; margin-left: 25px;">

												<br><br><span style="font-size: 30px;"><i class="fa fa-upload" aria-hidden="true"></i></span>
												<input type="text" id="img_texto3" placeholder="Adjuntar archivo" style="width: 40%; margin-left: 25px; margin-top: 30px;">
												<input type="hidden" id="texto_default3">
												<button class="btn btn-lg btn-primary subir" data-num="3" id="incorrectaF">Cargar</button>
												<input type="file" name="imagen3" id="imagen3" style="display: none;">
												<br><br><span class="error" id="error3"></span>
											</div>

											<div class="col-lg-6" style="margin-top: 20px;">
												<?php if (strpos($respuestas[1]['imagen_respuesta'], 'data:image/png') !== false || strpos($respuestas[1]['imagen_respuesta'], 'data:image/jpeg') !== false) { ?>
													<img src="<?php echo $respuestas[1]['imagen_respuesta']; ?>" id="preview3" style="width: 25%; border: none;" class="img-thumbnail">
												<?php } else if (strpos($respuestas[1]['imagen_respuesta'], 'data:audio/mp3') !== false || strpos($respuestas[1]['imagen_respuesta'], 'data:audio/mpeg') !== false) { ?>
													<audio src="<?php echo $respuestas[1]['imagen_respuesta']; ?>" id="audio3" controls></audio>
												<?php } else if (strpos($respuestas[1]['imagen_respuesta'], 'data:video/mp4') !== false) { ?>
													<video src="<?php echo $respuestas[1]['imagen_respuesta']; ?>" width="320" height="240" controls id="video3" style="display: none;"></video>
												<?php } else {
													$extension = explode(".", $respuestas[1]['imagen_respuesta']);
													if ($extension[1] == "png" || $extension[1] == "jpg") { ?>
														<img src="<?php echo ARCHIVO_FISICO.$respuestas[1]['imagen_respuesta']; ?>" id="preview3" style="width: 200px; border: none; margin-left: 30px;" class="img-thumbnail">
													<?php } else if ($extension[1] == "mp3") { ?>
														<audio src="<?php echo ARCHIVO_FISICO.$respuestas[1]['imagen_respuesta']; ?>" id="audio3" controls controlsList="nodownload" ></audio>
													<?php } else { ?>
														<video src="<?php echo ARCHIVO_FISICO.$respuestas[1]['imagen_respuesta']; ?>" width="320" height="240" controls controlsList="nodownload" id="video3" style="display: none;"></video>
													<?php }
												} ?>
												<img src="" class="img-thumbnail" id="preview_carga3" style="width: 25%;" style="display: none;">
												<audio id="preview_audio3" src="" controls style="display: none;"></audio>
											</div>
										</div>

										<div class="row">
											<div class="col-lg-6">
												<img alt="" src="<?php echo IMG ?>admin/opcion_incorrecta.png">
												<input type="hidden" name="respuesta_id4" value="<?php echo $respuestas[2]['id_respuesta']; ?>">
												<input type="text" name="respuesta4" id="respuesta4" value="<?php echo $respuestas[2]['texto_respuesta']; ?>" placeholder="Ingresa la respuesta correcta" style="width: 80%; margin-left: 25px;">

												<br><br><span style="font-size: 30px;"><i class="fa fa-upload" aria-hidden="true"></i></span>
												<input type="text" id="img_texto4" placeholder="Adjuntar archivo" style="width: 40%; margin-left: 25px; margin-top: 30px;">
												<input type="hidden" id="texto_default4">
												<button class="btn btn-lg btn-primary subir" data-num="4" id="incorrectaF">Cargar</button>
												<input type="file" name="imagen4" id="imagen4" style="display: none;">
												<br><br><span class="error" id="error4"></span>
											</div>

											<div class="col-lg-6" style="margin-top: 20px;">
												<!-- <img src="<?php echo $respuestas[2]['imagen_respuesta']; ?>" class="img-thumbnail" id="preview4" style="width: 25%;"> -->
												<?php if (strpos($respuestas[2]['imagen_respuesta'], 'data:image') !== false) { ?>
													<img src="<?php echo $respuestas[2]['imagen_respuesta']; ?>" id="preview4" style="width: 25%; border: none;" class="img-thumbnail">
												<?php } else if (strpos($respuestas[2]['imagen_respuesta'], 'data:audio') !== false) { ?>
													<audio src="<?php echo $respuestas[2]['imagen_respuesta']; ?>" id="audio4" controls></audio>
												<?php } else if (strpos($respuestas[2]['imagen_respuesta'], 'data:video') !== false) { ?>
													<video src="<?php echo $respuestas[2]['imagen_respuesta']; ?>" width="320" height="240" controls id="video4" style="display: none;"></video>
												<?php } else {
													$extension = explode(".", $respuestas[2]['imagen_respuesta']);
													if ($extension[1] == "png" || $extension[1] == "jpg") { ?>
														<img src="<?php echo ARCHIVO_FISICO.$respuestas[2]['imagen_respuesta']; ?>" id="preview4" style="width: 200px; border: none; margin-left: 30px;" class="img-thumbnail">
													<?php } else if ($extension[1] == "mp3") { ?>
														<audio src="<?php echo ARCHIVO_FISICO.$respuestas[2]['imagen_respuesta']; ?>" id="audio4" controls controlsList="nodownload" ></audio>
													<?php } else { ?>
														<video src="<?php echo ARCHIVO_FISICO.$respuestas[2]['imagen_respuesta']; ?>" width="320" height="240" controls controlsList="nodownload" id="video4" style="display: none;"></video>
													<?php }
												} ?>
												<img src="" class="img-thumbnail" id="preview_carga4" style="width: 25%;" style="display: none;">
												<audio id="preview_audio4" src="" controls style="display: none;"></audio>
											</div>
										</div>

										<div class="row">
											<div class="col-lg-6">
												<img alt="" src="<?php echo IMG ?>admin/opcion_incorrecta.png">
												<input type="hidden" name="respuesta_id5" value="<?php echo $respuestas[3]['id_respuesta']; ?>">
												<input type="text" name="respuesta5" id="respuesta5" value="<?php echo $respuestas[3]['texto_respuesta']; ?>" placeholder="Ingresa la respuesta correcta" style="width: 80%; margin-left: 25px;">

												<br><br><span style="font-size: 30px;"><i class="fa fa-upload" aria-hidden="true"></i></span>
												<input type="text" id="img_texto5" placeholder="Adjuntar archivo" style="width: 40%; margin-left: 25px; margin-top: 30px;">
												<input type="hidden" id="texto_default5">
												<button class="btn btn-lg btn-primary subir" data-num="5" id="incorrectaF">Cargar</button>
												<input type="file" name="imagen5" id="imagen5" style="display: none;">
												<br><br><span class="error" id="error5"></span>
											</div>

											<div class="col-lg-6" style="margin-top: 20px;">
												<!-- <img src="<?php echo $respuestas[3]['imagen_respuesta']; ?>" class="img-thumbnail" id="preview5" style="width: 25%;"> -->
												<?php if (strpos($respuestas[3]['imagen_respuesta'], 'data:image') !== false) { ?>
													<img src="<?php echo $respuestas[3]['imagen_respuesta']; ?>" id="preview3" style="width: 25%; border: none;" class="img-thumbnail">
												<?php } else if (strpos($respuestas[3]['imagen_respuesta'], 'data:audio') !== false) { ?>
													<audio src="<?php echo $respuestas[3]['imagen_respuesta']; ?>" id="audio3" controls></audio>
												<?php } else if (strpos($respuestas[3]['imagen_respuesta'], 'data:video') !== false) { ?>
													<video src="<?php echo $respuestas[3]['imagen_respuesta']; ?>" width="320" height="240" controls id="video3" style="display: none;"></video>
												<?php } else {
													$extension = explode(".", $respuestas[3]['imagen_respuesta']);
													if ($extension[1] == "png" || $extension[1] == "jpg") { ?>
														<img src="<?php echo ARCHIVO_FISICO.$respuestas[3]['imagen_respuesta']; ?>" id="preview3" style="width: 200px; border: none; margin-left: 30px;" class="img-thumbnail">
													<?php } else if ($extension[1] == "mp3") { ?>
														<audio src="<?php echo ARCHIVO_FISICO.$respuestas[3]['imagen_respuesta']; ?>" id="audio3" controls controlsList="nodownload" ></audio>
													<?php } else { ?>
														<video src="<?php echo ARCHIVO_FISICO.$respuestas[3]['imagen_respuesta']; ?>" width="320" height="240" controls controlsList="nodownload" id="video3" style="display: none;"></video>
													<?php }
												} ?>
												<img src="" class="img-thumbnail" id="preview_carga5" style="width: 25%;" style="display: none;">
												<audio id="preview_audio5" src="" controls style="display: none;"></audio>
											</div>
										</div>
									</td>
								</tr>
								<tr class="vf" style="display: none;">
									<td class="nameCampo color2">Pregunta correcta</td>
									<td>
										<div class="row">
											<div class="col-lg-6">
												<img alt="" src="<?php echo IMG ?>admin/opcion_correcta.png">
												<input type="hidden" name="respuesta_id6" value="<?php echo $respuestas[0]['id_respuesta']; ?>">
												<input type="text" name="respuesta6" id="respuesta6" value="<?php echo $respuestas[0]['texto_respuesta']; ?>" placeholder="Ingresa la respuesta correcta" style="width: 80%; margin-left: 25px;">

												<br><br><span style="font-size: 30px;"><i class="fa fa-upload" aria-hidden="true"></i></span>
												<input type="text" id="img_texto6" placeholder="Adjuntar archivo" style="width: 40%; margin-left: 25px; margin-top: 30px;">
												<input type="hidden" id="texto_default6">
												<button class="btn btn-lg btn-primary subir" data-num="6" id="incorrectaF">Cargar</button>
												<input type="file" name="imagen6" id="imagen6" style="display: none;">
												<br><br><span class="error" id="error6"></span>
											</div>

											<div class="col-lg-6" style="margin-top: 20px;">
												<!-- <img src="<?php echo $respuestas[0]['imagen_respuesta']; ?>" class="img-thumbnail" id="preview6" style="width: 25%;"> -->
												<?php if (strpos($respuestas[0]['imagen_respuesta'], 'data:image') !== false) { ?>
													<img src="<?php echo $respuestas[0]['imagen_respuesta']; ?>" id="preview6" style="width: 25%; border: none;" class="img-thumbnail">
												<?php } else if (strpos($respuestas[0]['imagen_respuesta'], 'data:audio') !== false) { ?>
													<audio src="<?php echo $respuestas[0]['imagen_respuesta']; ?>" id="audio6" controls></audio>
												<?php } else if (strpos($respuestas[0]['imagen_respuesta'], 'data:video') !== false) { ?>
													<video src="<?php echo $respuestas[0]['imagen_respuesta']; ?>" width="320" height="240" controls id="video6" style="display: none;"></video>
												<?php } else {
													$extension = explode(".", $respuestas[0]['imagen_respuesta']);
													if ($extension[1] == "png" || $extension[1] == "jpg") { ?>
														<img src="<?php echo ARCHIVO_FISICO.$respuestas[0]['imagen_respuesta']; ?>" id="preview6" style="width: 200px; border: none; margin-left: 30px;" class="img-thumbnail">
													<?php } else if ($extension[1] == "mp3") { ?>
														<audio src="<?php echo ARCHIVO_FISICO.$respuestas[0]['imagen_respuesta']; ?>" id="audio6" controls controlsList="nodownload" ></audio>
													<?php } else { ?>
														<video src="<?php echo ARCHIVO_FISICO.$respuestas[0]['imagen_respuesta']; ?>" width="320" height="240" controls controlsList="nodownload" id="video6" style="display: none;"></video>
													<?php }
												} ?>
												<img src="" class="img-thumbnail" id="preview_carga6" style="width: 25%;" style="display: none;">
												<audio id="preview_audio6" src="" controls style="display: none;"></audio>
											</div>
										</div>
									</td>
								</tr>
								<tr class="vf" style="display: none;">
									<td class="nameCampo color3">Opciones incorrectas</td>
									<td>
										<div class="row">
											<div class="col-lg-6">
												<img alt="" src="<?php echo IMG ?>admin/opcion_incorrecta.png">
												<input type="hidden" name="respuesta_id7" value="<?php echo $respuestas[1]['id_respuesta']; ?>">
												<input type="text" name="respuesta7" id="respuesta7" value="<?php echo $respuestas[1]['texto_respuesta']; ?>" placeholder="Ingresa una respuesta incorrecta" style="width: 80%; margin-left: 25px;">

												<br><br><span style="font-size: 30px;"><i class="fa fa-upload" aria-hidden="true"></i></span>
												<input type="text" id="img_texto7" placeholder="Adjuntar archivo" style="width: 40%; margin-left: 25px; margin-top: 30px;">
												<input type="hidden" id="texto_default7">
												<button class="btn btn-lg btn-primary subir" data-num="7" id="incorrectaF">Cargar</button>
												<input type="file" name="imagen7" id="imagen7" style="display: none;">
												<br><br><span class="error" id="error7"></span>
											</div>

											<div class="col-lg-6" style="margin-top: 20px;">
												<!-- <img src="<?php echo $respuestas[1]['imagen_respuesta']; ?>" class="img-thumbnail" id="preview7" style="width: 25%;"> -->
												<?php if (strpos($respuestas[1]['imagen_respuesta'], 'data:image') !== false) { ?>
													<img src="<?php echo $respuestas[1]['imagen_respuesta']; ?>" id="preview7" style="width: 25%; border: none;" class="img-thumbnail">
												<?php } else if (strpos($respuestas[1]['imagen_respuesta'], 'data:audio') !== false) { ?>
													<audio src="<?php echo $respuestas[1]['imagen_respuesta']; ?>" id="audio7" controls></audio>
												<?php } else if (strpos($respuestas[1]['imagen_respuesta'], 'data:video') !== false) { ?>
													<video src="<?php echo $respuestas[1]['imagen_respuesta']; ?>" width="320" height="240" controls id="video7" style="display: none;"></video>
												<?php } else {
													$extension = explode(".", $respuestas[1]['imagen_respuesta']);
													if ($extension[1] == "png" || $extension[1] == "jpg") { ?>
														<img src="<?php echo ARCHIVO_FISICO.$respuestas[1]['imagen_respuesta']; ?>" id="preview7" style="width: 200px; border: none; margin-left: 30px;" class="img-thumbnail">
													<?php } else if ($extension[1] == "mp3") { ?>
														<audio src="<?php echo ARCHIVO_FISICO.$respuestas[1]['imagen_respuesta']; ?>" id="audio7" controls controlsList="nodownload" ></audio>
													<?php } else { ?>
														<video src="<?php echo ARCHIVO_FISICO.$respuestas[1]['imagen_respuesta']; ?>" width="320" height="240" controls controlsList="nodownload" id="video7" style="display: none;"></video>
													<?php }
												} ?>
												<img src="" class="img-thumbnail" id="preview_carga7" style="width: 25%;" style="display: none;">
												<audio id="preview_audio7" src="" controls style="display: none;"></audio>
											</div>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
						<div class="alert" id="mensaje" style="display: none;"></div>
						<br />
						<div class="row">
							<!-- <input type="submit" value="GUARDAR" class="btGuardar btGuardarR"> -->
							<div class="col-lg-4 offset-lg-2">
								<button type="submit" class="btn btn-lg btn-primary registro text-center" id="guardar">Guardar pregunta</button>
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