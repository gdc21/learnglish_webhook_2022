<section class="container">
	<section id="contenido">
		<?php echo $this->temp['encabezado']; ?>
		<div class="separador">
			<div class="row">
				<div class="col-lg-6">
					<h1 class="title-section">Reporte de resultados</h1>
				</div>

				<?php if ($_SESSION['perfil'] == 1): ?>
					<div class="col-lg-3 offset-lg-3">
						<br>
						<select name="cliente" id="cliente" class="form-control" style="border-radius: 15px;">
							<option value="">Selecciona un cliente</option>
							<?php foreach ($this->temp['clientes'] as $cliente){ ?>
								<option value="<?php echo $cliente['LGF0280001'] ?>"><?php echo $cliente['LGF0280002'] ?></option>
							<?php } ?>
						</select>
					</div>
				<?php endif ?>

				<?php if ($_SESSION['perfil'] == 3): ?>
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

		<div class="separador" id="controles">
			<div class="row">
				<?php if ($_SESSION['perfil'] != 6) { ?>
					<div class="col-lg-3 offset-lg-2">
						<button class="btn btn-lg inhabilitar opcion op1" data-opcion="1">Institución</button>
					</div>
				<?php } ?>
				<div class="col-lg-3 <?php if ($_SESSION['perfil'] == 6) {echo 'col-lg-3 offset-lg-3';} ?>">
					<button class="btn btn-lg inhabilitar opcion op2" data-opcion="2">Grupos</button>
				</div>
				<div class="col-lg-3">
					<button class="btn btn-lg inhabilitar opcion op3" data-opcion="3">Alumnos</button>
				</div>
			</div>
		</div>

		<div class="separador">
			<div class="row">
				<div class="col-lg-3 offset-lg-3">
					<button class="btn btn-lg inhabilitar seccion sec1" data-opcion="1">Evaluaciones</button>
				</div>
				<div class="col-lg-3">
					<button class="btn btn-lg inhabilitar seccion sec2" data-opcion="2">Habilidades</button>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-3">
				<br><br>
				<input type="checkbox" id="tiempos" name="tiempos">
				<label for="tiempos">Reportes por tiempos</label>
			</div>

			<div class="col-lg-3" style="display: none;">
				<input type="radio" class="periodos" id="bimestral" name="selector" value="1">
				<label for="bimestral">Bimestral</label>

				<?php 
					$fecha_actual = date("d-m-Y");
					echo "(".$fecha_actual." - ".date("d-m-Y",strtotime($fecha_actual."- 2 month")).")";
				 ?>
			</div>
			
			<div class="col-lg-3" style="display: none;">
				<input type="radio" class="periodos" id="trimestral" name="selector" value="2">
				<label for="trimestral">Trimestral</label>

				<?php 
					$fecha_actual = date("d-m-Y");
					echo "(".$fecha_actual." - ".date("d-m-Y",strtotime($fecha_actual."- 3 month")).")";
				 ?>
			</div>

			<div class="col-lg-3" style="display: none;">
				<input type="radio" class="periodos" id="semestral" name="selector" value="3">
				<label for="semestral">Semestral</label>

				<?php 
					$fecha_actual = date("d-m-Y");
					echo "(".$fecha_actual." - ".date("d-m-Y",strtotime($fecha_actual."- 6 month")).")";
				 ?>
			</div>

			<div class="col-lg-3 fechas">
				<label class="form-label">Fecha inicial</label>
				<input type="text" class="form-control datepicker" id="fInicial" placeholder="01/01/<?php echo date("Y"); ?>">
			</div>

			<div class="col-lg-3 fechas">
				<label class="form-label">Fecha final</label>
				<input type="text" class="form-control datepicker" id="fFinal" placeholder="<?php echo date("d/m/Y"); ?>">
			</div>
		</div>

		<form action="POST" id="formReporte">
			<input type="hidden" name="opcion" id="opcion">
			<input type="hidden" name="seccion" id="seccion">
			<input type="hidden" name="periodo" id="periodo">
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
				<div class="col-lg-12 table-responsive" style="overflow: scroll;">
					<table class="table tabla reporte_tabla" id="tabla_evaluaciones" style="display: none;">
						<thead>
							<th class="columna1">Alumno</th>
							<th class="columna2">Grupo</th>
							<?php for ($i = 1; $i <= $this->temp['leccion'][0]['num']; $i++) { ?>
								<th><?php echo $i; ?></th>
							<?php } ?>
							<th>Promedio</th>
						</thead>
						<tbody>
						</tbody>
					</table>

					<table class="table tabla reporte_tabla" id="tabla_habilidades" style="display: none;">
						<thead>
							<th class="columna1">Alumno</th>
							<th class="columna2">Grupo</th>
							<th>Vocabulary</th>
							<th>Grammar</th>
							<th>Reading</th>
							<th>Listening</th>
							<th>Speaking</th>
							<th>% Total</th>
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
				<div id="estadisticas_habilidades table-responsive">
					<table class="reporte_tabla">
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
							<th style="width: 15%;">Vocabulary</th> <td id="gramatica1"></td>
						</tr>
						<tr>
							<th style="width: 15%;">Grammar</th> <td id="gramatica2"></td>
						</tr>
						<tr>
							<th style="width: 15%;">Reading</th> <td id="servicios"></td>
						</tr>
						<tr>
							<th style="width: 15%;">Listening</th> <td id="profesional"></td>
						</tr>
						<tr>
							<th style="width: 15%;">Speaking</th> <td id="speaking"></td>
						</tr>
						<tr>
							<th style="width: 15%;">% Total</th> <td id="total"></td>
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
<style>
	.inhabilitar {
		margin-bottom: 1em !important;
	}
</style>