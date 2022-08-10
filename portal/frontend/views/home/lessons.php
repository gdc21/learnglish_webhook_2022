<?php $lock = $this->temp['bloqueo']; ?>

<style>
    button.basico.titulo{
        border-color: #<?= $this->temp['color'] ?>;
    }

    span.lessonNum{
        color: #<?= $this->temp['color'] ?> !important;
    }

    button.basico span, .regresar.basico.menu-principal{
        color: #<?= $this->temp['color']?>;
        text-decoration: none;
    }

    <?php $long = strlen($this->temp['modulo']['nombre']); if(  $long > 21){
        $width= 265 + ( ($long - 21) * 7.5);	?>
    section button {
        width: <?=$width;?>px;
    }
    <?php } ?>
    .relleno{
        background: #<?php echo $this->temp['color']; ?>;
        color: #fff;
    }

</style>
<div class="container mt-5" style="max-width: 90%; margin: 0 auto;">
    <div class="row">
        <div class="col">
            <?php echo $this->temp['encabezado'];?>
        </div>
    </div>
</div>
<div class="container" >
    <div class="row">
        <?php
        $i = 1;
        foreach ( $this->temp ['lecciones'] as $lession ) {
            // Validacion original. Bloqueo secuencial de lecciones
            /*if ($_SESSION['perfil'] == 2 && $lock != "loock") {
                if ($this->temp['leccion_actual'] >= $lession['id']) {
                    $lock = "";
                } else {
                    $lock = "loock";
                }
            }*/

            // Validación por acceso con grupos. Bloqueo de lecciones por criterio del docente
            if ($_SESSION['perfil'] == 2) {
                $lock = "loock";
                if ($lession['access'] == 1) {
                    if ($lession['estatus'] == 1) {
                        $lock = "";
                    }
                } else {
                    if ($lession['estatus'] == 0) {
                        if ($this->temp['leccion_actual'] == $lession['id']) {
                            $lock = "loock";
                        }
                    }
                    else {
                        if ($this->temp['leccion_actual'] >= $lession['id']) {
                            $lock = "";
                        }
                    }
                }
            } ?>



            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 d-flex flex-wrap justify-content-center">
                <a class="d-flex align-items-center justify-content-center lesson-btn <?= $lock ;?>" href='<?=$lession['url']?>' style="border-color: #<?= $this->temp['color'] ?>; " title="<?php echo $lession['nombre']; ?>">
                    <img class="m-0 p-0 img-fluid" src="<?php echo $lession['img']; ?>" alt="<?php echo $lession['nombre']; ?>">
                </a>

                <span class="lessonNums-name w-100 text-center" style="max-width: 10.35em; position: relative; color: #<?= $this->temp['color'] ?>;">
                    <a style="max-width: 80%; max-height: 4rem; margin: 0 auto; text-align: revert; color: #<?= $this->temp['color'] ?>;"
                       id="lesson<?=$i;?>"
                       class="enlace_leccion d-flex align-items-center justify-content-center <?= $lock ;?>"
                       href='<?=$lession['url']?>'
                       title="<?php echo $lession['nombre']; ?>">
                        <?= $lession['nombre'] ?>
                    </a>
                    <!--#################################-->
                    <?php if (verificaModuloSistemaActivo('PreviewLecciones')) { ?>
                        <style>.enlace_leccion{margin: initial !important;}</style>
                        <?php if($lession['video_preview'] != null || $lession['imagen_preview'] != 'no_image'){ ?>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#leccion<?php echo $lession['id']; ?>" style="border: 0; padding: 0; background: transparent;">
                            <i class="fa fa-play-circle" aria-hidden="true" style="font-size: 30px; position: absolute; top: 0px; right: 4px; color: #<?= $this->temp['color'] ?>;"></i>
                        <?php }else{ ?>
                            <button type="button" style="border: 0; padding: 0; background: transparent;">
                            <i class="fa fa-play-circle" aria-hidden="true" style="font-size: 30px; position: absolute; top: 0px; right: 4px; color: gray;"></i>
                        <?php } ?>
                    <?php } ?>
                    <!--#################################-->
                </span>
            </div>

            <?php $i++;
        }
        ?>
        <div class="col-12 text-right">
            <?php if ($this->temp['modulo']['id'] >= 2 && $this->temp['modulo']['id'] <= 7) { ?>
                <a class="regresar basico menu-principal" href='<?= CONTEXT ?>home/primary'>Regresar al menú de primaria</a>
            <?php } else if ($this->temp['modulo']['id'] >= 8 && $this->temp['modulo']['id'] <= 10) { ?>
                <a class="regresar basico menu-principal" href='<?= CONTEXT ?>home/secundary'>Regresar al menú de secundaria</a>
            <?php }?>
        </div>
        <div class="col-12 text-right">
            <a class="regresar basico menu-principal" href='<?= CONTEXT ?>home/menu'>Regresar al menú principal</a>
        </div>

    </div>
</div>

<!-- Modal -->
<?php if (verificaModuloSistemaActivo('PreviewLecciones')) { ?>
    <?php foreach ($this->temp ["lecciones"] as $leccion){ ?>
        <?php if($leccion['video_preview'] != null || $leccion['imagen_preview'] != 'no_image'){ ?>
            <div class="modal fade" id="leccion<?php echo $leccion['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><?= $leccion['nombre'] ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <?php if($leccion['video_preview'] != null ){ ?>
                                <?php echo $leccion['video_preview']; ?>
                            <?php } ?>
                            <hr>
                            <?php if($leccion['imagen_preview'] != 'no_image'){ ?>
                                <img src="<?php echo $leccion['imagen_preview']; ?>" alt="" width="100%" style="max-width: 400px; margin: 0 auto;">
                            <?php } ?>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <a href="<?=$leccion['url']?>" class="btn btn-primary">
                                Ir a la lección
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
<?php } ?>

<style>
    .relleno{
        margin: 0;
    }
    .regresar.basico.menu-principal{
        margin: 10px 0px;
    }
    @media screen and (max-width: 800px){
        [id*='lesson']{
            max-width: 75% !important;
        }
    }
    @media screen and (max-width: 575px){
        .lesson-btn{
            max-width: 80% !important;
            padding: 10px 0px;
        }
        [id*='lesson']{
            margin-top: 5px;
            font-size: initial;
        }
        .fa-play-circle{
            margin-left: 15px;
        }
        .lessonNums-name{
            max-width: 60% !important;
        }
    }
    @media screen and (max-width: 400px){
        [id*='lesson']{
            max-width: 85% !important;
        }
    }
</style>