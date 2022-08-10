<!--<section id="contenido">
  <?php /*echo $this->temp['encabezado']; */?>
  <div class="separador"></div>
   <div class="row">
    <div class="col-lg-6">
      <select name="cliente" id="cliente" class="form-control">
        <option value="">Seleccionar Cliente</option>
        <option value="">Desarrollo</option>
        <option value="">Desarrollo</option>
        <option value="">Desarrollo</option>
      </select>
    </div>
    <div class="col-lg-6">
      <select name="institucion" id="institucion" class="form-control">
        <option value="">Seleccionar Institución</option>
        <option value="">Desarrollo</option>
        <option value="">Desarrollo</option>
        <option value="">Desarrollo</option>
      </select>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12" style="text-align: center;">
      <h3 class="title-section"><b><?php /*echo $this->temp['seccion_nombre']; */?></b></h3>
    </div>
  </div>
  <div class="separador"></div>
  <input type="hidden" id="nivel" value="<?php /*echo $this->temp['nivel']; */?>">
  <input type="hidden" id="docente" value="<?php /*echo $this->temp['docente']; */?>">
  <div class="table-responsive">
    <table class="table tabla reporte_tabla" id="tbl_informe">
      <thead>
        <th>Grupo</th>
        <th>Alumnos</th>
        <th>Nivel</th>
        <th>Docente</th>
        <th>Reportes</th>
      </thead>
      <tbody></tbody>
    </table>
  </div>
  
  <div class="row">
    <div class="col-lg-12" style="text-align: center;">
      <a href="<?php /*echo CONTEXT */?>admin/addGroup" class="btn btn-lg btn-primary">Nuevo Grupo</a>
    </div>
  </div>
  <div class="separador"></div>
  <div class="row">
    <div class="offset-lg-9 col-lg-3">
      <?php /*if ($_SESSION['perfil'] == 1 || $_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 3) { */?>
        <a class="regresar basico menu-principal" href='<?php /*echo CONTEXT */?>admin/manager/'>Regresar</a>
      <?php /*} else { */?>
        <a class="regresar basico menu-principal" href='<?php /*echo CONTEXT */?>home/teacher/'>Regresar</a>
      <?php /*} */?>
    </div>
  </div>
</section>
<style>
  a.btn.btn-lg.btn-primary {
    font-size: 1em;
    margin-top: 1em;
    padding: 0.5em 2em;
  }
</style>-->


<section  id="contenido"    class="my-0">
    <?php echo $this->temp['encabezado']; ?>
    <?php #var_dump($this->temp['menuItems']); ?>

</section>
<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto text-center">
            <div class="row my-4">
                <div class="col-lg-12" style="text-align: initial;">
                    <a href="<?php echo CONTEXT ?>admin/addGroup" class="btn btn-lg btn-primary">Nuevo Grupo</a>
                </div>
            </div>

            <h4>Inst => Institución, verificar concuerden con la seleccionada</h4>
            <b class="mt-5">Selecciona una institución:</b>
            <select name="modulo" id="instituciones" class="form-control mx-auto mb-4">
                <option value="">[ Seleccionar institucion ]</option>
                <?php foreach($this->temp['instituciones'] as $institucion) { ?>
                    <option value="<?php echo $institucion['LGF0270001']; ?>">
                        <?php echo "Id: ".$institucion['LGF0270001']." => ".$institucion['LGF0270002']; ?>
                    </option>
                <?php } ?>
            </select>

            <div id="notificaciones"></div>

            <div id="resultados">
                <b class="mt-4">Selecciona un grupo (se asignara a los alumnos que introduzcas):</b>
                <select name="grupos" class="mb-4 form-control " id="selectGrupos">
                    <option value="">[ Seleccione grupo ]</option>
                </select>
                <div id="infoGrupo" class="w-100 my-2"></div>

                <b class="mt-4">Selecciona un docente (se asignará al grupo que seleccionaste):</b>
                <select name="docentes" class="form-control mb-4" id="selectDocentes">
                    <option value="">[ Define al profesor del grupo ]</option>
                </select>

                <textarea name="alumnosCurp" id="alumnos" cols="30" rows="10" class="form-control" placeholder="CURP_ALUMNO,CURP_ALUMNO,CURP_ALUMNO"></textarea>

                <button class="btn mx-auto btn-warning text-white mt-3 mb-5" id="varificacionDeFallos">
                    <h5>Verificar si hay fallos... </h5>
                </button>

                <div id="status" class="my-2 w-100"></div>
                <button class="btn mx-auto btn-success text-white mt-3 mb-5 d-none" id="cargarAlumnosAgrupo">
                    <h5>Cargar alumnos</h5>
                </button>
            </div>


            <div id="cargarElementos">
            </div>



            <div class="row">
                <div class="offset-lg-9 col-lg-3">
                    <?php if ($_SESSION['perfil'] == 1 || $_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 3) { ?>
                    <a class="regresar basico menu-principal" href='<?php echo CONTEXT ?>admin/manager/'>Regresar</a>
                    <?php } else { ?>
                    <a class="regresar basico menu-principal" href='<?php echo CONTEXT ?>home/teacher/'>Regresar</a>
                    <?php } ?>
                </div>
            </div>


        </div>
    </div>
</div>


<!-- Modal para mostrar los alumnos de un grupo -->
<div class="modal fade" id="modalAlumnosMostrar" tabindex="-1" aria-labelledby="modalAlumnosMostrarLabel" aria-hidden="true">
    <div class="modal-dialog" style="display: flex; justify-content: center;">
        <div class="modal-content" style="min-width: 80vw !important;">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAlumnosMostrarLabel">
                    Alumnos del grupo
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body table-responsive" id="listadoAlumnosModal">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<style>
    #noAparecen li{
        text-align: initial !important;
    }
    .boton-mostrar-alumnos{
        border: 3px solid #0971b7;
        color: #0971b7;
        font-weight: bold;
    }
    #tabla{
        min-width: max-content !important;
    }
</style>
<script>
    $(function (){


        $("#alumnos").change(function(){
            $("#cargarAlumnosAgrupo")[0].classList.add('d-none');
            $("#varificacionDeFallos")[0].classList.remove('d-none');
            $("#status").html("");
        });


        $("#varificacionDeFallos").click(function(){
            var alumnos_cargar = $("#alumnos")[0];

            if(alumnos_cargar.value == ''){
                $("#status").html("<b style='color: red;'>Introduce el listado de CURPS faltantes.</b>");
            }else{
                alumnos_cargar.value = alumnos_cargar.value.toUpperCase();
                alumnos_cargar.value = alumnos_cargar.value.replaceAll('\n', '');
                alumnos_cargar.value = alumnos_cargar.value.replaceAll(' ', '');
                alumnos_cargar.value = alumnos_cargar.value.replaceAll('\t', '');
                alumnos_cargar.value = alumnos_cargar.value.normalize('NFD').replace(/[\u0300-\u036f]/g, '');

                if(alumnos_cargar.value[alumnos_cargar.value.length-1] == ','){

                    alumnos_cargar.value = alumnos_cargar.value.substr(0, alumnos_cargar.value.length-1);
                }

                $("#varificacionDeFallos")[0].classList.add('d-none');

                $("#status").html("<b style='color: green;'>Data lista para ser cargada, presiona 'Cargar alumnos'.</b>");
                $("#cargarAlumnosAgrupo")[0].classList.remove('d-none');
            }
        });


        function agregar_html(elemento, verifica_null, valor){
            if(verifica_null != undefined ){
                elemento.innerHTML += valor;
            }
        }


        $("#cargarElementos")[0].style.display = 'none';
        $("#resultados")[0].style.display = 'none';

        var selectGrupos = document.querySelector("#selectGrupos");
        var selectDocentes = document.querySelector("#selectDocentes");
        var info_grupo = $("#infoGrupo")[0];
        var listadoAlumnosModal = $("#listadoAlumnosModal")[0];

        selectGrupos.onchange = function(){
            var enlace = document.createElement('a');
            var nombre = this.options[this.selectedIndex].text;
            var id_grupo = this.value;

            document.querySelector('#enlaceEditarGrupo')?.remove();
            listadoAlumnosModal.innerHTML = '';

            info_grupo.innerHTML = '';
            info_grupo.style.textAlign = "initial";
            info_grupo.style.paddingLeft = "50px";


            enlace.classList.add('btn');
            enlace.id = "enlaceEditarGrupo";
            enlace.classList.add('text-white');
            enlace.classList.add('btn-info');
            enlace.classList.add('my-1');
            enlace.innerHTML = 'Editar: '+nombre;
            enlace.target = "_blank";

            enlace.href = context + "admin/editGroup/"+id_grupo;

            this.parentNode.insertBefore(enlace, this.nextSibling);

            var data = getInfoAjax('informacionGrupos', {id: id_grupo}, 'admin');

            var botonModal = document.createElement('button');
            botonModal.classList.add('btn');
            botonModal.classList.add('boton-mostrar-alumnos');
            botonModal.setAttribute('data-bs-toggle', 'modal');
            botonModal.setAttribute('data-bs-target', '#modalAlumnosMostrar');
            botonModal.type = "button";
            botonModal.innerHTML = "Ver alumnos de grupo";
            botonModal.onclick = function(){

                var data2 = getInfoAjax('listar_alumnos_grupo_especifico', {id: id_grupo}, 'admin');

                if(data2){
                    listadoAlumnosModal.innerHTML = '';

                    var tablaAlumnos = document.createElement('table');
                    tablaAlumnos.classList.add('table');
                    tablaAlumnos.classList.add('tabla');
                    tablaAlumnos.id = 'tabla';

                    var campos_tabla = ['nombre', 'institucion', 'curp', 'CCT'];

                    var tbody = document.createElement('tbody');
                    var thead = document.createElement('thead');

                    data2['lista'].forEach(function(item, indiceArray){
                        var tr = document.createElement('tr');
                        tbody.append(tr);

                        campos_tabla.forEach(function(elemento, indice_campos){
                            if (indiceArray == 0){
                                var th = document.createElement('th');
                                th.innerHTML = elemento;
                                thead.append(th);

                                if(indice_campos == campos_tabla.length-1){
                                    var th = document.createElement('th');
                                    th.innerHTML = "Acciones";
                                    thead.append(th);

                                    tablaAlumnos.append(thead);
                                    tablaAlumnos.append(tbody);
                                }
                            }
                            var td = document.createElement('td');
                            td.innerHTML = item[elemento];
                            tr.append(td);

                            if(indice_campos == campos_tabla.length-1){
                                var td = document.createElement('td');
                                td.innerHTML = "<a target='_blank' href='"+context+"admin/editUsuario/"+item['id']+"'><i class='fa fa-pencil' aria-hidden='true'></i>Editar</a>";
                                tr.append(td);
                            }
                        });
                    });

                    listadoAlumnosModal.append(tablaAlumnos);

                }
            }

            if(data){
                console.log("data", data);
                agregar_html(info_grupo, data['info'][0]['nombre'], 'Nombre grupo:'+data['info'][0]['nombre']+"<br>");
                agregar_html(info_grupo, data['info'][0]['modulo'], 'Modulo:'+data['info'][0]['modulo']+"<br>");
                agregar_html(info_grupo, data['info'][0]['ciclo'], 'Ciclo:'+data['info'][0]['ciclo']+"<br>");
                agregar_html(info_grupo, data['info'][0]['totalAlumnos'], 'Total alumnos:'+data['info'][0]['totalAlumnos']+"<br>");


                /*Verificacion del docente, si un grupo tiene asignado se pedira confirmacion*/
                info_grupo.innerHTML += data['info'][0]['nombre_docente'] != null ? "Docente:"+data["info"][0]["nombre_docente"]+"<br>": 'No tiene docente asignado';
                if(data['info'][0]['nombre_docente'] != null){

                    var botonCambiarDocente = document.createElement('button');
                    botonCambiarDocente.classList.add('btn');
                    botonCambiarDocente.classList.add('mr-3');
                    botonCambiarDocente.classList.add('boton-mostrar-alumnos');
                    botonCambiarDocente.type = "button";
                    botonCambiarDocente.style.marginRight = "10px";
                    botonCambiarDocente.innerHTML = "Cambiar docente asignado";
                    botonCambiarDocente.onclick = function(){
                        if(confirm("Recuerda que cambiaras el docente asignado a este grupo y por ende a los alumnos registrados en el grupo.")){
                            this.remove();
                            selectDocentes.disabled = false;
                        }
                    }

                    info_grupo.append(botonCambiarDocente);

                    selectDocentes.disabled = true;
                }



                if(data['info'][0]['totalAlumnos'] != null && data['info'][0]['totalAlumnos'] > 0){
                    info_grupo.append(botonModal);
                }


            }
        };


        /**
         * Verificamos que se seleccione un modulo para mostrar las lecciones
         */
        $("#instituciones").change(function(item){
            document.querySelector('#enlaceEditarGrupo')?.remove();
            listadoAlumnosModal.innerHTML = '';
            info_grupo.innerHTML = '';

            var id_institucion = this.value;
            var data = getInfoAjax('gruposyprofesoresdeinstitucion', {institucion: id_institucion}, 'admin');

            if(data){

                var notificaciones = $("#notificaciones")[0];
                notificaciones.innerHTML = '';

                selectGrupos.innerHTML = '';
                selectGrupos.innerHTML = '<option value="">[ Seleccione un GRUPO ]</option>';

                selectDocentes.innerHTML = '';
                selectDocentes.innerHTML = '<option value="">[ Seleccione un DOCENTE ]</option>';
                selectDocentes.disabled = true;
                console.log("true", true);

                $("#alumnos")[0].disabled = true;
                $("#cargarAlumnosAgrupo")[0].disabled = true;

                if(data['grupos'] == 0 || data['docentes'] == 0){

                    if(data['grupos'] == 0 ){
                        notificaciones.style.color = "red";
                        notificaciones.innerHTML = "<br>Primero deberas crear Grupos para la institución ya que no tiene<hr>";
                    }
                    if(data['docentes'] == 0){

                        notificaciones.style.color = "red";
                        notificaciones.innerHTML += "Primero deberas crear Docentes para la institución ya que no tiene<hr>";
                    }

                    return;
                }
                else{
                    selectDocentes.disabled = false;
                    $("#alumnos")[0].disabled = false;
                    $("#cargarAlumnosAgrupo")[0].disabled = false;

                    $("#resultados")[0].style.display = 'initial';
                    $("#notificaciones")[0].innerHTML = '';

                    selectGrupos.innerHTML = '';
                    selectGrupos.innerHTML = '<option value="">[ Seleccione un GRUPO ]</option>';

                    selectDocentes.innerHTML = '';
                    selectDocentes.innerHTML = '<option value="">[ Seleccione un DOCENTE ]</option>';

                    data['docentes'].forEach(function(item, index){
                        var option = document.createElement('option');
                        option.value = item['id'];
                        option.innerHTML = "Docente: "+id_institucion+" => "+item['nombre'];
                        selectDocentes.append(option);
                    })
                }

                if(data['grupos'] != 0){
                    data['grupos'].forEach(function(item, index){
                        var option = document.createElement('option');
                        option.value = item['LGF0290001'];
                        option.innerHTML = item['LGF0290002'] + ", modulo: "+item['nombre_modulo']+", "+item['totalAlumnos']+" alumnos.";
                        selectGrupos.append(option);
                    })
                }
            }else{
                console.log("Algo salio mal")
            }
        });


        $("#cargarAlumnosAgrupo").click(function(){
            if(!confirm("¿Seguro que ya verificaste la información? Recuerda que si un alumno pertenecia a otra institución este pasara a pertenecer a la que elegiste")){
                return;
            }

            var alumnos = $("#alumnos")[0];
            //if(alumnos.value != "" && selectGrupos.value != '' && selectDocentes.value != ''){
            if(alumnos.value != "" && selectGrupos.value != '' ){
                var curps = alumnos.value;

                var data = getInfoAjax('asignaralumnosagrupodesdecurps', {
                    curps: curps,
                    grupo: selectGrupos.value,
                    docente: selectDocentes.value,
                    institucion: $("#instituciones").val()
                }, 'admin');

                if(data){
                    console.log(data)
                    if(data['result'] == 'invalid_data'){
                        alert(data['msg']);
                        return;
                    }else if(data['result'] == 'not_equals'){

                        $("#notificaciones")[0].style.color = "red";
                        $("#notificaciones")[0].innerHTML = '';
                        $("#notificaciones")[0].innerHTML = data['msg'];

                        ul = document.createElement('ul');
                        ul.id = "noAparecen";

                        data['alumnosNoAparecen'].forEach(function (item){
                            li = document.createElement('li');
                            li.innerHTML = item;
                            ul.append(li);
                        });
                        $("#notificaciones")[0].append(ul)
                        return;
                    }else if(data['result'] == 'updated_correctly'){
                        $("#instituciones")[0].style.display = 'none';
                        $("#resultados")[0].style.display = 'none';
                        $("b").hide();
                        $("button").hide();
                        $("h4").hide();

                        $("#notificaciones")[0].innerHTML = '';
                        $("#notificaciones")[0].style.color = 'green';
                        $("#notificaciones")[0].innerHTML = '<br><br>Datos actualizados correctamente<br>';
                        $("#notificaciones")[0].innerHTML += '<button class="btn text-white btn-info mx-auto" onclick="location.reload();">Actualizar página</button>';
                    }
                }
            }else{
                alert("Aun hay datos requeridos por seleccionar o introducir.");
            }
        });
    });
</script>
