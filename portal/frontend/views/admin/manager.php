<section id="contenido">
    <?php echo $this->temp['encabezado']; ?>
    <div class="separador"></div>
    <!-- Admin -->
    <?php if ($_SESSION['perfil'] == 1) { ?>
        <div class="row">
            <div class="col-6 col-lg-3">
                <a href="<?php echo CONTEXT ?>admin/instituciones/">
                    <div class="cuadrado2"><i class="fa fa-university" aria-hidden="true"></i></div>
                    <span class="nombreM">Instituciones</span>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a href="<?php echo CONTEXT ?>admin/groups">
                    <div class="cuadrado"><i class="fa fa-sitemap" aria-hidden="true"></i></div>
                    <span class="nombreM">Grupos</span>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a href="<?php echo CONTEXT ?>admin/usuarios/">
                    <div class="cuadrado2"><i class="fa fa-users" aria-hidden="true"></i></div>
                    <span class="nombreM">Usuarios</span>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a href="<?php echo CONTEXT ?>admin/teachers/">
                    <div class="cuadrado"><i class="fa fa-graduation-cap" aria-hidden="true"></i></div>
                    <span class="nombreM">Docentes</span>
                </a>
            </div>

            <div class="separador"></div>

            <div class="col-6 col-lg-3">
                <a href="<?php echo CONTEXT ?>admin/clientes/">
                    <div class="cuadrado"><i class="fa fa-user-circle-o" aria-hidden="true"></i></div>
                    <span class="nombreM">Clientes</span>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a href="<?php echo CONTEXT ?>admin/reportes/">
                    <div class="cuadrado2"><i class="fa fa-signal" aria-hidden="true"></i></div>
                    <span class="nombreM">Reportes</span>
                </a>
            </div>

            <div class="col-6 col-lg-3">
                <a href="<?php echo CONTEXT ?>admin/importar/">
                    <div class="cuadrado2"><i class="fa fa-upload" aria-hidden="true"></i></div>
                    <span class="nombreM">Importar datos</span>
                </a>
            </div>
            <?php
            /**
             * Verifica en la seccion de modulos si esta habilitada esta opcion, tbl:lg00043
             */
            if (verificaModuloSistemaActivo('SistemaEstadisticas')) { ?>
                <div class="col-6 col-lg-3">
                    <a href="<?php echo CONTEXT ?>admin/estadisticassistema/0/general">
                        <div class="cuadrado"><i class="fa fa-area-chart" aria-hidden="true"></i></div>
                        <span class="nombreM">Estadisticas de uso</span>
                    </a>
                </div>
                <?php
            } ?>


            <?php
            /**
             * Verifica en la seccion de modulos si esta habilitada esta opcion, tbl:lg00043
             */
            if (verificaModuloSistemaActivo('PermitirCargaMultimedia')) { 

	            $data = verificaModuloSistemaRetornoValor('PermitirCargaMultimedia');
	            $subdominios_permitidos = explode(',', $data);


	            if (in_array($_SERVER['HTTP_HOST'], $subdominios_permitidos)) { ?>

	            <div class="col-12 my-3">
	                <hr>
	                <h3>Modulos de carga y edición de contenido</h3>
	                <hr>
	            </div>

	            <div class="col-6 col-lg-3">
	                <a href="<?php echo CONTEXT ?>admin/objeto/">
	                    <div class="cuadrado"><i class="fa fa-object-ungroup" aria-hidden="true"></i></div>
	                    <span class="nombreM">Objetos</span>
	                </a>
	            </div>
	            <div class="col-6 col-lg-3">
	                <a href="<?php echo CONTEXT ?>admin/evaluacion/">
	                    <div class="cuadrado2"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></div>
	                    <span class="nombreM">Evaluaciones</span>
	                </a>
	            </div>
	            <div class="col-6 col-lg-3">
	                <a href="<?php echo CONTEXT ?>admin/lessons/">
	                    <div class="cuadrado"><i class="fa fa-list-alt" aria-hidden="true"></i></div>
	                    <span class="nombreM">Lecciones</span>
	                </a>
	            </div>


	            <!--
	            TODO POR TERMINAR
	            MODULO AUN NO CONCLUIDO
	            <div class="col-6 col-lg-3">
	                <a href="<?php /*echo CONTEXT */?>admin/cargarinstruccionesejercicios/">
	                    <div class="cuadrado"><i class="fa fa-commenting" aria-hidden="true"></i></div>
	                    <span class="nombreM">Cargar instrucciones evaluación(producto)</span>
	                </a>
	            </div>-->

	            <div class="col-6 col-lg-3">
	                <a href="<?php echo CONTEXT ?>admin/cargarinstruccionessecciones/">
	                    <div class="cuadrado2"><i class="fa fa-file-audio-o" aria-hidden="true"></i></div>
	                    <span class="nombreM">Instrucciones de secciones</span>
	                </a>
	            </div>


	            <div class="col-6 col-lg-3">
	                <a href="<?php echo CONTEXT ?>admin/cargarpreview/">
	                    <div class="cuadrado2"><i class="fa fa-file-video-o" aria-hidden="true"></i></div>
	                    <span class="nombreM">Preview de lecciones</span>
	                </a>
	            </div>

	                <?php
	            }

	        }?>





        </div>
        <!-- Institucional -->
    <?php } else if ($_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 3) { ?>
        <div class="separador" style="margin-top: 15%;"></div>
        <div class="row">
            <?php if ($_SESSION['perfil'] == 3) { ?>
                <div class="col-6 col-lg-3">
                    <a href="<?php echo CONTEXT ?>admin/instituciones/">
                        <div class="cuadrado2"><i class="fa fa-university" aria-hidden="true"></i></div>
                        <span class="nombreM">Instituciones</span>
                    </a>
                </div>
            <?php } ?>

            <div class="col-6 col-lg-3">
                <a href="<?php echo CONTEXT ?>admin/groups/">
                    <div class="cuadrado"><i class="fa fa-object-group" aria-hidden="true"></i></div>
                    <span class="nombreM">Grupos</span>
                </a>
            </div>

            <div class="col-6 col-lg-3">
                <a href="<?php echo CONTEXT ?>admin/usuarios/">
                    <div class="cuadrado2"><i class="fa fa-users" aria-hidden="true"></i></div>
                    <span class="nombreM">Usuarios</span>
                </a>
            </div>

            <div class="col-6 col-lg-3">
                <a href="<?php echo CONTEXT ?>admin/teachers/">
                    <div class="cuadrado"><i class="fa fa-graduation-cap" aria-hidden="true"></i></div>
                    <span class="nombreM">Docentes</span>
                </a>
            </div>

            <div class="col-6 col-lg-3">
                <a href="<?php echo CONTEXT ?>admin/reportes/">
                    <div class="cuadrado2"><i class="fa fa-signal" aria-hidden="true"></i></div>
                    <span class="nombreM">Reportes</span>
                </a>
            </div>
            <?php if($_SESSION['perfil'] == 3){ ?>
                <div class="col-6 col-lg-3">
                    <a href="<?php echo CONTEXT ?>admin/estadisticacliente/no">
                        <div class="cuadrado2"><i class="fa fa-file-text-o" aria-hidden="true"></i></div>
                        <span class="nombreM">Dashboard reporte de usos</span>
                    </a>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</section>

<style>
    .relleno {
        background: #b5b5b5;
    }

    .cuadrado {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 7.5em;
        background: #0a6fb5;
        border-radius: 0.5em;
    }

    .cuadrado2 {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 7.5em;
        background: #2ebebb;
        border-radius: 0.5em;
    }

    .cuadrado .fa, .cuadrado2 .fa {
        font-size: 5em;
        color: #fff;
    }

    a {
        color: #000;
        text-decoration: none !important;
    }

    footer {
        background: #D0D0D0;
    }
</style>