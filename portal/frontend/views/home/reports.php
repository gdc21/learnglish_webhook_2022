<style>
	.tabla_evaluaciones thead th{
		background: #66ccff;
		color: #ffffff;
		font-size: 0.9em;
		text-align: center;
	}

	#tabla_habilidades thead th{
		background: #0d9344;
		color: #ffffff;
		font-size: 0.9em;
		text-align: center;
	}
	td{
		background: #e6e6e6;
	}
	tbody{
		text-align: center;
		background-color: #e6e6e6;
	}
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

	.modal-header .close{
		margin-top: -1em !important;
	}

	.relleno{
	    background: #<?php echo $this->temp['color']; ?>;
	    color: #fff;
	}
	a{
		text-decoration: none !important;
		text-align: center;
	}
	.regresar{
		color: #<?php echo $this->temp['color']; ?> !important;
	}

	.dt-button{
	    margin: auto;
	    height: 100%;
	    width: 10%;
	}
	button.dt-button.buttons-excel.buttons-html5.btn.btn-lg.btn-primary {
		width: 10em;
		font-size: 1em;
		padding: 0.4em;
	}
</style>

<section id="contenido">
	<?php echo $this->temp['encabezado']; ?>
	<div class="separador" style="margin-top: 2.5em;"></div>

	<div class="page" style="margin-top: 1.5em;">
		<div class="container-buttom-section">
			<div class="top-buttom">
				<button class="btn btn-lg inhabilitar seccion sec1" data-opcion="1" style="background-color: #66ccff;">Evaluaciones</button>
			</div>
			<div class="top-buttom">
				<button class="btn btn-lg inhabilitar seccion sec2" data-opcion="2" style="background-color: #0d9344;">Habilidades</button>
			</div>
		</div>
		<form action="POST" id="formReporte">
			<input type="hidden" name="seccion" id="seccion">
			<input type="hidden" name="usuario" id="usuario" value="<?=$_SESSION['idUsuario']?>">
		</form>
		<div class="separador"></div>
		<h3 id="titulo"></h3>
		<div class="row">
			<div class="col-lg-12" style="overflow: scroll;">
				<div class="separador table-responsive">
					<!--  -->
					<table class="table reporte_tabla tabla_evaluaciones" id="tabla_evaluaciones">
						<thead>
							<th>Grado Escolar</th>
							<?php for($i = 1; $i <= $this->temp['leccion'][0]['num']; $i++) { ?>
								<th style="text-align: center;"><?php echo $i; ?></th>
							<?php } ?>
							<th>Promedio</th>
						</thead>
						<tbody></tbody>
					</table>
					<!--  -->

					<table class="table reporte_tabla" id="tabla_habilidades" style="display: none;">
						<thead>
							<th class="columna1">Grado Escolar</th>
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
			<?php
			if ( $this->temp['nivel'] == 1 ) {
				echo "<a class=\"regresar basico menu-principal\" href='".CONTEXT."home/preschool/'>Regresar al menú de preescolar</a>";
			} else if ( $this->temp['nivel'] == 2 ) {
				echo "<a class=\"regresar basico menu-principal\" href='".CONTEXT."home/primary/'>Regresar al menú de primaria</a>";
			} else {
				echo "<a class=\"regresar basico menu-principal\" href='".CONTEXT."home/secundary/'>Regresar al menú de secundaria</a>";
			}
			?>
	    </div>
	  </div>
</section>