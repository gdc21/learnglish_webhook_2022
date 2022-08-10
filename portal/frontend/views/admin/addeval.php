
<section id="contenido">
	<form id="nuevaEvaluacion" novalidate="novalidate">
		<table class="FormularioStyle align_left" id="A_t_Neval">
			<tbody>
				<tr>
					<td class="nameCampo">Nombre</td>
					<td><span class="error"></span> <input type="text" name="nombre"
						class="input_large"></td>
				</tr>
				<tr>
					<td class="nameCampo">Tipo de evaluacion</td>
					<td><input type="radio" name="tipo" id="tipo1" value="1" checked>Lección
						<input type="radio" name="tipo" id="tipo2" value="2">Módulo</td>
				</tr>
				<tr>
					<td class="nameCampo">Nivel</td>
					<td><span class="error"></span> <select name="nivel" id="nivel">
							<option value="">Seleccione el Nivel</option>
							<option value="1">Nivel Basico</option>
							<option value="2">Nivel Avanzado</option>
					</select></td>
				</tr>
				<tr>
					<td class="nameCampo">Módulo</td>
					<td><span class="error"></span> <select name="modulo" id="modulo">
							<option value="">Seleccione primero el Nivel</option>
					</select></td>
				</tr>
				<tr>
					<td class="nameCampo">Lección</td>
					<td><span class="error"></span> <select name="leccion" id="leccion">
							<option value="0">Seleccione primero un Módulo</option>
					</select></td>
				</tr>
				<tr>
					<td class="nameCampo">Tiempo de evaluación</td>
					<td><span class="error"></span> <input type="text"
						placeholder="hh:mm" name="tiempo" id="tiempo"></td>
				</tr>
				<tr>
					<td class="nameCampo">Preguntas a mostrar</td>
					<td><span class="error"></span> <input type="number"
						name="numPreguntas" min="1" max="50" value="1"></td>
				</tr>
				<tr>
					<td class="nameCampo">Estatus</td>
					<td><input type="radio" name="activo" id="radio" value="1"
						checked="">Activa <input type="radio" name="activo" id="radio2"
						value="0">Inactiva</td>
				</tr>
				<tr>
					<td class="nameCampo">Versión</td>
					<td><select name="version" id="version">
							<?php
							foreach ( $this->temp ['Version'] as $ver ) {
								echo '<option value="' . $ver ["LGF0240001"] . '" >' . $ver ["LGF0240002"] . '</option>';
							}
							?>
						</select></td>
				</tr>
				<!-- <tr>
					<td class="nameCampo">PDF</td>
					<td><span class="error"></span><input type="file" name="archivoImg" id="archivoImg">
					</td>
				</tr>-->
				<tr>
					<td class="nameCampo">Fecha de registro</td>
					<td><?php echo date("d-m-Y");?></td>
				</tr>
			</tbody>
		</table>
		<div class="alert" id="mensaje" style="display: none;"></div>
		<br />
		<div class="plus">
			<input type="submit" value="GUARDAR" class="btGuardar btGuardarR">
		</div>
	</form>

	<a href="evaluaciones" id="back" data-id=""><input type="submit"
		value="Cancelar" class="btGuardar btGuardarR"></a>


</section>
<script type="text/javascript">
	
	setTimeout(function(){	
		//$.getScript("<?php echo CONTEXT;?>portal/frontend/js/jquery-ui.min.js",function(){	});
		$("head").append("<link rel='stylesheet' type='text/css' href='<?php echo CONTEXT;?>portal/frontend/css/jquery-ui.min.css'>");	
		
	},00);
</script>
<style>
.FormularioStyle {
	border-collapse: separate !important;
	border-spacing: 5px;
	border: 10px solid #fff !important;
	font-family: Lato, Arial, Helvetica, sans-serif;
	width: 100%;
}

.align_left {
	text-align: left;
}

.FormularioStyle tr .nameCampo {
	background-color: #202020;
	color: #fff;
	font-size: 15px;
	font-weight: bolder;
	height: 28px;
	width: 26.5%;
	color: #fff;
	font-family: Arial, Arial, sans-serif;
	font-size: 15px;
	font-weight: bold;
}

.FormularioStyle tr td {
	background-color: #ecedef;
	color: #666;
	font-size: 16px;
	padding: 10px;
	vertical-align: top;
	width: 71.6%;
}
</style>
