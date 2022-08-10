<style>
    .spinner {
        border: 4px solid rgba(0, 0, 0, 0.1);
        width: 26px;
        height: 26px;
        border-radius: 50%;
        border-left-color: #09f;
        animation: spin 1s ease infinite;
        margin-top: 8px;
    }

    @keyframes spin {
        0% {transform: rotate(0deg);}
        100% {transform: rotate(360deg);}
    }
</style>

<section  id="contenido"    class="my-0">
    <?php echo $this->temp['encabezado']; ?>
</section>
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto text-center">
            <select name="nivel" id="niveles" class="form-control mx-auto my-4">
                <option value="">[ Seleccionar un nivel ]</option>
                <?php foreach($this->temp['niveles'] as $nivel) { ?>
                    <option value="<?php echo $nivel['id']; ?>">
                        <?php echo $nivel['nombre']; ?>
                    </option>
                <?php } ?>
            </select>


            <select name="modulo" id="modulos" class="form-control mx-auto my-4">
                <option value="">[ Seleccione un modulo del nivel ]</option>
            </select>

            <select name="leccion" id="lecciones" class="form-control mx-auto my-4">
                <option value="">[ Seleccione una lección para ver secciones ]</option>
            </select>

            <label for="secciones" style="float:left;">Secciones ACTIVAS</label>
            <select name="seccion" id="secciones" class="form-control mx-auto my-4">
                <option value="">[ Seleccionar una sección ]</option>
            </select>

            <!-- Button trigger modal -->
            <button type="button" id="botonSeccion" class="btn btn-primary d-none" data-bs-toggle="modal" data-bs-target="#modalSeccion">
                Visualización de la sección
            </button>

            <hr>
            <ul id="contenidos_actuales" class="w-100 text-center flex-wrap d-flex justify-content-center align-items-center list-unstyled">
                <!--Aqui iran los contenidos de las secciones que se vayan a cargar (img instrucciones, mp3 de audios es-en)-->
            </ul>

            <form id="carga_archivos" class="d-none mt-4" onsubmit="return false;">

                <div class="archivo d-flex align-items-center flex-wrap my-3">
                    <label for="secciones" class="d-block" style="float:left; width: 100%;">Imagen de instrucciones para sección</label>
                    <input type="file" id="imagen_instrucciones" accept="image/png, image/jpeg, image/jpg" class="form-control">
                    <div id="imagen_instrucciones_status" class="w-100 d-block"></div>
                    <div id="imagen_instrucciones_spinner" class="spinner spinner1 mx-auto hide"></div>
                </div>

                <div class="archivo d-flex align-items-center flex-wrap my-3">
                    <label for="secciones" style="float:left; width: 100%;">Audio de instrucciones para sección ESPAÑOL</label>
                    <input type="file" id="audio_instrucciones_es" accept=".mp3" class="form-control">
                    <div id="audio_instrucciones_es_status" class="w-100 d-block"></div>
                    <div id="audio_instrucciones_es_spinner" class="spinner spinner1 mx-auto hide"></div>
                </div>

                <div class="archivo d-flex align-items-center flex-wrap my-3">
                    <label for="secciones" style="float:left; width: 100%;">Audio de instrucciones para sección INGLES</label>
                    <input type="file" id="audio_instrucciones_en" accept=".mp3" class="form-control">
                    <div id="audio_instrucciones_en_status" class="w-100 d-block"></div>
                    <div id="audio_instrucciones_en_spinner" class="spinner spinner1 mx-auto hide"></div>
                </div>

                <button type="submit" id="boton_cargar_todo" class="btn btn-primary ">
                    Cargar todo
                </button>
            </form>

            <div class="row">
                <div class="offset-lg-9 col-lg-3">
                    <a class="regresar basico menu-principal" href='<?php echo CONTEXT ?>admin/manager/'>Regresar</a>
                </div>
            </div>




            <!--Modal iframe para mostrar ejemplo de la pagina-->
            <!-- Modal -->
            <div class="modal fade" id="modalSeccion" tabindex="-1" aria-labelledby="modalSeccionLabeledby" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalSeccionLabeledby">Sección verificación</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="seccionVer">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--Modal iframe para mostrar ejemplo de la pagina-->
        </div>
    </div>
</div>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(function (){
        var inputs_multimedia_validar = ['imagen_instrucciones', 'audio_instrucciones_es', 'audio_instrucciones_en'];
        inputs_multimedia_validar.forEach(function(item){
            document.querySelector('#'+item).onchange = function(){


                if( this.value != '' && (this.value.length > 120 || !(/^[a-zA-Z0-9 .]+$/.test(this.files[0].name))) ){
                    Swal.fire({
                        icon: 'error',
                        text: 'Nombre de archivo MUY largo y evita usar caracteres especiales o acentos en nombre de archivos \'\ : ; ` ´ , ° | ¬ # $ % & ¿ ? - _',
                    });
                    this.value = '';
                }
            }
        })

        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        /**
         * Verificamos que se seleccione un nivel para mostrar los modulos
         */
        $("#niveles").change(function(item){

            document.querySelector("#contenidos_actuales").innerHTML = '';

            var selectModulos = document.querySelector("#modulos");
            selectModulos.innerHTML = '';
            selectModulos.innerHTML = '<option value="">[ Seleccione un modulo del nivel ]</option>';

            var selectlecciones = document.querySelector("#lecciones");
            selectlecciones.innerHTML = '';
            selectlecciones.innerHTML = '<option value="">[ Seleccione una lección para ver secciones ]</option>';

            var selectsecciones = document.querySelector("#secciones");
            selectsecciones.innerHTML = '';
            selectsecciones.innerHTML = '<option value="">[ Seleccionar una sección ]</option>';

            $("#botonSeccion")[0].classList.add('d-none');


            var data = getInfoAjax('GetModulos', {nivel: this.value}, 'admin');
            if(data){

                data.forEach(function(item, index){
                    var option = document.createElement('option');
                    option.value = item['LGF0150001'];
                    option.innerHTML = "Modulo "+(index+1)+": "+item['LGF0150002'];
                    selectModulos.append(option);
                })
            }else{
                console.log("Algo salio mal niveles change")
            }
        });

        /**
         * Verificamos que se seleccione un modulo para mostrar las lecciones
         */
        $("#modulos").change(function(item){

            var selectsecciones = document.querySelector("#secciones");
            selectsecciones.innerHTML = '';
            selectsecciones.innerHTML = '<option value="">[ Seleccionar una sección ]</option>';

            document.querySelector("#contenidos_actuales").innerHTML = '';

            $("#botonSeccion")[0].classList.add('d-none');

            var data = getInfoAjax('GetLecciones', {modulo: this.value}, 'admin');
            if(data){
                var selectLecciones = document.querySelector("#lecciones");
                selectLecciones.innerHTML = '';
                selectLecciones.innerHTML = '<option value="">[ Seleccione una lección para ver secciones ]</option>';

                data.forEach(function(item, index){
                    var option = document.createElement('option');
                    option.value = item['LGF0160001'];
                    option.setAttribute('numero_leccion', item['LGF0160007']);
                    option.innerHTML = "Lección "+(index+1)+": "+item['LGF0160002'];
                    selectLecciones.append(option);
                })
            }else{
                console.log("Algo salio mal modulos change")
            }
        });

        /**
         * Verificamos que se seleccione una leccion para mostrar secciones ACTIVAS
         */
        $("#lecciones").change(function(item){
            var nivelI   = $('#niveles').val();
            var moduloI  = $('#modulos').val();
            var leccionI = $('#lecciones').val();

            document.querySelector("#contenidos_actuales").innerHTML = '';

            var data = getInfoAjax('GETSeccionesActivas', {nivel:nivelI, modulo:moduloI, leccion:leccionI}, 'admin');
            if(data){


                var selectSecciones = document.querySelector("#secciones");
                selectSecciones.innerHTML = '';
                selectSecciones.innerHTML = '<option value="">[ Seleccionar una sección ]</option>';

                data.forEach(function(item, index){
                    if(item['estatus'] == 1){
                        var option = document.createElement('option');
                        option.value = item['orden'];
                        option.setAttribute("estructura_navegacion", item['id']);
                        option.setAttribute("nombre_seccion", item['seccion']);
                        option.innerHTML = "Sección "+(index+1)+": "+item['seccion'];
                        selectSecciones.append(option);
                    }
                })

            }else{
                console.log("Algo salio mal lecciones change")
            }
        });

        /**
         * #######################################################################
         * #######################################################################
         * Creamos y mostramos el li de cada elemento de multimedia actualmente cargado
         */
        function mostrar_elemento(nombre, id, nombre_campo, tipo_elemento){
            var nivelI   = $('#niveles').val();
            var moduloI  = $('#modulos').val();
            var leccionI = document.querySelector('#lecciones');
            var numero_leccion = leccionI[leccionI.selectedIndex].getAttribute('numero_leccion');

            var mostrar_elementos_actualm_cargados = document.querySelector("#contenidos_actuales");

            var bot_eliminar_multimedia = document.createElement('button');
            /*Evento click en "activar_funcion_botns_eliminar"()*/
            bot_eliminar_multimedia.classList.add('eliminar_multimedia');
            bot_eliminar_multimedia.classList.add('btn');
            bot_eliminar_multimedia.classList.add('btn-danger');
            bot_eliminar_multimedia.classList.add('text-white');
            bot_eliminar_multimedia.classList.add('btn-sm');
            bot_eliminar_multimedia.classList.add('d-block');
            bot_eliminar_multimedia.classList.add('mx-auto');
            bot_eliminar_multimedia.id = id;
            bot_eliminar_multimedia.setAttribute('nombre_campo', nombre_campo);
            bot_eliminar_multimedia.innerHTML = "Eliminar elemento actual";
            bot_eliminar_multimedia.setAttribute('relative_path', "portal/archivos/recursosLecciones/n"+nivelI+"/m"+moduloI+"/l"+numero_leccion+"/"+tipo_elemento+"/");

            var enlace_elemento = document.createElement('a');
            enlace_elemento.href = context + "portal/archivos/recursosLecciones/n"+nivelI+"/m"+moduloI+"/l"+numero_leccion+"/"+tipo_elemento+"/"+nombre;
            enlace_elemento.target = '_blank';
            enlace_elemento.innerHTML = nombre;
            enlace_elemento.classList.add('small');

            var elemento_li = document.createElement('li');

            elemento_li.append(enlace_elemento);
            elemento_li.append(bot_eliminar_multimedia);
            elemento_li.classList.add('mt-4');
            elemento_li.classList.add('w-100');
            elemento_li.classList.add('elemento_'+nombre_campo);

            mostrar_elementos_actualm_cargados.append(elemento_li);
        }

        /**
         * Esta funcion le da funcionalidad a los botones de eliminar cuando una
         * seccion tiene elementos cargados y el usuario necesita elimnar uno en
         * especifico
         */
        function activar_funcion_botns_eliminar(){
            $('.eliminar_multimedia').each(function(){
                this.onclick = function(){
                    if(confirm('¿Seguro que deseas borrar este elemento?')){
                        var id_estructura_navegacion = this.id;
                        var nombre_campo_eliminar = this.getAttribute('nombre_campo');
                        var ruta_archivo = this.getAttribute('relative_path');

                        var data = getInfoAjax('DELPartOfEstructuraNavegacion', {
                            id_estructura_navegacion: id_estructura_navegacion,
                            nombre_campo_eliminar: nombre_campo_eliminar,
                            ruta_archivo: ruta_archivo
                        }, 'admin');

                        if(data){
                            if(data[0] == 1){
                                document.querySelector('.elemento_'+nombre_campo_eliminar).innerHTML = "Elemento borrado satisfactoriamente.";
                            }else{
                                alert("Algo fallo recarga la pagina y vuelve a intentar");
                            }
                        }else{
                            console.log("Algo salio mal eliminar_multimedia")
                        }
                    }
                }
            });
        }

        /**
         * Al cambiar el select se mostraran los elementos multimedia actuales
         * para que el usuario pueda ver que hay y si se editaran o remplazaran
         */
        $("#secciones").change(function(item){
            $("#botonSeccion")[0].classList.remove('d-none');
            $("#carga_archivos")[0].classList.remove('d-none');

            var mostrar_elementos_actualm_cargados = document.querySelector("#contenidos_actuales");
            mostrar_elementos_actualm_cargados.innerHTML = '';

            var id_estructura = this[this.selectedIndex].getAttribute('estructura_navegacion');

            var data = getInfoAjax('GETEstructuraNavegacion', {id_estructura: id_estructura}, 'admin');
            if(data){

                var elementos_comprobar    = ['img_instrucciones', 'audio_es', 'audio_en'];
                var tipo_de_carpeta_buscar = [        'img',         'mp3',        'mp3'];

                elementos_comprobar.forEach(function(item, indexElemento){
                    if(data[item] != null && data[item] != '' && data[item] != undefined){
                        mostrar_elemento(data[item], data['id'], item, tipo_de_carpeta_buscar[indexElemento]);
                    }
                })

                activar_funcion_botns_eliminar();
            }else{
                console.log("Algo salio mal secciones change")
            }
        });

        /**
         * #######################################################################
         * #######################################################################
         */

        /**
         * Verificamos que se seleccione una seccion ACTIVA para mostrar previsualizacion
         */
        $("#botonSeccion").click(function(item){
            var nivelI   = $('#niveles').val();
            var moduloI  = $('#modulos').val();
            var leccionI = $('#lecciones').val();
            var ordenEstructuraNavegacion = $('#secciones').val();

            if(nivelI != '' && moduloI != '' && leccionI != '' && ordenEstructuraNavegacion != ''){
                var URL = context + "home/navegar/"+nivelI+"_"+moduloI+"_"+leccionI+"_"+ordenEstructuraNavegacion;

                var iframeS = document.createElement('iframe');
                iframeS.src = URL;
                iframeS.width = "100%";
                iframeS.style.height = "100vh";

                $('#seccionVer').html(iframeS);
            }else{
                $('#seccionVer').html("<h1>Debes seleccionar una sección para poder previsualizar</h1>");

            }
        });


         /**
         * Boton para cargar o actualizar contenido
         */
        $("#boton_cargar_todo").click(function(event){

            var instrucciones = document.getElementById('imagen_instrucciones');
            var audio_es = document.getElementById('audio_instrucciones_es');
            var audio_en = document.getElementById('audio_instrucciones_en');

            var secciones = document.querySelector('#secciones');
            var nombre_seccion = secciones[secciones.selectedIndex].getAttribute('nombre_seccion');

            var estructura_navegacion = document.querySelector('#secciones');
            var id_estruc_navegacion = estructura_navegacion[estructura_navegacion.selectedIndex].getAttribute('estructura_navegacion');

            var formularioArchivos = document.getElementById('carga_archivos');  // Our HTML form's ID

            /**Se cargara por primera vez el contenido*/
            if((instrucciones.value != '' || audio_en.value != '' || audio_es.value != '')){
                if(secciones.value == ''){
                    Swal.fire({
                        icon: 'error',
                        text: 'Es necesario seleccionar una sección.',
                    });
                    event.preventDefault()
                }

                /*#############*/
                //formularioArchivos = document.getElementById('carga_archivos');  // Our HTML form's ID
                var confirmacion_archivos = confirm("¿Estas seguro de cargar los archivos?");
                if(confirmacion_archivos){

                    formularioArchivos.onsubmit = function(event) {
                        event.preventDefault();

                        var id_inputs_archivos = ['imagen_instrucciones', 'audio_instrucciones_es', 'audio_instrucciones_en'];
                        var mimetypes_cada_elem= ['image.*', 'audio.*', 'audio.*'];

                        var nivelI                    = $('#niveles').val();
                        var moduloI                   = $('#modulos').val();
                        var leccionI                  = $('#lecciones').val();
                        var ordenEstructuraNavegacion = $('#secciones').val();

                        var formData = [];

                        var boton_subir_mas = document.createElement('button');
                        boton_subir_mas.innerHTML = "Cargar mas archivos...";
                        boton_subir_mas.classList.add('btn');
                        boton_subir_mas.classList.add('btn-warning');
                        boton_subir_mas.type = "button";
                        boton_subir_mas.onclick = function(){

                            $("#boton_cargar_todo")[0].classList.remove("hide");
                            /*Ocultamos boton cargar mas...*/
                            this.classList.add('hide');
                            /*Limpiamos status previos*/
                            document.querySelectorAll('[id*=_status]').forEach(function(item){
                                item.innerHTML = ''
                            });

                            document.querySelector("#contenidos_actuales").innerHTML = '';
                        }
                        var boton_subir_mas_cargado = 0;


                        var URL = nivelI+"_"+moduloI+"_"+leccionI+"_"+ordenEstructuraNavegacion;

                        /*Para cada elemento archivo se verificara cual no esta vacio y mandara de 1 en 1*/
                        id_inputs_archivos.forEach(function(item, indexItem){
                            /*  myFile */
                            var elemento_tratar_cargar = document.getElementById(item);

                            if(elemento_tratar_cargar.value !== ''){

                                if(elemento_tratar_cargar.value.length > 300 || !(/^[a-zA-Z0-9 .]+$/.test(elemento_tratar_cargar.files[0].name))){
                                    Swal.fire({
                                        icon: 'error',
                                        text: 'Nombre de archivo MUY largo y evita usar caracteres especiales o acentos en nombre de archivos \'\ : ; , ° | ¬ # $ % & ¿ ? - _',
                                    });
                                    return;
                                }

                                var spinner = document.getElementById(item+"_spinner");
                                var status = document.getElementById(item+"_status");

                                var files = elemento_tratar_cargar.files;
                                formData[indexItem] = new FormData();
                                var file = files[0];

                                if ( !file.type.match(mimetypes_cada_elem[indexItem])) {
                                    status.style.color = "red";
                                    status.innerHTML = 'El archivo cargado no es del tipo requerido favor de verificar.';
                                    return;
                                }else{
                                    spinner.classList.remove('hide');

                                    $("#boton_cargar_todo")[0].classList.add("hide");
                                }
                                formData[indexItem].append('fileAjax', file, file.name);
                                formData[indexItem].append('tipo_elemento', item);
                                formData[indexItem].append('ruta_elemento', URL);
                                formData[indexItem].append('nombre_seccion', nombre_seccion);
                                formData[indexItem].append('id_estruc_navegacion', id_estruc_navegacion);


                                var xhr = new XMLHttpRequest();
                                xhr.open('POST', context+'home/subirinstruccionesseccionesdelecciones', true);

                                xhr.onload = function (event) {

                                    if (xhr.status == 200 && event.target.response == 1) {

                                        status.style.color = "green";
                                        status.innerHTML = 'Tu documento se subio con éxito.';
                                        spinner.classList.add('hide');
                                        //elemento_tratar_cargar.value = '';

                                        if(!boton_subir_mas_cargado){
                                            document.getElementById('carga_archivos').append(boton_subir_mas);
                                            boton_subir_mas_cargado = 1;
                                            setTimeout(function(){
                                                var click = new Event('click');
                                                boton_subir_mas.dispatchEvent(click);
                                            }, 2000);
                                        }

                                        //$("#boton_cargar_todo")[0].classList.remove("hide");
                                    } else if(xhr.status == 200 && event.target.response == 2) {
                                        status.innerHTML = 'Tipo de archivo no permitido.';
                                    } else if(xhr.status == 200 && event.target.response == 0){
                                        status.style.color = "red";
                                        status.innerHTML = 'Hubo un error en el servidor al guardar tu archivo, recarga la página y vuelve a intentar.';
                                        spinner.classList.add('hide');
                                    }
                                };
                                // Send the data.
                                xhr.send(formData[indexItem]);
                            }
                        });
                    }
                }else{
                    console.log("Aun no estas seguro de subir archivos");

                    event.preventDefault()
                }

            }
            /**Se actualizara el contenido*/
            else{
                Swal.fire({
                    icon: 'error',
                    text: 'Es necesario cargar por lo menos un archivo.',
                });

            }
        });
    });
</script>
