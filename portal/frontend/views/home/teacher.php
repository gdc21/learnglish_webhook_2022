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
		</div>
	</div>
	<form action="POST" id="formReporte">
		<input type="hidden" name="seccion" id="seccion">
		<input type="hidden" name="usuario" id="usuario" value="<?=$_SESSION['idUsuario']?>">
	</form>
	<div class="page" style="margin-top: 30px;">
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
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Modal -->
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