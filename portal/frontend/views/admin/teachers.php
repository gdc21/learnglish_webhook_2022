<?php 
  function obtener_clase($nivel) {
    if ($nivel == 1) {
      $clase = "preescolar";
    } else if ($nivel >= 2 && $nivel <= 7) {
      $clase = "primaria";
    } else if ($nivel >= 8 && $nivel <= 10) {
      $clase = "secundaria";
    } else {
      $clase = "complemento";
    }
    return $clase;
  }
  function convertir_modulo_grado($modulo) {
    if ($modulo == 1) {
      $grado = "3° Preescolar";
    } elseif ($modulo >= 2 && $modulo <= 7) {
      $grado = ($modulo - 1)."° Primaria";
    } else {
      switch ($modulo) {
        case '8':
          $grado = "1 ° Secundaria";
        break;
        case '9':
          $grado = "2 ° Secundaria";
        break;
        case '10':
          $grado = "3 ° Secundaria";
        break;
      }
    }
    return $grado;
  }

  if ($_SESSION['perfil'] == 1) {
    $campo = "A";
  } else if ($_SESSION['perfil'] == 3) {
    $campo = "C";
  } else if ($_SESSION['perfil'] == 4) {
    $campo = "T";
  }
?>

<section id="contenido">
  <?php echo $this->temp['encabezado']; ?>
  <div class="separador"></div>
  <div class="row">
    <div class="col-lg-12" style="text-align: center;">
      <h3 class="title-section"><b><?php echo $this->temp['seccion_nombre']; ?></b></h3>
    </div>
  </div>
  <div class="separador"></div>
  <input type="hidden" id="nivel" value="<?php echo $this->temp['nivel']; ?>">
  <input type="hidden" id="docente" value="<?php echo $this->temp['docente']; ?>">
  <!-- <div class="row col-lg-4 offset-lg-8">
    <input id="buscar" class="form-control" type="text" placeholder="Buscar..">
  </div> -->
  <input id="campo" type="hidden" value="<?php echo $campo; ?>">
  <div class="table-responsive">
  <table class="table tabla reporte_tabla order-table" id="tbl_docentes">
    <thead>
      <tr>
        <th>Reportes grupales</th>
        <th>Nombre escuéla</th>
        <th>Docente</th>
        <th>Grupo</th>
        <th>Alumnos</th>
        <th>Grado</th>
        <th>Reportes</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
  </div>

  <div class="row">
    <div class="col-lg-12" style="text-align: center;">
      <a href="#" class="btn btn-lg btn-primary" data-bs-toggle="modal" data-bs-target="#modal_docente">Nuevo Docente</a>
    </div>
  </div>
  <div class="separador"></div>
  <div class="row">
    <div class="offset-lg-9 col-lg-3">
      <?php if (isset($this->temp['docente']) && $this->temp['docente']) { 
        if ($_SESSION['perfil'] == 1 || $_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 3) { ?>
          <a class="regresar basico menu-principal" href='<?php echo CONTEXT ?>admin/manager/'>Regresar</a>
        <?php } else { ?>
          <a class="regresar basico menu-principal" href='<?php echo CONTEXT ?>home/teacher/'>Regresar</a>
        <?php }
      } else {
        if ($_SESSION['perfil'] == 1 || $_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 3) { ?>
          <a class="regresar basico menu-principal" href='<?php echo CONTEXT ?>admin/manager/'>Regresar</a>
        <?php } else { ?>
          <a class="regresar basico menu-principal" href='<?php echo CONTEXT ?>home/teacher/'>Regresar</a>
        <?php }
      } ?>
    </div>
  </div>
</section>

<!-- Modal Asignar grupo -->
<div class="modal fade" id="modal_grupo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-bs-dismiss="modal">
          <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">Asignar grupo</h4>
      </div>
      <div class="modal-body">
        <div class="row" style="padding:15px">
          <div id="respuesta"></div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="alert " id="mensaje" role="alert" style="display: none;"></div>
        <form action="">
          <input type="hidden" name="usuario" id="usuario">
          <input type="hidden" name="grupo" id="grupo">
          <button type="button" class="btn btn-primary" id="asignar">Asignar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Registrar Docente -->
<div class="modal fade" id="modal_docente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-bs-dismiss="modal">
          <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">Registrar Docente</h4>
      </div>
      <form id="formDocente" autocomplete="off">
        <div class="modal-body">
          <input type="hidden" id="perfil" name="perfil" value="6">
          <input type="hidden" id="estatus" name="estatus" value="1">
          <div class="row" style="padding-bottom: 20px;">
            <div class="col-lg-6">
              <?php $selected = ""; if ($_SESSION['perfil'] == 4) {
                $selected = "selected";
              } ?>
              <label for="">Selecciona una institución <span class="importante">*</span></label>
              <span id="error-inst" class="importante"></span>
              <select id="institucion" name="institucion" class="form-control campos">
                  <option value="">Selecciona una institución</option>
                <?php foreach ($this->temp['docentes'] as $key => $value): ?>
                  <option value="<?php echo $value['LGF0270001']; ?>" <?php echo $selected; ?>><?php echo $value['LGF0270002']; ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="col-lg-6">
              <label for="">Selecciona un grado escolar <span class="importante">*</span></label>
              <span id="error-inst" class="importante"></span>
              <select id="modulo" name="modulo" class="form-control campos">
                  <option value="">Selecciona un grado escolar</option>
                <?php foreach ($this->temp['modulos'] as $key => $value): ?>
                  <option value="<?php echo $value['id']; ?>" <?php echo $selected; ?>><?php echo $value['nombre']; ?></option>
                <?php endforeach ?>
              </select>
            </div>
          </div>
          <div class="row" style="padding-bottom: 20px;">
            <div class="col-lg-4">
              <div class="form-group">
                <label for="" class="label-control">Nombre <span class="importante">*</span></label>
                <span id="error-nombre" class="importante"></span>
                <input type="text" class="form-control campos" id="nombre" name="nombre" placeholder="Nombre(s)">
              </div>
            </div>
            <div class="col-lg-4">
              <div class="form-group">
                <label for="" class="label-control">Apellido Paterno <span class="importante">*</span></label>
                <span id="error-aPaterno" class="importante"></span>
                <input type="text" class="form-control campos" id="aPaterno" name="aPaterno" placeholder="Apellido Paterno">
              </div>
            </div>
            <div class="col-lg-4">
              <div class="form-group">
                <label for="" class="label-control">Apellido Materno</label>
                <input type="text" class="form-control" id="aMaterno" name="aMaterno" placeholder="Apellido Materno">
              </div>
            </div>
            <div class="col-lg-4">
              <div class="form-group">
                <label for="" class="label-control">E-mail</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Correo electrónico....">
              </div>
            </div>
            <div class="col-lg-4">
              <div class="form-group">
                <label for="" class="label-control">Usuario <span class="importante">*</span></label>
                <span id="error-usuario" class="importante"></span>
                <input type="text" class="form-control campos" id="usuario" name="usuario" placeholder="Usuario....">
              </div>
            </div>
            <div class="col-lg-4">
              <div class="form-group">
                <label for="" class="label-control">Contraseña <span class="importante">*</span></label>
                <span id="error-password" class="importante"></span>
                <input type="text" class="form-control campos" id="password" name="password" placeholder="Contraseña....">
              </div>
            </div>
            <div class="col-lg-4">
              <br><br>
              <label for="" class="label-control">Selecciona un Género <span class="importante">*</span></label>
              <span id="error-genero" class="importante"></span>
              <div class="form-check">
                <input class="form-check-input genero" type="radio" name="genero" id="masculino" value="H" style="float: none;">
                <label class="form-check-label" for="masculino">&nbsp;Hombre</label>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input class="form-check-input genero" type="radio" name="genero" id="femenino" value="M" style="float: none;">
                <label class="form-check-label" for="femenino">&nbsp;Mujer</label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="row div col-lg-4"><span>(<span class="importante">*</span>) Campos obligatorios</span></div>
          <div class="alert " id="mensajeD" role="alert" style="display: none;"></div>
          <button type="button" class="btn btn-primary" id="save">Guardar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<style>
  a.btn.btn-lg.btn-primary {
    font-size: 1em;
    margin-top: 1em;
    padding: 0.5em 2em;
  }
</style>
<script src="//cdn.datatables.net/plug-ins/1.10.19/sorting/date-de.js"></script>
<script>

    function eliminar_grupo(grupoId){
        if(confirm("¿Seguro que deseas borrar al grupo?")){
            $.ajax({
                url: context+"admin/eliminar_grupo",
                type: "POST",
                data: {grupo: grupoId},
                dataType: "json",
                success: function (resp) {
                    alert(resp.respuesta);
                    if(resp.recargar){
                        location.reload();
                    }
                }
            });
        }
    }

    function eliminar_grupo_close_modal(grupoId){
        if(confirm("¿Seguro que deseas borrar al grupo?")){
            $.ajax({
                url: context+"admin/eliminar_grupo",
                type: "POST",
                data: {grupo: grupoId},
                dataType: "json",
                success: function (resp) {
                    alert(resp.respuesta);
                    if(resp.recargar){
                        $("#modal_grupo").modal('hide');
                    }
                }
            });
        }
    }

  function mostrar_grupo(usuario) {
    $("#modal_grupo").modal('show');
    $.ajax({
      url: context+"admin/mostrar_grupo",
      type: "POST",
      data: {usuario: usuario},
      dataType: "json",
      beforeSend: function () {
        $("#respuesta").html("");
      },
      success: function (resp) {
        if (resp.respuesta == 0) {
          contenido = '<h4>Seleccione un grupo</h4>';
          $.each(resp.contenido, function (i, value) {
            contenido+=
                '<div class="mt-3 form-check">' +
            '       <input class="form-check-input" type="radio" name="grupo" id="grupo_'+value.LGF0290001+'" value="'+value.LGF0290001+'">' +
            '       <label class="form-check-label" onclick="asignar_grupo('+value.LGF0290001+','+usuario+')" for="grupo_'+value.LGF0290001+'">' +
            '           '+value.LGF0290002+' -- '+value.nombre_modulo+' <br> Docente: '+(value.nombre_docente)+
                        '<br><a target="_blank" href="'+context+'admin/editGroup/'+value.LGF0290001+'">Editar grupo</a>' +
                        '<br><i onclick="eliminar_grupo_close_modal('+value.LGF0290001+')"' +
						'			style="cursor: pointer;" ' +
						'			class="complemento ml-4 fa fa-trash-o" ' +
						'			aria-hidden="true"></i>'+
                    '</label>' +
            '   </div>';
            contenido+='</div>';
          });
          $("#respuesta").append(contenido);
        } else {
        }
      }
    });
  }

  function asignar_grupo(grupo, usuario) {
    $("#usuario").val(usuario);
    $("#grupo").val(grupo)
  }

  $("#asignar").click(function (e) {
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: context+"admin/asignar_grupo",
      data: {usuario: $("#usuario").val(), grupo: $("#grupo").val()},
      dataType: "json",
      success: function (resp) {
        $("#mensaje").show();
        if (resp.error == 0) {
          $("#mensaje").addClass("alert-success");
          $("#mensaje").removeClass("alert-danger");
          $("#mensaje").html(resp.mensaje);
        } else {
          $("#mensaje").removeClass("alert-success");
          $("#mensaje").addClass("alert-danger");
          $("#mensaje").html(resp.mensaje);
        }
        setTimeout(function () {
          location.reload();
        }, 3000);
      }
    });
  });

  $(".campos").change(function () {
    $(".campos").each(function () {
      if ($(this).val() != "") {
        $(this).css({"border-color":"#ccc"});
      }
    });
  });

  $("#save").click(function (e) {
    e.preventDefault();
    var cambio = true;
    $(".campos").each(function () {
      if ($(this).val() == "") {
        $(this).css({"border-color":"#ff0000"});
        cambio = false;
      }
    });

    if (!$(".genero").is(":checked")) {
      $(".form-check").css({"border-color":"#ff0000"});
      cambio = false;
    }
    
    if (cambio) {
      var data = new FormData($('#formDocente')[0]);
      if($('#password').val()!='') { 
        data.set('pass', data.get('password'));
        data.append('password',CryptoJS.SHA1($('#password').val()).toString());
      }
      $.ajax({
        type: "POST",
        url: context+"admin/saveAddUsuario",
        data: data,
        dataType: "json",
        contentType:false,
        processData:false,
        cache:false,
        async: true,
        success: function (resp) {
          $("#mensajeD").show();
          if (resp.mensaje) {
            $("#mensajeD").addClass("alert-success");
            $("#mensajeD").removeClass("alert-danger");
            $("#mensajeD").html(resp.mensaje);
          } else {
            $("#mensajeD").removeClass("alert-success");
            $("#mensajeD").addClass("alert-danger");
            $("#mensajeD").html(resp.error);
          }
          setTimeout(function () {
            location.reload();
          }, 3000);
        }
      });
    }
  });

  $('.modal').on('hidden.bs.modal', function(){
    $(this).css({"border-color":"#ccc !important"});
    $(this).find('form')[0].reset(); //para borrar todos los datos que tenga los input, textareas, select.
  });
</script>