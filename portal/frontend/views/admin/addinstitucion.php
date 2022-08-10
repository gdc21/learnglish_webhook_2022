<section class="container">
	<section id="contenido">
		<?php echo $this->temp['encabezado']; ?>
		<div class="row">
			<div class="col-lg-6">
				<h1 class="title-section">Nueva Institución</h1>
			</div>

			<div class="col-lg-4 offset-lg-2">
				<br>
				<a href="<?php echo CONTEXT ?>admin/instituciones"><button class="btn btn-lg registro">Instituciones registradas</button></a>
			</div>
		</div>
		
		<div class="page">
			<div class="row">
				<div class="col-lg-12">
					<form id="nuevaInstitucion" enctype="multipart/form-data" novalidate="novalidate" autocomplete="off">
						<table class="FormularioStyle align_left" id="A_t_Neval">
							<tbody>
								<tr>
									<td class="nameCampo">Nombre</td>
									<td>
										<input type="text" name="nombre" id="nombre" placeholder="Ingresa el nombre de la institución" >
										<span class="error"></span>
									</td>
								</tr>
                                <tr>
                                    <td class="nameCampo">CCT</td>
                                    <td>
                                        <input type="text" name="cct" id="cct" placeholder="Ingresa el CCT de la institución" >
                                        <span class="error"></span>
                                    </td>
                                </tr>
								<tr>
									<td class="nameCampo">Logotipo</td>
									<td>
										<input type="file" name="logotipo" id="logotipo">
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Nombre corto</td>
									<td>
										<input type="text" name="nameCorto" id="nameCorto" placeholder="Ingresa el nombre corto de la institución" >
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">País</td>
									<td>
										<select name="pais" id="pais" class="form-control">
											<option value="">Selecciona un país</option>
											<option value="1">México</option>
										</select>
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Cliente</td>
									<td>
										<select name="cliente" id="cliente" class="form-control">
											<option value="">Selecciona un cliente</option>
											<?php if (!empty($this->temp['clientes'])) {
												if ($_SESSION['perfil'] == 3) { // Cliente
													$selected = "selected";
												}
												foreach ($this->temp['clientes'] as $cliente) { ?>
													<option value="<?php echo $cliente['LGF0280001'] ?>" <?php echo $selected; ?>><?php echo $cliente['LGF0280002']; ?></option>
												<?php }
											} ?>
										</select>
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Configuración de módulos</td>
									<td>
										<div class="row">
											<?php foreach ($this->temp['modulos'] as $modulo): ?>
												<div class="col-lg-6" style="text-align: left;">
													<input type="checkbox" name="tipo[]" id="modulo<?php echo $modulo['LGF0150001']?>" value="<?php echo $modulo['LGF0150001'] ?>" checked="checked">
													<label for="modulo<?php echo $modulo['LGF0150001']?>"><?php echo $modulo['LGF0150002']; ?></label>
												</div>
											<?php endforeach ?>
										</div>
									</td>
								</tr>
								<tr style="display: none;">
									<td class="nameCampo">Configuración de grupos</td>
									<td>
										<span class="form-text text-muted">En caso de ser necesario, los grupos de usuarios los puede configurar el administrador de cada institución</span>
										<br>
										<input type="checkbox" name="admin" id="admin" value="1">
										<label for="admin">Habilitar configuración grupos para el administrador de esta institución</label>
										<br>
										<label>Grupos creados</label>
										<span id="gruposCreados"></span>
										<br>
										<label for="">Nuevo grupo: </label>
										<input type="text" id="nuevoGrupo">&nbsp;
										<button type="button" id="newgrupo" class="btn btn-lg registro1">Agregar grupo</button>
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Periodo de vigencia</td>
									<td>
										<input type="date" name="vigencia" id="vigencia" placeholder="Ingresa el periodo de vigencia" >
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">IP o URL referido</td>
									<td>
										<input type="text" name="ip" id="ip" placeholder="Ingresa una IP" >
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Lote de licencias</td>
									<td>
										<input type="text" name="lote" id="lote" placeholder="Ingresa el lote de licencias" onkeypress="return aceptNum(event)" >
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Usuario</td>
									<td>
										<input type="text" name="usuario" id="usuario" placeholder="Ingresa el nick de la institución" >
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
										<input type="text" name="fecha" id="fecha" value="<?php echo date("d-m-Y"); ?>" readonly style="border: none;">
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

<script src="<?php echo CONTEXT ?>portal/frontend/js/institucion.js"></script>