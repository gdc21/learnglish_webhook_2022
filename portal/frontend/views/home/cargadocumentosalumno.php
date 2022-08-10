<?php
#Anotaciones indica los casos posibles para la carga de archivos y verificacion de evaluaciones
/*echo "# not_exercises_yet -> El alumno no ha completado los ejercicios de la leccion<br>";
echo "# no_files -> El alumno completo ejercicios pero no ha subido archivos<br>";
echo "# document_missing -> El alumno ha subido speaking pero no documentos<br>";
echo "# speaking_missing -> El alumno subio documento pero aun no speaking<br>";



echo $this->temp['anotaciones'];
*/
?>

<style>
    .spinner {
        border: 4px solid rgba(0, 0, 0, 0.1);
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border-left-color: #09f;
        animation: spin 1s ease infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
</style>


<?php if($this->temp['anotaciones'] == 'not_exercises_yet'){ ?>
    <h4 class="my-4">
        Recuerda que para realizar tu evaluación, deberás de completar los <?php echo $this->temp['cantidadEjercicios']; ?>
        ejercicios de tu lección en curso, las podrás identificar por la siguiente imagen:
    </h4>
    <div class="contenido d-flex justify-content-around align-items-center flex-wrap" style="padding-bottom: 100px;">
        <div class="imagen-demo">
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGEAAAA1CAIAAADeexIVAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA2hpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDo4MThBODkwQTBEMjA2ODExODhDNkQ3RkJCQ0I1QzRCMiIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpFQTU5OTNBMUEwNDMxMUU1QkIwQkE5NjVDRTcyQTMxMyIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpFQTU5OTNBMEEwNDMxMUU1QkIwQkE5NjVDRTcyQTMxMyIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M2IChNYWNpbnRvc2gpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6MDU4MDExNzQwNzIwNjgxMThDMTRBMjFEQjgxRDI0RTMiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6ODE4QTg5MEEwRDIwNjgxMTg4QzZEN0ZCQkNCNUM0QjIiLz4gPC9yZGY6RGVzY3Jp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" alt="">
            <b class="d-block w-100 text-center">
                <?php echo $this->temp['cantidadEjerciciosHechos']; ?> /
                <?php echo $this->temp['cantidadEjercicios']; ?>

            </b>
        </div>
        <img src="<?php echo ODA_REL; ?>n3/m9/l2/obj7/img/AU-M5-L2_V5.png" alt="" class="rounded-pill" style="max-width: 100%;">
    </div>
<?php } elseif($this->temp['anotaciones'] == 'no_files' || $this->temp['anotaciones'] == 'document_missing' || $this->temp['anotaciones'] == 'speaking_missing' ){ ?>
    <h4 class="my-4">
        Recuerda que deberás de realizar la carga de tus documentos de acuerdo a las indicaciones de tu profesor:
    </h4>
    <div class="contenido d-flex justify-content-around align-items-center flex-wrap" style="padding-bottom: 100px;">

        <?php if($this->temp['anotaciones'] == 'document_missing'){ ?>
            <div class="speakingCargado text-center">
                <i class="fa fa-check-circle" aria-hidden="true" style="background: white; border-radius: 50%; color: green; margin: 2px; z-index: 99999;font-size: 100px;"></i>
                <h3>Speaking cargado.</h3>
            </div>
        <?php }else{ ?>
            <div class="cargarSpeaking">
                <h3>Aqui se cargara tu speaking</h3>
                <div class="boton w-100 text-center">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#speaking" class="btn-primary btn">
                        Grabar
                    </button>
                </div>
            </div>
        <?php } ?>


        <?php if($this->temp['anotaciones'] == 'speaking_missing'){ ?>
            <div class="documentoCargado text-center">
                <i class="fa fa-check-circle" aria-hidden="true" style="background: white; border-radius: 50%; color: green; margin: 2px; z-index: 99999;font-size: 100px;"></i>
                <h3>Documento cargado.</h3>
            </div>
        <?php }else{ ?>
            <div class="cargarSpeaking">
                <h3>Aqui se cargará tu documento</h3>
                <div class="boton w-100 text-center">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#documento" class="btn btn-secondary">
                        Cargar
                    </button>
                </div>
            </div>
        <?php } ?>

    </div>



    <div class="modal fade" id="speaking" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="min-height: 120% !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Speaking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" >
                    <section class="container" style="padding-bottom: 40px;">

                        <h2 class="my-3">
                            <u style="color: blue; cursor: pointer;" id="instrucciones">
                                ¿Cómo subir tu speaking?
                            </u>
                        </h2>

                        <div class="collapse hide" id="instruccionesLista">
                            <ul>
                                <li>
                                    <h3>Instrucciones:</h3>
                                    <ul>
                                        <li><small>Herramientas</small></li>
                                        <li><small>Computadora con micrófono</small></li>
                                        <li><small>Celular con micrófono</small></li>
                                        <li><small>Cualquier electrónico que tenga incluido un micrófono</small></li>
                                    </ul>
                                    <ol>
                                        <li><small>Selecciona el micrófono con el que desees grabar.</small></li>
                                        <li><small>Selecciona el botón "comenzar". Empezará a grabar el audio.</small></li>
                                        <li><small>Selecciona el botón "detener". Detendrá la grabación.</small></li>
                                        <li><small>Se descargará un archivo .mp3 con el audio grabado.</small></li>
                                        <li><small>Se subirá el audio descargado en el apartado "cargar audio".</small></li>
                                        <li><small>Finalmente, aparecerá un mensaje con la siguiente leyenda "Tu speaking se subió con éxito".</small></li>

                                    </ol>
                                </li>
                                <li>¡Listo, todo se subió con éxito!</li>
                            </ul>

                        </div>

                        <div class="imagenInstruccionesSpeaking w-100 text-center">
                            <i class="d-block" style="text-align: justify !important;">
                                Graba un audio con lo aprendido a lo largo de esta lección mencionando, lo que más te gustó, lo que podria mejorar y lo que te gustaria aprender.
                            </i>
                            <img src="<?php echo CONTEXT; ?>portal/oda/n2/m6/l2/obj7/img/I-03-M2-L10.png" alt="" style="min-width: 50%; max-width: 100%; margin: 0 auto;">

                        </div>

                        <form action="" style="margin: 10px 0px 0px 0pc;" id="formAjax">
                            <b>Cargar audio</b>
                            <input type="file" id="fileAjax" name="speaking" class="form-control" required accept="audio/mp3,audio/*;capture=microphone">
                            <span id="status" ></span>
                            <div class="w-100 text-center">
                                <button class="mt-3 btn-success btn mx-0" id="botonEnviar" style="max-width: max-content; height: max-content;">
                                    Enviar actividad
                                </button>
                            </div>

                            <div class="spinner spinner1 mx-auto hide"></div>

                        </form>
                        <script>
                            var myForm = document.getElementById('formAjax');  // Our HTML form's ID
                            var myFile = document.getElementById('fileAjax');  // Our HTML files' ID
                            var spinner = document.querySelector(".spinner1");
                            var statusP = document.querySelector("#status");

                            myForm.onsubmit = function(event) {
                                event.preventDefault();

                                var files = myFile.files;
                                var formData = new FormData();
                                var file = files[0];

                                if (!file.type.match('audio.*')) {
                                    statusP.innerHTML = 'El archivo cargado no es de tipo audio.';
                                    return;
                                }else{
                                    spinner.classList.remove('hide');
                                    $("#botonEnviar")[0].classList.add("hide");
                                }
                                formData.append('fileAjax', file, file.name);
                                formData.append('leccion', <?php echo $this->temp["id_leccion"]; ?>);


                                var xhr = new XMLHttpRequest();
                                xhr.open('POST', '<?php echo CONTEXT; ?>home/subiraudios');

                                xhr.onload = function (event) {
                                    console.log(event.target.response)
                                    if (xhr.status == 200 && event.target.response == 1) {
                                        statusP.style.color = "green";
                                        statusP.innerHTML = 'Tu speaking se subio con éxito, recargando página...';
                                        spinner.classList.add('hide');
                                        setTimeout(function(){
                                            location.reload();
                                        }, 2000);

                                    } else if(xhr.status == 200 && event.target.response == 2) {
                                        statusP.innerHTML = 'Tipo de archivo no permitido.';
                                    } else if(xhr.status == 200 && event.target.response == 0){
                                        statusP.innerHTML = 'Hubo un error en el servidor al guardar tu archivo, recarga la página y vuelve a intentar.';
                                    }
                                };

                                // Send the data.
                                xhr.send(formData);
                            }
                        </script>


                        <div class="page text-center" id="actividad" style="width: 100%; padding-bottom: 10px; background: white;  bottom: 0; left: 0;">

                            <div id="audioContenidoWeb" >
                                <label class="d-block my-2 text-center w-100">ó</label>
                                <label class="d-block bold w-100" style="text-align: left !important;">Grabar audio</label>
                                <label class="d-block">Microfonos detectados...</label>
                                <select name="listaDeDispositivos" id="listaDeDispositivos" style="max-width: 100%;"></select>

                                <p id="duracion"></p>

                                <div id="audioGrabado" class="d-flex justify-content-center align-items-center flex-wrap"></div>
                                <style>
                                    @media screen and (max-width: 850px){#audioAlumno{width: 60%; display: block; margin: 10px 20% !important;}}
                                </style>
                                <span id="statusBlob" ></span>
                                <div class="spinner spinner3 mx-auto hide"></div>
                                <div id="botonesBlob">
                                    <button class="p-0 m-0 btn btn-info text-white botonGrabacion" id="btnComenzarGrabacion" style="width: max-content; height: max-content; padding: 5px 15px !important;">
                                        Grabar
                                    </button>
                                    <button class="p-0 m-0 btn btn-warning text-white botonGrabacion" id="btnDetenerGrabacion" style="width: max-content; height: max-content; padding: 5px 15px !important;">
                                        Detener
                                    </button>
                                </div>



                                <script>
                                    $(function (){
                                        /*Funcion que envia el formulario para guardar un audio que previamente se genero en blob en el servidor*/
                                        function activarBotonEnvioAudioGrabado(){
                                            var myForm = document.getElementById('formularioEnvioBlob');
                                            var statusBlob = document.querySelector("#statusBlob");
                                            var spinner3 = document.querySelector(".spinner3");


                                            myForm.onsubmit = function(event) {
                                                event.preventDefault();

                                                spinner3.classList.remove('hide');
                                                $("#botonesBlob")[0].classList.add("hide");

                                                var formData = new FormData();
                                                formData.append('archivo', myForm.archivoAudioBlob.value);
                                                formData.append('leccion', <?php echo $this->temp["id_leccion"]; ?>);

                                                var xhr = new XMLHttpRequest();
                                                xhr.open('POST', '<?php echo CONTEXT; ?>home/moveblobtospeakingfolder', true);

                                                xhr.onload = function (event) {
                                                    console.log(event)
                                                    if (xhr.status == 200 && event.target.response == 1) {
                                                        statusBlob.style.color = "green";
                                                        statusBlob.innerHTML = 'Tu speaking se subio con éxito, recargando página...';
                                                        spinner3.classList.add('hide');
                                                        $("#botonesBlob")[0].classList.remove("hide");
                                                        setTimeout(function () {
                                                            location.reload();
                                                        }, 2000);


                                                    } else{
                                                        alert("Algo fallo al mover el archivo interno del servidor")
                                                    }
                                                };
                                                // Send the data.
                                                xhr.send(formData);
                                            }
                                        }



                                        /*Funcion para desabilitar los botones al momento de grabar*/
                                        $("#btnComenzarGrabacion").click(function(){
                                            this.setAttribute("disabled", true);
                                        });
                                        $("#btnDetenerGrabacion").click(function(){
                                            $("#btnComenzarGrabacion")[0].removeAttribute("disabled");
                                        });


                                        /*Desplegable de instrucciones*/
                                        $("#instrucciones").click(function(){
                                            $("#instruccionesLista").toggle('show');
                                        });
                                        $("#instrucciones2").click(function(){
                                            $("#instruccionesLista2").toggle('show');
                                        });




                                        const tieneSoporteUserMedia = () =>
                                            !!(navigator.mediaDevices.getUserMedia)

                                        // Si no soporta...
                                        if (typeof MediaRecorder === "undefined" || !tieneSoporteUserMedia())
                                            return alert("Tu navegador web no cumple los requisitos; por favor, actualiza a un navegador como Firefox o Google Chrome");


                                        // Declaración de elementos del DOM
                                        const $listaDeDispositivos = document.querySelector("#listaDeDispositivos"),
                                            $duracion = document.querySelector("#duracion"),
                                            $btnComenzarGrabacion = document.querySelector("#btnComenzarGrabacion"),
                                            $btnDetenerGrabacion = document.querySelector("#btnDetenerGrabacion");

                                        const segundosATiempo = numeroDeSegundos => {
                                            let horas = Math.floor(numeroDeSegundos / 60 / 60);
                                            numeroDeSegundos -= horas * 60 * 60;
                                            let minutos = Math.floor(numeroDeSegundos / 60);
                                            numeroDeSegundos -= minutos * 60;
                                            numeroDeSegundos = parseInt(numeroDeSegundos);
                                            if (horas < 10) horas = "0" + horas;
                                            if (minutos < 10) minutos = "0" + minutos;
                                            if (numeroDeSegundos < 10) numeroDeSegundos = "0" + numeroDeSegundos;

                                            return `${horas}:${minutos}:${numeroDeSegundos}`;
                                        };
                                        // Variables "globales"
                                        let tiempoInicio, mediaRecorder, idIntervalo;

                                        // Comienza a grabar el audio con el dispositivo seleccionado
                                        $btnComenzarGrabacion.addEventListener("click", function (){

                                            if (!$listaDeDispositivos.options.length) return alert("No hay dispositivos");
                                            // No permitir que se grabe doblemente
                                            if (mediaRecorder) return alert("Ya se está grabando");

                                            document.getElementById('audioGrabado').innerHTML = '';

                                            navigator.mediaDevices.getUserMedia({
                                                audio: {
                                                    deviceId: $listaDeDispositivos.value,
                                                }
                                            })
                                                .then(
                                                    stream => {
                                                        // Comenzar a grabar con el stream
                                                        mediaRecorder = new MediaRecorder(stream);
                                                        // Ayudante para la duración; no ayuda en nada pero muestra algo informativo
                                                        mediaRecorder.start();
                                                        tiempoInicio = Date.now();
                                                        idIntervalo = setInterval(function (){
                                                            $duracion.textContent = segundosATiempo((Date.now() - tiempoInicio) / 1000);
                                                        }, 500);

                                                        // En el arreglo pondremos los datos que traiga el evento dataavailable
                                                        const fragmentosDeAudio = [];
                                                        // Escuchar cuando haya datos disponibles
                                                        mediaRecorder.addEventListener("dataavailable", evento => {
                                                            // Y agregarlos a los fragmentos
                                                            fragmentosDeAudio.push(evento.data);
                                                        });
                                                        // Cuando se detenga (haciendo click en el botón) se ejecuta esto
                                                        mediaRecorder.addEventListener("stop", () => {
                                                            // Detener el stream
                                                            stream.getTracks().forEach(track => track.stop());

                                                            // Detener la cuenta regresiva
                                                            clearInterval(idIntervalo);
                                                            tiempoInicio = null;
                                                            $duracion.textContent = "";

                                                            // Convertir los fragmentos a un objeto binario
                                                            const blobAudio = new Blob(fragmentosDeAudio, { type: "audio/ogg" });

                                                            // Crear una URL o enlace para descargar
                                                            urlParaDescargar = URL.createObjectURL(blobAudio);

                                                            var formData = new FormData();
                                                            formData.append('fileAjax', blobAudio);
                                                            formData.append('leccion', <?php echo $this->temp["id_leccion"]; ?>);


                                                            var xhr = new XMLHttpRequest();
                                                            xhr.responseType = 'json';
                                                            xhr.open('POST', '<?php echo CONTEXT; ?>home/subiraudiosblobpreload', true);

                                                            xhr.onload = function (event) {
                                                                console.log(event.target.response)
                                                                if (xhr.status == 200 && event.target.response.res != 'no') {

                                                                    let formulario = document.createElement('form');
                                                                    formulario.id = "formularioEnvioBlob";

                                                                    let audio = document.createElement("audio");
                                                                    audio.src = event.target.response.rutaAudio;
                                                                    audio.controls = true;
                                                                    audio.id = "audioAlumno";
                                                                    audio.controlsList = "nodownload";

                                                                    let botonEnvio = document.createElement('button');
                                                                    botonEnvio.innerHTML = "Enviar audio";
                                                                    botonEnvio.classList = "btn btn-primary btn-sm p-1";

                                                                    let leccion = document.createElement('input');
                                                                    leccion.type = "hidden";
                                                                    leccion.id = "leccionAudioBlob";
                                                                    leccion.value = '<?php echo $this->temp["id_leccion"]; ?>';

                                                                    let archivo = document.createElement('input');
                                                                    archivo.type = "hidden";
                                                                    archivo.id = "archivoAudioBlob";
                                                                    archivo.value = event.target.response.nombreArchivo;

                                                                    formulario.prepend(leccion);
                                                                    formulario.prepend(archivo);
                                                                    formulario.prepend(botonEnvio);
                                                                    formulario.prepend(audio);

                                                                    document.getElementById('audioGrabado').innerHTML = '';
                                                                    document.getElementById('audioGrabado').prepend(formulario);
                                                                    /*document.getElementById('audioGrabado').prepend(audio);*/

                                                                    activarBotonEnvioAudioGrabado();

                                                                } else{
                                                                    alert("Algo fallo durante la subida al servidor.")
                                                                }
                                                            };
                                                            // Send the data.
                                                            xhr.send(formData);
                                                        });
                                                    }
                                                )
                                                .catch(error => {
                                                    // Aquí maneja el error, tal vez no dieron permiso
                                                    console.log(error)
                                                });
                                        });
                                        $btnDetenerGrabacion.addEventListener("click", function(){
                                            if (!mediaRecorder) return alert("No se está grabando");
                                            mediaRecorder.stop();
                                            mediaRecorder = null;
                                        });

                                        // Cuando ya hemos configurado lo necesario allá arriba llenamos la lista
                                        navigator
                                            .mediaDevices
                                            .enumerateDevices()
                                            .then(dispositivos => {
                                                for (let x = $listaDeDispositivos.options.length - 1; x >= 0; x--) {
                                                    $listaDeDispositivos.options.remove(x);
                                                }
                                                dispositivos.forEach((dispositivo, indice) => {
                                                    if (dispositivo.kind === "audioinput") {
                                                        const $opcion = document.createElement("option");
                                                        // Firefox no trae nada con label, que viva la privacidad
                                                        // y que muera la compatibilidad
                                                        $opcion.text = dispositivo.label || `Dispositivo ${indice + 1}`;
                                                        $opcion.value = dispositivo.deviceId;
                                                        $listaDeDispositivos.appendChild($opcion);
                                                    }
                                                })
                                            })
                                    });
                                </script>

                            </div>
                        </div>

                    </section>
                </div>
            </div>
        </div>
    </div>






    <div class="modal fade" id="documento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog"  style="min-height: 120% !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Speaking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding-bottom: 70px;">
                    <section class="container" style="padding-bottom: 40px;">

                        <h2 class="my-3">
                            <u style="color: blue; cursor: pointer;" id="instrucciones2">
                                ¿Cómo subir tu documento?
                            </u>
                        </h2>

                        <div class="collapse hide" id="instruccionesLista2">

                            <ul>
                                <li>
                                    <h3>Herramientas</h3>
                                    <ul>
                                        <li>Computadora con word</li>
                                        <li>Celular con word</li>
                                        <li>Cualquier electronico que tenga incluido word</li>
                                    </ul>
                                </li>
                                <li>
                                    <h3>Instrucciones:</h3>
                                    <ol>
                                        <li><small>Crea un archivo word. Deberá incluir tu tarea.</small></li>
                                        <li><small>Cargar el archivo creado en el apartado "cargar documento a mi profesor".</small></li>
                                        <li><small>Finalmente, se deberá seleccionar el botón "enviar actividad".</small></li>
                                        <li><small>Aparecera una leyenda "Tu documento se subió con éxito".</small></li>
                                    </ol>
                                </li>
                                <li>¡Listo, todo se subió con éxito!</li>
                            </ul>
                        </div>


                        <div class="imagenInstruccionesSpeaking w-100 text-center">
                            <i class="d-block" style="text-align: justify !important;">
                                Crea una historia en Word con lo aprendido a lo largo de esta lección indicando, lo que más te gustó, lo que podria mejorar y lo que te gustaria aprender.
                            </i>
                            <img src="<?php echo CONTEXT; ?>portal/oda/n2/m6/l2/obj7/img/I-03-M2-L10.png" alt="" style="min-width: 50%; max-width: 100%; margin: 0 auto;">

                        </div>

                        <form action="#" id="formAjax2" style="margin: 10px 0px;">
                            <b>Cargar documento a mi profesor</b>
                            <input type="file" id="fileAjax2" name="speaking" class="form-control" required accept="application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword" >
                            <span id="status2" style="color: red;"></span>
                            <button class="w-100 mt-3 btn-success btn mx-0" id="botonEnviar2">Enviar actividad</button>

                            <div class="spinner spinner2 mx-auto hide"></div>
                        </form>

                        <script>
                            var myForm2 = document.getElementById('formAjax2');  // Our HTML form's ID
                            var myFile2 = document.getElementById('fileAjax2');  // Our HTML files' ID
                            var spinner2 = document.querySelector(".spinner2");
                            var statusP2 = document.querySelector("#status2");

                            myForm2.onsubmit = function(event) {
                                event.preventDefault();

                                var files = myFile2.files;
                                var formData = new FormData();
                                var file = files[0];

                                if ( !file.type.match('application/msword') &&
                                     !file.type.match("application/vnd.openxmlformats-officedocument.wordprocessingml.document")) {
                                    statusP2.innerHTML = 'El archivo cargado no es de tipo Office Word.';
                                    return;
                                }else{
                                    spinner2.classList.remove('hide');
                                    $("#botonEnviar2")[0].classList.add("hide");
                                }
                                formData.append('fileAjax', file, file.name);
                                formData.append('leccion', <?php echo $this->temp["id_leccion"]; ?>);

                                var xhr = new XMLHttpRequest();
                                xhr.open('POST', '<?php echo CONTEXT; ?>home/subiradocumentos', true);

                                xhr.onload = function (event) {
                                    if (xhr.status == 200 && event.target.response == 1) {
                                        statusP2.style.color = "green";
                                        statusP2.innerHTML = 'Tu documento se subio con éxito';
                                        spinner2.classList.add('hide');
                                        setTimeout(function(){
                                            location.reload();
                                        }, 3000);

                                    } else if(xhr.status == 200 && event.target.response == 2) {
                                        statusP2.innerHTML = 'Tipo de archivo no permitido.';
                                    } else if(xhr.status == 200 && event.target.response == 0){
                                        statusP2.innerHTML = 'Hubo un error en el servidor al guardar tu archivo, recarga la página y vuelve a intentar.';
                                    }
                                };

                                // Send the data.
                                xhr.send(formData);
                            }
                        </script>

                    </section>
                </div>
            </div>
        </div>
    </div>






<?php } ?>
