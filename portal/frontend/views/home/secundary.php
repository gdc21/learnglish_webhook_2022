<?php

/**
 * Verifica en la seccion de modulos si esta habilitada esta opcion, tbl:lg00043
 */
$mostrar_boton_examentrimestral = 0;
if (verificaModuloSistemaActivo('ExamenTrimestral')) {
    $mostrar_boton_examentrimestral = 1;
}

$bloqueo = '';
$niveles = (new Nivel())->obtenNivel((object) array("LGF0140001" => 3));
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

	a {
		text-decoration: none !important;
	}

	.relleno {
		background: #<?php echo $this->temp['color']; ?>;
		border-radius: 0.45em;
		font-size: 1.8em;
		font-weight: bold;
		color: #fff;
		text-align: center;
		display: block;
		height: 2.5em;
		width: 100%;
		padding-top: 0.4em;
		margin-bottom: 1em;
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

		<div class="row">
			<div class="levelIncator">
				<div class="btn_level basico">
					<img src="<?php echo IMG . $imagen[0] ?>">
					<div class="level_info">
						<h3>1° Secundaria - B1.1</h3>
					</div>
				</div>
				<div class="container-buttoms">
					<div class="">
						<a href="<?php echo $res['url_8']; ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo8']; ?>;">Lecciones</span>
						</a>
					</div>
					<div class="">
						<a href="<?php echo $res['urlg_8']; ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo8']; ?>;">Guías</span>
						</a>
					</div>
					<div class="">
						<a href="<?php echo $res['urlr_8']; ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo8']; ?>;">Recursos</span>
						</a>
					</div>
					<div class="">
						<a href="<?php echo $res['urlRe_8']; ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo8']; ?>;">Reportes</span>
						</a>
					</div>
                    <?php if($mostrar_boton_examentrimestral){ ?>
                    <div class="">
                        <a href="<?php echo CONTEXT . $this->temp['verificaEvaluacionTrimestral']; ?>">
                            <span class="lecciones" style="font-size: small; background: <?php echo $res['fondo8']; ?>;">Evaluaciones trimestrales</span>
                        </a>
                    </div>
                    <?php } ?>
				</div>
			</div>

			<div class="levelIncator">
				<div class="btn_level avanzado interno">
					<img src="<?php echo IMG . $imagen[1] ?>">
					<div class="level_info">
						<h3>2° Secundaria - B1.2</h3>
					</div>
				</div>
				<div class="container-buttoms">
					<div class="">
						<a href="<?php echo $res['url_9']; ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo9']; ?>;">Lecciones</span>
						</a>
					</div>
					<div class="">
						<a href="<?php echo $res['urlg_9']; ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo9']; ?>;">Guías</span>
						</a>
					</div>
					<div class="">
						<a href="<?php echo $res['urlr_9']; ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo9']; ?>;">Recursos</span>
						</a>
					</div>
					<div class="">
						<a href="<?php echo $res['urlRe_9']; ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo9']; ?>;">Reportes</span>
						</a>
					</div>
                    <?php if($mostrar_boton_examentrimestral){ ?>
                    <div class="">
                        <a href="<?php echo CONTEXT . $this->temp['verificaEvaluacionTrimestral']; ?>">
                            <span class="lecciones" style="font-size: small; background: <?php echo $res['fondo9']; ?>;">Evaluaciones trimestrales</span>
                        </a>
                    </div>
                    <?php } ?>
				</div>
			</div>

			<div class="levelIncator">
				<div class="btn_level basico">
					<img src="<?php echo IMG . $imagen[2] ?>">
					<div class="level_info">
						<h3>3° Secundaria - B1.3</h3>
					</div>
				</div>
				<div class="container-buttoms">
					<div class="">
						<a href="<?php echo $res['url_10']; ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo10']; ?>;">Lecciones</span>
						</a>
					</div>
					<div class="">
						<a href="<?php echo $res['urlg_10']; ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo10']; ?>;">Guías</span>
						</a>
					</div>
					<div class="">
						<a href="<?php echo $res['urlr_10']; ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo10']; ?>;">Recursos</span>
						</a>
					</div>
					<div class="">
						<a href="<?php echo $res['urlRe_10']; ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo10']; ?>;">Reportes</span>
						</a>
					</div>
                    <?php if($mostrar_boton_examentrimestral){ ?>
                    <div class="">
                        <a href="<?php echo CONTEXT . $this->temp['verificaEvaluacionTrimestral']; ?>">
                            <span class="lecciones" style="font-size: small; background: <?php echo $res['fondo10']; ?>;">Evaluaciones trimestrales</span>
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