<style>

    .verde{
        background: rgba(0,255,0,0.2) !important;
        padding: 2px 5px;
        border-radius: 5px;
    }
    .rojo{
        background: rgba(255,0,0,0.2) !important;
        padding: 2px 5px;
        border-radius: 5px;
    }
    @media print {
        * {
            -webkit-print-color-adjust: exact;
        }
    }
    #respuestasEvaluacion{
        list-style: none;
    }

    @media screen and (max-width: 600px){
        #respuestasEvaluacion li{
            width: 100%;
        }
    }
</style>
<section id="contenido">
    <?php echo $this->temp['encabezado']; ?>

    <div class="separador"></div>
    <!-- Admin -->

    <div class="container">
        <div class="align-items-center row">
            <div class="col-12">
                <h2 id="mensajeGracias" class="my-3 w-100 text-center">
                    Thank you for doing your evaluation, your results has been sent successfully!
                </h2>
            </div>
            <div class="col-md-6">
                <h2>Resultados: </h2>
                <ul>
                    <li>
                        Alumno: <mark><?php echo $this->temp['nombreAlumnoQueRealizaEvaluacion']; ?></mark>
                    </li>
                    <li>
                        Institución: <?php echo $this->temp['institucionAlumno']; ?>
                    </li>
                    <li>
                        Calificación de evaluación: <?php echo $this->temp['resultados']['calificacion']; ?>
                    </li>
                    <li>
                        Preguntas correctas: <?php echo $this->temp['resultados']['acertadas']; ?>
                    </li>
                    <li>
                        Preguntas incorrectas: <?php echo $this->temp['resultados']['totalPreguntas'] - $this->temp['resultados']['acertadas']; ?>
                    </li>
                    <li>
                        Total de preguntas: <?php echo $this->temp['resultados']['totalPreguntas']; ?>
                    </li>
                    <li>
                        Trimestre: <?php echo $this->temp['resultados']['trimestre']; ?>
                    </li>
                </ul>
                <button id="imprimir" class="btn btn-warning mx-auto text-white">Imprimir pdf</button>
            </div>
            <div id="graficoResultados" class="col-md-6">
                <figure class="highcharts-figure">
                    <div id="tiempoSemanaMinutos"></div>
                </figure>
            </div>
            <div class="col-12">

                <h2 class="text-center w-100 my-3">Resumen de tu evaluación</h2>
                <ol class="p-0" type="1">
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

                            <?php foreach($pregunta['respuestas'] as $respuesta) { $seMostro = 0; ?>
                                    <?php foreach($this->temp['respuestasExamen'] as $esRespuestaAlumno) {  ?>
                                        <?php if($esRespuestaAlumno == $respuesta['LGF0210001']){ $seMostro = 1; ?>
                                            <li class="my-1 <?php echo $respuesta['LGF0210005'] == "V" ? 'verde':'rojo'; ?>">
                                                <input type="radio" class=" form-check-input" name="respuestas[id_<?php echo $pregunta['id']; ?>]" value="<?php echo $pregunta['id']."___".$respuesta['LGF0210001']; ?>" required checked disabled>
                                        <?php } ?>
                                    <?php } ?>

                                    <?php if(!$seMostro){ ?>
                                        <li class="<?php echo $respuesta['LGF0210005'] == "V" ? 'verde':'rojo'; ?> my-1 ">
                                            <input type="radio" class="form-check-input" name="respuestas[id_<?php echo $pregunta['id']; ?>]" value="<?php echo $pregunta['id']."___".$respuesta['LGF0210001']; ?>" required disabled>
                                    <?php } ?>

                                    <?php if(strpos($respuesta['LGF0210004'], 'data:image') !== false){ ?>
                                        <img class="mb-1 mx-auto d-block" src="<?php echo $respuesta['LGF0210004']; ?>" >
                                    <?php }elseif(strpos($respuesta['LGF0210004'], 'mp3') !== false || strpos($respuesta['LGF0210004'], 'data:audio') !== false){ ?>
                                        <audio class="d-block mx-auto" src="<?php echo $respuesta['LGF0210004']; ?>" controls>
                                            No soportado aqui
                                        </audio>
                                    <?php }elseif($respuesta['LGF0210004'] != ''){ ?>
                                        <img class="mb-1 mx-auto d-block" src="<?php echo ARCHIVO_FISICO.$respuesta['LGF0210004']; ?>" >
                                    <?php } ?>
                                    <span class=""><?php echo $respuesta['LGF0210003']; ?></span>
                                </li>
                            <?php } ?>
                        </ol>
                    </li>

                    <div class="borde" style="border: 2px solid darkgray;height: 20px;width: 100%;background: indianred;margin: 20px 0px;"></div>
                <?php } ?>
                </ol>

                <a id="botonRegreso" href="<?php echo CONTEXT; ?>" class="btn btn-success mx-auto">Regresar a la pagina principal</a>

            </div>
        </div>

    </div>
</section>
<script>

    $(function(){

        window.addEventListener('afterprint', (event) => {
            $("header").show();
            $("#graficoResultados").show();
            $("#botonRegreso").show();
            $("footer").show();
            $("#imprimir").show();
            $("#freshworks-container").show();
            $("#mensajeGracias").show();
        });
        window.addEventListener('beforeprint', (event) => {
            $("header").hide();
            $("#graficoResultados").hide();
            $("#botonRegreso").hide();
            $("footer").hide();
            $("#imprimir").hide();
            $("#freshworks-container").hide();
            $("#mensajeGracias").hide();
        });

        $("#imprimir").click(function(){
            window.print()
        })

    })
    Highcharts.chart('tiempoSemanaMinutos', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: 0,
            plotShadow: false
        },
        title: {
            text: 'Resultados <br>de la<br>evaluación',
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
            name: 'Total',
            innerSize: '50%',

            data: [


                ['Correctas', <?php echo $this->temp['resultados']['acertadas']; ?>],
                ['Incorrectas', <?php echo intval($this->temp['resultados']['totalPreguntas'] - $this->temp['resultados']['acertadas']); ?>],

            ]
        }]
    });
</script>
