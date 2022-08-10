<section class="container">
	<section id="contenido">
		<?php echo $this->temp['encabezado']; ?>
		<div class="row">
			<div class="col-lg-6">
				<h1 class="title-section">Actualizar información</h1>
			</div>

			<div class="col-lg-4 offset-lg-2">
				<br>
				<a href="<?php echo CONTEXT ?>admin/instituciones"><button class="btn btn-lg registro">Instituciones registradas</button></a>
			</div>
		</div>
		
		<div class="page">
			<div class="row">
				<div class="col-lg-12">
					<form id="upInstitucion" enctype="multipart/form-data" novalidate="novalidate" autocomplete="off">
						<input type="hidden" name="id" id="idinstitucion" value="<?php echo $this->temp['info'][0]['LGF0270001'] ?>">
						<!-- <pre><?php print_r($this->temp['info'][0]['modulos']); ?></pre> -->
						<table class="FormularioStyle align_left" id="A_t_Neval">
							<tbody>
								<tr>
									<td class="nameCampo">Nombre</td>
									<td>
										<input type="text" name="nombre" id="nombre" placeholder="Nombre de la institución" value="<?php echo $this->temp['info'][0]['LGF0270002'] ?>" >
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
										<input type="text" name="nameCorto" id="nameCorto" placeholder="Nombre corto de la institución" value="<?php echo $this->temp['info'][0]['LGF0270022'] ?>" >
										<span class="error"></span>
									</td>
								</tr>

                                <tr>
                                    <td class="nameCampo">CCT</td>
                                    <td>
                                        <input type="text" name="cct" id="cct" placeholder="CCT de la institución" value="<?php echo $this->temp['info'][0]['LGF0270028'] ?>" >
                                        <span class="error"></span>
                                    </td>
                                </tr>

								<tr> <!-- Pendiente -->
									<td class="nameCampo">País</td>
									<td>
										<select name="pais" id="pais" class="form-control">
											<option value="">Selecciona un país</option>
											<option value="1">México</option>
										</select>
										<span class="error"></span>
									</td>
								</tr>
								<tr> <!-- Pendiente -->
									<td class="nameCampo">Cliente</td>
									<td>
										<select name="cliente" id="cliente" class="form-control">
											<option value="">Selecciona un cliente</option>
											<?php if (!empty($this->temp['clientes'])) {
												foreach ($this->temp['clientes'] as $cliente) { ?>
													<option value="<?php echo $cliente['LGF0280001'] ?>" <?php if($this->temp['info'][0]['LGF0270021'] == $cliente['LGF0280001']){echo "selected";} ?>><?php echo $cliente['LGF0280002']; ?></option>
												<?php }
											} ?>
										</select>
										<span class="error"></span>
									</td>
								</tr>
								<tr> <!-- Pendiente -->
									<td class="nameCampo">Configuración de módulos</td>
									<td>
										<div class="row">
											<?php 
												$aux = explode(",", $this->temp['info'][0]['modulos']);
												$aux1 = explode(",", $this->temp['info'][0]['idmodulo']);
												foreach ($this->temp['modulos'] as $modulo){
													$checked = "";
													$ids = "";
													for ($i=0; $i < count($aux); $i++) { 
														if ($aux[$i] == $modulo['LGF0150001']) {
															// echo $aux[$i]." == ".$modulo['LGF0150001']."<br>";
															$checked = "checked";
															$ids = $aux1[$i];
														}
													} ?>
													<div class="col-lg-6" style="text-align: left;">
														<input type="checkbox" name="tipo[]" class="modulo<?php echo $modulo['LGF0150001']?>" id="modulo<?php echo $modulo['LGF0150001']?>" value="<?php echo $modulo['LGF0150001'] ?>" <?php echo $checked; ?> onclick="modulos(<?php echo $modulo['LGF0150001']?>, <?php echo $ids; ?>)">
														<label for="modulo<?php echo $modulo['LGF0150001']?>"><?php echo $modulo['LGF0150002']; ?></label>
													</div>
												<?php }
											?>
										</div>
									</td>
								</tr>
								<tr style="display: none;"> <!-- Pendiente -->
									<td class="nameCampo">Configuración de grupos</td>
									<td>
										<span class="form-text text-muted">En caso de ser necesario, los grupos de usuarios los puede configurar el administrador de cada institución</span>
										<br>
										<input type="checkbox" name="admin" id="admin" value="1">
										<label for="admin">Habilitar cnfiguración grupos para el administrador de esta institución</label>
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
										<?php 
											$aux = explode(" ", $this->temp['info'][0]['LGF0270005']);
											$vigencia = date('Y-m-d', strtotime($aux[0]));
										?>
										<input type="date" name="vigencia" id="vigencia" placeholder="Periodo de vigencia" value="<?php echo $vigencia; ?>" >
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">IP o URL referido</td>
									<td>
										<input type="text" name="ip" id="ip" placeholder="IP o URL" value="<?php echo $this->temp['info'][0]['LGF0270020'] ?>"  onkeypress="return aceptNum(event)">
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Lote de licencias</td>
									<td>
										<?php if ($_SESSION['perfil'] == 3 || $_SESSION['perfil'] == 4) {
											$atributo = "readonly";
										} ?>
										<input type="text" name="lote" id="lote" placeholder="Lote de licencias" value="<?php echo $this->temp['info'][0]['LGF0270019'] ?>"  <?php echo $atributo; ?>>
										<span class="error"></span>
									</td>
								</tr>
								<tr>
									<td class="nameCampo">Usuario</td>
									<td>
										<input type="text" name="usuario" id="usuario" placeholder="Ingresa el nick de la institución" value="<?php echo $this->temp['info'][0]['LGF0270024'] ?>" >
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
										<?php 
											$aux1 = explode(" ", $this->temp['info'][0]['LGF0270013']);
											$fecha_registro = date('d-m-Y', strtotime($aux1[0]));
										?>
										<input type="text" value="<?php echo $fecha_registro; ?>" readonly style="border: none;">
									</td>
								</tr>
							</tbody>
						</table>
						<div class="alert" id="mensaje" style="display: none;"></div>
						<br/>
						<div class="row">
							<!-- <input type="submit" value="GUARDAR" class="btGuardar btGuardarR"> -->
							<div class="col-lg-4 offset-lg-4">
								<button type="submit" id="actualizar" class="btn btn-lg registro text-center">Guardar</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
</section>

<script src="<?php echo CONTEXT ?>portal/frontend/js/institucion.js"></script>