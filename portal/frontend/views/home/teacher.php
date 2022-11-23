<section id="contenido">
	<div class="row">
	    <div class="col-lg-2">
	      <img src="<?= IMG?>logo_color.png" alt="learnglish icon">
	    </div>

	    <div class="col-lg-8">
	      <div class="relleno">
	        <span>Módulo de Administración del Docente</span>
	      </div>
	    </div>

	    <!-- <div class="nameUser col-lg-4 hide"> -->
	    <div class="col-lg-2">
	      <img src="<?= $this->temp ["img_usuario"]?>" class="imagen">
	      <span class="nombreAvatar"> <?php echo $_SESSION['nombre']?></span>
	    </div>
	</div>
	<br><br>
	<div class="separador"></div>
	<div class="row">
		<div class="col-lg-6 col-lg-offset-3">
			<h3 id="titulo"><strong>Grupos vinculados a la cuenta del Docente</strong></h3>

            <?php if(verificaModuloSistemaActivo('permitirAdministrarGruposDocente')){ ?>
                <button type="button" class="boder border-info btn btn-close-white btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarGrupo">
                    Agregar grupo
                </button>

                <?php if(isset($_SESSION['status'])){ ?>
                    <div class="col-12"><?php echo $_SESSION['status']; ?></div>
                    <?php
                        unset($_SESSION['status']);
                    } ?>
            <?php } ?>
		</div>
	</div>
	<form action="POST" id="formReporte">
		<input type="hidden" name="seccion" id="seccion">
		<input type="hidden" name="usuario" id="usuario" value="<?=$_SESSION['idUsuario']?>">
	</form>
	<div class="page">
		<div class="separador">
			
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="separador table-responsive">
					<table class="table tabla" id="contenido_tabla">
						<thead>
							<th>Grupo</th>
							<th># Alumnos</th>
							<th>Nivel</th>
							<th>Lecciones</th>
							<th>Guías</th>
							<th>Recursos</th>
							<th>Reportes</th>
							<!-- Descomentar linea de abajo, cuando se aprueba la configuracion de modulos administrable por el docente -->
							<th>Accesos a lecciones</th>
							<th>Alumnos del grupo</th>
                            <?php if(verificaModuloSistemaActivo('permitirAdministrarGruposDocente')){ ?>
							    <th>Eliminar grupo</th>
                            <?php } ?>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Modal activar desactivar lecciones -->
<div class="modal fade" id="modalLecciones" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ModalLabel"></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="formGL">
				<input type="hidden" name="modulo" id="modulo">
				<input type="hidden" name="grupo" id="grupo">
				<input type="hidden" name="docente" id="docente">
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12">
							<h6 id="moduloL">Lecciones de Secundaria</h6>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-lg-4 offset-lg-8">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" id="all">
								<label class="form-check-label" for="all">Activar/Desactivar todas las lecciones</label>
							</div>
						</div>
					</div>
					<div id="lecciones"></div>
				</div>
				<div class="modal-footer">
					<div class="alert alert-success" id="mensaje" role="alert" style="display: none;"></div>
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
					<button type="button" class="btn btn-primary" id="saveGL">Guardar cambios</button>
				</div>
			</form>
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


<!-- Modal para agregar un grupo -->
<div class="modal fade" id="modalAgregarGrupo" tabindex="-1" aria-labelledby="modalAgregarGrupoLabel" aria-hidden="true">
    <div class="modal-dialog" style="display: flex; justify-content: center;">
        <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarGrupoLabel">
                    Crear un grupo
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <input type="hidden" name="institucion" value="">
                    <div class="mb-3">
                        <h1 id="nombreGrupo" class="text-black-50">Grupo ?A.0</h1>
                        <h3 id="moduloGrupo" class="text-black-50"></h3>
                    </div>
                    <div class="mb-3">
                        <label for="numero">Número: </label>
                        <input type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"
                               class="form-control" name="numero" maxlength="1" id="numero" required>
                    </div>
                    <div class="mb-3">
                        <label for="letra">Letra: </label>
                        <select name="letra" id="letraGrupo" class="form-control" required></select>
                    </div>
                    <div class="mb-3">
                        <label for="modulo">Modulo grupo: </label>
                        <select name="modulo" id="moduloGrupoSelect" class="form-control" required>
                            <option value="" nombre="">[Selecciona un módulo]</option>
                            <?php foreach($this->temp['modulos_disponibles'] as $modulo){ ?>
                                <option value="<?php echo $modulo['id']; ?>" nombre="<?php echo $modulo['nombre']; ?>">
                                    <?php echo $modulo['nombre']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="version">Versión</label>
                        <input type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"
                               name="version" class="form-control" maxlength="1" id="version" value="0" required>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-success shadow">Agregar grupo</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){

        /*Formamos el select de letras de grupo*/
        var letrasGrupo = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","U","V","W","X","Y","Z"];

        letrasGrupo.forEach(function(item){
            $("#letraGrupo")[0].innerHTML += "<option value='"+item+"'>"+item+"</option>";
        })

        /*Validamos la longitud de campos*/
        $("#numero,#version").keyup(function(){
            if(this.value.length > 1){
                this.value = this.value.substring(0,1);
            }
        })

        /*Mostramos como quedara el nombre del grupo al docente*/
        $("#numero, #letraGrupo, #version").on('keyup change',function(){
            if(this.value == ''){
                this.placeholder = "CAMPO REQUERIDO";
            }else{
                $("#nombreGrupo")[0].innerText = "Grupo "+$("#numero").val()+""+$("#letraGrupo").val()+"."+$("#version").val();
            }
        });

        /*Mostramos el modulo del grupo*/
        $("#moduloGrupoSelect").change(function(){
            $("#moduloGrupo").html(this.selectedOptions[0].getAttribute('nombre'));
        })


    });
</script>