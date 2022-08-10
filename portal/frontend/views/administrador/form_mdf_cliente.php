<div class="h2-wrap">
	<div class="container">
		<div class="row">
			<div class="col-md-30">
				<table width="100%" border="0" cellspacing="10" cellpadding="0">
					<tr>
						<td width="65%"><span class="standard-block">Admin / Modificar cliente</span></td>
						<td width="65%" align="right"><a
							href="<?= CONTEXT ?>administrador/clientes" class="hero-btn">
								Clientes registrados</a></td>
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
				<img src="<?= IMG ?>clientes.png" width="50" height="42"
					align="absmiddle"> Modificar cliente
			</h2>

			<div align="center"></div>
			<form enctype="multipart/form-data" id="form_mdf_cliente" name="form_mdf_cliente">
				<table width="70%" border="0" align="center" cellpadding="0"
					cellspacing="2">
					<tr>
						
					
						<td width="16%" align="left" valign="top" bgcolor="#63C6AE"><strong>Nombre</strong></td>
						<td width="84%" align="left" bgcolor="#CCECE4">
						<input id="id_cliente" name="id_cliente" type="hidden"  value="<?= $this->temp["cliente"]["id_cliente"] ?>" size="30">
						<input
							name="nombre" type="text" class="form-control input-lg" id="nombre" value="<?= $this->temp["cliente"]["nombre"] ?>" size="30"><span class="error"></span></td>
					</tr>
					<tr>
						<td align="left" valign="top" bgcolor="#63C6AE"><strong>Fecha
								inicio</strong></td>
						<td align="left" bgcolor="#CCECE4"><div class='input-group date'
								id='datetimepicker1'>
								<input type='text' class="form-control" value="<?= $this->temp["cliente"]["fecha_inicio"] ?>" name="fecha_inicio" id="fecha_inicio" class="date"/><span class="error"></span>	 <span
									class="input-group-addon"> <span
									class="glyphicon glyphicon-calendar"></span>
								</span>
							</div></td>
					</tr>
					<tr>
						<td align="left" valign="top" bgcolor="#63C6AE"><strong>Fecha
								término</strong></td>
						<td align="left" bgcolor="#CCECE4"><div class='input-group date'
								id='datetimepicker1'>
								<input type='text' class="form-control" value="<?= $this->temp["cliente"]["fecha_fin"] ?>" name="fecha_fin" id="fecha_fin"  class="date"/><span class="error"></span>	 <span
									class="input-group-addon"> <span
									class="glyphicon glyphicon-calendar"></span>
								</span>
							</div></td>
					</tr>
					<tr>
						<td align="left" valign="top" bgcolor="#63C6AE"><strong>IP
								referida</strong></td>
						<td align="left" bgcolor="#CCECE4"><input name="fld_ip"
							type="text" class="form-control input-lg" id="fld_ip"  value="<?= $this->temp["cliente"]["ip"]?>" placeholder="Ip ej. 000.000.00.000" class="ip_address"  size="30" > <!--  onblur="ValidateIPaddress(this)"-->  
						<span class="error"></span>	
							
							</td>
					</tr>
					<tr>
						<td align="left" valign="top" bgcolor="#63C6AE"><strong>URL
								referido</strong></td>
						<td align="left" bgcolor="#CCECE4"><input name="fld_url"  value="<?= $this->temp["cliente"]["url"] ?>"
							type="text" class="form-control input-lg" id="fld_url"  size="30">
							<span class="error"></span>	
							</td>
					</tr>
					<tr>
						<td align="left" valign="top" bgcolor="#63C6AE"><strong>Licencias
								contratadas</strong></td>
						<td align="left" bgcolor="#CCECE4"><input name="licencias"
							type="text" class="form-control input-lg" id="licencias" value="<?= $this->temp["cliente"]["licencias"] ?>" size="30">
							<span class="error"></span>	</td>
					</tr>
					<tr>
						<td width="16%" align="left" valign="top" bgcolor="#63C6AE"><strong>Activar</strong></td>
						<td bgcolor="#CCECE4">

							<ul class="list-group">
							<li class="list-group-item">

								<div class="material-switch pull-right">

									<input id="estatus" name="estatus" type="checkbox"
										<?php if($this->temp ["cliente"]["estatus"]==1){ ?> checked
										<?php }?> /> <label for="estatus" name="label" class="label"><?php if($this->temp ["cliente"]["estatus"]==1){ ?> Activado
										<?php }else{?>Desactivado<?php }?></label>
								</div>
							</li>
						</ul>

						</td>
					</tr>
					<tr>
						<td width="16%" align="left" valign="top" bgcolor="#63C6AE"><strong>Fecha</strong></td>
						<td bgcolor="#CCECE4"><?= $this->temp["cliente"]["fecha"] ?></td>
					</tr>
				</table>
				<table width="60%" border="0" align="center" cellpadding="5"
					cellspacing="5">
					<tr>
						<td align="center">&nbsp;</td>
					</tr>
					<tr>
						<td align="center"><div class="alert alert-info" id="mensaje" name="mensaje" style="display: none;"></div>
						
						<input type="submit" class="btn btn-primary"
							value="Guardar"></td>
					</tr>
				</table>
			</form>
			<p>&nbsp;</p>

			<div class="divider"></div>
			<div class="divider"></div>



		</div>

	</div>
</div>