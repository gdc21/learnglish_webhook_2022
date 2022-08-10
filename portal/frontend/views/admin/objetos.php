<section id="contenido">
	Objetos
	<form id="NewNavStructure">
		<div>
			<div class="img_c" id="add_level">+</div>
			<span>Nivel: </span>
			<select name="nivel" id="nivel">
				<option value="0">Seleccione el Nivel</option>   	
				<option value="1">Nivel 1</option>
				<option value="2">Nivel 2</option>
			</select>
		</div>
		<div>
			<div class="img_c" id="add_modul" style="display:none">+</div>
			<span>Módulo: </span>
			<select name="modulo" id="modulo">
				<option value="">Seleccione el Nivel</option>   	
			</select>
		</div>
		<div>
			<div class="img_c" id="add_lesson" style="display:none">+</div>
			<span>Lección: </span>
			<select name="leccion" id="leccion">
				<option value="">Seleccione el Módulo</option>   	
			</select>
		</div>
		<div class="add_sec_btn">+Agregar Seccion</div> 
	</form>
	<div style="clear: both;"></div>
	<div class="div_secciones" id="div_sec_1">
		<div><b>Secciones: </b></div>
		<ul class="slides" id="slides"></ul>
	</div>
	<div class="div_secciones" id="div_sec_2">
	
		<div id="add_seccion">
		<button type="button" class="close" id="cerrar" aria-label="Close">
            <span aria-hidden="true">×</span>
     </button>
			<b>Agregar Seccion: </b>
			<form id="NewSeccion">
				<div class="select_n_sec">
					<span>Seccion: </span>
					<select name="new_seccion" id="new_seccion">
						<option value="0">Seleccione nombre de la sección</option>   	
					</select>
				</div>
				<input type="button" value="Guardar" id="new_sec_nav"/>  
			</form>	

		</div>
		<div id="edit_seccion">


			<div class="sec_name">

				<span>Nombre de la sección: </span>
				<select name="sec_name_sele" id="sec_name_sele">
					<option value="">Seleccione la sección</option>   	
				</select>
				<button type="button" class="close" id="cerrar_2" aria-label="Close">
            <span aria-hidden="true">×</span>
     </button>
<div class="form-group">
            <div class="checkbox">
               <label> <input type="checkbox" value=""
                  id="estatus" name="estatus" form="form"> <span
                  class="cr"><i class="cr-icon fa fa-circle"></i></span> Estatus
               </label>
            </div>
            <div id="mostrar_conexion" style="position:absolute; left:0; right:0; top:0; bottom:0; cursor: pointer; display:none;" ></div>
         </div>	
			</div>
			
            <form enctype="multipart/form-data" id="frm_file">
              	
                    <input id="file-4" name="file-4" type="file" class="file-loading" data-upload-url="#" form="frm_file">
               	
            </form>
            <hr>
            <br>
        </div>
			
		
	</div>
	
</section>
<script type="text/javascript">
	
	setTimeout(function(){	
		//$.getScript("<?php echo CONTEXT;?>portal/frontend/js/jquery-ui.min.js",function(){	});
		$("head").append("<link rel='stylesheet' type='text/css' href='<?php echo CONTEXT;?>portal/frontend/css/jquery-ui.min.css'>");	
		
	},00);
</script>