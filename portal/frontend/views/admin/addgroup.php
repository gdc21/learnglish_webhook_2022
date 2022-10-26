<section id="contenido">
	<?php echo $this->temp['encabezado']; ?>
	<div class="row">
	    <div class="col-lg-12" style="text-align: center;">
	    	<h3 class="title-section"><b><?php echo $this->temp['seccion_nombre']; ?></b></h3>
	    </div>
	</div>
	<div class="separador"></div>
	<form id="addGroup">
		<table class="FormularioStyle align_left" id="A_t_Neval">
			<tbody>
				<tr>
					<td class="nameCampo">Institución</td>
					<td>
						<select name="institucion" id="institucion" class="form-control">
							<?php if ($_SESSION['perfil'] != 4): ?>
								<option value="">Selecciona una institucion</option>
							<?php endif ?>
							<?php foreach ($this->temp['instituciones'] as $institucion): ?>
								<option value="<?php echo $institucion['LGF0270001']; ?>"><?php echo $institucion['LGF0270028']." ".$institucion['LGF0270002']; ?></option>
							<?php endforeach ?>
						</select>
						<span class="error"></span>
					</td>
				</tr>
				<tr>
					<td class="nameCampo">Grado académico</td>
					<td>
						<select name="nivel" id="nivel" class="form-control">
							<option value="">Selecciona un grado académico</option>
							<?php foreach ($this->temp['niveles'] as $nivel): ?>
								<option value="<?php echo $nivel['id']; ?>"><?php echo $nivel['nombre']; ?></option>
							<?php endforeach ?>
						</select>
						<span class="error"></span>
					</td>
				</tr>
				<tr>
					<td class="nameCampo">Ciclo Escolar</td>
					<td>
						<!-- <input type="text" name="ciclo" id="ciclo" class="form-control" placeholder="Ciclo Escolar"> -->
						<select name="ciclo" id="ciclo" class="form-control">
							<option value="">Selecciona un ciclo escolar</option>
							<?php foreach ($this->temp['cicloEscolar'] as $es): ?>
								<option value="<?php echo $es['LGF0350001'] ?>"><?php echo $es['LGF0350002'] ?></option>
							<?php endforeach ?>
						</select>
						<span class="error"></span>
					</td>
				</tr>
				<tr>
					<td class="nameCampo">Nombre</td>
					<td>
						<input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre del grupo">
						<span class="error"></span>
					</td>
				</tr>
				<tr>
					<td class="nameCampo">Docente Asignado</td>
					<td>
						<select name="docente" id="docente" class="form-control">
							<option value="">Selecciona un docente</option>
							<?php foreach ($this->temp['docentes'] as $docente): ?>
								<option value="<?php echo $docente['clave']; ?>"><?php echo $docente['nombreInstitucion']." ".$docente['nombre']; ?></option>
							<?php endforeach ?>
						</select>
						<span class="error"></span>
					</td>
				</tr>
			</tbody>
		</table>

		<div class="separador"></div>
		<div class="row">
		    <div class="col-lg-12" style="text-align: center;">
		    	<button id="guardar" class="btn btn-lg btn-primary" style="background: #0a6fb5;">Registrar Grupo</button>
		    </div>

		    <div class="col-md-12">
				<div class="form-group">
					<div class="alert alert-danger" id="mensaje" role="alert" style="margin-top: 20px; display: none;"></div>
				</div>
			</div>
		</div>
	</form>
	<div class="row">
		<div class="offset-lg-9 col-lg-3">
			<a class="regresar basico menu-principal" href='<?php echo CONTEXT ?>admin/groups/'>Regresar</a>
		</div>
	</div>
</section>