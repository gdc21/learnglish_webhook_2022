<section class="container">
	<section id="contenido">
		<?php echo $this->temp['encabezado']; ?>
		<div class="separador">
			<div class="row">
				<div class="col-lg-7">
					<h1 class="title-section">Registrar nuevo usuario</h1>
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
					<form id="formUsuario" enctype="multipart/form-data" novalidate="novalidate" autocomplete="off">
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
													<option value="<?php echo $inst['LGF0270001']; ?>"><?php echo $inst['LGF0270002']; ?></option>
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
												<option value="<?php echo $perfil['LGF0020001']; ?>"><?php echo $perfil['LGF0020002']; ?></option>
											<?php endforeach ?>
										</select>
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Nombre</td>
									<td>
										<input type="text" name="nombre" id="nombre" placeholder="Ingresa el nombre del usuario" >
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Apellido paterno</td>
									<td>
										<input type="text" name="aPaterno" id="aPaterno" placeholder="Ingresa el apellido paterno del usuario" >
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Apellido materno</td>
									<td>
										<input type="text" name="aMaterno" id="aMaterno" placeholder="Ingresa el apellido materno del usuario" >
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Fecha de nacimiento</td>
									<td>
										<input type="date" name="fNacimiento" id="fNacimiento" placeholder="Ingresa la fecha de nacimiento del usuario" >
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">CURP</td>
									<td>
										<input type="text" name="curp" id="curp" placeholder="Ingresa el CURP" >
										<span class="error" id="matricula"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Género</td>
									<td>
										<input type="radio" name="genero" id="Masculino" value="H">
										<label for="Masculino">Hombre</label>
										<input type="radio" name="genero" id="Femenino" value="M">
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
												<option value="<?php echo $grado['LGF0150001']; ?>"><?php echo $grado['LGF0150002']; ?></option>
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
										<input type="text" name="email" id="email" placeholder="Ingresa el correo del usuario" >
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Usuario</td>
									<td>
										<input type="text" name="usuario" id="usuario" placeholder="Ingresa el nick del usuario" >
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Contraseña</td>
									<td>
										<input type="text" name="password" id="password" placeholder="Ingresa una contraseña" >
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Fecha de registro</td>
									<td>
										<input type="text" value="<?php echo date("d-m-Y"); ?>" placeholder="Ingresa el nombre corto de la institución"  readonly>
										<span class="error"></span>
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
									<td class="nameCampo">Fotografía</td>
									<td>
										<input type="file" name="foto" id="foto" placeholder="Ingresa el nombre corto de la institución" style="width: 100%; display: none;">
										<span class="error"></span>
										<img src="<?php echo CONTEXT ?>/portal/IMG/default.png" id="imagenPerfil" alt="" style="width: 20%;">
									</td>
								</tr>
							</tbody>
						</table>
						<div class="alert" id="mensaje" style="display: none;"></div>
						<br />
						<div class="row">
							<!-- <input type="submit" value="GUARDAR" class="btGuardar btGuardarR"> -->
							<div class="col-lg-4 offset-lg-4">
								<button type="submit" id="save" class="btn btn-lg registro text-center">Guardar</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
</section>

<script src="<?php echo CONTEXT ?>portal/frontend/js/admin/usuarios.js"></script>