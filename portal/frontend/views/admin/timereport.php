<style>
	thead tr th{
		width: auto !important;
	}
</style>

<section class="container">
	<section id="contenido">
		<?php echo $this->temp['encabezado']; ?>
		<div class="separador">
			<div class="row">
				<div class="col-lg-6">
					<h1 style="font-weight: bold;">Reporte tiempo en plataforma</h1>
				</div>
				<?php if ($_SESSION['perfil'] == 1 || $_SESSION['perfil'] == 3): ?>
					<div class="col-lg-3 offset-lg-3">
						<br>
						<select name="institucion" id="institucion" class="form-control" style="border-radius: 15px;">
							<?php if ($_SESSION['perfil'] == 1 || $_SESSION['perfil'] == 3) { ?>
								<option value="">Selecciona una institución</option>
								<?php foreach ($this->temp['instituciones'] as $inst){ ?>
									<option value="<?php echo $inst['LGF0270001'] ?>"><?php echo $inst['LGF0270002'] ?></option>
								<?php } 
							} else if($_SESSION['perfil'] == 4) { ?>
								<option value="<?php echo $_SESSION['idUsuario'] ?>" selected><?php echo $_SESSION['nombre'] ?></option>
							<?php } else if($_SESSION['perfil'] == 6) { ?>
								<option value="<?php echo $this->temp['info'][0]['idInstitucion']; ?>"><?php echo $this->temp['info'][0]['nombreInstitucion']; ?></option>
							<?php }?>
						</select>
					</div>
				<?php endif ?>
			</div>
		</div>

		<!-- <div class="separador">
			<div class="row">
				<div class="col-lg-4 offset-lg-2">
					<button class="btn btn-lg seccion sec1 registro" data-opcion="1">Tiempo en plataforma</button>
				</div>
				<div class="col-lg-3">
					<button class="btn btn-lg inhabilitar seccion sec2" data-opcion="2">Tiempo en lecciones</button>
				</div>
			</div>
		</div> -->
		<form action="POST" id="formReporte">
			<input type="hidden" name="opcion" id="opcion">
			<input type="hidden" name="seccion" id="seccion">
		</form>
		<div class="page" style="margin-top: 30px;">
			<div class="separador">
				<?php if ($_SESSION['perfil'] == 4): ?>
					<h3><b>Institución: <?php echo $_SESSION['nombre']; ?></b></h3>
				<?php else: ?>
					<h3 id="titulo"></h3>
				<?php endif ?>
			</div>
			<div class="row">
				<div class="col-lg-12" style="overflow: scroll;">
					<table class="table tabla" id="tabla_general" style="display: block;">
						<thead>
							<th class="columna1">Usuario</th>
							<th>CURP</th>
							<th>C.C.T</th>
							<th>Institución</th>
							<th class="columna2">Tiempo en plataforma</th>
						</thead>
						<tbody>
						</tbody>
					</table>

					<table class="table tabla" id="tabla_lecciones" style="display: none;">
						<thead>
							<th class="columna1">Usuario</th>
							<th>CURP</th>
							<th>C.C.T</th>
							<th>Institución</th>
							<th class="columna2">Tiempo en plataforma</th>
							<th class="columna2">Módulo</th>
							<th class="columna2">Lección</th>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>

			<div class="row">
			    <div class="offset-lg-9 col-lg-3">
			    	<a class="regresar basico menu-principal" href='<?php echo CONTEXT ?>admin/manager/'>Regresar</a>
			    </div>
			</div>
		</div>
	</section>
</section>

<div class="modal fade" id="modalReporte" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style="width: 110%;">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold; font-size: 30px;">Reporte de avance</h5>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="estadisticas_evaluaciones"></div>
				<div id="estadisticas_habilidades">
					<table class="table reporte_tabla">
						<tr>
							<th style="width: 25%;">Alumno</th>
							<th style="width: 40%;" colspan=2>Habilidades</th>
						</tr>
						<tr>
							<td rowspan=7>
								<img src="" id="imagenPerfil" alt="" style=" width: 50%;">
								<br><br>
								<span style="font-weight: bold; font-size: 30px;" id="nombre"></span>
								<br><br>
								<span style="font-weight: bold; font-size: 30px;" id="grupo"></span>
							</td>
						</tr>
						<tr>
							<th style="width: 15%;">Vocabulary</th> <td style="background: #fff;"><span class="cuadrado" id="gramatica1"></span></td>
						</tr>
						<tr>
							<th style="width: 15%;">Grammar</th> <td style="background: #fff;"><span class="cuadrado" id="gramatica2"></span></td>
						</tr>
						<tr>
							<th style="width: 15%;">Reading</th> <td style="background: #fff;"><span class="cuadrado" id="servicios"></span></td>
						</tr>
						<tr>
							<th style="width: 15%;">Listening</th> <td style="background: #fff;"><span class="cuadrado" id="profesional"></span></td>
						</tr>
						<tr>
							<th style="width: 15%;">Speaking</th> <td style="background: #fff;"><span class="cuadrado" id="speaking"></span></td>
						</tr>
						<tr>
							<th style="width: 15%;">% Total</th> <td style="background: #fff;"><span class="cuadrado" id="total"></span></td>
						</tr>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>