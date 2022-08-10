<style>
	.inhabilitar{
		background-color: #b9bbbb;
		border: none;
		font-weight: bold;
		color: #ffffff;
		width: 100% !important;
		height: auto;
	}

	.inhabilitar:hover, .inhabilitar:focus{
		color: #ffffff !important;
	}
	.dt-button{
	    margin: auto;
	    height: auto;
	    width: auto;
	}
</style>

<section id="contenido">
	<?php echo $this->temp['encabezado']; ?>
	<div class="row">
		<div class="col-lg-12" style="text-align: center;">
			<h3 class="title-section"><?php echo $this->temp['grupo']; ?> - <span id="titulo">Evaluaciones</span></h3>
		</div>
	</div>
	<div class="separador" style="margin-top: 1.5em;"></div>
	<br>
	<div class="row">
		<div class="col-lg-3 offset-lg-1">
			<button class="btn btn-lg inhabilitar seccion sec1" data-opcion="1" style="background-color: #0971b7;">Evaluaciones</button>
		</div>
		<div class="col-lg-3">
			<button class="btn btn-lg inhabilitar seccion sec2" data-opcion="2" style="background-color: #0d9344;">Habilidades</button>
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
		<input type="hidden" name="seccion" id="seccion" value="1">
		<input type="hidden" name="leccion" id="leccion" <?php echo $this->temp['leccion']; ?>>
		<input type="hidden" name="grupo" id="grupo" value="<?php echo $this->temp['grupoid']; ?>">
	</form>
	<div class="page" style="margin-top: 1.5em;">
		<div class="row">
			<div class="col-lg-12" style="overflow: scroll;">
				<div class="separador table-responsive">
					<!--  -->
					<table class="table tabla tabla_evaluaciones" id="tabla_evaluaciones">
						<thead>
							<th>Alumno</th>
							<?php for($i = 1; $i <= $this->temp['leccion'][0]['num']; $i++) { ?>
								<th style="text-align: center;"><?php echo $i; ?></th>
							<?php } ?>
							<th>Promedio</th>
						</thead>
						<tbody></tbody>
					</table>
					<!--  -->

					<table class="table tabla" id="tabla_habilidades" style="display: none;">
						<thead>
							<th class="columna1">Alumno</th>
							<th>% Vocabulary</th>
							<th>% Grammar</th>
							<th>% Reading</th>
							<th>% Listening</th>
							<th>% Speaking</th>
							<th>% Promedio</th>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
	    <div class="offset-lg-9 col-lg-3">
	    	<?php if ($this->temp['origen'] == "C" || $this->temp['origen'] == "A") { ?>
	    		<a class="regresar basico menu-principal" href='<?= CONTEXT ?>admin/teachers/'>Regresar al menú anterior</a>
	    	<?php } else if ($this->temp['origen'] == "t") { ?>
	    		<a class="regresar basico menu-principal" href='<?= CONTEXT ?>home/tutor/'>Regresar al menú anterior</a>
	    	<?php } else if ($this->temp['origen'] == "" && $_SESSION['perfil'] != 6) { ?>
	    		<a class="regresar basico menu-principal" href='<?= CONTEXT ?>admin/groups/'>Regresar al menú anterior</a>
	    	<?php } else if ($_SESSION['perfil'] == 6 && $this->temp['origen'] == "") { ?>
	    		<a class="regresar basico menu-principal" href='<?= CONTEXT ?>home/teacher/'>Regresar al menú anterior</a>
	    	<?php } ?>
	    </div>
	  </div>
</section>