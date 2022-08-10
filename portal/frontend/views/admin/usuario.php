
<section id="contenido">
	<form id="nuevoUsuario" name="nuevoUsuario"  enctype="multipart/form-data" method="post">
		<table class="FormularioStyle align_left" id="A_t_Neval">
			<tbody>
				<tr>
					<td class="nameCampo">Nombre*</td>
					<td><span class="error"></span> <input type="text" name="nombre"
						class="input_large"></td>
				</tr>
				<tr>
					<td class="nameCampo">Apellido Paterno*</td>
					<td><span class="error"></span> <input type="text" name="lastnamep"
						class="input_large"></td>
				</tr>
				<tr>
					<td class="nameCampo">Apellido Materno*</td>
					<td><span class="error"></span> <input type="text" name="lastnamem"
						class="input_large"></td>
				</tr>
				<tr>
					<td class="nameCampo">Usuario*</td>
					<td><span class="error"></span> <input type="text" name="user"
						class="input_large"></td>
				</tr>
				<tr>
					<td class="nameCampo">Contraseña*</td>
					<td><span class="error"></span> <input type="text" name="password" id="password"
						class="input_large"></td>
				</tr>
				<tr>
					<td class="nameCampo">Confirmar Contraseña*</td>
					<td><span class="error"></span> <input type="text" name="passwordconfirm"
						class="input_large"></td>
				</tr>				
				<tr>
					<td class="nameCampo">Sexo</td>
					<td><span class="error"></span> <select name="sexo" id="sexo">
							<option value="0">Seleccione...</option>
							<option value="M">M</option>
							<option value="H">H</option>
					</select></td>
				</tr>
				<tr>
					<td class="nameCampo">Perfil</td>
					<td><span class="error"></span> <select name="perfil" id="perfil">
							<option value="0">Seleccione un perfil</option>
					</select></td>
				</tr>	
				<tr>
					<td class="nameCampo">Nivel</td>
					<td><span class="error"></span> <select name="nivel" id="nivel">
							<option value="0">Seleccione el Nivel</option>
							<option value="1">Nivel Basico</option>
							<option value="2">Nivel Avanzado</option>
					</select></td>
				</tr>
				<tr>
					<td class="nameCampo">Módulo</td>
					<td><span class="error"></span> <select name="modulo" id="modulo">
							<option value="0">Seleccione primero el Nivel</option>
					</select></td>
				</tr>
				<tr>
					<td class="nameCampo">Lección</td>
					<td><span class="error"></span> <select name="leccion" id="leccion">
							<option value="0">Seleccione primero un Módulo</option>
					</select></td>
				</tr>						
				<tr>
					<td class="nameCampo">Avatar</td>
					<td><span class="error"></span><input type="file" name="archivoImg" id="archivoImg" form="nuevoUsuario"/>												  
					</td>
				</tr> 
				<tr>
					<td class="nameCampo">Estatus*</td>
					<td><input type="radio" name="activo" id="radio" value="1"
						checked="">Activa <input type="radio" name="activo" id="radio2"
						value="0">Inactiva</td>
				</tr>
				<tr>
					<td class="nameCampo">Fecha de registro</td>
					<td><?php echo date("d-m-Y");?></td>
				</tr>
			</tbody>
		</table>
		<div class="alert" id="mensaje" name="mensaje"></div>
		<br />
		<div class="plus">
			<input type="submit" value="GUARDAR" class="btGuardar btGuardarR">
		</div>
	</form>

	<a href="<?=CONTEXT ?>admin/index" id="back" data-id=""><input type="submit"
		value="Cancelar" class="btGuardar btGuardarR"></a>


</section>
<script type="text/javascript">
	
	setTimeout(function(){		
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
