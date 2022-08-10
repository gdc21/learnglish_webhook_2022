<div class="h2-wrap">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<table width="100%" border="0" cellspacing="10" cellpadding="0">
					<tr>
						<td width="65%"><span class="standard-block">Admin /
								Administradores</span></td>
						<td width="65%" align="right"><a
							href="<?= CONTEXT ?>administrador/form_nva_administrador"
							class="hero-btn">Registrar nuevo administrador</a></td>
					</tr>
				</table>

			</div>
		</div>
	</div>
</div>
<div class="text-inter">
	<div class="container">

		<div class="row">
			<div class="col-md-12">
				<h2 align="center">
					<img src="<?= IMG?>administradores.png" width="39" height="41"
						align="absmiddle"> Administradores registrados
				</h2>
				<div class="table-responsive">
					<table width="100%" border="0" align="center" cellpadding="0"
						cellspacing="2" id="tabla" class="table">
						<thead>
							<tr>
								<th width="10%" bgcolor="#63C6AE"><strong>Registro</strong></th>
								<th width="40%" align="center" bgcolor="#63C6AE"><strong>Nombre</strong></th>
								<th width="20%" align="center" bgcolor="#63C6AE"><strong>Permisos</strong></th>
								<th width="15%" align="center" bgcolor="#63C6AE"><strong>User</strong></th>
								<th width="15%" align="center" bgcolor="#63C6AE"><strong>Pass</strong></th>
								<th width="15%" align="center" bgcolor="#63C6AE"><strong>Editar</strong></th>
								<th width="15%" align="center" bgcolor="#63C6AE"><strong>Estatus</strong></th>
							</tr>
						</thead>	
				<?php
				/*echo('<pre>');
				var_dump($this->temp ["contenido"]);
				echo('</pre>');*/
				foreach ( $this->temp ["contenido"] as $contenido ) {
					?>
				<tr>
							<td valign="top" bgcolor="#CCECE4"><?= $contenido['registro'];?></td>
							<td align="left" valign="top" bgcolor="#CCECE4"><?= $contenido['nombre'];?></td>
							<td align="left" valign="top" bgcolor="#CCECE4"><?php 
							foreach ( $contenido['permisos'] as $subcontenido ) {
							echo $subcontenido['NMF0030002'].'</br>';
							}
							?></td>
							<td align="center" valign="top" bgcolor="#CCECE4"><?= $contenido['user'];?></td>
							<td align="center" valign="top" bgcolor="#CCECE4"><?= $contenido['password'];?></td>
							<td align="center" valign="top" bgcolor="#CCECE4"><a
								href="<?= CONTEXT ?>administrador/form_mdf_administrador/<?= $contenido['id'];?>"><img
									src="<?= IMG?>editar.png" width="26" height="25"></a></td>
							<td align="center" valign="top" bgcolor="#CCECE4">
							
								<?php if($contenido['estatus'] == 1){?>
								<img
									src="<?= IMG?>activado.png" class="img-responsive" width="38"
									height="31" align="center">
							
							
							<?php }else{?>
							<img src="<?= IMG ?>inactivo.png"
								class="img-responsive disabled" width="38" height="31"
								align="center">
							<?php }?>
							
							
				
					</td>
						</tr>
<?php } ?>					
					</table>
				</div>
			</div>
		</div>
	</div>
</div>