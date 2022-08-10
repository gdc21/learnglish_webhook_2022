<section  id="contenido"    class="my-0">
    <?php #echo $this->temp['encabezado']; ?>
    <?php #var_dump($this->temp['menuItems']); ?>

</section>
<div class="dashboard">
    <div class="menuSeccion">
        <div class="clientes menuSeccionItem">
            <a class="menuSeccionItemEnlace" href="<?php echo CONTEXT; ?>admin/estadisticasSistema/0/general">
                <button class="menuSeccionItemEnlaceButton" >
                    <i class="fa fa-home"></i> <br>
                    Inicio
                </button>
            </a>
        </div>
        <div class="alumnos menuSeccionItem">
            <a class="menuSeccionItemEnlace" href="<?php echo CONTEXT; ?>/admin/estadisticasSistema/0/alumnos">
                <button class="menuSeccionItemEnlaceButton">
                    <i class="fa fa-users"></i> <br>
                    Alumnos
                </button>
            </a>
        </div>
        <div class="clientes menuSeccionItem">
            <a class="menuSeccionItemEnlace" href="<?php echo CONTEXT; ?>admin/estadisticasSistema/0/clientes">
                <button class="menuSeccionItemEnlaceButton" >
                    <i class="fa fa-users"></i> <br>
                    Clientes
                </button>
            </a>
        </div>
        <div class="instituciones menuSeccionItem">
            <a class="menuSeccionItemEnlace" href="<?php echo CONTEXT; ?>admin/estadisticasSistema/0/instituciones">
                <button class="menuSeccionItemEnlaceButton">
                    <i class="fa fa-building"></i> <br>
                    Instituciones
                </button>
            </a>
        </div>
        <div class="alumnos menuSeccionItem">
            <a class="menuSeccionItemEnlace" href="<?php echo CONTEXT; ?>/admin/estadisticasSistema/0/alumnos">
                <button class="menuSeccionItemEnlaceButton">
                    <i class="fa fa-users"></i> <br>
                    Grupos
                </button>
            </a>
        </div>
        <div class="docentes menuSeccionItem">
            <a class="menuSeccionItemEnlace" href="<?php echo CONTEXT; ?>/admin/estadisticasSistema/0/docentes">
                <button class="menuSeccionItemEnlaceButton">
                    <i class="fa fa-graduation-cap"></i> <br>
                    Docentes
                </button>
            </a>
        </div>
        <div class="niveles menuSeccionItem">
            <a class="menuSeccionItemEnlace" href="<?php echo CONTEXT; ?>/admin/estadisticasSistema/0/niveles">
                <button class="menuSeccionItemEnlaceButton">
                    <i class="fa fa-trophy"></i> <br>
                    Niveles
                </button>
            </a>
        </div>
        <div class="grupos menuSeccionItem">
            <a class="menuSeccionItemEnlace" href="<?php echo CONTEXT; ?>/admin/estadisticasSistema/0/modulos">
                <button class="menuSeccionItemEnlaceButton">
                    <i class="fa fa-star"></i> <br>
                    Modulos
                </button>
            </a>
        </div>


    </div>
    <?php #var_dump($this->temp['vistaNombre'] ); ?>
    <div class="contenidoWeb">
        <?php
        /**
        * VISTA general principal del dashboard
        */
        if($this->temp['vistaNombre'] == 'general') { ?>
           <div class="row">
                <!--Primeros 2 elementos-->
                <div class="col-md-3 mx-auto contenidoWebItem contenidoWebItem-texto">
                    <div class="card h-auto w-100 m-2">
                        <div class="card-body">
                            <p class="contenidoWebItemTexto">
                                <?php echo number_format($this->temp['tiempoSemanaMinutosSimple'][0]['tiempo']); ?>
                            </p>
                            <p class="contenidoWebItemTextoMediano">
                                Minutos de uso del sistema esta semana por alumnos
                            </p>
                        </div>
                    </div>

                    <div class="card h-auto w-100 m-2">
                        <div class="card-body">
                            <p class="contenidoWebItemTexto">
                                <?php echo number_format($this->temp['tiempoMesMinutosSimple'][0]['tiempo']); ?>
                            </p>
                            <p class="contenidoWebItemTextoMediano">
                                Minutos de uso del sistema este mes por alumnos
                            </p>
                        </div>
                    </div>
                </div>
                <!--Grafica centras de dias de la semana-->
                <div class="col-md-9 col-lg-6 mx-auto contenidoWebItem">
                    <div class="card h-auto w-100 m-2">
                        <div class="card-body">
                            <figure class="highcharts-figure">
                                <div id="tiempoMesMinutos"></div>
                            </figure>
                        </div>
                    </div>
                </div>
                <!--Minutos 2 totales del sistema-->
                <div class="col-lg-3 mx-auto contenidoWebItem contenidoWebItem-texto">
                    <div class="card h-auto w-100 m-2">
                        <div class="card-body">
                            <p class="contenidoWebItemTexto">
                                <?php echo number_format($this->temp['tiempoTotalGeneral'][0]['tiempo']); ?>
                            </p>
                            <p class="contenidoWebItemTextoMediano">
                                Minutos totales de uso del sistema por alumnos
                            </p>
                        </div>
                    </div>
                    <!--Hacer-->
                    <div class="card h-auto w-100 m-2">
                        <div class="card-body">
                            <p class="contenidoWebItemTexto">
                                <?php echo number_format($this->temp['tiempoTotalPorDocentes'][0]['tiempo']); ?>
                            </p>
                            <p class="contenidoWebItemTextoMediano">
                                Minutos totales de uso del sistema por docentes
                            </p>
                        </div>
                    </div>
                </div>
                <!--Tiempos de uso en mes-->
                <div class="col-lg-6 mx-auto">
                    <div class="card h-auto w-100 m-2">
                        <div class="card-body">
                            <figure class="highcharts-figure">
                                <div id="tiempoSemanaMinutos"></div>
                            </figure>

                        </div>
                    </div>
                </div>
                <!--Tiempos por niveles-->
                <div class="col-lg-6 mx-auto contenidoWebItem contenidoWebItem-texto">
                    <div class="card h-auto w-100 m-2">
                        <div class="card-body">
                            <figure class="highcharts-figure">
                                <div id="tiempoTotalPorNiveles"></div>
                            </figure>
                        </div>
                    </div>
                </div>
                <!--Tiempos por modulos-->
                <div class="col-lg-6 mx-auto contenidoWebItem contenidoWebItem-texto">
                    <div class="card h-auto w-100 m-2">
                        <div class="card-body">
                            <figure class="highcharts-figure">
                                <div id="tiempoTotalPorModulos"></div>
                            </figure>
                        </div>
                    </div>
                </div>

                <div class="col-md-2 mx-auto contenidoWebItem contenidoWebItem-texto">
                    <div class="card h-auto w-100 m-2">
                        <div class="card-body">
                            <p class="contenidoWebItemTexto">
                                <?php echo number_format($this->temp['tiempoTotalPorAdmins'][0]['tiempo']); ?>
                            </p>
                            <p class="contenidoWebItemTextoMediano">
                                Minutos de uso del sistema esta semana por administradores
                            </p>
                        </div>
                    </div>
                </div>








            </div>








        <?php }
        /**
        * VISTA clientes principal para visualizar
        */
        elseif(
                $this->temp['vistaNombre'] == 'clientes' ||
                $this->temp['vistaNombre'] == 'niveles' ||


                $this->temp['vistaNombre'] == 'modulos' ||
                $this->temp['vistaNombre'] == 'PrimariaInstitucion' ||
                $this->temp['vistaNombre'] == 'SecundariaInstitucion' ||
                $this->temp['vistaNombre'] == 'PreescolarInstitucion' ||


                $this->temp['vistaNombre'] == 'alumnos' ||
                ($this->temp['vistaNombre'] == 'instituciones' && $this->temp['id'] == 0) ||
                $this->temp['vistaNombre'] == 'alumsDeInstiucionEspecifica' ||
                $this->temp['vistaNombre'] == 'docentesInstitucion' ||


                $this->temp['vistaNombre'] == 'alumnosDeGrupo' ||
                $this->temp['vistaNombre'] == 'docentes' ||
                $this->temp['vistaNombre'] == 'grupos'){ ?>
           <div class="row justify-content-center">

           <?php if(!isset($this->temp['IDSestudiantesDeDocente'])){  ?>

                <?php if($this->temp['vistaNombre'] == 'modulos'  ||
                         (
                         ($this->temp['vistaNombre'] == 'PrimariaInstitucion' && $this->temp['mostrarGrafico']) ||
                         ($this->temp['vistaNombre'] == 'SecundariaInstitucion' && $this->temp['mostrarGrafico']) ||
                         ($this->temp['vistaNombre'] == 'PreescolarInstitucion' && $this->temp['mostrarGrafico'])
                         )
               ) { ?>
                   <!--Tiempos por modulos-->
                   <div class="col-lg-6 mx-auto contenidoWebItem contenidoWebItem-texto">
                       <div class="card h-auto w-100 m-2">
                           <div class="card-body">
                               <figure class="highcharts-figure">
                                   <div id="tiempoTotalPorModulos2"></div>
                               </figure>
                           </div>
                       </div>
                   </div>
                   <div class="w-100 my-2"></div>
               <?php
                } ?>


                <?php
                /**
                * Mostramos los elementos azules solo cuando las vistas lo soliciten, de lo contrario se personaliza
                */

                if( $this->temp['vistaNombre'] != 'niveles' &&
                    $this->temp['vistaNombre'] != 'modulos' ){


                    if(!empty($this->temp['elementos'])){

                        foreach ($this->temp['elementos'] as $key => $itemMenu){ ?>
                            <div class="col-6 col-lg-3 elementoListado">
                                <?php
                                if($this->temp['vistaGruposParaVisualizarAlumnos']) { ?>
                                    <a href="<?php echo CONTEXT ?>admin/estadisticasSistema/<?php echo $itemMenu['id']."/".$itemMenu['rutaParaVerAlumnosDeGrupo']; ?>">
                                <?php
                                }else{ ?>
                                    <a class="enlaceVistaNombreClientes" href="<?php echo CONTEXT ?>admin/estadisticasSistema/<?php echo $itemMenu['id']."/".$itemMenu['tipoElemento']; ?>">
                                <?php
                                } ?>
                                        <div class="cuadrado<?php echo rand(1,2) == 2 ? '2':''?>">
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                        </div>
                                        <span class="nombreM">
                                        <?php echo $itemMenu['nombre']; ?>
                                    </span>
                                    </a>
                            </div>
                            <?php
                        }
                    }else{ ?>
                        <h5 class="w-100 text-center mt-5">Por el momento no hay elementos para mostrar</h5>

                    <?php }
                    /**
                     * Si hay un elementos2 significa que alguien quiere ver los grupos de un determinado nivel
                     */
                    if(isset($this->temp['elementos2'])){ ?>
                        <hr class="mt-3">
                        <h3 class="w-100 text-center">Listado de Grupos</h3>
                        <hr class="mt-3">
                        <?php
                        foreach ($this->temp['elementos2'] as $key => $itemMenu){ ?>
                            <div class="col-6 col-lg-3 elementoListado">
                                <?php
                                if($this->temp['vistaGruposParaVisualizarAlumnos']) { ?>
                                <a href="<?php echo CONTEXT ?>admin/estadisticasSistema/<?php echo $itemMenu['id']."/".$itemMenu['rutaParaVerAlumnosDeGrupo']; ?>">
                                    <?php
                                    }else{ ?>
                                    <a class="enlaceVistaNombreClientes" href="<?php echo CONTEXT ?>admin/estadisticasSistema/<?php echo $itemMenu['id']."/".$itemMenu['tipoElemento']; ?>">
                                        <?php
                                        } ?>
                                        <div class="cuadrado<?php echo rand(1,2) == 2 ? '2':''?>">
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                        </div>
                                        <span class="nombreM">
                                    <?php echo $itemMenu['nombre']; ?>
                                </span>
                                    </a>
                            </div>
                            <?php
                        }
                    }



                }elseif ($this->temp['vistaNombre'] == 'niveles'){ ?>
                    <!--Tiempos por modulos-->
                    <div class="col-lg-6 mx-auto contenidoWebItem contenidoWebItem-texto">
                        <div class="card h-auto w-100 m-2">
                            <div class="card-body">
                                <figure class="highcharts-figure">
                                    <div id="tiempoTotalPorNiveles2"></div>
                                </figure>
                            </div>
                        </div>
                    </div>
                    <div class="w-100 my-2"></div>

                    <div class="col-12 text-center my-3 bold">
                        <h4>Seleccione un nivel para visualizar grupos/docentes</h4>
                    </div>

                    <div class="col-5 col-md-3">
                        <a href="<?php echo $this->temp['enlaces'][0]['url']; ?>">
                            <img src="<?php echo IMG.$this->temp['enlaces'][0]['imagen'] ?>">
                            <div class="level_info">
                                <h3>Preescolar</h3>
                            </div>
                        </a>
                    </div>
                    <div class="col-5 col-md-3">
                        <a href="<?php echo $this->temp['enlaces'][1]['url']; ?>">
                            <img src="<?php echo IMG.$this->temp['enlaces'][1]['imagen'] ?>">
                            <div class="level_info">
                                <h3>Primaria</h3>
                            </div>
                        </a>
                    </div>
                    <div class="col-5 col-md-3">
                        <a href="<?php echo $this->temp['enlaces'][2]['url']; ?>">
                            <img src="<?php echo IMG.$this->temp['enlaces'][2]['imagen'] ?>">
                            <div class="level_info">
                                <h3>Secundaria</h3>
                            </div>
                        </a>
                    </div>

                    <div class="w-100 my-2"></div>

                    <div class="col-6 col-lg-3 elementoListado">
                       <a href="<?php echo CONTEXT ?>admin/estadisticasSistema/0/modulos">
                           <div class="cuadrado<?php echo rand(1,2) == 2 ? '2':''?>">
                               <i class="fa fa-user" aria-hidden="true"></i>
                           </div>
                           <span class="nombreM">
                                 Ver Modulos
                           </span>
                       </a>
                   </div>
                    <div class="col-6 col-lg-3 elementoListado">
                        <a href="<?php echo CONTEXT ?>admin/estadisticasSistema/0/alumnos">
                            <div class="cuadrado<?php echo rand(1,2) == 2 ? '2':''?>">
                                <i class="fa fa-user" aria-hidden="true"></i>
                            </div>
                            <span class="nombreM">
                                 Ver alumnos
                           </span>
                        </a>
                    </div>
                <?php
                }
                elseif ($this->temp['vistaNombre'] == 'modulos'){ ?>
                <div class="col-6 col-lg-3 elementoListado">
                    <?php if($this->temp['hayIdInstitucion']) { ?>
                        <a href="<?php echo CONTEXT."admin/estadisticasSistema/".$this->temp['id']."/instituciones" ?>">
                    <?php }else{ ?>
                        <a href="<?php echo CONTEXT ?>admin/estadisticasSistema/0/niveles">
                    <?php } ?>
                       <div class="cuadrado<?php echo rand(1,2) == 2 ? '2':''?>">
                           <i class="fa fa-user" aria-hidden="true"></i>
                       </div>
                       <span class="nombreM">
                             Ver niveles
                       </span>
                   </a>
                </div>
                <div class="col-6 col-lg-3 elementoListado">
                        <?php if($this->temp['hayIdInstitucion']) { ?>
                        <a href="<?php echo CONTEXT."admin/estadisticasSistema/".$this->temp['id']."/alumsDeInstiucionEspecifica" ?>">
                        <?php }else{ ?>
                        <a href="<?php echo CONTEXT ?>admin/estadisticasSistema/0/niveles">
                            <?php } ?>
                           <div class="cuadrado<?php echo rand(1,2) == 2 ? '2':''?>">
                               <i class="fa fa-user" aria-hidden="true"></i>
                           </div>
                           <span class="nombreM">
                                 Ver alumnos
                           </span>
                       </a>
                </div>
                <?php
                }
           }else{
                if(!empty($this->temp['elementos'])){ ?>
                    <a href="<?php echo $_SERVER['HTTP_REFERER'] ?>">Regresar</a>
                    <div class="col-8 mx-auto">
                        <figure class="highcharts-figure">
                            <div id="alumnosCU"></div>
                        </figure>

                    </div>
                    <div class="col-10 mx-auto">
                       <h3>Listado de alumnos del grupo</h3>
                       <p class="p-0 m-o">
                           Para medir el progreso de un alumno debera apreciar un lapso de uso en la grafica anterior,
                           en caso de ser 0 minutos o no aparecer en la grafica solamente ha iniciado sesión.
                       </p>
                        <table class=" mx-auto" id="dataTableAlumnos2" style="width: 100%;">
                            <thead class="table-hover inverse text-white">
                                <th>Id alumno</th>
                                <th>*</th>
                                <th>Nombre</th>
                                <th>Usuario Sistema</th>
                                <th>Genero</th>
                                <th>Estadistica</th>
                                <th>Ha ingresado</th>
                                <th>*</th>
                            </thead>
                            <tbody>

                            <?php foreach ($this->temp['elementos'] as $key => $itemMenu){ ?>
                                <tr>
                                    <td>
                                        <?php echo $itemMenu['id']; ?>
                                    </td>
                                    <td>
                                        <i class='fa <?php echo $itemMenu['sexo'] == 'H' ? 'fa-male':'fa-female'; ?>' aria-hidden='true' style="font-size: 25px;"></i>

                                    </td>
                                    <td>
                                        <?php echo $itemMenu['nombre']; ?>
                                    </td>
                                    <td>
                                        <?php echo $itemMenu['usuarioDeSistema']; ?>
                                    </td>
                                    <td>
                                        <?php echo $itemMenu['sexo']; ?>
                                    </td>
                                    <td>

                                        <!--Modal que crea listado de los tuiempos que ha estado el alumno-->
                                        <?php foreach($this->temp['estadisticasPorAlumno'] as $tiempoAlumno){ ?>
                                            <?php if($tiempoAlumno['id_usuario'] == $itemMenu['id']){ ?>
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAlumno_<?php echo $itemMenu['id']; ?>">
                                                    Ver analisis
                                                </button>
                                            <?php break; } ?>
                                        <?php } ?>
                                        <!--Modal que crea listado de los tuiempos que ha estado el alumno-->
                                    </td>
                                    <td>
                                        <?php #var_dump($this->temp['alumnosQueNoHanUsadoElSistema']);
                                        if($this->temp['alumnosQueNoHanUsadoElSistema'] != false){
                                            $no = 1;
                                            foreach ($this->temp['alumnosQueNoHanUsadoElSistema'] as $keyAl => $alNoUsado){ ?>
                                                <?php
                                                if($alNoUsado['id'] == $itemMenu['id']){
                                                    $no = 0; ?>
                                                    <i class="fa fa-window-close" style="font-size: 25px;"></i>
                                                <?php
                                                }
                                            } ?>
                                            <?php
                                            if($no){ ?>
                                                <i class="fa fa-star" style="font-size: 25px;"></i>
                                            <?php
                                            }
                                        }else{ ?>
                                            <i class="fa fa-window-close" style="font-size: 25px;"></i>
                                        <?php
                                        }?>
                                    </td>
                                    <td>
                                        <a class="btn btn-primary btn-sm" href="<?php echo CONTEXT ?>admin/editUsuario/<?php echo $itemMenu['id']; ?>">Editar</a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php
                }else{ ?>
                    <h5 class="w-100 text-center mt-5">Por el momento no hay elementos para mostrar</h5>

                <?php
                }
            } ?>
           </div>




        <?php }
        /**
         * VISTA Mostrara los niveles contratados por la institucion
         */
        elseif($this->temp['vistaNombre'] == 'instituciones'){ ?>



            <div class="row flex-wrap d-flex text-center justify-content-center">
                <div class="col-5 col-md-3">
                    <a href="<?php echo $this->temp['enlaces'][0]['url']; ?>">
                        <img src="<?php echo IMG.$this->temp['enlaces'][0]['imagen'] ?>">
                        <div class="level_info">
                            <h3>Preescolar</h3>
                        </div>
                    </a>
                </div>
                <div class="col-5 col-md-3">
                    <a href="<?php echo $this->temp['enlaces'][1]['url']; ?>">
                        <img src="<?php echo IMG.$this->temp['enlaces'][1]['imagen'] ?>">
                        <div class="level_info">
                            <h3>Primaria</h3>
                        </div>
                    </a>
                </div>
                <div class="col-5 col-md-3">
                    <a href="<?php echo $this->temp['enlaces'][2]['url']; ?>">
                        <img src="<?php echo IMG.$this->temp['enlaces'][2]['imagen'] ?>">
                        <div class="level_info">
                            <h3>Secundaria</h3>
                        </div>
                    </a>
                </div>
                <div class="w-100 my-3"></div>
                <div class="col-md-6 mt-4">
                    <a class="btn btn-info" href="<?php echo CONTEXT."admin/estadisticasSistema/".$this->temp['id']."/alumsDeInstiucionEspecifica"; ?>">
                        <div class="level_info">
                            <h3 class="text-white">Ver alumnos de la institucion</h3>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 mt-4">
                    <a class="btn btn-info" href="<?php echo CONTEXT."admin/estadisticasSistema/".$this->temp['id']."/docentesInstitucion"; ?>">
                        <div class="level_info">
                            <h3 class="text-white">Ver docentes de la institucion</h3>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 mt-4">
                    <a class="btn btn-info" href="<?php echo CONTEXT."admin/estadisticasSistema/".$this->temp['id']."/modulos"; ?>">
                        <div class="level_info">
                            <h3 class="text-white">Ver modulos de la institucion</h3>
                        </div>
                    </a>
                </div>

                <div class="w-100 my-3"></div>
                <h3>Listado de grupos de la institucion:</h3>

                <?php
                foreach ($this->temp['elementos'] as $key => $itemMenu){ ?>
                    <div class="col-6 col-lg-3 elementoListado">
                        <?php if($this->temp['vistaGruposParaVisualizarAlumnos']) { ?>
                        <a href="<?php echo CONTEXT ?>admin/estadisticasSistema/<?php echo $itemMenu['id']."/".$itemMenu['rutaParaVerAlumnosDeGrupo']; ?>">
                            <?php }else{    ?>
                            <a class="enlaceVistaNombreClientes" href="<?php echo CONTEXT ?>admin/estadisticasSistema/<?php echo $itemMenu['id']."/".$itemMenu['tipoElemento']; ?>">
                                <?php }    ?>
                                <div class="cuadrado<?php echo rand(1,2) == 2 ? '2':''?>">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                </div>
                                <span class="nombreM">
                                            <?php echo $itemMenu['nombre']; ?>
                                        </span>
                            </a>
                    </div>
                    <?php
                } ?>
            </div>

        <?php }?>
    </div>
</div>







<?php #var_dump($this->temp['estadisticasPorAlumno']);
if($this->temp['vistaNombre'] == 'docentes' || $this->temp['vistaNombre'] == 'alumnosDeGrupo' || $this->temp['vistaNombre'] == 'alumsDeInstiucionEspecifica'){
    foreach ($this->temp['elementos'] as $key => $itemMenu){ ?>

        <!-- Modal -->
        <div class="modal fade" id="modalAlumno_<?php echo $itemMenu['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <h4>
                                Analisis de tiempo del alumno: <br>
                                <small><?php echo $itemMenu['nombre']; ?></small> <br>
                                <i>desglozado por nivel, modulo y lección</i>
                            </h4>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <table class="table-striped" style="width: 100%;">
                            <thead>
                                <th>Fecha</th>
                                <th>Nivel</th>
                                <th>Modulo</th>
                                <th>Leccion</th>
                                <th>Tiempo</th>
                            </thead>
                            <tbody>
                                <?php foreach($this->temp['estadisticasPorAlumno'] as $key => $tiempoAlumno){ ?>
                                    <?php if($tiempoAlumno['id_usuario'] == $itemMenu['id']){ ?>
                                        <tr>
                                            <td style="padding: 5px 0px;"><?php echo $tiempoAlumno['dia']; ?></td>
                                            <td style="padding: 5px 0px;"><?php echo $tiempoAlumno['nivel']; ?></td>
                                            <td style="padding: 5px 0px;"><?php echo $tiempoAlumno['modulo']; ?></td>
                                            <td style="padding: 5px 0px;"><?php echo $tiempoAlumno['leccion']; ?></td>
                                            <?php if($tiempoAlumno['tiempo'] > 0) { ?>
                                                <td style="padding: 5px 0px;"><?php echo $tiempoAlumno['tiempo']; ?> minutos</td>
                                            <?php }else{ ?>
                                                <td style="padding: 5px 0px;">El alumno solo inicio sesión</td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

<?php
    }
}
#var_dump($this->temp['estudiantesDeDocente']);
?>








<style>
    /*####################################################*/
    /*Estilos de la pagina clientes*/
    .relleno {
        background: #b5b5b5;
    }
    .cuadrado, .cuadrado2{
        display: flex;
        justify-content: center;
        align-items: center;
        width: 90%;
        height: 7.5em;
        margin: 0 auto;
        border-radius: 0.5em;
    }
    .cuadrado{
        background: #0a6fb5;
    }
    .cuadrado2{
        background: #2ebebb;
    }
    .cuadrado .fa, .cuadrado2 .fa{
        font-size: 5em;
        color: #fff;
    }
    .enlaceVistaNombreClientes{
        color: #000;
        text-decoration: none !important;
    }
    /*####################################################*/
    /*Estilos de la pagina general*/
    footer{
        display: none;
    }
    .dashboard{
        position: relative;
        display: block;
        min-height: 100vh;
        width: 100%;
    }
    .menuSeccion{
        width: 100px;
        background: black;
        color: white;
        display: flex;
        justify-content: space-around;
        flex-direction: column;
        position: absolute;
        top: 0;
        left: 0;
        height: 100vh;

    }
    .menuSeccionItem{
        text-align: center;
    }
    .menuSeccionItemEnlace{
        color: white;
        font-size: 15px;
        text-decoration: none;

    }
    .menuSeccionItemEnlaceButton:hover{
        background: white;
        color: black !important;
    }
    .menuSeccionItemEnlaceButton{
        background: transparent;
        border: 0;
        color: white;
        width: 100%;
    }
    /*$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$*/
    .contenidoWeb{
        width: calc(100% - 100px);
        min-height: 100vh;
        position: absolute;
        top: 0;
        right: 0;
    }
    .contenidoWebItemTexto{
        font-family:;
    }
    .contenidoWebItem-texto{
        display: flex !important;
        justify-content: center !important;
        align-content: center !important;
        flex-wrap: wrap !important;
        text-align: center !important;
    }
    .contenidoWebItem-texto p:nth-child(1){
        font-size: 40px !important;
        font-weight: bold !important;
    }

    /*####################################################*/
</style>

<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script>
    <?php
    /**
     * VISTA clientes principal para visualizar
     */
    if($this->temp['vistaNombre'] == 'general'){ ?>

        Highcharts.chart('tiempoSemanaMinutos', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: 0,
                plotShadow: false
            },
            title: {
                text: 'Uso de sistema<br> por día <br>en esta semana',
                align: 'center',
                verticalAlign: 'middle',
                y: 60
            },
            plotOptions: {
                pie: {
                    dataLabels: {
                        enabled: true,
                        distance: -50,
                        style: {
                            fontWeight: 'bold',
                            color: 'white'
                        }
                    },
                    startAngle: -90,
                    endAngle: 90,
                    center: ['50%', '75%'],
                    size: '110%'
                }
            },
            series: [{
                type: 'pie',
                name: 'Minutos',
                innerSize: '50%',

                data: [
                    <?php foreach($this->temp['tiempoSemanaMinutos'] as $dia) { ?>

                        ['<?php echo $dia['diaSemana']; ?>', <?php echo $dia['tiempo'] > 0 ? $dia['tiempo']:0; ?>],
                    <?php } ?>
                ]
            }]
        });
        /*###################################*/
        Highcharts.chart('tiempoMesMinutos', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Tiempo de uso general en este mes:'
            },

            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            },
            series: [{
                name: 'Minutos',
                colorByPoint: true,
                data: [
                    <?php foreach($this->temp['tiempoMesMinutos'] as $dia) { ?>
                        {
                            name: '<?php echo $dia['diaMes']; ?>',
                            y: <?php echo $dia['tiempo'] > 0 ? $dia['tiempo']:0; ?>,
                            sliced: true,
                            selected: true
                        },
                    <?php } ?>
                ]
            }]
        });
        /*##################################*/
        Highcharts.chart('tiempoTotalPorNiveles', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: 0,
                plotShadow: false
            },
            title: {
                text: 'Uso total <br>de sistema<br> por niveles',
                align: 'center',
                verticalAlign: 'middle',
                y: 60
            },
            plotOptions: {
                pie: {
                    dataLabels: {
                        enabled: true,
                        distance: -50,
                        style: {
                            fontWeight: 'bold',
                            color: 'white'
                        }
                    },
                    startAngle: -90,
                    endAngle: 90,
                    center: ['50%', '75%'],
                    size: '110%'
                }
            },
            series: [{
                type: 'pie',
                name: 'Minutos',
                innerSize: '60%',

                data: [
                    <?php foreach($this->temp['tiempoTotalPorNiveles'] as $dia) { ?>

                    ['<?php echo $dia['nivel']; ?>', <?php echo $dia['tiempo'] > 0 ? $dia['tiempo']:0; ?>],
                    <?php } ?>
                ]
            }]
        });
        /*###########################################*/
        Highcharts.chart('tiempoTotalPorModulos', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Tiempo total de uso por cada modulo'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            type: 'category',
            labels: {
                rotation: -65,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Minutos'
            }
        },
        legend: {
            enabled: false
        },
        tooltip: {
            pointFormat: 'Tiempo: <b>{point.y} minutos</b>'
        },
        series: [{
            name: 'Population',
            data: [
                <?php foreach($this->temp['tiempoTotalPorModulos'] as $dia) { ?>

                ['<?php echo $dia['modulo']; ?>', <?php echo $dia['tiempo'] > 0 ? $dia['tiempo']:0; ?>],
                <?php } ?>

            ],
            dataLabels: {
                enabled: true,
                rotation: -90,
                color: '#FFFFFF',
                align: 'right',
                format: '{point.y:.1f}', // one decimal
                y: 10, // 10 pixels down from the top
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        }]
    });
    <?php }
    elseif($this->temp['vistaNombre'] == 'modulos'  || $this->temp['vistaNombre'] == 'PrimariaInstitucion' || $this->temp['vistaNombre'] == 'SecundariaInstitucion' || $this->temp['vistaNombre'] == 'PreescolarInstitucion'){ ?>
        /*###########################################*/
        Highcharts.chart('tiempoTotalPorModulos2', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Tiempo total de uso por cada modulo'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            type: 'category',
            labels: {
                rotation: -65,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Minutos'
            }
        },
        legend: {
            enabled: false
        },
        tooltip: {
            pointFormat: 'Tiempo: <b>{point.y} minutos</b>'
        },
        series: [{
            name: 'Population',
            data: [
                <?php foreach($this->temp['tiempoTotalPorModulos'] as $dia) { ?>

                ['<?php echo $dia['modulo']; ?>', <?php echo $dia['tiempo']; ?>],
                <?php } ?>

            ],
            dataLabels: {
                enabled: true,
                rotation: -90,
                color: '#FFFFFF',
                align: 'right',
                format: '{point.y:.1f}', // one decimal
                y: 10, // 10 pixels down from the top
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        }]
    });
    <?php }




    elseif($this->temp['vistaNombre'] == 'niveles'){ ?>
        /*###########################################*/
        Highcharts.chart('tiempoTotalPorNiveles2', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: 0,
                plotShadow: false
            },
            title: {
                text: 'Uso total <br>de sistema<br> por niveles',
                align: 'center',
                verticalAlign: 'middle',
                y: 60
            },
            plotOptions: {
                pie: {
                    dataLabels: {
                        enabled: true,
                        distance: -50,
                        style: {
                            fontWeight: 'bold',
                            color: 'white'
                        }
                    },
                    startAngle: -90,
                    endAngle: 90,
                    center: ['50%', '75%'],
                    size: '110%'
                }
            },
            series: [{
                type: 'pie',
                name: 'Minutos',
                innerSize: '60%',

                data: [
                    <?php foreach($this->temp['tiempoTotalPorNiveles'] as $dia) { ?>

                    ['<?php echo $dia['nivel']; ?>', <?php echo $dia['tiempo'] > 0 ? $dia['tiempo']:0; ?>],
                    <?php } ?>
                ]
            }]
        });
    <?php }

        /**
        * VISTA clientes principal para visualizar
        */
    elseif( $this->temp['vistaNombre'] == 'alumnosDeGrupo' ||
            $this->temp['vistaNombre'] == 'alumsDeInstiucionEspecifica' ||
            $this->temp['vistaNombre'] == 'docentes'
    ){ ?>

        // Grafica vertical por alumno
        Highcharts.chart('alumnosCU', {
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Alumnos que han empleado el sistema.'
            },
            subtitle: {
                text: 'Presiona la columna del alumno para mostrar detalles por día de uso del sistema.'
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Minutos en sistema'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y} minutos'
                    }
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.data.drilldown}</span><br>',
                pointFormat: '<span>{point.name}</span>: <b>{point.y} minutos</b> en total<br/>'
            },
            series: [

                {
                    name: "Alumno",
                    colorByPoint: true,
                    data: [

                        <?php
                        foreach ($this->temp['IDSestudiantesDeDocente'] as $key => $elementoTranscurso){
                            if($this->temp['IDSestudiantesDeDocente'][$key]['sumaTiempo'] > 0){ ?>
                                {
                                    name: "<?php echo $this->temp['IDSestudiantesDeDocente'][$key]['nombre']; ?>",
                                    y: <?php echo $this->temp['IDSestudiantesDeDocente'][$key]['sumaTiempo'] > 0 ? $this->temp['IDSestudiantesDeDocente'][$key]['sumaTiempo'] : 0; ?>,
                                    drilldown: "alumno_<?php echo $elementoTranscurso['id']; ?>"
                                },
                            <?php
                            }

                        }?>
                    ]
                }
            ],
            drilldown: {
                breadcrumbs: {
                    position: {
                        align: 'right'
                    }
                },
                series: [
                    <?php foreach ($this->temp['IDSestudiantesDeDocente'] as $elementoTranscursoID){ ?>
                        {
                            name: "Estudiante",
                            id: "alumno_<?php echo $elementoTranscursoID['id']; ?>",
                            data: [

                                <?php foreach ($this->temp['estudiantesDeDocente'] as $elementoTranscurso){ ?>
                                    <?php if($elementoTranscursoID['id'] == $elementoTranscurso['id']) { ?>
                                    [
                                        "<?php echo $elementoTranscurso['fecha']; ?>",
                                        <?php echo $elementoTranscurso['tiempo'] > 0 ? $elementoTranscurso['tiempo']: 0; ?>
                                    ],
                                    <?php } ?>
                                <?php } ?>
                            ]
                        },
                    <?php
                    }
                    ?>

                ]
            }
        });
        $(document).ready( function () {
            $('#dataTableAlumnos').DataTable({
            });
            $('#dataTableAlumnos2').DataTable({
            });
        } );

    <?php } ?>


</script>