<style>
	.level_info{
	  font-size: 0.7em;
	  font-weight: bold;
	  width: auto !important;
	  text-align: center;
	}
	.level_info1{
	  font-size: 0.6em;
	  color: #000 !important;
	  font-weight: bold;
	  width: auto !important;
	  text-align: center;
	}
	.levelIncator{
		margin-top: 0;
	}
	.levelPrimaria{
		width: 16%;
	}
	
	a{
	    color: #000;
	    text-decoration: none !important;
	}

	.preescolar{
		background: #<?php echo $this->temp['preescolar']; ?> !important;
		color: #fff;
	}
	.primaria{
		background: #<?php echo $this->temp['primaria']; ?> !important;
		color: #fff;
	}
	.secundaria{
		background: #<?php echo $this->temp['secundaria']; ?> !important;
		color: #fff;
	}
	.inactivo{
		color: #ff0000 !important;
	}
	.btn-primary{
		background: #0971b7 !important;
	}
</style>
<?php 
	$numTotal = count($this->temp['relacion']);
	// $numTotal = 5;
	$columnas = columnas($numTotal);
	function columnas($registros) {
		$columnas = "";
		if ($registros == 1) {
			$columnas = "col-lg-6 col-lg-offset-4";
		} else if ($registros == 2) {
			$columnas = "col-lg-6";
		} else if ($registros == 3) {
			$columnas = "col-lg-4";
		} else if ($registros >= 4) {
			$columnas = "col-lg-2";
		}
		return $columnas;
	}
?>

<section id="contenido">
	<div class="chooseaLessonl">
		<div class="row">
			<div class="col-lg-2">
				<img src="<?= IMG?>logo_color.png" alt="learnglish icon">
			</div>

			<div class="col-lg-8">
				<div class="relleno">
					<span><?php echo $this->temp['titulo'] ?></span>
				</div>
			</div>

			<div class="col-lg-2">
				<img src="<?= $this->temp ["img_usuario"]?>" class="imagen">
				<span class="nombreAvatar"> <?php echo $_SESSION['nombre']?></span>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-lg-12" style="text-align: center;">
				<h3><b><?php echo $this->temp['seccion_nombre']; ?></b></h3>
			</div>
		</div>
		<div class="separador"></div>

		<!-- Empieza -->
		<div class="row">
			<?php for ($i=0; $i < $numTotal; $i++) { 
				if ($numTotal > 3) {
					$clase = "levelPrimaria";
					$clase1 = "level_info1";
				} else {
					$clase1 = "level_info";
				} ?>
				<div class="levelIncator <?php echo $clase; ?>">
					<div class="btn_level basico">
						<div class="<?php echo $clase1; ?>" style="margin-bottom: 0.5em;">
							<h3><?php echo $this->temp['relacion'][$i]['grado']; ?></h3>
						</div>
						<img src="<?php echo $this->temp['relacion'][$i]['imagen']; ?>">
						<div class="<?php echo $clase1; ?>">
							<h3><?php echo $this->temp['relacion'][$i]['alumno']; ?></h3>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
		<div style="margin-top: 20%;"></div>

		<div class="row">
			<?php for ($i=0; $i < $numTotal; $i++) { ?>
				<div class="<?php echo $columnas; ?>">
			 		<div class="row">
				 		<a href="<?php echo CONTEXT; ?>Home/lessons/<?php echo $this->temp['relacion'][$i]['leccion'] ?>/">
				 			<span class="lecciones" style="background: #<?php echo $this->temp['relacion'][$i]['color'] ?>;">
				 				Lecciones
				 			</span>
				 		</a>
				 		<a href="<?php echo CONTEXT; ?>Home/means/<?php echo $this->temp['relacion'][$i]['nivel'] ?>/<?php echo $this->temp['relacion'][$i]['id'] ?>t">
			 				<span class="lecciones" style="background: #<?php echo $this->temp['relacion'][$i]['color'] ?>;">
			 					Recursos
			 				</span>
			 			</a>
			 			<a href="<?php echo CONTEXT; ?>Home/results/<?php echo $this->temp['relacion'][$i]['grupo'] ?>/<?php echo $this->temp['relacion'][$i]['id'] ?>t">
			 				<span class="lecciones" style="background: #<?php echo $this->temp['relacion'][$i]['color'] ?>;">
			 					Reportes
			 				</span>
			 			</a>
			 			<a href="<?php echo CONTEXT; ?>Home/results/<?php echo $this->temp['relacion'][$i]['grupo'] ?>/<?php echo $this->temp['relacion'][$i]['id'] ?>t">
			 				<span class="lecciones" style="background: #<?php echo $this->temp['relacion'][$i]['color'] ?>;">
			 					Reportes
			 				</span>
			 			</a>
			 		</div>
				</div>
			<?php } ?>
		</div>
		
		<!-- <div class="row">
			<div class="offset-lg-9 col-lg-3">
				<a class="regresar basico menu-principal" href="http://learnglish.com.mx/learnglishk10/home/menu">Regresar al menú principal</a>
			</div>
		</div> -->
		<!-- Termina -->
	</div>
</section>