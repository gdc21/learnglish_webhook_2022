<style>
	.list-group-item {
		background-color: #2ebebb;
		border-color: #2ebebb;
		color: #ffffff;
		font-size: 0.75em;
		font-weight: bold;
		cursor: pointer;
		margin-top: 0.5em;
	}

	.text-estatus {
		display: block;
		margin: 0em 0em 0em 90%;
	    margin-top: -0.75em;
	}
</style>
<section class="container">
	<section id="contenido">
		<?php echo $this->temp['encabezado']; ?>
		<div class="separador">
			<div class="row">
				<div class="col-lg-6">
					<h1 class="title-section">Objetos Registrados</h1>
				</div>

				<div class="col-lg-3 offset-lg-3">
					<br>
					<script>
						function enlazar() {
							var url = "";
							var modulo = $("#modulo").val();
							var leccion = $("#leccion").val();
							if (modulo != "" && leccion != "") {
							    url = "<?php echo CONTEXT ?>admin/addObjeto/"+modulo+"/"+leccion;
							} else if (modulo != "" && leccion == "") {
								url = "<?php echo CONTEXT ?>admin/addObjeto/"+modulo+"/b";
							} else {
							    url = "<?php echo CONTEXT ?>admin/addObjeto/a/b";
							}
							location.href = url;
						}
					</script>
					<button class="btn btn-lg registro" onclick="enlazar();">Nuevo objeto</button>
					<?php if ($_SESSION['perfil'] == 1): ?>
						<br><br>
						<a href="<?php echo CONTEXT ?>admin/lessons/"><button class="btn btn-lg registro">Ver lecciones</button></a>
					<?php endif ?>
				</div>
			</div>
		</div>

		<div class="separador">
			<div class="row">
				<div class="col-lg-4 offset-lg-4">
					<select name="modulo" id="modulo" class="form-control">
						<option value="">Todos los módulos</option>
						<?php 
							foreach ($this->temp['modulos'] as $modulo) { ?>
								<option value="<?php echo $modulo['id']; ?>"><?php echo $modulo['nombre']; ?></option>
							<?php }
						?>
					</select>
				</div>
			</div>
			<div class="row" style="margin-top: 20px;">
				<div class="col-lg-4 offset-lg-4">
					<select name="leccion" id="leccion" class="form-control"></select>
				</div>
			</div>
		</div>

		<div class="separador">
			<div class="row">
				<div class="col-lg-4 offset-lg-4">
					<button type="button" id="ordenar" class="btn registro" style="display: none;">Ordenar objetos</button>
				</div>
			</div>
		</div>

		<div class="page">
			<div class="row">
				<div class="col-lg-12 table-responsive">
					<table class="table tabla" id="tabla">
						<thead>
							<th>Orden</th>
							<th>Nombre</th>
							<th>Módulo</th>
							<th>Lección</th>
							<th>Tipo</th>
							<th>Fecha</th>
							<th>Estatus</th>
							<th>Acciones</th>
						</thead>
						<tbody>
						</tbody>
					</table>
					<div class="alert" id="mensaje" style="display: none;"></div>
				</div>
			</div>

			<div class="row">
			    <div class="offset-lg-9 col-lg-3">
			    	<a class="regresar basico menu-principal" href='<?php echo CONTEXT ?>admin/manager/'>Regresar</a>
			    </div>
			</div>
		</div>
	</section>

	<div class="modal fade bd-example-modal-lg modal-ordenamiento" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><b id="tituloModal"></b></h5>
					<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" style="margin-top: -20px !important;">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<ul class='list-group' id='lista'></ul>
					<ul class='list-group' id='sortable'></ul>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color: #2ebebb; color: #ffffff;">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
</section>