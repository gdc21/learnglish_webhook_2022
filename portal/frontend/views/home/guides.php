<style>
  .relleno{
    background: #<?php echo $this->temp['color']; ?>;
    color: #<?php echo $this->temp['color1']; ?>;
  }
  a{
    color: #000;
    text-decoration: none !important;
  }

  tbody tr td{
    background: #fff;
    border: 0.05em solid #<?php echo $this->temp['color']; ?>;
    color: #000;
    font-size: 1em;
    text-align: center;
    font-weight: bold;
    vertical-align: middle !important;
  }
  tbody tr td img {
     width: auto;
     height: 2em !important;
   }


  tbody tr td .fa{
    color: #<?php echo $this->temp['color']; ?>;
  }

  .regresar {
    color: #<?php echo $this->temp['color']; ?> !important;
    text-align: center;
  }
</style>
<section id="contenido">
  <?php echo $this->temp['encabezado']; ?>
  <div class="separador"></div>
  <?php if (isset($this->temp['origen']) && !empty($this->temp['origen'])) { ?>
    <div class="row">
      <div class="col-lg-12" style="text-align: center;">
        <h3><b><?php echo $this->temp['seccion_nombre']; ?></b></h3>
      </div>
    </div>
    <div class="separador"></div>
  <?php } ?>
  
  <input type="hidden" id="nivel" value="<?php echo $this->temp['nivel']; ?>">
  <input type="hidden" id="docente" value="<?php echo (($this->temp['origen'] == 'docente') ? 1 : 2); ?>">
  <div class="table-responsive">
    <table class="table reporte_tabla" id="tablaguias">
      <thead>
        <tr>
          <th>Icono</th>
          <th>Lección</th>
          <th>Guia</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>

  <div class="separador"></div>
  <div class="row">
    <div class="offset-lg-9 col-lg-3">
      <?php if (isset($this->temp['origen']) && $this->temp['origen'] == "docente") { ?>
        <a class="regresar basico menu-principal" href='<?php echo CONTEXT ?>home/teacher/'>Regresar al menú anterior</a>
      <?php } else if (isset($this->temp['origen']) && $this->temp['origen'] == "tutor") { ?>
        <a class="regresar basico menu-principal" href='<?php echo CONTEXT ?>home/tutor/'>Regresar al menú anterior</a>
      <?php } else {
               if($this->temp['nivel'] == 1 ){ ?>
          <a class="regresar basico menu-principal" href='<?= CONTEXT ?>home/preschool/'>Regresar al menú de preescolar </a>
        <?php  } elseif ($this->temp['nivel'] >= 2 && $this->temp['nivel'] <= 7) { ?>
          <a class="regresar basico menu-principal" href='<?= CONTEXT ?>home/primary/'>Regresar al menú de primaria</a>
        <?php  } else { ?>
          <a class="regresar basico menu-principal" href='<?= CONTEXT ?>home/secundary/'>Regresar al menú de secundaria</a>
        <?php  }
      } ?>
    </div>
  </div>  
</section>

<div id="mdlGuias" class="modal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Información de guías de estudio</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="frmGuias">
          <input type="hidden" id="actividad" value="1">
          <input type="hidden" name="smodulo" id="smodulo" value="<?php echo $this->temp['modulo']; ?>">
          <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Agregar/Editar guías</button>
              <button class="nav-link" id="nav-activar-tab" data-bs-toggle="tab" data-bs-target="#nav-activar" type="button" role="tab" aria-controls="nav-activar" aria-selected="false">Activar guías</button>
            </div>
          </nav>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
              <div class="separador"></div>
              <input type="hidden" name="accion" id="accion" value="1">
              <input type="hidden" name="valor" id="valor">
              <div class="row">
                <div class="col-lg-6">
                  <select class="form-select form-select-lg mb-3 campos" id="sLecciones" name="sLecciones"></select>
                </div>
                <div class="col-lg-4 offset-lg-2">
                  <img class="img-fluid" id="imagenL" src="">
                </div>
              </div>

              <div class="row">
                <div class="col-lg-6">
                  <input class="form-control campos" type="file" id="fileG" name="fileG">
                </div>
                <div class="col-lg-6">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input estatus" type="radio" name="estatus" id="estatus1" value="1" style="height: 2em; width: 2em;">
                    <label class="form-check-label" for="estatus1" style="font-size: 1em; margin-left: 0.4em;">Activar guía</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input estatus" type="radio" name="estatus" id="estatus2" value="0" style="height: 2em; width: 2em;">
                    <label class="form-check-label" for="estatus2" style="font-size: 1em; margin-left: 0.4em;">Desactivar guía</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="nav-activar" role="tabpanel" aria-labelledby="nav-activar-tab">
              <div class="separador"></div>
              <div id="contenedorL"></div>
            </div>
          </div>
          <div class="mensaje" style="display: none;">
            <div class="separador"></div>
            <div class="row">
              <div class="col-lg-12">
                <div class="alert " role="alert" id="msjFile"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="saveF">Guardar cambios</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </form>
      </div>
    </div>
  </div>
</div>