<style>

    .progressbar {
        counter-reset: step;
    }

    .progressbar li {
        list-style: none;
        display: inline-block;
        width: 100%;
        position: relative;
        text-align: center;
        cursor: pointer;

        /*#######################*/
        transition: width 1s;
        /*#######################*/
    }

    .progressbar li:before {
        content: counter(step);
        counter-increment: step;
        width: 30px;
        height: 30px;
        line-height: 30px;
        border: 1px solid #ddd;
        border-radius: 100%;
        display: block;
        text-align: center;
        margin: 0 auto 10px auto;
        background-color: #fff;
    }

    .progressbar li:after {
        content: "";
        position: absolute;
        width: 100%;
        height: 1px;
        background-color: #ddd;
        top: 15px;
        left: -50%;
        z-index: -1;
    }

    .progressbar li:first-child:after {
        content: none;
    }

    .progressbar li.active {
        color: green;
    }

    .progressbar li.active:before {
        border-color: green;
    }

    .progressbar li.active:after {
        background-color: green;
    }
</style>
<section class="container">
    <section id="contenido">
        <?php echo $this->temp['encabezado']; ?>
        <div class="separador">
            <div class="row">
                <div class="col-lg-6">
                    <h1 class="title-section"><?php echo $this->temp['seccion_nombre']; ?></h1>
                </div>
            </div>
        </div>
        <div class="separador"></div>


        <div class="container">
            <label class="form-label">Primero selecciona que vamos a importar</label>

            <select class="form-select importar_step1_selecciona" id="accion" name="accion">
                <option value="">Selecciona una opción</option>
                <option value="1">Cargar instituciones</option>
                <option value="3">Cargar docentes</option>
                <option value="2">Cargar alumnos</option>
            </select>

            <ul class="progressbar my-5 d-flex justify-content-center text-center">
                <li class="active itemSteps" id="Step1">Esperando selección...</li>
                <li class="itemSteps d-none" id="Step2">Paso 2</li>
                <li class="itemSteps d-none" id="Step3">Paso 3</li>
                <li class="itemSteps d-none" id="Step4">Paso 4</li>
            </ul>

            <div id="institucionesCaja" class="text-center">
                <!--*****************************************************-->
                <!--*****************************************************-->
                <!--*****************************************************-->
                <div class="seccionPaso1 d-none">
                    <h4 class="w-100 text-center my-5">Primero descarga la plantilla de ejemplo</h4>

                    <a href="" id="download_ejemplo" style="margin-top: 15px;">
                        <i id="botonDownloadi" class="fa fa-cloud-download mt-2" aria-hidden="true"
                           style="font-size: 30px; padding: 30px; border: 1px solid blue; border-radius: 50%; box-shadow: 0px 0px 5px green; margin: 0 auto; display: block; width: max-content;"></i>
                    </a>
                </div>
                <!--*****************************************************-->
                <!--*****************************************************-->
                <!--*****************************************************-->


                <!--*****************************************************-->
                <!--*****************************************************-->
                <!--*****************************************************-->
                <div class="seccionPaso2 d-none">
                    <h4>Abre el archivo "<b class="nombre_archivo"></b>" que se descargo</h4>
                    <b class="my-5">A continuación una explicación del significado de cada campo</b>


                    <!--#####################################################################################-->
                    <!--#####################################################################################-->
                    <!--#####################################################################################-->
                    <table class="table mx-auto tabla_mostrar_simbologia" id="plantilla_instituciones">
                        <thead>
                            <th>Campo</th>
                            <th>Descripción</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>CCT</td>
                                <td>Clave CCT de la institución.
                                    <li>16DPB0110C</li>
                                </td>
                            </tr>
                            <tr>
                                <td>Nombre</td>
                                <td>Nombre de la institución a cargar (sin usar ¡ # $ % / “ ó ‘).
                                    <li>Esc. Prim. Fed. Gral. Lázaro Cárdenas</li>
                                </td>
                            </tr>
                            <tr>
                                <td>Modulo</td>
                                <td>De acuerdo a lo siguiente:
                                    <li>1  (3° preescolar)</li>
                                    <li>2  (1° primaria)</li>
                                    <li>3  (2° primaria)</li>
                                    <li>4  (3° primaria)</li>
                                    <li>5  (4° primaria)</li>
                                    <li>6  (5° primaria)</li>
                                    <li>7  (6° primaria)</li>
                                    <li>8  (1° secundaria)</li>
                                    <li>9  (2° secundaria)</li>
                                    <li>10 (3° secundaria)</li>
                                </td>
                            </tr>
                            <tr>
                                <td>Grado</td>
                                <td>Nivel académico que se va a registrar:
                                    <li>Módulo 1, Grado: 3 (3° preescolar)</li>
                                    <li>Módulo 2, Grado: 1 (1° primaria)</li>
                                    <li>Módulo 3, Grado: 2 (2° primaria)</li>
                                    <li>Módulo 4, Grado: 3 (3° primaria)</li>
                                    <li>Módulo 5, Grado: 4 (4° primaria)</li>
                                    <li>Módulo 6, Grado: 5 (5° primaria)</li>
                                    <li>Módulo 7, Grado: 6 (6° primaria)</li>
                                    <li>Módulo 8, Grado: 1 (1° secundaria)</li>
                                    <li>Módulo 9, Grado: 2 (2° secundaria)</li>
                                    <li>Módulo 10, Grado: 3 (3° secundaria)</li>
                                </td>
                            </tr>
                            <tr>
                                <td>Letra</td>
                                <td>Grupo o identificador de cada “Grado”
                                    <li>A</li>
                                    <li>B</li>
                                    <li>C</li>
                                    <li>D</li>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                    <!--#####################################################################################-->
                    <!--#####################################################################################-->
                    <!--#####################################################################################-->

                    <table class="table mx-auto tabla_mostrar_simbologia" id="plantilla_alumnos">
                        <thead>
                            <th>Campo</th>
                            <th>Descripción</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Nombre</td>
                                <td>Nombre del alumno:
                                    <li>fulano1Juan
                                </td>
                            </tr>
                            <tr>
                                <td>Apellido paterno</td>
                                <td>Apellido paterno del alumno (opcional):
                                    <li>Apellido1</li>
                                </td>
                            </tr>
                            <tr>
                                <td>Apellido materno</td>
                                <td>Apellido materno del alumno (opcional):
                                    <li>Apellido2</li>
                                </td>
                            </tr>
                            <tr>
                                <td>CURP</td>
                                <td>CURP del alumno (18 caracteres):
                                    <li>Apellido1</li>
                                </td>
                            </tr>
                            <tr>
                                <td>Genero</td>
                                <td>Género del alumno:
                                    <li>H</li>
                                    <li>M</li>
                                </td>
                            </tr>
                            <tr>
                                <td>Modulo</td>
                                <td>Nivel académico que se va a registrar:
                                    <li>Modulo 1, Grado: 3 (3° preescolar)Módul
                                    <li>Modulo 2, Grado: 1 (1° primaria)Módul
                                    <li>Modulo 3, Grado: 2 (2° primaria)Módul
                                    <li>Modulo 4, Grado: 3 (3° primaria)Módul
                                    <li>Modulo 5, Grado: 4 (4° primaria)Módul
                                    <li>Modulo 6, Grado: 5 (5° primaria)Módul
                                    <li>Modulo 7, Grado: 6 (6° primaria)Módul
                                    <li>Modulo 8, Grado: 1 (1° secundaria)Módul
                                    <li>Modulo 9, Grado: 2 (2° secundaria)Módul
                                    <li>Modulo 10, Grado: 3 (3° secundaria)Módul
                                </td>
                            </tr>
                            <tr>
                                <td>Institucion</td>
                                <td>CCT de la institución a la que pertenece
                                    <li>16DPB0110C</li>
                                </td>
                            </tr>
                            <tr>
                                <td>Grado</td>
                                <td>Nivel académico que se va a registrar:
                                    <li>Modulo 1, Grado: 3 (3° preescolar)Módul
                                    <li>Modulo 2, Grado: 1 (1° primaria)Módul
                                    <li>Modulo 3, Grado: 2 (2° primaria)Módul
                                    <li>Modulo 4, Grado: 3 (3° primaria)Módul
                                    <li>Modulo 5, Grado: 4 (4° primaria)Módul
                                    <li>Modulo 6, Grado: 5 (5° primaria)Módul
                                    <li>Modulo 7, Grado: 6 (6° primaria)Módul
                                    <li>Modulo 8, Grado: 1 (1° secundaria)Módul
                                    <li>Modulo 9, Grado: 2 (2° secundaria)Módul
                                    <li>Modulo 10, Grado: 3 (3° secundaria)Módul
                                </td>
                            </tr>
                            <tr>
                                <td>Letra</td>
                                <td>Letra del grupo al que pertenece el alumno:
                                    <li>A</li>
                                    <li>B</li>
                                    <li>C</li>
                                    <li>D</li>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!--#####################################################################################-->
                    <!--#####################################################################################-->
                    <!--#####################################################################################-->


                    <table class="table mx-auto tabla_mostrar_simbologia" id="plantilla_docentes">
                        <thead>
                            <th>Campo</th>
                            <th>Descripción</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Nombre</td>
                                <td>Nombre del alumno:
                                    <li>fulano1Juan
                                </td>
                            </tr>
                            <tr>
                                <td>Apellido paterno</td>
                                <td>Apellido paterno del alumno (opcional):
                                    <li>Apellido1</li>
                                </td>
                            </tr>
                            <tr>
                                <td>Apellido materno</td>
                                <td>Apellido materno del alumno (opcional):
                                    <li>Apellido2</li>
                                </td>
                            </tr>
                            <tr>
                                <td>CURP</td>
                                <td>CURP del alumno (18 caracteres):
                                    <li>Apellido1</li>
                                </td>
                            </tr>
                            <tr>
                                <td>Genero</td>
                                <td>Género del alumno:
                                    <li>H</li>
                                    <li>M</li>
                                </td>
                            </tr>
                            <tr>
                                <td>Institucion</td>
                                <td>CCT de la institución a la que pertenece
                                    <li>16DPB0110C</li>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!--#####################################################################################-->
                    <!--#####################################################################################-->
                    <!--#####################################################################################-->

                </div>
                <!--*****************************************************-->
                <!--*****************************************************-->
                <!--*****************************************************-->


                <!--*****************************************************-->
                <!--*****************************************************-->
                <!--*****************************************************-->
                <div class="seccionPaso3 d-none">
                    <h4>Ya tienes listo tu documento de excel csv "<b class="nombre_archivo"></b>"?</h4>
                    <h4>Si, perfecto, continuemos.</h4>
                    <h4 class="my-5">A continuación súbelo, se va a descargar un archivo llamado "<b class="resultante"></b>" que deberas cargar en el siguiente paso.</h4>

                    <form id="importFile">
                        <input type="hidden" name="accion" id="inputLimpiarDatosHidden">
                        <input type="file" name="limpiar" accept=".csv" class="limpiar mt-5 mb-3 w-75 mx-auto form-control" required>
                        <p class="mt-3 mensaje" style="color: green;"></p>
                        <button type="button" class="text-white btn d-block mx-auto btn-success mb-5 procesar" formularioNumero="1">
                            Subir y limpiar documento
                        </button>
                    </form>
                </div>
                <!--*****************************************************-->
                <!--*****************************************************-->
                <!--*****************************************************-->

                <!--*****************************************************-->
                <!--*****************************************************-->
                <!--*****************************************************-->
                <div class="seccionPaso4 d-none">
                    <h4>Finalmente carga el archivo que acabaste de recibir: "<b class="resultante"></b>" en el siguiente campo.</h4>

                    <form id="importFile2">
                        <input type="hidden" name="accion" id="inputLimpiarDatosHidden2">
                        <input type="file" name="limpiar" accept=".csv" class="limpiar mt-5 mb-3 w-75 mx-auto form-control" required>
                        <p class="mt-3 mensaje" style="color: green;"></p>
                        <button type="button" class="text-white btn d-block mx-auto btn-success mb-5 procesar"  formularioNumero="2">
                            Subir y limpiar documento
                        </button>
                    </form>
                </div>
                <!--*****************************************************-->
                <!--*****************************************************-->
                <!--*****************************************************-->




                <!--<button actualTab="1" id="accionBotonSiguiente" class="text-white d-none btn btn-info float-end">-->
                <button id="accionBotonAnterior" class="text-white d-none btn btn-primary mt-5">
                    Regresar paso
                </button>
                <button actualTab="1" id="accionBotonSiguiente" class="text-white d-none btn btn-info mt-5">
                    Siguiente paso
                </button>
            </div>
            <div id="docentesCaja"></div>
            <div id="alumnosCaja"></div>
            <div id="gruposCaja"></div>


        </div>

        <script>
            $(function () {

                /**Al presionar el boton de siguiente tab se iluminaran las siguientes
                 * */
                $("#accionBotonSiguiente").click(function () {
                    $("#accionBotonAnterior").removeClass('d-none');

                    var actualTab = this.getAttribute('actualTab');
                    var siguienteTab = parseInt(actualTab) + 1;
                    if (actualTab != '4') {
                        /*Seccion de mostrar contenido de cada paso*/
                        $("[class*=seccionPaso" + actualTab + "]").addClass('d-none');
                        $("[class*=seccionPaso" + siguienteTab + "]").removeClass('d-none');

                        /*Seccion de tabs en verde pasos*/
                        $("[id*=Step" + actualTab + "]").removeClass('active');
                        this.setAttribute('actualTab', siguienteTab);
                        $("[id*=Step" + siguienteTab + "]").addClass('active');
                    }
                });

                /**Al presionar el boton de siguiente tab se iluminaran las siguientes
                 * */
                $("#accionBotonAnterior").click(function () {
                    var actualTab = $("#accionBotonSiguiente").attr('actualTab');
                    var siguienteTab = parseInt(actualTab) - 1;
                    if (actualTab != '1') {
                        /*Seccion de mostrar contenido de cada paso*/
                        $("[class*=seccionPaso" + actualTab + "]").addClass('d-none');
                        $("[class*=seccionPaso" + siguienteTab + "]").removeClass('d-none');

                        /*Seccion de tabs en verde pasos*/
                        $("[id*=Step" + actualTab + "]").removeClass('active');
                        $("#accionBotonSiguiente").attr('actualTab', siguienteTab);
                        $("[id*=Step" + siguienteTab + "]").addClass('active');
                    }

                    if(actualTab == '2'){
                        $("#accionBotonAnterior").addClass('d-none');
                    }


                });

                /**+
                 * MOSTRAR BOT SIGUIENTE, MOSTRAR TABLA, CAMBIA TITULO SIMBOLOGIA
                 *
                 * Cuando se de click en el boton descargar empezara a mostrarse el boton de siguiente
                 * Se cambiar titulo de simbologia
                 * Se mostrara tabla con simbologia correspondiente
                 */
                $("#botonDownloadi").click(function () {
                    var nombre_archivo = $("#download_ejemplo").attr('nombre_archivo');
                    $(".nombre_archivo").html(nombre_archivo);

                    var resultante = $("#download_ejemplo").attr('resultante');
                    $(".resultante").html(resultante);

                    var tabla_mostrar_simbologia = $("#download_ejemplo").attr('tabla');

                    $(".tabla_mostrar_simbologia").addClass('d-none');
                    $("#"+tabla_mostrar_simbologia).removeClass('d-none');

                    $("#accionBotonSiguiente").removeClass('d-none');

                });

                /**
                 * Cuando el usuario selecciona una opcion para importacion masiva
                 */
                $(".importar_step1_selecciona").change(function () {

                    $("[class*=seccionPaso]").addClass('d-none');


                    if(this.value != ""){
                        $("[class*=seccionPaso1]").removeClass('d-none');
                        $("#Step1").html("Paso 1");
                        $(".itemSteps").removeClass('d-none');

                    }else{
                        $("#Step1").html("Esperando selección...");

                        /*Ocultamos los circulos y ampliamos el primero*/
                        $("[id*='Step']").addClass('d-none');

                        $(".itemSteps").addClass('d-none');
                        $(".itemSteps:first").removeClass('d-none');

                        /*$("#Step1").removeClass('d-none');
                        $("#Step1").css({'width': '100%'});*/
                        console.log("100", 100);
                    }

                    $("[id*=Step]").removeClass('active');
                    $("[id*=Step1]").addClass('active');

                    $("#accionBotonSiguiente").addClass('d-none');
                    $("#accionBotonSiguiente").attr('actualTab', 1);

                    $("#accionBotonAnterior").addClass('d-none');


                    $(".progressbar li").css({'width': '20%'});

                    $("#inputLimpiarDatosHidden").val(this.value);
                    $("#inputLimpiarDatosHidden2").val(this.value);
                });
            });
        </script>


        <!--<div class="page">
          <form id="importFile">
            <div class="row">
              <div class="col-lg-5">
                <label class="form-label">
                  Limpiar información <a href="" id="download_ejemplo" style="margin-top: 15px;">Descargar ejemplo</a>
                </label>
                <select class="form-select" id="accion" name="accion">
                  <option value="">Selecciona una opción</option>
                  <option value="1">Limpiar datos de la institución</option>
                  <option value="2">Limpiar datos del alumno</option>
                  <option value="3">Limpiar datos del docente</option>
                  <option value="4">Importar instituciones</option>
                  <option value="5">Importar alumnos</option>
                  <option value="6">Importar docentes</option>
                </select>
              </div>
              <div class="col-lg-4">
                <label class="form-label">
                  Subir archivo
                  <button class="btn btn-lg registro" id="archivo">Cargar <i class="fa fa-upload" aria-hidden="true"></i></button>
                </label>
                  <input type="file" name="limpiar" id="limpiar" style="display: none;">
              </div>
              <div class="col-lg-3">
                <br>
                <button class="btn btn-lg registro" id="procesar">Procesar archivo</button>
              </div>
            </div>
          </form>
          <div class="row">
            <div class="col-lg-12">
              <div class="alert alert-warning" role="alert" id="info" style="display: none;"></div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <div class="alert alert-warning" role="alert" id="mensaje" style="display: none;"></div>
            </div>
          </div>
        </div>-->
    </section>
    <div class="row">
        <div class="offset-lg-9 col-lg-3">
            <a class="regresar basico menu-principal" href='<?php /*echo CONTEXT */ ?>admin/manager/'>Regresar</a>
        </div>
    </div>
</section>
<script>
    $(document).ready(function () {


        /*##################################################################*/
        /*##################################################################*/
        /*Funciones que hacen el efecto de pasar al siguiente paso*/
        function nextTab(elem) {
            $(elem).next().find('a[data-toggle="tab"]').click();
        }
        function prevTab(elem) {
            $(elem).prev().find('a[data-toggle="tab"]').click();
        }
        $('.nav-tabs > li a[title]').tooltip();
        $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
            var $target = $(e.target);
            if ($target.parent().hasClass('disabled')) {
                return false;
            }
        });
        $(".next-step").click(function (e) {
            var $active = $('.wizard .nav-tabs li.active');
            $active.next().removeClass('disabled');
            nextTab($active);
        });
        $(".prev-step").click(function (e) {
            var $active = $('.wizard .nav-tabs li.active');
            prevTab($active);

        });
        /*##################################################################*/
        /*##################################################################*/

        $("#accion").change(function (e) {
            $(".mensaje").hide();
            $(".mensaje").html("");
            if ($(this).val() == "") {
                $("#download_ejemplo").attr("href", "#");
                $("#info").hide();
                $("#info").html();
            } else if ($(this).val() == 1) {
                $("#download_ejemplo").attr("href", context + "importar/plantilla_instituciones.csv");
                $("#download_ejemplo").attr("nombre_archivo", "plantilla_instituciones.csv");
                $("#download_ejemplo").attr("tabla", "plantilla_instituciones");
                $("#download_ejemplo").attr("resultante", "importar_instituciones.csv");
                $("#info").show();
                $("#info").html("Retorna un archivo con la siguiente estructura<br> CCT/Institución/Modulos/Grupos");
            } else if ($(this).val() == 2) {
                $("#download_ejemplo").attr("href", context + "importar/plantilla_alumnos.csv");
                $("#download_ejemplo").attr("nombre_archivo", "plantilla_alumnos.csv");
                $("#download_ejemplo").attr("tabla", "plantilla_alumnos");
                $("#download_ejemplo").attr("resultante", "importar_alumnos.csv");
                $("#info").show();
                $("#info").html("Retorna un archivo con la siguiente estructura<br> Nombre/Apellido paterno/Apellido materno/CURP/Genero/Modulo/Institución/Grado");
            } else if ($(this).val() == 3) {
                $("#download_ejemplo").attr("href", context + "importar/plantilla_docentes.csv");
                $("#download_ejemplo").attr("nombre_archivo", "plantilla_docentes.csv");
                $("#download_ejemplo").attr("tabla", "plantilla_docentes");
                $("#download_ejemplo").attr("resultante", "importar_docentes.csv");
                $("#info").show();
                $("#info").html("Retorna un archivo con la siguiente estructura<br> Nombre/Apellido paterno/Apellido materno/CURP/Genero/Institución");
            } else {
                $("#download_ejemplo").attr("href", "#");
                $("#info").hide();
                $("#info").html();
            }
        });

        /*$("#archivo").click(function (e) {
            e.preventDefault();
            var accion = $("#accion").val();
            $(".limpiar").click();
        });*/

        $(".procesar").click(function (e) {
            var accion = 0;

            /*Verificamos el numero de formulario (debido a codigo anterior para no refactorizar mucho)*/
            var numero_de_formulario = this.getAttribute('formularioNumero');

            /*Formulario 1 es el limpiar plantilla*/
            if(numero_de_formulario == '1'){
                /*Verificamos el formdata a enviar*/
                var form = new FormData($('#importFile')[0]);
                /*El valor de input hidden es el numero de accion a realizar en backend*/
                accion = $("#inputLimpiarDatosHidden").val();

                var cajaMensaje = $('#importFile .mensaje');
                var limpiar = $('#importFile .limpiar');
            }else{
                /*Verificamos el formdata a enviar*/
                var form = new FormData($('#importFile2')[0]);

                /*El valor de input hidden es el numero de accion a realizar en backend*/
                var valor = $("#inputLimpiarDatosHidden2").val();
                var cajaMensaje = $('#importFile2 .mensaje');
                var limpiar = $('#importFile2 .limpiar');

                /*Revisar backend serie de opciones anteriores*/
                if(parseInt(valor) + 3 <= 6){
                    console.log("dentro del parse", valor);
                    $("#inputLimpiarDatosHidden2").val(parseInt(valor) + 3)
                }
                accion = $("#inputLimpiarDatosHidden2").val();
                console.log("accion", accion);
            }

            e.preventDefault();


            $.ajax({
                url: context + 'admin/limpiar_datos',
                type: "post",
                data: form,
                cache: false,
                processData: false,
                contentType: false,
                beforeSend: function (xhr, opts) {

                    if (accion >= 1 && accion <= 3) {
                        if(limpiar.val() != ''){
                            cajaMensaje.html("<i class='fa fa-spinner fa-spin fa-3x fa-fw' style='font-size: 1em;'></i> Espera un momento mientras se realiza la limpieza de datos.");
                            $(".procesar").addClass('disabled');
                        }else{
                            cajaMensaje.html("<p style='color: red;'>Favor de cargar un archivo.</p>");
                            xhr.abort();
                        }
                    } else{
                        if(limpiar.val() != ''){
                            cajaMensaje.html("<i class='fa fa-spinner fa-spin fa-3x fa-fw' style='font-size: 1em;'></i> Espera un momento mientras se realiza la importación de datos.");
                            $(".procesar").addClass('disabled');
                        }else{
                            cajaMensaje.html("<p style='color: red;'>Favor de cargar un archivo.</p>");
                            xhr.abort();
                        }
                    }
                    cajaMensaje.show();
                },
                success: function (data) {

                    limpiar.val('');
                    cajaMensaje.html(data.mensaje);

                    if(data.error != 1){
                        if (data.data != null) {
                            generarCSV(data.data, true, data.titulo);
                        }
                        if (data.data1 != null) {
                            generarCSV(data.data1, true, data.titulo1);
                        }
                    }else{
                        cajaMensaje.html("<p style='color: red;'>"+data.mensaje+"</p>");
                    }
                    $(".procesar").removeClass('disabled');

                }
            });
        });
    });

    function generarCSV(JSONData, ShowLabel, titulo) {

        var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;
        var CSV = '';

        if (ShowLabel) {
            var row = "";

            for (var index in arrData[0]) {
                row += index + ',';
            }
            row = row.slice(0, -1);
            CSV += row + '\r\n';
        }

        for (var i = 0; i < arrData.length; i++) {
            var row = "";
            for (var index in arrData[i]) {
                row += '"' + arrData[i][index] + '",';
            }
            row.slice(0, row.length - 1);
            CSV += row + '\r\n';
        }

        if (CSV == '') {
            alert("Invalid data");
            return;
        }

        var fileName = titulo;
        var uri = 'data:text/csv;charset=utf-8,' + escape(CSV);
        var link = document.createElement("a");
        link.href = uri;
        link.style = "visibility:hidden";
        link.download = fileName + ".csv";
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>