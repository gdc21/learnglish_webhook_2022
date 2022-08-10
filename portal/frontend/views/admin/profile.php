<section id="contenido">
	<div class="row">
		<div class="col-lg-2">
			<img src="<?= IMG?>logo_color.png" alt="learnglish icon">
		</div>
		<div class="col-lg-8">
			<div class="relleno">
				<span>Perfil de usuario</span>
			</div>
		</div>
		<!-- <div class="nameUser col-lg-4 hide"> -->
		<div class="col-lg-2">
			<img src="<?= $this->temp ["img_usuario"]?>" class="imagen">
			<span class="nombreAvatar"> <?php echo $_SESSION['nombre']?></span>
		</div>
	</div>
	<br>
	<div class="separador"></div>
	<table class="FormularioStyle align_left" id="A_t_Neval">
		<tbody>
			<tr>
				<td class="nameCampo">Institución</td>
				<td>
					<div id="institucion">Escuela Federal 1 - José Narciso Raviosa</div>
					<span class="error"></span>
				</td>
			</tr>
			<tr>
				<td class="nameCampo">Grupo</td>
				<td>
					<div id="grupo">1°A Secundaria</div>
					<span class="error"></span>
				</td>
			</tr>
			<tr>
				<td class="nameCampo">Nombre</td>
				<td>
					<div id="nombre">Juan Carlos Estrada Zurita</div>
					<span class="error"></span>
				</td>
			</tr>
			<tr>
				<td class="nameCampo">Fotografía</td>
				<td>
					<input type="file" name="foto" id="foto" placeholder="Ingresa el nombre corto de la institución" style="width: 100%; display: none;">
					<span class="error"></span>
					<img src="<?php echo CONTEXT ?>/portal/IMG/default.png" id="imagenPerfil" alt="" style="margin-left: 10%; width: 20%;">
					<button class="btn btn-primary btn-lg" id="cambiar" style="margin-left: 10% !important;">Cambiar</button>
				</td>
			</tr>
			<tr>
				<td class="nameCampo">Usuario</td>
				<td>
					<div id="usuario">Jestrada</div>
					<span class="error"></span>
				</td>
			</tr>
			<tr>
				<td class="nameCampo">Contraseña</td>
				<td>
					<input type="text" name="password" id="password" placeholder="Ingresa una contraseña">
					<span class="error"></span>
				</td>
			</tr>
			<tr>
				<td class="nameCampo">E-mail</td>
				<td>
					<input type="text" name="email" id="email" value="Jestrada@hotmail.com">
					<span class="error"></span>
				</td>
			</tr>
			<tr>
				<td class="nameCampo">Padre o tutor</td>
				<td>
					<div id="tutor">Dolores Trinidad Zurita Andrade</div>
					<span class="error"></span>
				</td>
			</tr>
		</tbody>
	</table>
</section>

<style>
  	.nombreAvatar {
	    display: block;
	    font-size: 15px;
	    text-align: center;
  	}
  	.relleno{
	    background: #0a6fb5;
	    /*margin-left: 15px;*/
	    border-radius: 9px;
	    /*margin-right: 10%;*/
	    font-size: 30px;
	    font-weight: bold;
	    color: #fff;
	    text-align: center;
	    display: block;
	    height: 70px;
	    width: 100%;
	    padding-top: 15px;
  	}
  	.separador{
	    margin-top: 5%;
  	}
  	.imagen{
	    width: 100px;
	    height: 100px;
	    -moz-border-radius: 50%;
	    -webkit-border-radius: 50%;
	    border-radius: 50%;
	    margin-top: -10px;
	    margin-left: 10%;
  	}
  	.cuadrado{
	    width: 100%;
	    height: 150px;
	    /*border: 3px solid #555;*/
	    background: #0a6fb5;
	    border-radius: 10px;
  	}

  	.cuadrado2{
	    width: 100%;
	    height: 150px;
	    /*border: 3px solid #555;*/
	    background: #2ebebb;
	    border-radius: 10px;
  	}

	.nombreM{
		display: block;
		font-size: 24px;
		text-align: center;
	}
	a{
		color: #000;
		text-decoration: none !important;
	}

  	.FormularioStyle {
		border-collapse: separate !important;
		border-spacing: 8px;
		width: 100%;
	}

	.FormularioStyle tr .nameCampo {
		background-color: #0a6fb5;
		color: #fff;
		font-size: 15px;
		font-weight: bold;
		height: 28px;
		width: 30%;
		color: #fff;
		font-family: Arial, Arial, sans-serif;
		font-size: 18px;
		font-weight: bold;
		padding-left: 20px;
		text-align: left;
	}

	.FormularioStyle tr td {
		background-color: #ecedef;
		color: #666;
		font-size: 16px;
		padding: 10px;
		vertical-align: middle;
		width: 100%;
		border: 1px solid;
		font-weight: bold;
		padding-left: 20px;
	}
	input, input:focus{
		width: 100%;
		border: none;
		outline: none;
	}
</style>