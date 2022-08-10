<div class="h2-wrap">
	<div class="container">
		<div class="row">
			<div class="col-md-30">
				<table width="100%" border="0" cellspacing="10" cellpadding="0">
					<tr>
						<td width="65%"><span class="standard-block">Admin / Agregar
								usuario</span></td>
						<td width="65%" align="right"><a
							href="<?= CONTEXT ?>administrador/administradores" class="hero-btn">
								Administradores registrados</a></td>
					</tr>
				</table>

			</div>
		</div>
	</div>
</div>
<div class="text-inter">
	<div class="container">
		<div class="row">
			<h2 align="center">
				<img src="<?= IMG ?>administradores.png" width="50" height="42"
					align="absmiddle"> Agregar usuario
			</h2>


			<form enctype="multipart/form-data" id="form_nva_administrado" name="form_nva_administrado">

				<table width="70%" border="0" align="center" cellpadding="0"
					cellspacing="2">
					<tr>
						<td width="16%" align="left" valign="top" bgcolor="#63c6ae"><strong>Nombre</strong></td>
						<td width="84%" align="left" bgcolor="#CCECE4"><input
							name="nombre" id="nombre" placeholder="nombre" type="text" class="form-control input-lg" class="form-control input-lg"
							value="" size="30"><span class="error"></span></td>
					</tr>
					<tr>
						<td width="16%" align="left" valign="top" bgcolor="#63c6ae"><strong>Usuario</strong></td>
						<td width="84%" align="left" bgcolor="#CCECE4"><input
							name="usuario" id="usuario" placeholder="Usuario" type="text" class="form-control input-lg" class="form-control input-lg"
							value="" size="30"><span class="error"></span></td>
					</tr>

				
					<tr>
						<td width="16%" align="left" valign="top" bgcolor="#63c6ae"><strong>contraseña</strong></td>
						<td width="84%" align="left" bgcolor="#CCECE4"><input
							type="password" class="form-control input-lg" id="password" name="password" placeholder="*****"
							value="" size="30"><span class="error"></span></td>
					</tr>
					
					<td align="left" valign="top" bgcolor="#63c6ae"><strong>Permisos</strong></td>
						<td bgcolor="#CCECE4">


						        
<ul class="list-group">
<?php foreach ( $this->temp ["permisos"] as $contenido ) { ?>	

								<li class="list-group-item">
									<div class="material-switch pull-right">

										<input name="permisos[]" type="checkbox"
											value="<?= $contenido['id'];?>" id="<?= $contenido['id'];?>"
											
											/>

										<label for="<?= $contenido['id'];?>" name="permisos" ><?= $contenido['nombre'];?></label>
									</div>
									
								</li>
					<br />
<?php } ?>
</ul>



					
						</td>
					</tr>
					<tr>
						<td align="left" valign="top" bgcolor="#63c6ae"><strong>Activar</strong></td>
						<td bgcolor="#CCECE4">

							<ul class="list-group">
							<li class="list-group-item">

								<div class="material-switch pull-right">

									<input id="estatus" name="estatus" type="checkbox"
										 /> <label for="estatus" name="label" class="label"> Desactivado
										</label>
								</div>
							</li>
						</ul>

						</td>
					</tr>
					<tr>
						<td align="left" valign="top" bgcolor="#63c6ae"><strong>Fecha</strong></td>
						<input type="hidden" id="id" name="id" value="">
						<input type="hidden" id="fecha" name="fecha"
							value="<?= date("d/m/Y");?>">

						<td align="left" bgcolor="#CCECE4"><label> <?= date("d/m/Y");?></label>
							</div></td>
					</tr>



					</tr>

				</table>
				<table width="60%" border="0" align="center" cellpadding="5"
					cellspacing="5">
					<tr>
						<td align="center">&nbsp;</td>
					</tr>
					<tr>
						<td align="center">
						<div class="alert alert-info" id="mensaje" name="mensaje" style="display: none;"></div>
						
						<input type="submit" class="btn btn-primary"
							value="Guardar"></td>
					</tr>
				</table>
			</form>
			<div class="divider"></div>
			<div class="divider"></div>

		</div>

	</div>
</div>