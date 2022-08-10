<section id="contenido">
  <div class="cssmenu">
    <p style="text-align:center;font-size:16px;background-color:#2EBEBB">
      <font color="white" weight="bold" family= "Lato, Arial, Helvetica, sans-serif"></>MENU ADMINISTRADOR </font>
    </p>
    <ul>
      <?php if ($_SESSION['perfil'] == 1) { ?>
        <!-- <li class='active'><a href="<?= CONTEXT ?>admin/evaluaciones">Evaluaciones</a></li>
        <li><a href="<?= CONTEXT ?>admin/addEval">Agregar Evaluación</a></li> -->
        <li class='active'><a href="<?php echo CONTEXT ?>admin/evaluacion">Evaluaciones</a></li>
        <li class="last"><a href="<?php echo CONTEXT ?>admin/objeto">Objetos</a></li>
        <!-- <li><a href="<?= CONTEXT ?>admin/objetos">Objetos</a></li> -->
        <li class="last"><a href="<?php echo CONTEXT ?>admin/clientes/1">Clientes</a></li>
        <li class="last"><a href="<?php echo CONTEXT ?>admin/instituciones">Instituciones</a></li>
        <!-- <li class='last'><a href="<?= CONTEXT ?>admin/usuario">Agregar Usuario</a></li> -->
        <li class="last"><a href="<?php echo CONTEXT ?>admin/usuarios">Usuarios</a></li>
        <li class="last"><a href="<?php echo CONTEXT ?>admin/reportes">Reportes</a></li>
      <?php }
      if ($_SESSION['perfil'] == 3) { ?>
        <li class="last"><a href="<?php echo CONTEXT ?>admin/instituciones">Instituciones</a></li>
        <li class="last"><a href="<?php echo CONTEXT ?>admin/usuarios">Usuarios</a></li>
        <li class="last"><a href="<?php echo CONTEXT ?>admin/reportes">Reportes</a></li>
      <?php }

      if ($_SESSION['perfil'] == 4) { ?>
        <li class="last"><a href="<?php echo CONTEXT ?>admin/usuarios">Usuarios</a></li>
        <li class="last"><a href="<?php echo CONTEXT ?>admin/instituciones">Instituciones</a></li>
        <li class="last"><a href="<?php echo CONTEXT ?>admin/reportes">Reportes</a></li>
      <?php }

      if ($_SESSION['perfil'] == 6) { ?>
        <li class="last"><a href="<?php echo CONTEXT ?>admin/usuarios">Usuarios</a></li>
        <li class="last"><a href="<?php echo CONTEXT ?>admin/reportes">Reportes</a></li>
      <?php } ?>
    </ul>
  </div>
</section>

<style>
  .cssmenu {
    width: 200px;
  }
  .cssmenu ul {
    list-style: none;
    padding: 0px;
    margin: 0px;
  }
  .cssmenu li a { 
    text-decoration: none;
    font-weight: bold;
    color: #98A8DC;
    font-family: Lato, Arial, Helvetica, sans-serif;
    font-size:14px;
    border-bottom: 1px solid #0A6FB5;
  }
  .cssmenu li a:link,
  .cssmenu li a:visited {
    color: #98A8DC;
    display: block;
    background-repeat: no-repeat;
    padding: 8px 0 0 10px;
  }
  .cssmenu li a:hover {
    background-color: #98A8DC;  
    padding: 8px 0 0 10px;
    color: #FFFFFF;
    font-size:14px;
    border-bottom: 2px solid #000000;
  }
  .cssmenu li a:active {
    color: #98A8DC; 
    background-repeat: no-repeat;
    padding: 8px 0 0 10px;
  }
</style>