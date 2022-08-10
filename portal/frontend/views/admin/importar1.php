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
    
    <div class="page">
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
      <div class="row">
          <div class="offset-lg-9 col-lg-3">
            <a class="regresar basico menu-principal" href='<?php echo CONTEXT ?>admin/manager/'>Regresar</a>
          </div>
      </div>
    </div>
  </section>
</section>
<script>
  $(document).ready(function () {
    $("#accion").change(function (e) {
      $("#mensaje").hide();
      $("#mensaje").html("");
      if ($(this).val() == "") {
        $("#download_ejemplo").attr("href","#");
        $("#info").hide();
        $("#info").html();
      } else if ($(this).val() == 1) {
        $("#download_ejemplo").attr("href",context+"importar/plantilla_instituciones.csv");
        $("#info").show();
        $("#info").html("Retorna un archivo con la siguiente estructura<br> CCT/Institución/Modulos/Grupos");
      } else if ($(this).val() == 2) {
        $("#download_ejemplo").attr("href",context+"importar/plantilla_alumnos.csv");
        $("#info").show();
        $("#info").html("Retorna un archivo con la siguiente estructura<br> Nombre/Apellido paterno/Apellido materno/CURP/Genero/Modulo/Institución/Grado");
      } else if ($(this).val() == 3) {
        $("#download_ejemplo").attr("href",context+"importar/plantilla_docentes.csv");
        $("#info").show();
        $("#info").html("Retorna un archivo con la siguiente estructura<br> Nombre/Apellido paterno/Apellido materno/CURP/Genero/Institución");
      } else {
        $("#download_ejemplo").attr("href","#");
        $("#info").hide();
        $("#info").html();
      }
    });

    $("#archivo").click(function (e) {
      e.preventDefault();
      var accion = $("#accion").val();
      $("#limpiar").click();
    });

    $("#procesar").click(function (e) {
      e.preventDefault();
      var form = new FormData($('#importFile')[0]);
      $.ajax({
        url: context+'admin/limpiar_datos',
        type: "post",
        data : form,
        processData: false,
        contentType: false,
        beforeSend: function () {
          var accion = $("#accion").val();
          if (accion >= 1 && accion <= 3) {
            $("#mensaje").html("<i class='fa fa-spinner fa-spin fa-3x fa-fw' style='font-size: 1em;'></i> Espera un momento mientras se realiza la limpieza de datos.");
          } else {
            $("#mensaje").html("<i class='fa fa-spinner fa-spin fa-3x fa-fw' style='font-size: 1em;'></i> Espera un momento mientras se realiza la importación de datos.");
          }
          $("#mensaje").show();
        },
        success: function(data) {
          $("#mensaje").html(data.mensaje);
          if (data.data != null) {
            generarCSV(data.data, true, data.titulo);
          }

          if (data.data1 != null) {
            generarCSV(data.data1, true, data.titulo1);
          }
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