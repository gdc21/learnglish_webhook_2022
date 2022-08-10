<style>
	.tabla_evaluaciones thead th{
		background: #66ccff;
		color: #ffffff;
		font-size: 18px;
		text-align: center;
	}

	#tabla_habilidades thead th{
		background: #0d9344;
		color: #ffffff;
		font-size: 18px;
		text-align: center;
	}
	td{
		background: #e6e6e6;
	}
	tbody{
		text-align: center;
		background-color: #e6e6e6;
	}
	.reporte_tabla {
		border-collapse: separate !important;
		border-spacing: 6px !important;
	}
	.registro{
		background-color: #2ebebb !important;
		border: none;
		font-weight: bold;
		color: #ffffff;
		width: 100% !important;
	}
	.registro1{
		background-color: #2ebebb8f !important;
		border: none;
		font-weight: bold;
		color: #000000ad !important;
		width: 100% !important;
	}
	.registro:hover, .registro:focus{
		background-color: #2ebebb;
		color: #ffffff;
	}

	.registro1:hover, .registro1:focus{
		background-color: #2ebebb;
		color: #000000ad !important;
	}
	.separador{
		padding-bottom: 15px;
	}
	.dataTables_length{
		display: none;
	}
	.table.dataTable.no-footer{
		border-bottom: none;
	}

	.inhabilitar{
		background-color: #b9bbbb;
		border: none;
		font-weight: bold;
		color: #ffffff;
		width: 100% !important;
	}

	.inhabilitar:hover, .inhabilitar:focus{
		color: #ffffff !important;
	}

	.titulo-reporte{
		background-color: #2ebebb;
		border: none;
		font-weight: bold;
		color: #ffffff;
		width: 64% !important;
		float: left;
	}

	.barra-reporte{
		background-color: #2ebebb;
		border: none;
		font-weight: bold;
		color: #ffffff;
		width: 64% !important;
		float: left;
	}

	.modal-header .close{
		margin-top: -20px !important;
	}

	.cuadrado {
		float: left;
		height: 40px; 
		background: #2ebebb;
		text-align: end;
		padding: 10px;
		font-weight: bold;
		color: #ffffff;
	}

	.relleno{
		background-color: #0a6fb5 !important;
		font-weight: bold;
		color: #fff;
	}
</style>
<section id="contenido" class="container">
	<div class="separador">
		<div class="row">
			<div class="col-lg-3 offset-lg-3">
				<button class="btn btn-lg inhabilitar seccion sec1" data-opcion="1" style="background-color: #66ccff;">Evaluaciones</button>
			</div>
			<div class="col-lg-3">
				<button class="btn btn-lg inhabilitar seccion sec2" data-opcion="2" style="background-color: #0d9344;">Habilidades</button>
			</div>
		</div>
	</div>
	<form action="POST" id="formReporte">
		<input type="hidden" name="seccion" id="seccion">
		<input type="hidden" name="usuario" id="usuario" value="<?=$_SESSION['idUsuario']?>">
	</form>
	<div class="page" style="margin-top: 30px;">
		<div class="separador">
			<h3 id="titulo"></h3>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="separador">
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
</section>