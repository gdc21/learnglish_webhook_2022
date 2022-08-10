<style>
  .relleno{
    background: #<?php echo $this->temp['color']; ?>;
    color: #<?php echo $this->temp['color1']; ?>;
  }

  #tblRecursos thead {
    background: #<?php echo $this->temp['color']; ?>;
    color: #<?php echo $this->temp['color1']; ?>;
  }

  tbody tr td{
    background: #fff;
    border: solid #<?php echo $this->temp['color']; ?> 0.05em;
    border-top: solid #<?php echo $this->temp['color']; ?> !important;
    color: #<?php echo $this->temp['color']; ?>;
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
    font-size: 1em !important;
  }

  .regresar {
    color: #<?php echo $this->temp['color']; ?> !important;
    text-align: center;
  }
</style>
<section id="contenido">
  <?php echo $this->temp['encabezado']; ?>
  <div class="separador"></div>
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
    <table class="table tabla" id="tblRecursos">
      <thead>
        <tr>
          <th>Icono</th>
          <th>Lección</th>
          <th>Listening</th>
          <th>For Fun</th>
          <th>Reading</th>
          <th>Exercise</th>
          <th>Evaluation</th>
        </tr>
      </thead>
      <tbody></tbody>
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