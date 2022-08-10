
<section  id="contenido"    class="my-0">
    <?php echo $this->temp['encabezado']; ?>
</section>
<div class="container" id="contenidoWeb">
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

            <hr>
            <div id="inputURLvideo" class="my-3">
                <div class="justify-content-around" id="mostrarPreviewActual">
                    <button type="button"  class=" my-3 btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPreviewActual">
                        Mostrar preview actual
                    </button>
                    <button type="button" id="borrarPreviewLeccion" class="my-3 btn btn-danger">
                        Eliminar preview actual
                    </button>
                </div>
                <hr>

                <b>Similitudes de URL requeridas:</b>
                <p class="text-start">https://www.youtube.com/watch?v=bIX_95zNX2E&feature=youtu.be</p>
                <p class="text-start">https://www.youtube.com/watch?v=bIX_95zNX2E</p>
                <p class="text-start">https://youtu.be/bIX_95zNX2E</p>
                <input type="url" id="urlVideo" class="form-control" placeholder="Coloca la URL del video en YouTube">

                <button type="button" id="verificarVideoButton" class="my-3 btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPreview">
                    Verificar video
                </button>
            </div>

            <div id="botonCargaPreview" class="my-3">
                <button class="btn btn-warning text-white">Cargar preview a leccion</button>
            </div>

            <div class="row">
                <div class="offset-lg-9 col-lg-3 mt-5">
                    <a class="regresar basico menu-principal" href='<?php echo CONTEXT ?>admin/manager/'>Regresar</a>
                </div>
            </div>


            <!-- Modal -->
            <div class="modal fade" id="modalPreview" tabindex="-1" aria-labelledby="modalPreviewLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalPreviewLabel">Verifica si el video carga correctamente</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="contenidoModal">

                        </div>
                        <div class="modal-footer">
                            <b>
                                Si el video se muestra correctamente cierra esta alerta emergente y presiona el boton naranja para
                                cargar el preview a la base de datos.
                            </b>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->

            <!-- Modal 2 mostrar preview que posee la leccion -->
            <div class="modal fade" id="modalPreviewActual" tabindex="-1" aria-labelledby="modalPreviewActualLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalPreviewActualLabel">Verifica si el video carga correctamente</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="contenidoModalActual">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->



        </div>
    </div>
</div>

<script>
    $(function (){

        $("#verificarVideoButton").hide();
        $("#botonCargaPreview").hide();
        $("#inputURLvideo").hide();
        $("#mostrarPreviewActual").hide();

        /**
         * Verificamos que se seleccione un nivel para mostrar los modulos
         */
        $("#niveles").change(function(item){

            $("#botonCargaPreview").hide();
            $("#mostrarPreviewActual").hide();

            var selectModulos = document.querySelector("#modulos");
            selectModulos.innerHTML = '';
            selectModulos.innerHTML = '<option value="">[ Seleccione un modulo del nivel ]</option>';

            var selectlecciones = document.querySelector("#lecciones");
            selectlecciones.innerHTML = '';
            selectlecciones.innerHTML = '<option value="">[ Seleccione una lección para ver secciones ]</option>';


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

            $("#botonCargaPreview").hide();
            $("#mostrarPreviewActual").hide();

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
         * Verificamos que se seleccione una leccion para mostrar input de url de video y ocultamos boton de
         * cargar para que el usuario verifique que se carga correctamente el video
         */
        $("#lecciones").change(function(item){
            $("#inputURLvideo").show();
            $("#botonCargaPreview").hide();

            var id_leccion = document.querySelector('#lecciones').value;
            var data = getInfoAjax('GetLeccionData', {leccion: id_leccion}, 'admin');
            if(data){
                if(data[0]['LGF0160009'] == null || data[0]['LGF0160009'] == ''){
                    console.log("LGF0160009 if", data[0]['LGF0160009'] == null );

                    $("#mostrarPreviewActual").hide();
                    $('#contenidoModalActual').html('No posee preview cargado hasta el momento');
                }else{
                    console.log("LGF0160009 else", data[0]['LGF0160009'] == null );

                    $("#mostrarPreviewActual").show();
                    $('#contenidoModalActual').html(data[0]['LGF0160009']);
                }

            }else{
                console.log("Algo salio mal cargar data de leccion")
            }

        });

        $("#urlVideo").keyup(function(){
                console.log("this", this.value.length);
            if(this.value.replaceAll(' ','') == '' || this.value.length < 25){
                $("#botonCargaPreview").hide();
                $("#verificarVideoButton").hide();
            }else{
                $("#verificarVideoButton").show();
            }
        });

        /**
         * Boton que inserta el iframe que resultara si el cliente carga el preview, verificar igual backend
         */
        $("#verificarVideoButton").click(function(){
            var url = $("#urlVideo").val();

            var nombre_leccion = document.querySelector('#lecciones');
            nombre_leccion = nombre_leccion[nombre_leccion.selectedIndex].innerHTML;

            var id_video, rx = /^.*(?:(?:youtu\.be\/|v\/|vi\/|u\/\w\/|embed\/|shorts\/)|(?:(?:watch)?\?v(?:i)?=|\&v(?:i)?=))([^#\&\?]*).*/;
            id_video = url.match(rx);

            /*Mismo iframe se armara en backend, solo se enviara id de video por motivos de seguridad*/
            var base_url_armar_video_iframe = '<iframe width="100%" style="min-height: 30vh;" src="https://www.youtube.com/embed/'+id_video[1]+'" title="'+nombre_leccion+'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';

            $("#contenidoModal").html(base_url_armar_video_iframe);


            $("#botonCargaPreview").show();
        });

        /**
         * Una vez "verificado" por el usuario cargamos los datos hacia la base de datos
         */
        $("#botonCargaPreview").click(function(item){
            var url = $("#urlVideo").val();
            var id_leccion = document.querySelector('#lecciones').value;


            var id_video, rx = /^.*(?:(?:youtu\.be\/|v\/|vi\/|u\/\w\/|embed\/|shorts\/)|(?:(?:watch)?\?v(?:i)?=|\&v(?:i)?=))([^#\&\?]*).*/;
            id_video = url.match(rx)[1]+'"';


            var data = getInfoAjax('cargarpreview', {id_leccion: id_leccion, id_video: id_video}, 'admin');
            if(data){
                if(data['error'] == 0){
                    $("#contenidoWeb").html(data['data']);
                }else if(data['error'] == 1){
                    $("#botonCargaPreview").after(data['data']);
                }
            }else{
                console.log("Algo salio mal boton carga preview")
            }
        });

        $("#borrarPreviewLeccion").click(function(event){
            if(!confirm('¿Seguro que deseas borrar el preview?')){

                return;
            }

            var id_leccion = document.querySelector('#lecciones').value;

            var data = getInfoAjax('eliminarpreview', {id_leccion: id_leccion}, 'admin');
            if(data){
                if(data['error'] == 0){
                    $("#contenidoWeb").html(data['data']);
                }else if(data['error'] == 1){
                    $("#botonCargaPreview").after(data['data']);
                }
            }else{
                console.log("Algo salio mal boton carga preview");
            }
        });





    });
</script>
