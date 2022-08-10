<?php
$ruta = IMG . "default.png";
if ($_SESSION['perfil'] == 1 || $_SESSION['perfil'] == 2 || $_SESSION['perfil'] == 6) {
	$columna = "col-lg-4";
} else {
	$columna = "col-lg-12";
}
?>
<section id="contenido">
	<?php echo $this->temp['encabezado']; ?>
	<div class="separador"></div>
	<form id="formP">
		<input type="hidden" id="perfil" value="<?php echo $_SESSION['perfil']; ?>">
		<table class="FormularioStyle align_left" id="A_t_Neval">
			<tbody>
				<?php if ($_SESSION['perfil'] == 2) :
					$login = (new Administrador())->informacionUsuario($_SESSION['idUsuario']);
				?>
					<tr>
						<td class="nameCampo">Institución</td>
						<td>
							<div id="institucion"><?php echo $login[0]['institucion'];?></div>
							<span class="error"></span>
						</td>
					</tr>
				<?php endif ?>
				<tr>
					<td class="nameCampo">Nombre</td>
					<td>
						<div>
							<span id="nombre"><?php echo $this->temp['nombre']; ?></span>
							<?php if ($_SESSION['perfil'] != 5) : ?>
								<i class='fa fa-pencil' title="Actualizar nombre" id='uDatos'></i> <i class='fa fa-close' title="Cancelar cambio" id='xDatos' style="display: none;"></i>
							<?php endif ?>
						</div>
						<div class="row">
							<div class="<?php echo $columna; ?>">
								<input type="text" class="form-control datPer" id="uName" name="uName" placeholder="Ingresa tu(s) nombre(s)">
							</div>
							<?php if ($_SESSION['perfil'] == 1 || $_SESSION['perfil'] == 2 || $_SESSION['perfil'] == 6) : ?>
								<div class="col-lg-4">
									<input type="text" class="form-control datPer" id="uPat" name="uPat" placeholder="Ingresa el apellido paterno">
								</div>
								<div class="col-lg-4">
									<input type="text" class="form-control datPer" id="uMat" name="uMat" placeholder="Ingresa el apellido materno">
								</div>
							<?php endif ?>
						</div>
						<span class="error"></span>
					</td>
				</tr>
				<tr>
					<td class="nameCampo">Fotografía</td>
					<td>
						<input type="file" name="foto" id="foto" placeholder="Ingresa el nombre corto de la institución" style="width: 100%; display: none;">
						<span class="error"></span>
						<img src="<?php echo $ruta; ?>" id="imagenPerfil" alt="" style="margin-left: 10%; width: 20%;">
						<button class="btn btn-primary btn-lg" id="cambiar" style="margin-left: 10% !important; height: auto;padding: 0.5em 1em;">Cambiar</button>
					</td>
				</tr>
				<tr>
					<td class="nameCampo">Usuario</td>
					<td>
						<div>
							<span id="usuario"><?php echo $this->temp['usuario']; ?></span>
							<?php if ($_SESSION['perfil'] != 5) : ?>
								<i class='fa fa-pencil' title="Cambiar nombre de usuario" id='uUser'></i> <i class='fa fa-close' title="Cancelar cambio" id='xUser' style="display: none;"></i>
							<?php endif ?>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<input type="text" class="form-control" id="cUser" name="cUser" placeholder="Ingresa un nombre de usuario">
							</div>
							<div class="col-lg-6">
								<div class="alert alert-danger" id="cUserMsj" style="display: none; padding: 0.3em;"></div>
							</div>
						</div>
						<span class="error"></span>
					</td>
				</tr>
				<tr>
					<td class="nameCampo">Contraseña</td>
					<td>
						<input type="text" name="password" class="form-control" id="password" placeholder="Ingresa una contraseña">
						<span class="error"></span>
					</td>
				</tr>
				<tr>
					<td class="nameCampo">E-mail</td>
					<td>
						<input type="text" name="email" class="form-control" id="email" value="<?php echo $this->temp['email']; ?>" placeholder="Ingresa tu correo">
						<span class="error"></span>
					</td>
				</tr>
				<?php if ($_SESSION['perfil'] == 0) : ?>
					<tr>
						<td class="nameCampo">Padre o tutor</td>
						<td>
							<div id="tutor">Dolores Trinidad Zurita Andrade</div>
							<span class="error"></span>
						</td>
					</tr>
				<?php endif ?>
			</tbody>
		</table>
		<div class="row offset-lg-3 col-lg-8">
			<div class="alert alert-success" id="mensaje" style="display: none;"></div>
		</div>
		<div class="row offset-lg-3 col-lg-6" style="text-align: center;">
			<button class="btn btn-primary btn-lg" id="guardar" style="height: 2.5em;">Guardar</button>
		</div>
	</form>

</section>

<style>
	.nombreAvatar {
		display: block;
		font-size: 0.75em;
		text-align: center;
	}

	.relleno {
		background: #0a6fb5;
		border-radius: 0.45em;
		font-size: 1.5em;
		font-weight: bold;
		color: #fff;
		text-align: center;
		display: block;
		height: 3.5em;
		width: 100%;
		padding-top: 0.75em;
	}

	.separador {
		margin-top: 5%;
	}

	.cuadrado {
		width: 100%;
		height: 7.5em;
		background: #0a6fb5;
		border-radius: 0.5em;
	}

	.cuadrado2 {
		width: 100%;
		height: 7.5em;
		background: #2ebebb;
		border-radius: 0.5em;
	}

	.nombreM {
		display: block;
		font-size: 1.2em;
		text-align: center;
	}

	a {
		color: #000;
		text-decoration: none !important;
	}

	.FormularioStyle {
		border-collapse: separate !important;
		border-spacing: 0.4em;
		width: 100%;
	}

	.FormularioStyle tr .nameCampo {
		background-color: #0a6fb5;
		color: #fff;
		font-size: 10.75em;
		font-weight: bold;
		height: 1.4em;
		width: 30%;
		color: #fff;
		font-family: Arial, Arial, sans-serif;
		font-size: 0.9em;
		font-weight: bold;
		padding-left: 1em;
		text-align: left;
	}

	.FormularioStyle tr td {
		background-color: #ecedef;
		color: #666;
		font-size: 0.8em;
		padding: 0.5em;
		vertical-align: middle;
		width: 100%;
		border: 0.05em solid;
		font-weight: bold;
		padding-left: 1em;
	}

	input,
	input:focus {
		width: 100%;
		border: none;
		outline: none;
		font-size: 1em;
	}

	button#guardar {
		padding: unset;
		margin: unset;
		height: auto;
		width: auto;
		display: block;
		margin: 1em auto;
		padding: 0.5em 1em;
	}
</style>