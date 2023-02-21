<style>
    .font-red{
        color: red;
    }
    .font-green{
        color: green;
    }
    #search-box{
        padding: 10px;
        border-radius:4px;
    }
    #suggesstion-box{
        background: white;
        z-index: 9999;
        max-height: 300px;
        min-width: 50vw;
        overflow: auto;
        position: absolute;
        border-radius: 3px;
        border: 3px solid rgba(0,0,0,0.4);
    }
    #suggesstion-box li{
        list-style: none;
        padding: 5px 2px;
    }
    #suggesstion-box li:hover{
        background: rgba(153, 217, 234, 0.4);
        cursor: pointer;
    }
    .formularioBusqueda{
        position: relative;
    }
    .botonCancelar{
        position: absolute;
        right: 10px;
        font-size: 30px;
        top: 8px;
        cursor: pointer;
        color: rgba(0,0,0,0.4);
    }
    #contenido{
        padding-bottom: 20em;
    }
    .nombreAlumno{
        font-size: 13px;
    }

</style>

<section id="contenido">
    <?php echo $this->temp['encabezado']; ?>

    <div class="separador"></div>
    <!-- Admin -->

    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php if(isset($this->temp['mensajeUsuario']) || isset($_SESSION['mensajeUsuario'])){ ?>
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <svg style="width: 30px !important;height: 30px !important;margin-right: 10px;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
                            <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z"/>
                            <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z"/>
                        </svg>
                        <div>
                            <?php echo $this->temp['mensajeUsuario']; ?>
                            <?php echo $_SESSION['mensajeUsuario']; unset($_SESSION['mensajeUsuario']); ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-md-8">
                <h2>Alumnos <?php echo $this->temp['nombre_grupo']; ?></h2>
                <h4><?php echo $this->temp['modulo']; ?> </h4>
                <i></i>
            </div>
            <div class="col-md-4 d-flex align-items-center ">
                <button type="button" class="btGuardar btn btn-primary" id="sugerirAlumnos" data-bs-toggle="modal" data-bs-target="#modalAgregarAlumnos">
                    Agregar alumno
                </button>
            </div>

            <div class="col-12">
                <table class="table tabla" id="tablaAlumnos">
                    <thead>
                        <th>Nombre</th>
                        <th>A. Paterno</th>
                        <th>A. Materno</th>
                        <th>CURP</th>
                        <th>Modulo</th>
                        <th>Grupo</th>
                    </thead>

                    <?php
                    if (count($this->temp['lista']) > 0) {
                        echo "<tbody>";
                            foreach ($this->temp['lista'] as $alumno) { ?>
                                <tr>
                                    <td><?php echo $alumno['nombre_simple']; ?></td>
                                    <td><?php echo $alumno['a_paterno']; ?></td>
                                    <td><?php echo $alumno['a_materno']; ?></td>
                                    <td><?php echo $alumno['curp']; ?></td>
                                    <td><?php echo $alumno['nombre_modulo']; ?></td>
                                    <td><?php echo $alumno['nombre_grupo']; ?></td>
                                </tr>
                            <?php }
                        echo "</tbody>";
                    } ?>

                </table>
            </div>
        </div>
    </div>


    <!-- Modal para agregar alumnos-->
    <div class="modal fade" id="modalAgregarAlumnos" tabindex="-1" aria-labelledby="modalAgregarAlumnosLabel" aria-hidden="true">
        <div class="modal-dialog" style="min-width: 80% !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAgregarAlumnosLabel">Agregar alumnos a grupo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row">
                    <div class="col-12">
                        <div class="d-flex justify-content-between flex-wrap">
                            <h3>Asignar alumnos al: <?php echo $this->temp['nombre_grupo']; ?></h3>
                            <button type="button" class="w-auto btGuardar btn btn-warning" id="asignacionMasiva">
                                Asignación masiva con listado de curps
                            </button>
                            <button type="button" class="w-auto btGuardar btn btn-info d-none" id="asignacionSimple">
                                Asignación simple
                            </button>
                        </div>
                        <p>Alumnos seleccionados: <b id="seleccionados"></b></p>

                        <button id="guardarAlumnos" class="btGuardar d-none btn btn-success btn-sm">Agregar alumnos</button>
                    </div>

                    <!--Textarea para asignacion simple-->
                    <div class="col-12" id="formularioAsignacionSimple">
                        <span id="mensaje"></span>
                        <div class="formularioBusqueda mb-3">
                            <input type="text" id="search-box" class="form-control mt-3" placeholder="Nombre del alumno de la insitución" autocomplete="off"/>
                            <div id="suggesstion-box"></div>
                            <i class="fa fa-times-circle-o botonCancelar bg-white" aria-hidden="true"></i>
                        </div>
                        <div>
                            <small class="font-1x">Si no hay resultados, posiblemente el alumno aún no haya sido registrado en la plataforma, contacta a soporte.</small>
                        </div>
                    </div>

                    <!--Textarea para asignacion masiva-->
                    <div class="col-12 d-none" id="formularioAsignacionMasiva">
                        <div class="row w-100">
                            <span id="mensajeMasiva" class="col-lg-6"></span>
                            <span id="asignacionMasivaOk" class="col-lg-6" style="border-radius: 5px; min-height: 100px; border: 1px solid green; padding: 5px; margin-bottom: 15px;">
                                Alumnos agregados: <br>
                            </span>
                        </div>
                        <b>Carga la lista de curps que deseas agregar con el siguiente formato:</b>
                        <textarea name="curps" id="curpsAsignacionMasiva" cols="30" rows="10" class="form-control" placeholder="CURP_ALUMNO&#10;CURP_ALUMNO&#10;CURP_ALUMNO"></textarea>
                        <button id="guardarAlumnosMasiva" class="btGuardar btn btn-dark btn-sm">Buscar alumnos</button>
                    </div>

                    <div class="col-12 table-responsive">
                        <table class="table tabla" id="tablaAgregarAlumnos">
                            <thead>
                                <tr>
                                    <th>Seleccion</th>
                                    <th>Nombre</th>
                                    <th>A_paterno</th>
                                    <th>A_materno</th>
                                    <th>Curp</th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<script>
    $(function(){

        $("#tablaAlumnos").dataTable({
            language: {
                search: "Buscar alumno: ",
            }
        });
        $("#tablaAgregarAlumnos").dataTable({
            language: {
                search: "Buscar alumno: ",
            }
        });

        /*########################################################*/
        /*########################################################*/
        /*Verifica valores unicos en un array*/
        function quitarRepetidos(value, index, self) {
            return self.indexOf(value) === index;
        }

        /*Accion de carga masiva, funcion llamada tras dat clic en #guardarAlumnosMasiva*/
        function verificaCurp(curp){
            /*Creamos la promesa para que sea resuelta tras cada verificacion de curp*/
            return new Promise(async (resolve, reject) => {
                await $.ajax({
                    type: "POST",
                    url: "<?php echo CONTEXT; ?>home/obtenerUsuariosBusquedaCurpNombre",
                    data: {
                        exacto: 'si',
                        nombre: curp,
                        institucion: <?php echo $this->temp['id_institucion']; ?>
                    }
                }).done(function(data){
                    /*Agregamos a la peticion el curp en caso de que no haya registro en la base se indique
                    * al usuario para que se realice la carga*/
                    data.curp = curp;
                    /*resolve de la promesa*/
                    resolve(data);
                })
            });
        }

        /*Accion de carga masiva*/
        $("#guardarAlumnosMasiva").click(async function(){
            $("#guardarAlumnosMasiva").addClass('disabled');

            var alumnos_cargar = $("#curpsAsignacionMasiva")[0];

            /*Empezamos con las validacion del lado del front */
            /*Campo carga masiva vacio?*/
            if(alumnos_cargar.value == ''){
                $("#mensajeMasiva").html("<small class='font-red'>Introduce un listado de CURPS para verificar.</small><hr>");
                $("#guardarAlumnosMasiva").removeClass('disabled');
            }else {
                /*Campo carga masiva a mayusculas, quitando espacios y tabs*/
                alumnos_cargar.value = alumnos_cargar.value.toUpperCase();
                alumnos_cargar.value = alumnos_cargar.value.replaceAll(' ', '');
                alumnos_cargar.value = alumnos_cargar.value.replaceAll('\t', '');

                /*Campo carga masiva remplazando mayusculas*/
                alumnos_cargar.value = alumnos_cargar.value.normalize('NFD').replace(/[\u0300-\u036f]/g, '');

                /*Campo carga masiva to array*/
                listaCurps = alumnos_cargar.value.split('\n');

                var curpsNoValidos = [];
                var mensajesValidacion = [];
                var curpsCorrectos = [];
                var dataRes2 = [];

                /*Iteracion de cada curp limpiado a caracteres alfanumericos, ahora a verificar contra servidor
                * de 1 en 1, por eso se hace un promise all*/
                listaCurps = listaCurps.filter(quitarRepetidos);

                Promise.all(

                    /*Para cada curp limpio*/
                    listaCurps.map(async function(curp, indice){

                        /*Solo alfanumericos */
                        var expresionTester = /^[a-zA-Z0-9-]+$/i;

                        /*Se verifica que no sea un salto de linea vacio*/
                        if(curp.replace(' ', '') === ''){
                            return;
                        }
                        /*Testeamos que se haya limpiado correctamente verificando solo caracter alfanumerico*/
                        if(!expresionTester.test(curp)){
                            /*Indicamos que fallo el test y agregamos a lista de mensajes de validacion a corregir*/
                            mensajesValidacion.push('<small class="font-red">Curp: '+curp+', linea: #### posee caracteres alfanumericos no permitidos, verificar. </small><br>');
                            curpsNoValidos.push(curp)
                            return
                        }
                        /*Si tiene logitudes incorrectas lo indicamos*/
                        if(curp.length < 18 || curp.length > 20){
                            mensajesValidacion.push('<small class="font-red">Verifica la longitud del curp: '+curp+', linea: #### que posea de 18-20 caracteres. </small><br>');
                            curpsNoValidos.push(curp)
                            return
                        }
                        /*Mandamos a procesar contra servidor solo curps con 18 a 20 caracteres y alfanumericos correctos*/
                        dataRes2.push(await verificaCurp(curp));
                    })
                )/*Then para indicar que una vez procesada cada promesa (verificacion asincrona contra servidor de cada curp)*/
                    .then(function(){

                    /*dataRes2 trae los resolve de cada promesa trayendo consigo la variable data de cada success de cada ajax*/
                    dataRes2.forEach(function(data, indice){
                        /*Si hay coincidencias en sistema se agregara a la tabla de carga de alumnos... */
                        if(data.data.length == 1){
                            /*Si el alumno se agrego a la tabla correctamente lo agregamos para mostrar mensaje verde de algunos alumnos cargados*/
                            /*#######################################*/
                            /*#######################################*/
                            /*#######################################*/
                            /*#######################################*/

                            /*Al dar clic poner en la tabla pendientes de agregar*/
                            var campos_agregar = ['nombre', 'ap1', 'ap2', 'curp'];
                            //var alumno = this;
                            alumno = data.data[0];

                            var datatableAgregar = [];
                            var agregar = 1;

                            /*Verificamos si ya fue agregado al datatable*/
                            document.querySelectorAll(".curpDatatableAdd").forEach(function(curpDatatable){
                                if(curpDatatable.innerText.indexOf(alumno.curp) !== -1){
                                    agregar = 0;
                                }
                            });

                            if(!agregar){
                                $("#mensaje").html("<span style='color: red;'>El curp ya fue agregado al grupo.<span>");
                                setTimeout(function(){
                                    $("#mensaje").html("");
                                }, 1000)
                                return;
                            }
                            datatableAgregar.push("<input type='checkbox' class='form-check-input' name='alumnoSeleccionadoAgregar[]' value='"+alumno.id+"' checked>");

                            campos_agregar.forEach(function(item){
                                if(item == 'curp'){
                                    var insertar = "<span class='curpDatatableAdd'>"+alumno[item]+"</span>";
                                    datatableAgregar.push(insertar)
                                }else{
                                    datatableAgregar.push(alumno[item])
                                }
                            });

                            $("#tablaAgregarAlumnos").DataTable().row.add(
                                datatableAgregar
                            ).draw()

                            $("#suggesstion-box").html('');
                            $("#search-box").val('');

                            /*Array de alumnos seleccionados*/
                            var alumnosSeleccionados = $('input[name="alumnoSeleccionadoAgregar[]"]:checked');
                            $("#seleccionados").html(alumnosSeleccionados.length);

                            /*Se cuentan los checkboxes y se ejecuta el evento para que cada que alguien de click se vulvan a contar*/
                            contar_checks_al_click();
                            $('input[name="alumnoSeleccionadoAgregar[]"]').click(function(){
                                var elementoPresionado = this;
                                $("#tablaAgregarAlumnos").DataTable()
                                    .row( $(elementoPresionado).parents('tr') )
                                    .remove()
                                    .draw();
                                contar_checks_al_click();
                            });

                            $("#mensaje").html("<span class='font-green'>Alumno agregado<span>");
                            setTimeout(function(){
                                $("#mensaje").html("");
                            }, 1000)

                            /*#######################################*/
                            /*#######################################*/
                            /*#######################################*/
                            /*#######################################*/

                            /*Proceso que agrega curp, obtiene los verdes (cargados en tabla listos), quita duplicados y vuelve a pintar*/
                            if($("#asignacionMasivaOk")[0].innerHTML.indexOf(alumno.curp) == -1) {
                                $("#asignacionMasivaOk")[0].innerHTML += "<span class='font-green'>" + alumno.curp + "<span><br>";
                            }

                            /*Ponemos los curps correctos para verificar un mensaje "se agregaron alumnos pero aun hay errores"*/
                            curpsCorrectos.push(alumno.curp);
                        }
                        /*El curp-alumno no ha sido cargado al sistema por IT para poder ser asignado a un grupo */
                        else{
                            mensajesValidacion.push('<small class="font-red">Alumno no se ha cargado a sistema, contactar a soporte, curp: '+data.curp+', linea: ####.</small> <br>');
                            curpsNoValidos.push(data.curp);
                        }
                    });

                    /*Si hay curps no validos por caracteres alfanumericos o por no estar cargados en sistema y si hay curps correctamente cargados
                    * indicamos que ya se cargaron algunos pero falta por verificar toda la lista que coloco el docente*/
                    if(curpsNoValidos.length > 0 && curpsCorrectos.length > 0){
                        mensajesValidacion.push('<small class="font-green">Alumnos cargados a la tabla, verificar errores para continuar.</small><br>');
                    }

                    /*Quitamos los valores repetidos en caso de que existan*/
                    mensajesValidacion = mensajesValidacion.filter(quitarRepetidos);
                    curpsNoValidos = curpsNoValidos.filter(quitarRepetidos);

                    /*Ya que recuperamos los errores asignamos las lineas correctas en donde actualmente se encuentran */
                    mensajesValidacion.forEach(function(item, indiceLineaError){
                        mensajesValidacion[indiceLineaError] = item.replace('####', (indiceLineaError + 1));
                    });
                    mensajesValidacion.push('<hr>');

                    $("#mensajeMasiva").html(mensajesValidacion.join(''));
                    alumnos_cargar.value = curpsNoValidos.join('\n');

                    $("#guardarAlumnosMasiva").removeClass('disabled');
                });


            }
        });
        /*########################################################*/
        /*########################################################*/


        /*Botones asignacion masiva y asignacion simple, mostrar formaularios*/
        $("#asignacionMasiva").click(function(){
            $("#formularioAsignacionMasiva")[0].classList.remove('d-none');
            $("#formularioAsignacionSimple")[0].classList.add('d-none');
            $("#asignacionMasiva")[0].classList.add('d-none');
            $("#asignacionSimple")[0].classList.remove('d-none');
        });
        $("#asignacionSimple").click(function(){
            $("#formularioAsignacionSimple")[0].classList.remove('d-none');
            $("#formularioAsignacionMasiva")[0].classList.add('d-none');
            $("#asignacionSimple")[0].classList.add('d-none');
            $("#asignacionMasiva")[0].classList.remove('d-none');
        });


        /*Boton guardar alumnos buscados que le hacian falta al grupo*/
        $("#guardarAlumnos").click(function(){
            $("#guardarAlumnos").addClass('disabled');

            var alumnosSeleccionados = [];
            $('input[name="alumnoSeleccionadoAgregar[]"]:checked').each(function(){
                alumnosSeleccionados.push(this.value);
            });

            if(alumnosSeleccionados.length > 0){
                $.ajax({
                    type: "POST",
                    url: "<?php echo CONTEXT; ?>home/asignarAlumnosGrupoVerificandoInstGrupo",
                    data: {
                        alumnos: alumnosSeleccionados,
                        alumnosCantidad: alumnosSeleccionados.length,
                        institucion: <?php echo $this->temp['id_institucion']; ?>,
                        grupo: <?php echo $this->temp['id_grupo']; ?>
                    },
                    success: function(data){
                        /*Respuesta ok*/
                        if(data.status == 1){
                            $("#mensaje").html("");
                            $("#mensaje").html("<span style='color: green;'>"+data.mensaje+"<span>");
                            setTimeout(function(){
                                location.reload();
                            }, 3000)
                        }
                        /*Estado maximo de alumnos en grupo*/
                        /*Alumnos no son de institucion o alumnos*/
                        /*Estado permisos denegados*/
                        else if(data.status == 2){
                            $("#mensaje").html("");
                            $("#mensaje").html("<span style='color: red;'>"+data.mensaje+"<span>");
                            $("#guardarAlumnos").removeClass('disabled');
                        }
                    }
                });
            }
        });


        /*Boton de cancelar que limpia y coloca la busqueda previa que se estaba haciendo*/
        $(".botonCancelar").click(function (){
            $('#institucion').html('');
            $("#search-box").val(localStorage.getItem('prediccion'));
        })

        /*Funcion que cuenta los checkboxes tras cada clic*/
        function contar_checks_al_click(){
            var alumnosSeleccionados = $('input[name="alumnoSeleccionadoAgregar[]"]:checked');
            $("#seleccionados").html(alumnosSeleccionados.length);
            if(alumnosSeleccionados.length != 0){
                $("#guardarAlumnos")[0].classList.remove('d-none');
            }else{
                $("#guardarAlumnos")[0].classList.add('d-none');
            }
        }


        /*Funcion que se llama cada que una prediccion es cargada*/
        function accionesListadoAlumnos(){
            $('.nombreAlumno').click(function(){

                /*Al dar clic poner en la tabla pendientes de agregar*/
                var campos_agregar = ['nombre', 'a_paterno', 'a_materno', 'curp'];
                var alumno = this;

                var datatableAgregar = [];
                var agregar = 1;

                /*Verificamos si ya fue agregado al datatable*/
                document.querySelectorAll(".curpDatatableAdd").forEach(function(curpDatatable){
                    if(curpDatatable.innerText.indexOf(alumno.getAttribute('curp')) !== -1){
                        agregar = 0;
                    }
                });

                if(!agregar){
                    $("#mensaje").html("<span style='color: red;'>El curp ya fue agregado al grupo.<span>");
                    setTimeout(function(){
                        $("#mensaje").html("");
                    }, 1000)
                    $("#suggesstion-box").html('');
                    $("#search-box").val('');
                    return;
                }
                datatableAgregar.push("<input type='checkbox' class='form-check-input' name='alumnoSeleccionadoAgregar[]' value='"+alumno.id+"' checked>");

                campos_agregar.forEach(function(item){
                    if(item == 'curp'){
                        var insertar = "<span class='curpDatatableAdd'>"+alumno.getAttribute(item)+"</span>";
                        datatableAgregar.push(insertar)
                    }else{
                        datatableAgregar.push(alumno.getAttribute(item))
                    }
                });

                $("#tablaAgregarAlumnos").DataTable().row.add(
                    datatableAgregar
                ).draw()

                $("#suggesstion-box").html('');
                $("#search-box").val('');

                /*Array de alumnos seleccionados*/
                var alumnosSeleccionados = $('input[name="alumnoSeleccionadoAgregar[]"]:checked');
                $("#seleccionados").html(alumnosSeleccionados.length);

                /*Se cuentan los checkboxes y se ejecuta el evento para que cada que alguien de click se vulvan a contar*/
                contar_checks_al_click();
                $('input[name="alumnoSeleccionadoAgregar[]"]').click(function(){
                    var elementoPresionado = this;

                    /*Elimina alumno de la tabla tras dar clic al checkbox*/
                    $("#tablaAgregarAlumnos").DataTable()
                        .row( $(elementoPresionado).parents('tr') )
                        .remove()
                        .draw();
                    console.log("Diste clic al: ", elementoPresionado);
                    var cuadro_alumnos_agregrados = $("#asignacionMasivaOk")[0].innerHTML.split('<br>');

                    $("#asignacionMasivaOk")[0].innerHTML = '';
                    $("#asignacionMasivaOk")[0].innerHTML += cuadro_alumnos_agregrados.filter(function(item, index){
                        console.log("Valor en cuadro: ", item)
                        console.log("Valor a buscar: ", elementoPresionado.parentElement.parentElement.children[elementoPresionado.parentElement.parentElement.children.length-1].innerText)
                        return item.indexOf(
                            elementoPresionado.parentElement.parentElement.children[elementoPresionado.parentElement.parentElement.children.length-1].innerText
                        ) == -1;
                    }).join('<br>');

                    contar_checks_al_click();
                });

                $("#mensaje").html("<span style='color: green;'>Alumno agregado<span>");

                /*Agregar a lista verde el curp que se agrego por buscador */
                if($("#asignacionMasivaOk")[0].innerHTML.indexOf(alumno.getAttribute('curp')) == -1){
                    $("#asignacionMasivaOk")[0].innerHTML += "<span class='font-green'>"+alumno.getAttribute('curp')+"<span><br>";
                }

                /*Se quita leyenda de alumno agregado*/
                setTimeout(function(){
                    $("#mensaje").html("");
                }, 1000)



            })
        }


        /*Caja de busqueda predicciones*/
        $("#search-box").keyup(function(){
            var busqueda = $(this).val();
            if(busqueda == ''){
                $("#suggesstion-box").html('');
            }else{
                $.ajax({
                    type: "POST",
                    url: "<?php echo CONTEXT; ?>home/obtenerUsuariosBusquedaCurpNombre",
                    data: {nombre: busqueda, institucion: <?php echo $this->temp['id_institucion']; ?>},
                    success: function(data){

                        elementos = [];
                        data.data.forEach(function(item){
                            /*alumnoAgregarListado clase identificadora de cada alumno*/
                            elementos.push("<li nombre='"+item.nombre +"' a_paterno='"+item.ap1 +"' a_materno='"+item.ap2 +"' curp='"+item.curp+"' class='nombreAlumno' id='"+item.id+"'>"+item.nombre +" "+ item.ap1+" " + item.ap2 +" CURP: "+ item.curp+"</li>")
                        });

                        $("#suggesstion-box").show();
                        $("#suggesstion-box").html(elementos);
                        accionesListadoAlumnos()
                    }
                });
            }
        });


    });
</script>
