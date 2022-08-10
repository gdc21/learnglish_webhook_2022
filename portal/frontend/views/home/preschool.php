<?php

/**
 * Verifica en la seccion de modulos si esta habilitada esta opcion, tbl:lg00043
 */
$mostrar_boton_examentrimestral = 0;
if (verificaModuloSistemaActivo('ExamenTrimestral')) {
    $mostrar_boton_examentrimestral = 1;
}

$bloqueo = '';
$niveles = (new Nivel())->obtenNivel((object) array("LGF0140001" => 1));
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
						<h3>3º Preescolar - Pre A1.1</h3>
					</div>
				</div>
				<div class="container-buttoms">
					<div class="">
						<a href="<?php echo $res['url_1']; ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo1']; ?>;">Lecciones</span>
						</a>
					</div>
					<div class="">
						<a href="<?php echo $res['urlg_1']; ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo1']; ?>;">Guías</span>
						</a>
					</div>
					<div class="">
						<a href="<?php echo $res['urlr_1']; ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo1']; ?>;">Recursos</span>
						</a>
					</div>
					<div class="">
						<a href="<?php echo $res['urlRe_1']; ?>">
							<span class="lecciones" style="background: <?php echo $res['fondo1']; ?>;">Reportes</span>
						</a>
					</div>
                    <?php if($mostrar_boton_examentrimestral){ ?>
                    <div class="">
                        <a href="<?php echo CONTEXT . $this->temp['verificaEvaluacionTrimestral']; ?>">
                            <span class="lecciones" style="font-size: small; background: <?php echo $res['fondo1']; ?>;">Evaluaciones trimestrales</span>
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