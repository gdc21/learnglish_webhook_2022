<section class="container">
  <section id="contenido">
    <?php echo $this->temp['encabezado']; ?>
    <div class="separador"></div>
    <div class="row">
      <div class="col-lg-6">
        <h1 class="title-section">Guías de estudio</h1>
      </div>
      <div class="col-lg-3 offset-lg-3">
        <button class="btn btn-lg registro" id="addRegistro">Registrar guía</button>
      </div>
    </div>
    <div class="separador"></div>
    <div class="row">
      <div class="col-lg-4 offset-lg-4">
        <select class="form-select" id="modulo">
          <option value="">Selecciona un módulo</option>
          <?php foreach ($this->temp['modulos'] as $key => $value): ?>
            <option value="<?php echo $value['LGF0150001']; ?>"><?php echo $value['LGF0150002']; ?></option>
          <?php endforeach ?>
        </select>
      </div>
    </div>
    <div class="separador"></div>
    <div class="page">
      <div class="row">
        <div class="col-lg-12">
          <table class="table tabla" id="tblAdminG">
            <thead>
              <tr>
                <th scope="col">Icono</th>
                <th scope="col">Grado escolar</th>
                <th scope="col">Lección</th>
                <th scope="col">Guía</th>
                <th scope="col">Tipo de guía</th>
                <th scope="col">Estado de guía</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-4 offset-lg-4">
          <a class="regresar basico menu-principal" href='<?php echo CONTEXT ?>admin/manager/'>Regresar al menú principal</a>
        </div>
        <div class="col-lg-4">
          <a class="regresar basico menu-principal" href='<?php echo CONTEXT ?>admin/lessons/'>Regresar al menú de lecciones</a>
        </div>
      </div>
    </div>
  </section>
</section>

<!-- Modal -->
<div class="modal fade" id="modal-guides" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-guidesLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-guidesLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formGuia" autocomplete="off">
        <div class="modal-body">
          <div class="row">
            <div class="col-lg-4">
              <select class="form-select validar" id="tipoG" name="tipoG">
                <option value="">Selecciona el tipo de guía</option>
                <option value="0">Guía general (Scope and sequence)</option>
                <option value="1">Guía de usuario</option>
                <option value="2">Guía del docente</option>
              </select>
            </div>
            <div class="col-lg-4">
              <select class="form-select validar" id="grado" name="grado">
                <option value="">Selecciona un módulo</option>
                <?php foreach ($this->temp['modulos'] as $key => $value): ?>
                  <option value="<?php echo $value['LGF0150001']; ?>"><?php echo $value['LGF0150002']; ?></option>
                <?php endforeach ?>
              </select>
            </div>

            <div class="col-lg-4">
              <select class="form-select validar" id="leccion" name="leccion">
                <option value="">Selecciona una lección</option>
              </select>
            </div>
          </div>
          <div class="separador"></div>
          <div class="row">
            <div class="col-lg-6">
              <input class="form-control validar" type="file" id="fileG" name="fileG">
            </div>
            <div class="col-lg-6">
              <div class="form-check form-check-inline">
                <input class="form-check-input estatus" type="radio" name="estatus" id="estatus1" value="1" style="height: 2em; width: 2em;">
                <label class="form-check-label" for="estatus1" style="font-size: 20px; margin-left: 8px;">Activar guía</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input estatus" type="radio" name="estatus" id="estatus2" value="0" style="height: 2em; width: 2em;">
                <label class="form-check-label" for="estatus2" style="font-size: 20px; margin-left: 8px;">Desactivar guía</label>
              </div>
            </div>
          </div>
          <div class="separador"></div>
          <div class="modal-footer">
            <div class="alert " id="mensaje" role="alert" style="display: none;"></div>
            <button type="button" class="btn btn-primary" id="saveG">Guardar</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>