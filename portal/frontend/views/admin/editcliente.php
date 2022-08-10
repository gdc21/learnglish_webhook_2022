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
					<a href="<?php echo CONTEXT ?>admin/clientes/"><button class="btn btn-lg registro">Clientes registrados</button></a>
				</div>
			</div>
		</div>

		<div class="page">
			<div class="row">
				<div class="col-lg-12">
					<form id="formCliente" enctype="multipart/form-data" novalidate="novalidate" autocomplete="off">
						<?php $cliente = $this->temp['info'][0]; ?>
						<input type="hidden" name="id" value="<?php echo $cliente['LGF0280001']; ?>">
						<table class="FormularioStyle align_left" id="A_t_Neval">
							<tbody>
								<tr>
									<td class="nameCampo">Nombre</td>
									<td>
										<input type="text" name="nombre" id="nombre" value="<?php echo $cliente['LGF0280002']; ?>" placeholder="Ingresa el nombre del cliente" style="width: 100%;">
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Contacto</td>
									<td>
										<input type="text" name="contacto" id="contacto" value="<?php echo $cliente['LGF0280017']; ?>" placeholder="Ingresa el contacto del cliente" style="width: 100%;">
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Email</td>
									<td>
										<input type="text" name="email" id="email" value="<?php echo $cliente['LGF0280018']; ?>" placeholder="Ingresa el correo del cliente" style="width: 100%;">
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Usuario</td>
									<td>
										<input type="text" name="usuario" id="usuario" value="<?php echo $cliente['LGF0280019']; ?>" placeholder="Ingresa el nick del cliente" style="width: 100%;">
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
									<td class="nameCampo">Teléfono</td>
									<td>
										<input type="tel" name="telefono" id="telefono" value="<?php echo $cliente['LGF0280021']; ?>" placeholder="Ingresa el teléfono del cliente" onkeypress="return aceptNum(event)" maxlength="15" style="width: 100%;">
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Dirección</td>
									<td>
										<input type="text" name="direccion" id="direccion" value="<?php echo $cliente['LGF0280003']; ?>" placeholder="Ingresa la dirección del cliente" style="width: 100%;">
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">País</td>
									<td>
										<select name="pais" id="pais" class="form-control select">
											<option value="">Selecciona un país</option>
											<option value="1">México</option>
										</select>
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Fecha de registro</td>
									<td>
										<?php 
											$aux = explode(" ", $cliente['LGF0280011']);
											$fecha = date("d-m-Y", strtotime($aux[0]));
										?>
										<input type="text" value="<?php echo $fecha; ?>" style="width: 100%;" readonly>
										<span class="error"></span>
									</td>
								</tr>
							</tbody>
						</table>
						<div class="alert" id="mensaje" style="display: none;"></div>
						<br />
						<div class="row">
							<!-- <input type="submit" value="GUARDAR" class="btGuardar btGuardarR"> -->
							<div class="col-lg-4 offset-lg-4">
								<button type="submit" class="btn btn-lg registro text-center" id="actualizar">Guardar</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
</section>