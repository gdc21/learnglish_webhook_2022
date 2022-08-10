<!DOCTYPE html>
<html lang=es>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="<?= $this->view;?>/styles/img/favicon.ico" />
	<link rel="shortcut icon" href="<?= $this->view;?>/styles/img/favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?= $this->view;?>/styles/img/favicon.ico" type="image/x-icon">
	<title><?= APP_NAME ?> - <?= $this->temp["seccion"]; ?></title>
	<link href="<?= COMPONENTES;?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?= COMPONENTES ?>/bootstrap-fileinput-master/css/fileinput.css" rel="stylesheet" />
	<link href="<?= COMPONENTES ?>/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
	<link href="<?= $this->view;?>/styles/main.css" rel="stylesheet">
	<!-- <link href="<?= $this->view;?>/styles/home.css" rel="stylesheet">  -->

	<link rel="stylesheet" type="text/css" href="<?php echo CONTEXT; ?>portal/componentes/bootstrap-datepicker/datepicker.css">

	<?php
		if (isset ( $this->temp ["css_oda_abs"] )) {
			//if (file_exists ( $this->temp ["css_oda_abs"] )) {
				echo "<link type='text/css' rel='stylesheet' href='" . $this->temp ["css_oda_rel"] . "?version=2.".date("dG")."' />";
			//}
		}
	?>

	<!-- Cookies -->
	<script src="<?= COMPONENTES ?>/cookie/cookie.js"></script>
	
	<script src="<?= COMPONENTES ?>/jquery/jquery.js"></script>
	<script src="<?= COMPONENTES ?>/ui/jquery-ui.min.js"></script>
	<script src="<?= COMPONENTES ?>/ui/jquery.ui.touch-punch.min.js"></script>

	<script src="<?= COMPONENTES ?>/jquery/jquery.validate.min.js"></script>
	<script src="<?= COMPONENTES ?>/jquery/jquery.validate-additional.js"></script>
	<script src="<?= COMPONENTES ?>/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?= COMPONENTES ?>/Highcharts/js/highcharts.js"></script>
	<script src="<?= COMPONENTES ?>/Highcharts/js/highcharts-more.js"></script>
	<script src="<?= COMPONENTES ?>/Highcharts/js/modules/solid-gauge.js"></script>

	<script src="<?= COMPONENTES ?>/sha/sha1.js"></script>
	<script src="<?= $this->view;?>/js/main.js"></script>
	<script src="<?= COMPONENTES ?>/bootstrap-fileinput-master/js/fileinput.js" type="text/javascript"></script>
	<script src="<?= COMPONENTES ?>/bootstrap-fileinput-master/js/locales/es.js" type="text/javascript"></script>
	<?php //echo "<pre>".print_r($this->temp, true)."</pre>"; ?>
	<?php
		$file = VIEW_REALPATH . "/js/" . $this->temp ["seccion"] . "/" . $this->temp ['accion'] . ".js";
		if ($this->temp ["seccion"] && file_exists ( $file )) {
			echo "<script src='" . $this->view . "/js/" . $this->temp ["seccion"] . "/" . $this->temp ['accion'] . ".js?version=2.".date("dG")."'></script>";
		}
		
		$file = VIEW_REALPATH . "styles/" . $this->temp ["seccion"] . ".css";
		if ($this->temp ["seccion"] && file_exists ( $file )) {
			echo "<link href='" . $this->view . "/styles/" . $this->temp ["seccion"] . ".css?version=2.".date("dG")."' rel='stylesheet'>";
		}
	?>
	<script type=text/javascript>var context="<?= CONTEXT ?>";</script>

	<?php
		if (isset ( $this->temp ["js_oda_abs"] )) {
			//if (file_exists ( $this->temp ["js_oda_abs"] )) {
				echo '<script>' . 'var directorio_oda = "' . $this->temp ["dir_oda"] . '"; ' . '</script>';
				echo "<script  src='" . $this->temp ["js_oda_rel"] . "?version=2.".date("dG")."'></script>";
			//}
		}

		if (isset ( $this->temp ["js_evaluacion_abs"] ) && $this->temp['js_evaluacion_abs'] != 'no_acabo_ejercicios') {
			#echo "<script  src='" . $this->temp ["js_evaluacion_rel"] . "'></script>";
			//if (file_exists ( $this->temp ["js_evaluacion_rel"] )) {
				echo "<script  src='" . $this->temp ["js_evaluacion_rel"] . "?version=2.".date("dG")."'></script>";
			//}
			echo "<script> var IMG='" . IMG . "';</script>";
		}
	?>

	<!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

	<!-- <link href=http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css rel=stylesheet> -->
	<link href='https://fonts.googleapis.com/css?family=Sintony:400,700' rel=stylesheet type=text/css>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel=stylesheet type=text/css>

	<!-- Scripts DataTable -->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
	<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

	<!-- <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> -->
	<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

	<script src="<?php echo CONTEXT; ?>portal/componentes/bootstrap-datepicker/datepicker.js"></script>
	<?php if (isset($this->temp['retroseso'])): ?>
		<script>
			function noback(){
				window.location.hash="";
			    window.location.hash="" //chrome
			    window.onhashchange=function(){window.location.hash="";}
			}
		</script>
	<?php endif ?>

	<!-- Reproductor de audio -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.2.3/howler.min.js"></script>

	<!-- Script para traducir texto -->
	<script id="scriptTraslate" src="<?php echo CONTEXT; ?>portal/componentes/traductor/traductor.js"></script>
	<!-- <script>
		function googleTranslateElementInit () {
        	new google.translate.TranslateElement ({
        		// pageLanguage: 'en'
        		includedLanguages: 'en,es'
        	}, 'google_translate_element');
        }
	</script> -->
	<style>
		.goog-te-banner-frame{
			display: none;
		}
		body {
			top: 0 !important;
		}
	</style>
</head>
<body rel=<?= $this->temp["accion"]; ?> <?php if (isset($this->temp['retroseso'])) {echo "onload='noback();'";} ?> translate="no">
    <input type="hidden" id="hiddenVal"/>

	<?php 
		if ($this->temp['accion'] == "menu" && $_SERVER['HTTP_REFERER'] == CONTEXT || $_SERVER['HTTP_REFERER'] == CONTEXT."Home/index") {
			if (isset($this->temp['usuario']) && $_SESSION['perfil'] == 2) { ?>
				<script>
					$(function () {
						$("#modalAvance").modal("show");
					});
				</script>
		<?php }
		}
	?>
	<?php  echo $this->header; ?>

    <?php  if($this->temp ["seccion"] == 'home' && $this->temp ["accion"] == 'index' && verificaModuloSistemaActivo('ExamenTrimestral')){ ?>
        <!--Modal de evaluacion trimestral--> 
        <div class="modal fade" id="modalEvaluacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Recuerda que...</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body row">
                        <div class="col-md-6 d-flex align-items-center text-justify">
                            <h4>La evaluación trimestral correspondiente al periodo abril-junio estará disponible del 22 de junio al 15 de julio.</h4>
                        </div>
                        <div class="col-md-6 text-center">
                            <img src="<?php echo ARCHIVO_FISICO; ?>grammarQ2021_06_15_17_02_46.png" alt="" >
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Ya la hice
                        </button>
                        <a href="<?php echo CONTEXT; ?>evaluaciontrimestral/evaluacionlistarlecciones" class="btn btn-primary">
                            Realizar evaluación
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(function () {
                $("#modalEvaluacion").modal("show");
            });
        </script>
        <!--Modal de evaluacion trimestral-->
    <?php } ?>





	<?= $this->body; ?>
	<div class=shadow></div>
	<div class="modal fade" id=modalAlert data-backdrop=static>
		<div class=modal-dialog>
			<div class=modal-content>
				<div class=modal-header>
					<button type=button class=close data-bs-dismiss=modal aria-hidden=true
						id=close>×</button>
					<h4 class=modal-title style="width: 95%; float: left"></h4>
					<div style="clear: both"></div>
					<div id=conthr></div>
				</div>
				<div class=modal-body></div>
				<div class=modal-footer>
					<div id=GenericBtn>
						<button type=button class="btn btn-primary" id=modalAlertBotonOk>Aceptar</button>
					</div>
					<div id=CustomBtn></div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modalAvance" role="dialog">
		<style type="text/css">
            /** ##################################################
            Vocabulary excercise section */
            @media screen and (max-width: 767px){
                #lo_contenedor p.palabra img.oa_imagenPalabra{
                    display: block !important;
                    width: auto;
                    margin: 0 auto !important;
                }
                #lo_contenedor p[class*="palabra c"]{
                    text-align: center !important;
                }
            }
            /** End vocabulary excercise section
            ################################################## */


			#modal-dialog{
				/*width: 50%;*/
		    	margin-top: 6em !important;
			}
			#modal-content{
				max-height: 36em;
			}
			#modal-body{
				display: inline-block;
				width: 100%;
				height: 90%;
			}
			#imagen_left_modal, #contenido_modal{
				display: inline-block;
			}
			#imagen_left_modal{
				width: 33%;
				height: 80%;
			}
			#imagen_left_modal img{
				max-width: 100%; 
				max-height: 34em; 
			}
			#contenido_modal{
				width: 100%;
		    	height: 100%;
		    	float: right;
			}
			#encabezado_modal, #encabezado_modal2{
				max-width: 100%;
				max-height: 30%;
				text-align: center;
			}
			
			#info_modal, #info_modal2{
				max-width: 100%;
				max-height: 48%;
				margin-top: 3%;
			}
			#info_modal2{
				margin-top: 10%;
			}
			#botones_modal{
			    max-width: 100%;
			    max-height: 20%;
			    margin-top: 7%;
			    text-align: center;
			}
			.btn-modal{
				margin: 3%;
			}
			.label_modal{
				padding-left: 1%;
				width: 100%;
				text-align: left;
				font-size: 1.25em;
			}
			#continuar_modal,#continuar_modal2, #menu_prinipal_modal, #ver_avance_modal, #menu_prinipal_modal2{
				font-size: 0.9em;
				padding: 0.45em 1em;
				font-weight: bold;
				border-radius: 1em;
			}
			#continuar_modal,#continuar_modal2{
				width: 8em;
			}
			#menu_prinipal_modal,#ver_avance_modal, #menu_prinipal_modal2{
				background: #56d9db;
				font-size: 1em;
			}
			.modal-hover:hover{
				color: white;
			}
			.color_modalinfo{
				background: #0a6fb5;
				color: #ffffff;
				font-size: 1em;
			}
			#userimage{
				float: right;
				padding: 1%;
			}
			#loguser{
				float: right;
			    text-align: left;
			    font-size: 1.1em;
			    padding: 2%;
			}
			.tabla_modal{
				padding: 0.5em;
				text-align: center;
				border: 0.15em solid white;
  				border-collapse: collapse;
			}
			.tit_mod1_modal{
				background: #355CA8;
				color: white;
			}
			.tit2_mod1_modal{
				background: #5380C4;
				color: white;
			}
			.tit_mod2_modal{
				background: #CFCB5C;
			}
			.tit2_mod2_modal{
				background: #EDE475;
			}
			.tit_mod3_modal{
				background: #58A94A;
				color: white;
			}
			.tit2_mod3_modal{
				background: #B1D275;
				color: white;
			}
			.tit_mod4_modal{
				background: #8B95CD;
				color: white;
			}
			.tit2_mod4_modal{
				background: #B3BADE;
				color: white;
			}
			.body_tab_modal{
				background: #f7eded;
			}
			.body_tab_modal2{
				background: #d4d4d4;
			}
			#info_modal h3 {
				font-size: 1em;
			}
		</style>
	    <div class="modal-dialog" id="modal-dialog" style="margin-top: -0.4em;">
	    	<div class="modal-content" id="modal-content">
	    		<div class="modal-body" id="modal-body">
	        		<div id="contenido_modal">
	        			<div id="encabezado_modal">
	        				<img src="<?php echo IMG ?>logo_color.png">
	        			</div>
	        			<div id="info_modal">
	        				<h3>Bienvenido nuevamente a la plataforma learnglish</h3>
	        				<label class="label_modal color_modalinfo"> <?php echo $this->temp['usuario']; ?></label><br>
	        				<h3>La fecha y hora de tu última sesión de ingreso fue:</h3>
	        				<label class="label_modal color_modalinfo"><?php echo $this->temp['ultimoAcceso']; ?></label><br>
	        				<h3>Tu último avance fue:</h3>
	        				<?php 
	        					$aux = explode("_", $this->temp['avance']);
	        				?>
	        				<label class="label_modal color_modalinfo"><?php echo $this->temp['avance_texto']; ?></label><br>
	        			</div>
	        			<div id="botones_modal">
	        				<button id="menu_prinipal_modal" type="button" class="btn btn-modal modal-hover" data-bs-dismiss="modal">Menú principal</button>
	        				<?php if ($this->temp['continuar']) { ?>
	        					<button id="continuar_modal" data-avance="<?php echo 'home/navegar/'.$this->temp['avance']; ?>" type="button" class="btn btn-modal color_modalinfo" data-bs-dismiss="modal">Continuar</button>
	        				<?php } ?>
	        			</div>
	        		</div>
	        	</div>
	      	</div>  
	    </div>
	</div>

<?= $this->footer; ?>
<?php include 'mesaServicios.php';?>
</body>
</html>