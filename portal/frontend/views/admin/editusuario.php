<section class="container">
	<section id="contenido">
		<?php echo $this->temp['encabezado']; ?>
		<div class="separador">
			<div class="row">
				<div class="col-lg-7">
					<h1 class="title-section">Actualizar información del usuario</h1>
				</div>

				<div class="col-lg-4 offset-lg-1">
					<br>
					<a href="<?php echo CONTEXT ?>admin/Usuarios"><button class="btn btn-lg registro">Usuarios registrados</button></a>
				</div>
			</div>
		</div>

		<div class="page">
			<div class="row">
				<div class="col-lg-12">
					<form id="formUpUsuario" enctype="multipart/form-data" novalidate="novalidate" autocomplete="off">
						<?php $usuario = $this->temp['info'][0]; ?>
						<!--<pre><?php /*print_r($usuario); */?></pre>-->
						<input type="hidden" id="id" name="id" value="<?php echo $usuario['LGF0010001']; ?>">
						<input type="hidden" id="grupo_id" value="<?php echo $usuario['LGF0010039']; ?>">
						<input type="hidden" name="leccion" id="leccion">
						<table class="FormularioStyle align_left" id="A_t_Neval">
							<tbody>
								<tr>
									<td class="nameCampo">Institución</td>
									<td>
										<select name="institucion" id="institucionUp" class="form-control select">
											<?php if ($_SESSION['perfil'] == 1 || $_SESSION['perfil'] == 3) { ?>
												<option value="">Selecciona una institución</option>
												<?php foreach ($this->temp['instituciones'] as $inst): ?>
													<option value="<?php echo $inst['LGF0270001']; ?>" <?php if($usuario['LGF0010038'] == $inst['LGF0270001']){ echo "selected";} ?>><?php echo $inst['LGF0270002']; ?></option>
												<?php endforeach ?>
											<?php } else if ($_SESSION['perfil'] == 4) { // Institucion ?>
												<option value="<?php echo $_SESSION['idUsuario'] ?>" selected><?php echo $_SESSION['nombre'] ?></option>
											<?php } ?>
										</select>
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Perfil</td>
									<td>
										<select name="perfil" id="perfil" class="form-control select">
											<option value="">Selecciona un perfil</option>
											<?php foreach ($this->temp['perfil'] as $perfil): ?>
												<option value="<?php echo $perfil['LGF0020001']; ?>" <?php if($usuario['LGF0010007'] == $perfil['LGF0020001']){ echo "selected";} ?>><?php echo $perfil['LGF0020002']; ?></option>
											<?php endforeach ?>
										</select>
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Nombre</td>
									<td>
										<input type="text" name="nombre" id="nombre" value="<?php echo $usuario['LGF0010002']; ?>" placeholder="Ingresa el nombre del usuario" style="width: 100%;">
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Apellido paterno</td>
									<td>
										<input type="text" name="aPaterno" id="aPaterno" value="<?php echo $usuario['LGF0010003']; ?>" placeholder="Ingresa el apellido paterno del usuario" style="width: 100%;">
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Apellido materno</td>
									<td>
										<input type="text" name="aMaterno" id="aMaterno" value="<?php echo $usuario['LGF0010004']; ?>" placeholder="Ingresa el apellido materno del usuario" style="width: 100%;">
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Fecha de nacimiento</td>
									<td>
										<input type="date" name="fNacimiento" id="fNacimiento" value="<?php echo $usuario['LGF0010022']; ?>" placeholder="Ingresa la fecha de nacimiento del usuario" style="width: 100%;">
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">CURP</td>
									<td>
										<input type="text" name="curp" id="curp" value="<?php echo $usuario['LGF0010040']; ?>" placeholder="Ingresa el CURP" style="width: 100%;">
										<span class="error" id="matricula"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Género</td>
									<td>
										<input type="radio" name="genero" id="Masculino" value="H" <?php if($usuario['LGF0010021'] == 'H') {echo "checked";} ?>>
										<label for="Masculino">Hombre</label>
										<input type="radio" name="genero" id="Femenino" value="M" <?php if($usuario['LGF0010021'] == 'M') {echo "checked";} ?>>
										<label for="Femenino">Mujer</label>
										<br><span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Grado académico</td>
									<td>
										<select name="nivel" id="nivel" class="form-control select">
											<option value="">Selecciona un grado académico</option>
											<?php foreach ($this->temp['grados'] as $grado): ?>
												<option value="<?php echo $grado['LGF0150001']; ?>" <?php if($usuario['LGF0010024'] == $grado['LGF0150001']){ echo "selected";} ?>><?php echo $grado['LGF0150002']; ?></option>
											<?php endforeach ?>
										</select>
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Grupo</td>
									<td>
										<select name="grupo" id="grupo" class="form-control select">
											<option value="">Selecciona un grupo</option>
										</select>
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Email</td>
									<td>
										<input type="text" name="email" id="email" value="<?php echo $usuario['LGF0010012']; ?>" placeholder="Ingresa el correo del usuario" style="width: 100%;">
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Usuario</td>
									<td>
										<input type="text" name="usuario" id="usuario" value="<?php echo $usuario['LGF0010005']; ?>" placeholder="Ingresa el nick del usuario" style="width: 100%;">
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Contraseña</td>
									<td>
										<input type="text" name="password" id="password" placeholder="Ingresa una contraseña" style="width: 100%;">
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Fecha de registro</td>
									<td>
										<input type="text" value="<?php echo $usuario['LGF0010030']; ?>" placeholder="Fecha de registro" style="width: 100%;" readonly>
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Estatus</td>
									<td>
										<select name="estatus" id="estatus" class="form-control select">
											<option value="">Selecciona una opción</option>
											<option value="1" <?php if($usuario['LGF0010008'] == 1){echo "selected";} ?>>Activo</option>
											<option value="0" <?php if($usuario['LGF0010008'] == 0){echo "selected";} ?>>Inactivo</option>
										</select>
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Fotografía</td>
									<td>
										<input type="file" name="foto" id="foto" placeholder="Ingresa el nombre corto de la institución" style="width: 100%; display: none;">
										<span class="error"></span>
										<?php if (empty($usuario['LGF0010009'])) {
											$ruta = CONTEXT."portal/IMG/default.png";
										} else {
											$img = CONTEXT."portal/IMG/".$usuario['LGF0010009'];
											if (file_exists($img)) {
												$ruta = $img;
											} else {
												$ruta = CONTEXT."portal/IMG/default.png";
											}
										} ?>
										<img src="<?php echo $ruta; ?>" id="imagenPerfil" style="width: 20%;">
									</td>
								</tr>
							</tbody>
						</table>
						<div class="alert" id="mensaje" style="display: none;"></div>
						<br />
						<div class="row">
							<!-- <input type="submit" value="GUARDAR" class="btGuardar btGuardarR"> -->
							<div class="col-lg-4 offset-lg-4">
								<button type="submit" id="updateUsuario" class="btn btn-lg registro text-center">Guardar</button>
							</div>
							<div class="mt-5 col-lg-4 offset-lg-4">
								<button type="button" id="deleteUsuario" id_usuario="<?php echo $usuario['LGF0010001']; ?>" class="btn btn-lg registro text-center" style="background: red !important;">
                                    Eliminar
                                </button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
</section>

<script src="<?php echo CONTEXT ?>portal/frontend/js/admin/usuarios.js"></script>
<script>
    function eliminar(id) {
        var confirma = confirm("¿Est\u00E1s seguro de eliminar este registro?");
        if (confirma) {
            // console.log("Eliminado")
            $.ajax({
                type: 'POST',
                url: context+'admin/deleteUsuario',
                data: {id: id},
                dataType: 'json',
                success: function(resp) {
                    // console.log(resp)
                    if (resp.error) {
                        alert(resp.error);
                    } else {
                        alert(resp.mensaje);
                        window.location.href = context+"admin/manager";
                    }
                }
            });
        } else {
            // console.log("Error")
        }
    }
    $("#deleteUsuario").click(function(){
        eliminar(this.getAttribute('id_usuario'));
    })
</script>