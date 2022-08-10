<style>
    input[type='radio'] {
        font-size: 20px;
        margin: 5px;
    }

    #respuestasEvaluacion{
        list-style: none;
    }

</style>
<section id="contenido">

    <div class="separador"></div>
    <!-- Admin -->

    <div class="container">
        <h1 class="w-100 text-center">Evaluación trimestral</h1>
        <ul class="my-4">
            <li>
                Alumno: <?php echo $_SESSION['nombreAlumnoQueRealizaEvaluacion']; ?>
            </li>
            <li>
                Institución: <?php echo $_SESSION['institucionAlumno']; ?>
            </li>
        </ul>
        <form action="<?php echo CONTEXT; ?>evaluaciontrimestral/guardarevaluaciontrimestralalumno" method="POST">
            <ol class="p-0">
                <?php foreach($this->temp['preguntasFinales'] as $pregunta) {?>



                    <li>
                        <?php if(strpos($pregunta['LGF0200003'], 'data:image') !== false){ ?>
                                <img class="mb-1 mx-auto d-block" src="<?php echo $pregunta['LGF0200003']; ?>" >
                        <?php }elseif(strpos($pregunta['LGF0200003'], 'mp3') !== false || strpos($pregunta['LGF0200003'], 'data:audio') !== false){ ?>
                                <audio class="d-block mx-auto" src="<?php echo ARCHIVO_FISICO.$pregunta['LGF0200003']; ?>" controls></audio>
                        <?php }elseif($pregunta['LGF0200003'] != ''){ ?>
                                <img class="mb-1 mx-auto d-block" src="<?php echo ARCHIVO_FISICO.$pregunta['LGF0200003']; ?>" >
                        <?php } ?>

                        <p><?php echo $pregunta['LGF0200002']; ?></p>

                        <ol id="respuestasEvaluacion" class="p-0 d-flex justify-content-around align-items-center flex-wrap">

                            <?php foreach($pregunta['respuestas'] as $respuesta) { ?>
                                <li class="my-1 d-flex align-items-center">
                                    <input type="radio" class="form-check-input" name="respuestas[id_<?php echo $pregunta['id']; ?>]" value="<?php echo $pregunta['id']."___".$respuesta['LGF0210001']; ?>" required>



                                    <?php if(strpos($respuesta['LGF0210004'], 'data:image') !== false){ ?>
                                        <img class="mb-1 mx-auto d-block" src="<?php echo $respuesta['LGF0210004']; ?>" >
                                    <?php }elseif(strpos($respuesta['LGF0210004'], 'mp3') !== false || strpos($respuesta['LGF0210004'], 'data:audio') !== false){ ?>
                                        <audio class="d-block mx-auto" src="<?php echo $respuesta['LGF0210004']; ?>" controls>
                                            No soportado aqui
                                        </audio>
                                    <?php }elseif($respuesta['LGF0210004'] != ''){ ?>
                                        <img class="mb-1 mx-auto d-block" src="<?php echo ARCHIVO_FISICO.$respuesta['LGF0210004']; ?>" >
                                    <?php } ?>

                                    <span><?php echo $respuesta['LGF0210003']; ?></span>
                                </li>
                            <?php } ?>
                        </ol>

                    </li>
                    <div class="borde" style="border: 2px solid darkgray;height: 20px;width: 100%;background: indianred;margin: 20px 0px;"></div>
                <?php } ?>
            </ol>
            <div class="w-100 text-center">
                <button type="submit" class="btn btn-warning mx-auto" style="padding: 20px 80px;width: auto !important;height: auto !important;color: white;font-weight: bold;font-size: 30px !important;">
                    Enviar examen
                </button>
            </div>
        </form>
    </div>
</section>
