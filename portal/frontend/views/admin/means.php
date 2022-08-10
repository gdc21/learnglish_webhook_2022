<section class="container w-100 mb-4 pt-4">
    <?php echo $this->temp['encabezado']; ?>
  <section id="" style="max-width: 90%; overflow:auto; margin: 0 auto;">
    <div class="separador"></div>
    <div class="row">
      <div class="col-lg-6">
        <h1 class="title-section">Recursos digitales</h1>
      </div>
      <div class="col-lg-3 offset-lg-3">
        <button class="btn btn-lg registro" id="addRegistro">Registrar recurso</button>
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
    <div class="w-100 flex-wrap d-flex justify-content-center">
      <div class="">
        <div class="w-100 overflow-auto">
          <table class="table tabla" id="tblAdminR">
            <thead>
              <tr>
                <th scope="col">Icon</th>
                <th scope="col">Grado Escolar</th>
                <th scope="col">Lección</th>
                <th scope="col">Type</th>
                <th scope="col">Listening</th>
                <th scope="col">For Fun</th>
                <th scope="col">Reading</th>
                <th scope="col">Exercises</th>
                <th scope="col">Evaluation</th>
                <th scope="col">Estatus</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
      <div class="row d-flex justify-content-around">
        <div class="col-lg-4 ">
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
<div class="modal fade" id="modal-sinews" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-sinewsLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-sinewsLabel">Registrar recurso</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formRecurso" autocomplete="off">
        <div class="modal-body">
          <div class="row">
            <div class="col-lg-4">
              <select class="form-select validar" id="tipoR" name="tipoR">
                <option value="">Selecciona el tipo de guía</option>
                <option value="1" selected>Recurso de usuario</option>
                <option value="2">Recurso del docente</option>
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
            <div class="col-lg-12 offset-lg-2">
              <div class="form-check form-check-inline">
                <input checked class="form-check-input estatus" type="radio" name="estatus" id="estatus1" value="1" style="height: 2em; width: 2em;">
                <label class="form-check-label" for="estatus1" style="font-size: 20px; margin-left: 8px;">Activar recurso</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input estatus" type="radio" name="estatus" id="estatus2" value="0" style="height: 2em; width: 2em;">
                <label class="form-check-label" for="estatus2" style="font-size: 20px; margin-left: 8px;">Desactivar recurso</label>
              </div>
            </div>
          </div>
          <div class="separador"></div>
          <div class="row">
            <div class="col-lg-6">
              <label class="form-label">Subir Recurso 1 (Listening)</label>
              <input class="form-control validAlMenosUno" type="file" id="upRec1" name="upRec1">
              <small id="msjAudio" class="form-text text-muted" style="display: none; font-size: 14px; color: #ff0000 !important;">Solo se permiten formatos MP3.</small>
            </div>

            <div class="col-lg-6">
              <label class="form-label">Subir Recurso 2 (For Fun)</label>
              <input class="form-control validAlMenosUno" type="file" id="upRec2" name="upRec2">
            </div>
            <div class="separador"></div>
            <div class="col-lg-6">
              <label class="form-label">Subir Recurso 3 (Reading)</label>
              <input class="form-control validAlMenosUno" type="file" id="upRec3" name="upRec3">
            </div>
            <!--
            El recurso 5 se agrego tiempo despues en la tabla, verificar en comentarios de campos estructura base datos
            el campo evaluation es recurso 4 y exercises sera recurso 5
            -->
            <div class="col-lg-6">
              <label class="form-label">Subir Recurso 4 (Exercises)</label>
              <input class="form-control validAlMenosUno" type="file" id="upRec5" name="upRec5">
            </div>
            <div class="col-lg-6">
              <label class="form-label">Subir Recurso 5 (Evaluation)</label>
              <input class="form-control validAlMenosUno" type="file" id="upRec4" name="upRec4">
            </div>
          </div>
          <div class="separador"></div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="save">Guardar</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <div class="alert " id="mensaje" role="alert" style="display: none; width: 100%;"></div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>