<style>
    button{
    	height: auto !important;
    }
</style>
<section id="contenido">
	<div class="row col-lg-12">
		<form id="startSession" novalidate="novalidate">
			<div class="modal-body">
				<div>
					<label for="uname">Usuario:</label><br>
				</div>
				<div>
					<span class="error"></span> <input type="text" id="uname" name="uname" class="form-control" onfocus="document.getElementById('uname').focus();">
				</div>
				<div>
					<br> <label for="pw">Contraseña:</label> <br>
				</div>
				<div>
					<span class="error"></span>
					<input type="password" autocomplete="on" id="pw" name="pw" class="form-control">
				</div>
				<br> <span class="error-login error"></span>
				<div id="closeLoginForm" data-target="#recoverPassword" data-toggle="modal" style="text-align: right;">
					<!-- <span style="cursor: pointer; font-size: 12px;"><b>Olvidé mi contraseña</b></span> -->
				</div>
				<br>
				<input type="checkbox" id="check" onchange="muestraPassword()">
				<label for="check">Mostrar contraseña</label>
			</div>
			<div class="modal-footer">
				<input type="submit" value="Ingresar" class="btn btn-primary">
			</div>
		</form>
	</div>
</section>
<script src="<?php echo CONTEXT; ?>portal/frontend/js/main.js"></script>