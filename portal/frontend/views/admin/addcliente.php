<section class="container">
	<section id="contenido">
		<?php echo $this->temp['encabezado']; ?>
		<div class="separador">
			<div class="row">
				<div class="col-lg-7">
					<h1 class="title-section">Cliente nuevo</h1>
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
						<table class="FormularioStyle align_left" id="A_t_Neval">
							<tbody>
								<tr>
									<td class="nameCampo">Nombre</td>
									<td>
										<input type="text" name="nombre" id="nombre" placeholder="Ingresa el nombre del cliente" >
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Contacto</td>
									<td>
										<input type="text" name="contacto" id="contacto" placeholder="Ingresa el contacto del cliente" >
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Email</td>
									<td>
										<input type="text" name="email" id="email" placeholder="Ingresa el correo del cliente" >
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Usuario</td>
									<td>
										<input type="text" name="usuario" id="usuario" placeholder="Ingresa el nick del cliente" >
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
									<td class="nameCampo">Teléfono</td>
									<td>
										<input type="text" name="telefono" maxlength="15" id="telefono" placeholder="Ingresa el teléfono del cliente" onkeypress="return aceptNum(event)" >
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Dirección</td>
									<td>
										<input type="text" name="direccion" id="direccion" placeholder="Ingresa la dirección del cliente" >
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
										<input type="text" value="<?php echo date("d-m-Y"); ?>"  readonly>
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
								<button type="submit" class="btn btn-lg registro text-center">Guardar</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
</section>