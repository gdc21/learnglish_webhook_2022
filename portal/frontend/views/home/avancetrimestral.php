<section class="container">
    <section id="contenido">
        <?php echo $this->temp['encabezado']; ?>

        <div class="row">
            <div class="col pb-5">
                <?php
                $suma = 0;
                $cantidad = 0;
                $plumaCount = 0;
                $totalPlumas = 0;
                foreach ($this->temp['cantidadPlumas'] as $calificacion) {
                    $totalPlumas += $calificacion['CANTIDAD_EXCERCISES'];
                    if($calificacion['RESULT_EVAL'] != null && $calificacion['SPEAKING'] != null && $calificacion['DOCUMENTO'] != null){
                        $cantidad += 1;
                        $suma += $calificacion['RESULT_EVAL'];
                    }
                    $plumaCount += $calificacion['HECHOS'];
                }
                if($suma != 0 && $cantidad != 0){
                    $res = number_format($suma/$cantidad);
                }else{
                    $res = 0;
                }
                ?>
                <div class="elementos d-flex flex-wrap justify-content-center align-items-center">
                    <div class="pluma w-100 d-block text-center">
                        <img class="d-block mx-auto" src="<?php echo CONTEXT; ?>portal/archivos/archivosCargadosPorEstudiantes/pluma-100.png" alt="" style="margin-left: 20px;">
                    </div>
                    <h3 class="bold d-block"><?php echo $plumaCount."/".$totalPlumas; ?></h3>
                </div>
                <div class="table-responsive">
                    <table class="tabla mx-auto" style="font-size: initial; width: max-content; padding: 3px;">
                        <thead>
                        <th class="py-1">IMG</th>
                        <th class="py-1">Lección</th>
                        <th class="py-1">Ejercicios</th>
                        <th class="py-1">Speaking</th>
                        <th class="py-1">Documento</th>
                        <th class="py-1">Evaluación</th>
                        </thead>
                        <tbody>
                        <?php foreach ($this->temp['cantidadPlumas'] as $pluma){ ?>
                            <tr>
                                <td class="p-1 w-100 text-center">
                                    <img src="<?php echo CONTEXT."portal/archivos/iconosLecciones/n".$pluma['NIVEL']."/m".$pluma['MODULO']."/l".$pluma['LECCION_ORDEN']."/".$pluma['IMAGEN']; ?>" alt="" style="min-width: 20px; max-width: 40% !important;">

                                    <br>
                                    <?php if($pluma['RESULT_EVAL'] != null){ ?>
                                        <i class="fa fa-check-circle" aria-hidden="true"></i>
                                    <?php }else{ ?>
                                        <i class="fa fa-hourglass-half" aria-hidden="true"></i>
                                    <?php }?>
                                </td>
                                <td class="p-1">
                                    <?php echo $pluma['NOMBRE_LECCION']; ?>
                                    <br>
                                    <a target="_blank" href="<?php echo CONTEXT."home/navegar/".$pluma['NIVEL']."_".$pluma['MODULO']."_".$pluma['LECCION']; ?>" class="btn btn-sm my-1 btn-primary" style="padding: 2px 3px; font-size: 13px;">
                                        Continue
                                    </a>
                                </td>
                                <td class="text-center">
                                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGEAAAA1CAIAAADeexIVAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA2hpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDo4MThBODkwQTBEMjA2ODExODhDNkQ3RkJCQ0I1QzRCMiIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpFQTU5OTNBMUEwNDMxMUU1QkIwQkE5NjVDRTcyQTMxMyIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpFQTU5OTNBMEEwNDMxMUU1QkIwQkE5NjVDRTcyQTMxMyIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M2IChNYWNpbnRvc2gpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6MDU4MDExNzQwNzIwNjgxMThDMTRBMjFEQjgxRDI0RTMiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6ODE4QTg5MEEwRDIwNjgxMTg4QzZEN0ZCQkNCNUM0QjIiLz4gPC9yZGY6RGVzY3Jp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" alt="" style="padding: 5px; max-width: 50px !important;" class="my-2">
                                    <br>
                                    <?php echo $pluma['HECHOS']. "/" . $pluma['CANTIDAD_EXCERCISES']; ?>
                                </td>
                                <td class="p-1">
                                    <?php if($pluma['SPEAKING'] != null){ ?>
                                        <i class="fa fa-check-circle" aria-hidden="true" style="background: white; border-radius: 50%; font-size: 20px; color: green; right: 0; margin: 2px;"></i>
                                        <!--<a href="<?php /*echo CONTEXT."portal/archivos/archivosCargadosPorEstudiantes/speaking/".$pluma['SPEAKING']; */?>">
                                                    Descargar <br>
                                                    <i class="fa fa-download" aria-hidden="true"></i>
                                                </a>-->
                                    <?php }else{ ?>
                                        Not loaded yet
                                    <?php } ?>
                                </td>
                                <td class="p-1">
                                    <?php if($pluma['DOCUMENTO'] != null){ ?>
                                        <i class="fa fa-check-circle" aria-hidden="true" style="background: white; border-radius: 50%; font-size: 20px; color: green; right: 0; margin: 2px;"></i>
                                        <!--<a href="<?php /*echo CONTEXT."portal/archivos/archivosCargadosPorEstudiantes/documentos/".$pluma['DOCUMENTO']; */?>">
                                                    Descargar <br>
                                                    <i class="fa fa-download" aria-hidden="true"></i>
                                                </a>-->
                                    <?php }else{ ?>
                                        Not loaded yet
                                    <?php } ?>
                                </td>

                                <td class="p-1"><?php echo $pluma['RESULT_EVAL'] ? $pluma['RESULT_EVAL']: 'Pending'; ?></td>
                            </tr>
                        <?php } ?>
                            <tr>
                                <td class="w-100 py-3" colspan="5">
                                    <b class="position-relative">Promedio general de evaluaciones concluidas:</b>
                                </td>
                                <td>
                                    <b><?php echo $res; ?>/100</b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <button style="position: absolute; right: 30px;" onclick="history.back()" class="btn btn-sm btn-primary">Volver</button>

            </div>
        </div>


    </section>
</section>
