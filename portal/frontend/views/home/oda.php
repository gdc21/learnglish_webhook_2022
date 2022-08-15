<?php
#var_dump($this->temp);
switch ($this->temp['id_seccion']) {
	case '1':
		$fondo = "6bc8d0";
		break;
	case '2':
		$fondo = "6bc8d0";
		break;
	case '3':
		$fondo = "ed5740";
		break;
	case '4':
		$fondo = "f5bd3d";
		break;
	case '5':
		$fondo = "ed5740";
		break;
	case '6':
		$fondo = "2d75d8";
		break;
	case '7':
		$fondo = "ed5740";
		break;
	case '8':
		$fondo = "be51e8";
		break;
	case '9':
		$fondo = "ed5740";
		break;
	case '10':
		$fondo = "ef86b4";
		break;
	case '11':
		$fondo = "56dba1";
		break;
	case '12':
		$fondo = "ef86b4";
		break;
} ?>
<style>
	.basico.arrow_rg,
	.basico.arrow_lf {
		border: 0.15em solid #<?php echo $this->temp['color']; ?> !important;
	}

	.regresar.basico.menu-principal {
		color: #<?php echo $this->temp['color']; ?> !important;
	}

    .horizontal {
        overflow-x: auto;
        -ms-overflow-x: auto;
        -ms-overflow-y: hidden;
        overflow-y: hidden;
        margin-left: 20px;
        margin-right: 20px;
        display: flex;
        align-items: center;
        padding-bottom: 5px;
    }

	.horizontal1 {
		width: 96%;
		text-align: center;
	}

	/* Estilos para motores Webkit y blink (Chrome, Safari, Opera... )*/

	.horizontal::-webkit-scrollbar {
		-webkit-appearance: none;
	}

	.horizontal::-webkit-scrollbar-button:increment,
	.horizontal::-webkit-scrollbar-button {
		display: none;
	}

	.horizontal::-webkit-scrollbar:horizontal {
		height: 8px;
	}

    .horizontal::-webkit-scrollbar-thumb {
        background-color: #<?php echo $fondo; ?>;
        border-radius: 20px;
    }

	.horizontal::-webkit-scrollbar-track {
		border-radius: 10px;
	}
</style>

<div id="content" class="container">
	<section id="contenido">
        <?php
        /**
         * Verifica en la seccion de modulos si esta habilitada esta opcion, tbl:lg00043
         */
        if ($_SESSION['perfil'] == 1 && verificaModuloSistemaActivo('MostrarRutasApoyo')) { ?>
            <p id="aqui"></p>
            <script>
                if(typeof directorio_oda !== 'undefined'){
                    document.getElementById('aqui').innerHTML =
                        "C:\\wamp64\\www\\htmlsistemas\\learnglishk10Git\\portal\\"+directorio_oda.substr(directorio_oda.indexOf('oda'), directorio_oda.length);
                    //document.getElementById('aqui').innerHTML +=
                    //    "<br><br>\\\\JMORENO\\folder_oda_jon\\"+directorio_oda.substr(directorio_oda.indexOf('oda/'), directorio_oda.length);
                }
            </script>
            <?php
        } ?>



		<div class="lesson-tieles">
			<h2 class="lesson lesson-1" id="lessonnumber" style="width: 50%">
				<span id="nolesson" class="nolesson">Lesson<?php echo ": ".$this->temp['leccion'] ?> </span>
				<span id="nameT" class="nametema"></span>
				<span class="task">
					<img src="<?php echo $this->temp['img_leccion']; ?>" id="icono">
				</span>
			</h2>
			<h3 class="section type-<?php echo  $this->temp['id_seccion'] ?>" id="lessonname" style="width: 50%; font-weight: 800; text-align: left; padding-left: 0.75em; padding-top: 5px;">
                <?php if(stripos($this->temp['nombre_seccion'],'Grammar bit exercise') !== false && $this->temp["id_nivel"] == 1) { ?>
				    <span class="namelesson" id="namelesson">Language exercise</span>
                <?php }elseif(stripos($this->temp['nombre_seccion'],'Grammar bit') !== false && $this->temp["id_nivel"] == 1){ ?>
				    <span class="namelesson" id="namelesson">Language</span>
                <?php }else{ ?>
				    <span class="namelesson" id="namelesson"><?php echo $this->temp['nombre_seccion']; ?></span>
                <?php } ?>
				<img src="<?php echo  $this->temp['img_seccion'] ?>" id="iconoSec">
			</h3>
		</div>
		<nav aria-label="Page navigation example">
			<ul class="pagination d-flex align-items-center">
				<li class="page-item disabled">
					<a href="<?php echo  $this->temp['anterior'] ?>">
						<i class="fa fa-arrow-left icon-direction" aria-hidden="true" style="color: #<?php echo $this->temp['color']; ?>;"></i>
					</a>
				</li>
				<li style="width: 89%;">
					<ul id="deslizanteNavegacionLecciones" class="pagination <?php echo (count($this->temp['enlaces']) > 9 ? "horizontal" : "horizontal") ?>">
						<?php foreach ($this->temp['enlaces'] as $key => $value) : ?>
							<li class="page-item">
								<a style="position: relative;" href="<?php echo $value['link']; ?>" seccion="<?php echo $value['seccion']; ?>" class="type-<?php echo  $value['seccion']; ?>" >
									<img src="<?php echo $value['img']; ?>">
                                    <?php foreach($this->temp['ejerciciosHechosAlumnoTot'] as $item) { ?>
                                        <?php if($item == $value['indentificadorSeccion']) { ?>
                                            <i class="fa fa-check-circle" aria-hidden="true" style="background: white; border-radius: 50%; position: absolute; bottom: 0; color: green; right: 0; margin: 2px;"></i>
                                        <?php } ?>
                                    <?php } ?>
								</a>
							</li>
						<?php endforeach ?>
					</ul>
				</li>
				<li class="page-item">
					<a href="<?php echo  $this->temp['siguiente'] ?>">
						<i class="fa fa-arrow-right icon-direction" aria-hidden="true" style="color: #<?php echo $this->temp['color']; ?>;"></i>
					</a>
				</li>

			</ul>
		</nav>

		<!--<div class="clearfix" style="margin-top: 2em;"></div>-->
		<div class="row">
			<div class="col-12">
				<?php 
                if ($this->temp['instrucciones_img'] != "") {  ?>
                    <img style="width: 100%; height: auto;" src="<?php echo $this->temp['instrucciones_img']; ?>">
                <?php } ?>
                <div class="d-flex justify-content-center align-items-center w-100 mb-3 mt-1">
                     <?php if ($this->temp['audio_es'] != "") {  ?>
                        <img class="mx-4 audio_instrucciones" width="50px" style="cursor: pointer;" onclick="reproductor_imagen('<?php echo $this->temp['audio_es']; ?>');" src="<?php echo ARCHIVO_FISICO; ?>recursosLecciones/bandera_audio_es.png" >
                    <?php }
                    if ($this->temp['audio_en'] != "") { ?>
                        <img class="mx-4 audio_instrucciones" width="50px" style="cursor: pointer;" onclick="reproductor_imagen('<?php echo $this->temp['audio_en']; ?>');" src="<?php echo ARCHIVO_FISICO; ?>recursosLecciones/bandera_audio_en.png" >

                    <?php } ?>

                </div>

				<?php if ($this->temp['instrucciones_en'] != "") { ?>
					<span id="" style="font-size: 0.9em; display: block;">
						<div style="margin-top: 0.5em;"></div>
						<?php if ($this->temp['instrucciones_es'] != "") { echo "if 3";
							echo "<p><b>" . $this->temp['instrucciones_es'] . "</b></p>";
						} ?>
						<div class="row">
							<div class="col-lg-12"></div>
						</div>
						<?php if ($this->temp['instrucciones_en'] != "") { echo "if 5";
							echo "<p><i>" . $this->temp['instrucciones_en'] . "</i></p>";
						} ?>
					</span>
                <?php
                }
                ?>
			</div>
		</div>
		<div class="container-scroll">
			<div class="container-oda">
				<div class="contentOda">
					<div id="objeto_de_aprendizaje">

                        <?php if($this->temp['anotaciones'] == 'files_loaded'){ ?>
                            <div class="contenido d-flex justify-content-around align-items-center flex-wrap" >
                                <div class="speakingCargado text-center">
                                    <i class="fa fa-check-circle" aria-hidden="true" style="background: white; border-radius: 50%; color: green; margin: 2px; z-index: 99999;font-size: 50px;"></i>
                                    <h3>Speaking cargado.</h3>
                                </div>
                                <div class="documentoCargado text-center">
                                    <i class="fa fa-check-circle" aria-hidden="true" style="background: white; border-radius: 50%; color: green; margin: 2px; z-index: 99999;font-size: 50px;"></i>
                                    <h3>Documento cargado.</h3>
                                </div>
                            </div>
                            <hr>
                        <?php }

                        if($this->temp['examen'] == 'already_applied'){ ?>
                            <div class="contenido d-flex justify-content-around align-items-center flex-wrap" >
                                <div class="speakingCargado text-center">
                                    <i class="fa fa-check-circle" aria-hidden="true" style="background: white; border-radius: 50%; color: green; margin: 2px; z-index: 99999;font-size: 50px;"></i>
                                    <h3>Evaluación realizada. <br>(Calificación actual <?php echo $this->temp['resultadosEval']['calificacion']; ?>)</h3>
                                    <small>
                                        <i>Buena suerte en el siguiente intento.</i>
                                    </small>
                                </div>
                            </div>
                            <hr>

                        <?php }


                        if ( $this->temp ["anotaciones"] == 'not_exercises_yet' ||
                                 $this->temp ["anotaciones"] == 'no_files' ||
                                 $this->temp ["anotaciones"] == 'document_missing' ||
                                 $this->temp ["anotaciones"] == 'speaking_missing'
                        ) {
                            include_once "cargadocumentosalumno.php";
                        } ?>
                    </div>
					<div id="lesson-content"></div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="offset-lg-9 col-lg-3">
				<a class="regresar basico menu-principal <?php if (isset($this->temp['retroseso'])) {
																echo 'retroseso';
															} ?>" href='<?php echo  CONTEXT ?>home/lessons/<?php echo $this->temp['id_modulo'] ?>' style="text-align: center; text-decoration: none;">Regresar al menú de lecciones</a>
			</div>
		</div>
	</section>
	<input type="hidden" id="id_modulo" value="<?php echo $this->temp["id_modulo"] ?>" />
	<input type="hidden" id="id_leccion" value="<?php echo $this->temp["id_leccion"] ?>" />
	<?php
	$leccion = $this->temp["id_leccion"] - 1;
	if ($leccion == 0) {
		$leccion = 1;
	}
	?>

	<input type="hidden" id="leccion_anterior" value="<?php echo $this->temp["id_nivel"] . "_" . $this->temp["id_modulo"] . "_" . $this->temp["id_leccion"]; ?>">
	<?php
	$url = $_SERVER["REQUEST_URI"];
	$aux = explode("/", $url);

	if (isset($aux[4]) && !empty($aux[4])) { ?>
		<input type="hidden" id="repetir" value="1">
	<?php } else { ?>
		<input type="hidden" id="repetir" value="0">
	<?php }
	?>
</div>
<style>
    /** ###############################################################
    For fun input words doesnt appear */
    #tablero input.respuesta{
        line-height: initial;
    }
    /** For fun input words doesnt appear
    ###############################################################*/

    /** ###############################################################
    All sentence games centred */
    div.frase {
        line-height: 2em;
        font-size: 1em;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        height: auto;
        padding: 5px 0px;
        border-bottom: 1px dotted gray;
    }
    /** All sentence games centred
    ###############################################################*/

    /** ###############################################################
    Blue Cards game */
    #lo_contenedor #oa_contenedorCartas .oa_filaCartas{
        width: 100%;
    }
    #lo_contenedor #oa_contenedorCartas .oa_filaCartas img{
        max-width: 100%;
    }
    /** End Blue Cards game
    ############################################################### */

    /** ###############################################################
    Border color when section is selected */
    #deslizanteNavegacionLecciones li.claseBordeEnNavegacionSecciones{
        height: 95%; !important;
    }

    .claseBordeEnNavegacionSecciones{
        border: 5px solid greenyellow !important;
        padding: 0 !important;
    }
    .claseBordeEnNavegacionSecciones a{
        padding: 0 !important;
    }

    /** Border color when section is selected
    ###############################################################*/



    /*img.oa_centrado {
        max-width: 100% !important;
    }*/

	p.palabra {
		margin: unset;
		margin-top: 1em;
		font-size: 1em;
		letter-spacing: 0.5em;
	}

	img.oa_imagenPalabra {
		/*width: 4em;*/
		height: auto;
	}

	input.respuesta {
		border: solid 0.05em #aaa;
		/*width: max-content;*/
		margin-right: 1em;
		font-size: 1em;
		font-weight: bold;
		text-align: center;
		border-color: #aaa;
		color: #aaa;
		height: 1.7em;
		margin: 5px;
	}

	div.oa_pantalla {
		width: 100%;
		height: auto;
	}

	div.contenedorTarjetas {
		display: block;
		margin: auto;
		width: 30.5em;
		height: auto;
		margin-top: 1.5em;
	}

	div.tarjeta {
		width: 10em;
		height: 7.5em;
		display: inline-block;
		margin-top: -4px;
		overflow: hidden;
		position: relative;
	}

	div.anversoTarjeta {
		position: absolute;
		top: 0;
		left: 0;
		width: 10em;
		height: 7.5em;
		background-repeat: no-repeat;
		background-position: center center;
		cursor: pointer;
		background-size: 100%;
	}

	/*div.boton_pantalla {
	    display: inline-block;
	    position: relative;
	    background-repeat: no-repeat;
	    background-position: center center;
	    width: 2.2em;
	    height: 1.7em;
	    cursor: pointer;
	    background-size: contain;
	}*/
	div.frase {
		/*height: 2em;*/
		line-height: 2em;
		font-size: 1em;
		/*margin-top: 0.8em;*/
		text-align: center;
	}

	div.contenedorFrase {
		line-height: 2.5em;
		height: 4.2em;
		width: 100%;
		margin-bottom: 1.5em;
	}

	div.respuesta {
		background-size: 2em;
	}

	div.oa_cargando {
		background-repeat: no-repeat;
		background-position: center center;
		width: 90%;
		height: auto;
	}

	video#oa_video {
		width: 100%;
		height: auto;
		margin: unset;
	}

	#objeto_de_aprendizaje div#tablero {
		width: 100% !important;
	}

	.circle {
		border-radius: 1.25em;
		display: flex;
		justify-content: center;
		align-items: center;
	}

	.evalbtn-blue {
		background-color: #435ea3;
		width: 2em;
		height: 2em;
		font-size: 1em;
		float: left;
	}

	div#oa_contenedorFiguras {
		width: 29em;
	}

	div#contenedorBotonesPantalla {
		position: relative;
	}

	@media screen and (max-width: 768px) {
		p.palabra {
			margin-top: 1em;
			font-size: 1.1rem;
			letter-spacing: 0.5em;
		}

		img.oa_imagenPalabra {
			width: 6em;
			height: auto;
		}

		img.oa_centrado {
			width: auto;
			max-width: 100%;
		}
	}

	@media screen and (max-width: 500px) {
		div.contenedorTarjetas {
			width: 100%;
		}

		div.tarjeta {
			width: 33%;
			height: 19vw;
		}

		div.anversoTarjeta,
		div.reversoTarjeta {
			width: 100%;
			height: 100%;
		}
	}

	@media screen and (max-width: 489px) {
		#plato .subPlato {
    		height: 31px;
		}
		#plato .subPlato .letra {
			width: 7.2%;
		}
	}
</style>

<script>
    $(function(){
        /** ###############################################################
         Border color when section is selected */


        var enlacesAIluminar = '<?php echo implode(',', array_column($this->temp['enlaces'], 'link')); ?>';
        var enlcesOriginales = enlacesAIluminar.split(',');
        var urlActual = window.location.href;
        if(urlActual.split('_').length != 4){
            urlActual += "_1";
            /*console.log(enlacesAIluminar)*/
            document.getElementById('deslizanteNavegacionLecciones').firstElementChild.classList.add('claseBordeEnNavegacionSecciones');
        }else{

            if(enlacesAIluminar.search(urlActual) != -1){

                var indice = enlcesOriginales.indexOf(urlActual);
                localStorage.setItem('indiceDondeEstaUrl', indice);
                localStorage.setItem('indiceDondeEstaUrlProxima', indice - 1);

                document.querySelector('a[href="'+urlActual+'"]').parentElement.classList
                        .add('claseBordeEnNavegacionSecciones');
            }
            else{
                var indice = localStorage.getItem('indiceDondeEstaUrl');
                if(indice != null){
                    document.querySelector('a[class*="type"][href="'+enlcesOriginales[indice] +'"]')
                        .parentElement.classList.add('claseBordeEnNavegacionSecciones');
                }else{
                    localStorage.setItem('indiceDondeEstaUrl', 1);
                }
            }
        }
        document.querySelector('.claseBordeEnNavegacionSecciones').scrollIntoView({block: 'center'});
        /** Border color when section is selected
         ###############################################################*/


        /** ###############################################################
         Listening videos doesnt load on IOS */
        if(document.querySelector('video') != null){
            document.querySelector('video').setAttribute('autoplay', 'false');
            document.querySelector('video').setAttribute('controls', '');
        }
        /** Listening videos doesnt load on IOS
         ###############################################################*/


        var seccionActual = document.getElementById('namelesson').innerHTML;

        //console.log("estoy en un excercise")
        if(seccionActual.indexOf('exercise') !== -1){
            var urlActual = window.location.href.split('/');
            var pagina = urlActual[urlActual.length - 1];
            var apartado = pagina.split('_');

            //Si es un formato 1_1_2_4
            if(apartado.length === 4){
                abecedario = 'abcdefghijklmnopqrstuvwxyz';

                for(letra of abecedario){
                    try{

                        elemento = eval(letra);

                        if(elemento instanceof HTMLElement){
                            if(elemento.getAttribute('src').indexOf('ganar') != -1){
                                elemento.addEventListener('play', function () {
                                    //console.log("El sonido de ganar se reprodujo, guardar avances para avatar");
                                    var data = getInfoAjax('guardarAvanceAlumno', {parte1: pagina, seccion: $('[href="'+window.location.href+'"]').attr('seccion')}, 'home');
                                    if(data){
                                        if(data.creado){
                                            var elementoI = document.createElement('i');
                                            elementoI.classList.add('fa', 'fa-check-circle');
                                            elementoI.style.background = 'white';
                                            elementoI.style.borderRadius = '50%';
                                            elementoI.style.position = 'absolute';
                                            elementoI.style.bottom = '0';
                                            elementoI.style.right = '0';
                                            elementoI.style.margin = '2px';
                                            elementoI.style.color = 'green';
                                            elementoI.setAttribute('aria-hidden', 'true');

                                            document.querySelector('[href="'+window.location.href+'"]').appendChild(elementoI);
                                        }
                                    }
                                })
                            }
                        }
                    }catch(e){}
                }




            }
        }
    });
</script>
