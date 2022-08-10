<?php


/**
 * Verifica en la seccion de modulos si esta habilitada esta opcion, tbl:lg00043
 */
$mostrar_boton_examentrimestral = 0;
if (verificaModuloSistemaActivo('ExamenTrimestral')) {
    $mostrar_boton_examentrimestral = 1;
}
$bloqueo = '';

$niveles = (new Nivel())->obtenNivel((object) array("LGF0140001" => 2));
$this->temp['color'] = $niveles[0]['LGF0140005'];
$usuario = $_SESSION['idUsuario'];
?>

<style>
	button.basico.titulo {
		border-color: #<?= $this->temp['color'] ?>;
	}

	span.lessonNum {
		color: #<?= $this->temp['color'] ?> !important;
	}

	button.basico span,
	.regresar.basico.menu-principal {
		color: #<?= $this->temp['color'] ?>;
		text-decoration: none;
	}

	.level_info {
		/*font-size: 0.6em;*/
		font-weight: bold;
		width: auto !important;
	}

	.lecciones {
		background: #67b3a0;
	}

	a {
		text-decoration: none !important;
	}

	.relleno {
		background: #<?php echo $this->temp['color']; ?>;
		color: #fff;
	}

	<?php $long = strlen($this->temp['modulo']['nombre']);
	if ($long > 21) {
		$width = 265 + (($long - 21) * 7.5);	?>section button {
		width: <?= $width; ?>px;
	}

	<?php } ?>
</style>

<?php
$res = $this->temp['urls'];
$imagen = $this->temp['imagen'];
?>

<section id="contenido">
	<div class="chooseaLessonl">
		<?php echo $this->temp['encabezado']; ?>
		<div class="menu-choose-level">
			<div class="levelIncator levelPrimaria">
				<div class="btn_level basico">
					<img src="<?php echo IMG . $imagen[0] ?>">
					<div class="level_info">
						<h3>1° Primaria - Pre A1.2</h3>
					</div>
				</div>
				<div class="container-buttoms">
					<div class="">
						<a href="<?php echo $res['url_2']; ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo2'] ?> ;">Lecciones</span>
						</a>
					</div>
					<div class="">
						<a href="<?php echo $res['urlg_2'] ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo2']; ?>">Guías</span>
						</a>
					</div>
					<div class="">
						<a href="<?php echo $res['urlr_2'] ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo2']; ?>;">Recursos</span>
						</a>
					</div>
					<div class="">
						<a href="<?php echo $res['urlRe_2'] ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo2'] ?>;">Reportes</span>
						</a>
					</div>
                    <?php if($mostrar_boton_examentrimestral) { ?>
                    <div class="">
						<a href="<?php echo CONTEXT . $this->temp['verificaEvaluacionTrimestral']; ?>">
							<span class="lecciones" style="font-size: small; background: <?php echo $res['fondo2']; ?>;">Evaluaciones trimestrales</span>
						</a>
					</div>
                    <?php } ?>
				</div>
			</div>

			<div class="levelIncator levelPrimaria">
				<div class="btn_level avanzado interno">
					<img src="<?php echo IMG . $imagen[1] ?>">
					<div class="level_info">
						<h3>2° Primaria - Pre A1.3</h3>
					</div>
				</div>
				<div class="container-buttoms">
					<div class="">
						<a href="<?php echo $res['url_3']; ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo3'] ?> ;">Lecciones</span>
						</a>
					</div>
					<div class="">
						<a href="<?php echo $res['urlg_3'] ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo3']; ?>">Guías</span>
						</a>
					</div>
					<div class="">
						<a href="<?php echo $res['urlr_3'] ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo3']; ?>;">Recursos</span>
						</a>
					</div>
					<div class="">
						<a href="<?php echo $res['urlRe_3'] ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo3'] ?>;">Reportes</span>
						</a>
					</div>
                    <?php if($mostrar_boton_examentrimestral) { ?>
                    <div class="">
                        <a href="<?php echo CONTEXT . $this->temp['verificaEvaluacionTrimestral']; ?>">
							<span class="lecciones" style="font-size: small; background: <?php echo $res['fondo3']; ?>;">Evaluaciones trimestrales</span>
						</a>
					</div>
                    <?php } ?>
				</div>
			</div>

			<div class="levelIncator levelPrimaria">
				<div class="btn_level basico">
					<img src="<?php echo IMG . $imagen[2] ?>">
					<div class="level_info">
						<h3>3° Primaria - A1.1</h3>
					</div>
				</div>
				<div class="container-buttoms">
					<div class="">
						<a href="<?php echo $res['url_4']; ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo4'] ?> ;">Lecciones</span>
						</a>
					</div>
					<div class="">
						<a href="<?php echo $res['urlg_4'] ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo4']; ?>">Guías</span>
						</a>
					</div>
					<div class="">
						<a href="<?php echo $res['urlr_4'] ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo4']; ?>;">Recursos</span>
						</a>
					</div>
					<div class="">
						<a href="<?php echo $res['urlRe_4'] ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo4'] ?>;">Reportes</span>
						</a>
					</div>
                    <?php if($mostrar_boton_examentrimestral) { ?>
                    <div class="">
                        <a href="<?php echo CONTEXT . $this->temp['verificaEvaluacionTrimestral']; ?>">
							<span class="lecciones" style="font-size: small; background: <?php echo $res['fondo4']; ?>;">Evaluaciones trimestrales</span>
						</a>
					</div>
                    <?php } ?>
				</div>
			</div>

			<div class="levelIncator levelPrimaria">
				<div class="btn_level basico">
					<img src="<?php echo IMG . $imagen[3] ?>">
					<div class="level_info">
						<h3>4° Primaria - A1.2</h3>
					</div>
				</div>
				<div class="container-buttoms">
					<div class="">
						<a href="<?php echo $res['url_5']; ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo5'] ?> ;">Lecciones</span>
						</a>
					</div>
					<div class="">
						<a href="<?php echo $res['urlg_5'] ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo5']; ?>">Guías</span>
						</a>
					</div>
					<div class="">
						<a href="<?php echo $res['urlr_5'] ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo5']; ?>;">Recursos</span>
						</a>
					</div>
					<div class="">
						<a href="<?php echo $res['urlRe_5'] ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo5'] ?>;">Reportes</span>
						</a>
					</div>
                    <?php if($mostrar_boton_examentrimestral) { ?>
                    <div class="">
                        <a href="<?php echo CONTEXT . $this->temp['verificaEvaluacionTrimestral']; ?>">
							<span class="lecciones" style="font-size: small; background: <?php echo $res['fondo5']; ?>;">Evaluaciones trimestrales</span>
						</a>
					</div>
                    <?php } ?>
				</div>
			</div>

			<div class="levelIncator levelPrimaria">
				<div class="btn_level avanzado interno">
					<img src="<?php echo IMG . $imagen[4] ?>">
					<div class="level_info">
						<h3>5° Primaria - A2.1</h3>
					</div>
				</div>
				<div class="container-buttoms">
					<div class="">
						<a href="<?php echo $res['url_6']; ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo6'] ?> ;">Lecciones</span>
						</a>
					</div>
					<div class="">
						<a href="<?php echo $res['urlg_6'] ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo6']; ?>">Guías</span>
						</a>
					</div>
					<div class="">
						<a href="<?php echo $res['urlr_6'] ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo6']; ?>;">Recursos</span>
						</a>
					</div>
					<div class="">
						<a href="<?php echo $res['urlRe_6'] ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo6'] ?>;">Reportes</span>
						</a>
					</div>
                    <?php if($mostrar_boton_examentrimestral) { ?>
                    <div class="">
                        <a href="<?php echo CONTEXT . $this->temp['verificaEvaluacionTrimestral']; ?>">
							<span class="lecciones" style="font-size: small; background: <?php echo $res['fondo6']; ?>;">Evaluaciones trimestrales</span>
						</a>
					</div>
                    <?php } ?>
				</div>
			</div>

			<div class="levelIncator levelPrimaria">
				<div class="btn_level basico">
					<img src="<?php echo IMG . $imagen[5] ?>">
					<div class="level_info">
						<h3>6° Primaria - A2.2</h3>
					</div>
				</div>
				<div class="container-buttoms">
					<div class="">
						<a href="<?php echo $res['url_7']; ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo7'] ?> ;">Lecciones</span>
						</a>
					</div>
					<div class="">
						<a href="<?php echo $res['urlg_7'] ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo7']; ?>">Guías</span>
						</a>
					</div>
					<div class="">
						<a href="<?php echo $res['urlr_7'] ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo7']; ?>;">Recursos</span>
						</a>
					</div>
					<div class="">
						<a href="<?php echo $res['urlRe_7'] ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo7'] ?>;">Reportes</span>
						</a>
					</div>
                    <?php if($mostrar_boton_examentrimestral) { ?>
                    <div class="">
                        <a href="<?php echo CONTEXT . $this->temp['verificaEvaluacionTrimestral']; ?>">
							<span class="lecciones" style="font-size: small; background: <?php echo $res['fondo7']; ?>;">Evaluaciones trimestrales</span>
						</a>
					</div>
                    <?php } ?>
				</div>
			</div>

		</div>
		<div class="row">
			<div class="offset-lg-9 col-lg-3">
				<a class="regresar basico menu-principal" href='<?= CONTEXT ?>home/menu'>Regresar al menú principal</a>
			</div>
		</div>
	</div>
</section>