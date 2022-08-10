<style>
	thead, th{
		background: #2ebebb;
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
	.registro:hover, .registro:focus{
		background-color: #2ebebb;
		color: #ffffff;
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
		color: #ffffff;
		font-weight: bold;
	}
</style>

<?php
	$avance = $this->temp['avance_modulo'];
	$columnas = $this->temp['modulos'];
?>
<!-- <pre><?php print_r($avance['modulo1']); ?></pre> -->
<table class="table reporte_tabla">
	<tr>
		<th>Alumno</th>
	</tr>
	<tr>
		<td>
			<img src="http://localhost/learnglish//portal/IMG/default.png" id="imagenPerfil" alt="" style=" width: 10%;">
			<span style="font-weight: bold; font-size: 30px;" id="nombre"></span>
			<br><br>
			<span style="font-weight: bold; font-size: 30px;" id="grupo"></span>
		</td>
	</tr>
</table>
<table class="table reporte_tabla">
	<tr>
		<th style="width: 40%;" colspan=40>Evaluaciones</th>
	</tr>
	<tr>
		<th style="width: 15%;">Gramática 1</th>
		<?php 
			$cont = 0;
			for ($i=1; $i <=$columnas[0]['totalmodulos']; $i++) {
				$clase = "";
				$porcentaje = "";
				// echo $columnas[0]['lecciones'][$i]['ids']."<br>";
				for ($j=0; $j <count($avance['modulo1']) ; $j++) { 
					if ($columnas[0]['lecciones'][$cont]['ids'] <= $avance['modulo1'][$j]['leccion']) {
						// echo $columnas[0]['lecciones'][$i]['ids']." -> ".$avance['modulo1'][$j]['leccion']."<br>";
						$clase.="class='relleno'";
					} else {
						$clase.="";
					}

					if ($columnas[0]['lecciones'][$cont]['ids'] == $avance['modulo1'][$j]['leccion']) {
						$porcentaje.= "<br>".$avance['modulo1'][$j]['porcentaje'];
					} else {
						$porcentaje.= "";
					}
				} ?>
				<td <?php echo $clase; ?>><?php echo $i.$porcentaje ?></td>
			<?php $cont++;
			}
		?>
	</tr>
	<tr>
		<th style="width: 15%;">Gramática 2</th>
		<?php 
			$cont = 0;
			for ($i=1; $i <=$columnas[1]['totalmodulos']; $i++) {
				$clase = "";
				$porcentaje = "";
				// echo $columnas[0]['lecciones'][$i]['ids']."<br>";
				for ($j=0; $j <count($avance['modulo2']) ; $j++) { 
					if ($columnas[1]['lecciones'][$cont]['ids'] <= $avance['modulo2'][$j]['leccion']) {
						// echo $columnas[0]['lecciones'][$i]['ids']." -> ".$avance['modulo1'][$j]['leccion']."<br>";
						$clase.="class='relleno'";
					} else {
						$clase.="";
					}

					if ($columnas[1]['lecciones'][$cont]['ids'] == $avance['modulo2'][$j]['leccion']) {
						$porcentaje.= "<br>".$avance['modulo2'][$j]['porcentaje'];
					} else {
						$porcentaje.= "";
					}
				} ?>
				<td <?php echo $clase; ?>><?php echo $i.$porcentaje ?></td>
			<?php $cont++;
			}
		?>
	</tr>
	<tr>
		<th style="width: 15%;">Servicios</th>
		<?php 
			$cont = 0;
			for ($i=1; $i <=$columnas[2]['totalmodulos']; $i++) {
				$clase = "";
				$porcentaje = "";
				// echo $columnas[0]['lecciones'][$i]['ids']."<br>";
				for ($j=0; $j <count($avance['modulo3']) ; $j++) { 
					if ($columnas[2]['lecciones'][$cont]['ids'] <= $avance['modulo3'][$j]['leccion']) {
						// echo $columnas[0]['lecciones'][$i]['ids']." -> ".$avance['modulo1'][$j]['leccion']."<br>";
						$clase.="class='relleno'";
					} else {
						$clase.="";
					}

					if ($columnas[2]['lecciones'][$cont]['ids'] == $avance['modulo3'][$j]['leccion']) {
						$porcentaje.= "<br>".$avance['modulo3'][$j]['porcentaje'];
					} else {
						$porcentaje.= "";
					}
				} ?>
				<td <?php echo $clase; ?>><?php echo $i.$porcentaje ?></td>
			<?php $cont++;
			}
		?>
	</tr>
	<tr>
		<th style="width: 15%;">Profesional</th>
		<?php 
			$cont = 0;
			for ($i=1; $i <=$columnas[3]['totalmodulos']; $i++) {
				$clase = "";
				$porcentaje = "";
				// echo $columnas[0]['lecciones'][$i]['ids']."<br>";
				for ($j=0; $j <count($avance['modulo4']) ; $j++) { 
					if ($columnas[3]['lecciones'][$cont]['ids'] <= $avance['modulo4'][$j]['leccion']) {
						// echo $columnas[0]['lecciones'][$i]['ids']." -> ".$avance['modulo1'][$j]['leccion']."<br>";
						$clase.="class='relleno'";
					} else {
						$clase.="";
					}

					if ($columnas[3]['lecciones'][$cont]['ids'] == $avance['modulo4'][$j]['leccion']) {
						$porcentaje.= "<br>".$avance['modulo4'][$j]['porcentaje'];
					} else {
						$porcentaje.= "";
					}
				} ?>
				<td <?php echo $clase; ?>><?php echo $i.$porcentaje ?></td>
			<?php $cont++;
			}
		?>
	</tr>
	<tr id="colturismo">
		<th style="width: 15%;">Turismo</th>
		<?php 
			$cont = 0;
			for ($i=1; $i <=$columnas[4]['totalmodulos']; $i++) {
				$clase = "";
				$porcentaje = "";
				// echo $columnas[0]['lecciones'][$i]['ids']."<br>";
				for ($j=0; $j <count($avance['modulo5']) ; $j++) { 
					if ($columnas[4]['lecciones'][$cont]['ids'] <= $avance['modulo5'][$j]['leccion']) {
						// echo $columnas[0]['lecciones'][$i]['ids']." -> ".$avance['modulo1'][$j]['leccion']."<br>";
						$clase.="class='relleno'";
					} else {
						$clase.="";
					}

					if ($columnas[4]['lecciones'][$cont]['ids'] == $avance['modulo5'][$j]['leccion']) {
						$porcentaje.= "<br>".$avance['modulo5'][$j]['porcentaje'];
					} else {
						$porcentaje.= "";
					}
				} ?>
				<td <?php echo $clase; ?>><?php echo $i.$porcentaje ?></td>
			<?php $cont++;
			}
		?>
	</tr>
</table>