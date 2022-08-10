<?php
$preg = $this->temp ['Preg'] [0];
$resp = $this->temp ['Resp'];
$html = "";
$tipo = 0;
?>

<section id="contenido">
	<form id="preguntaN">
		<table class="TableStyle align_left" id="NewPreg"
			eval="<?php echo $this->temp['id_P'];?>">
			<tr>
				<th colspan="2">Configuración Pregunta</th>
			</tr>
					<?php
					$imgP = "";
					$displayP = '';
					if ($preg ["LGF0200003"] != "") {
						$imgP = '<img alt="" src="' . $preg ["LGF0200003"] . '" >';
						$displayP = 'style="display: block;"';
					}
					?>
				<tr>
				<td></td>
				<td>
					<p id="A_Aj_salto">Texto de la pregunta</p> <span class="error"></span>
					<textarea name="preguntaTXT" id="preguntaTXT" data-kind="pregunta"
						class="input_medium_length input_pregunta "><?php echo $preg["LGF0200002"]; ?></textarea>
				</td>
			</tr>
			<tr>
				<td id="img1"><img alt=""
					src="<?php echo IMG;?>/admin/foto_pregunta.png"></td>
				<td><input type="file" name="preguntaIMG" data-kind="pregunta"
					id="preguntaIMG" class="input_pregunta "> <input type="button"
					value="Borrar imagen" data-kind="pregunta" class="clearBTN"
					id="pregunta_clearBTN" <?php echo $displayP?>>
					<div id="displayIMG_Q" class="displayIMG_correcta"><?php echo $imgP;?></div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<p id="A_Aj_salto">Tipo de pregunta</p> <span class="error"></span>
					<select name="tipo" id="tipo">
							<?php
							if ($preg ["LGF0200004"] == "1") {
								$tipo = 4;
								echo '<option value="1" selected>Opción multiple</option>
							<option value="2">Verdadero o falso</option>';
							} else {
								$tipo = 2;
								echo '<option value="1">Opción multiple</option>
							<option value="2" selected>Verdadero o falso</option>';
							}
							?>
							
						</select>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<p id="A_Aj_salto">Categoria</p> <span class="error"></span> <select
					name="categoria" id="categoria">
							<?php
							
							foreach ( $this->temp ['Cat'] as $cat ) {
								$selected = "";
								if ($cat ["LGF0250001"] == $preg ["LGF0200010"])
									$selected = "selected";
								echo '<option value="' . $cat ["LGF0250001"] . '" ' . $selected . '>' . $cat ["LGF0250002"] . '</option>';
							}
							?>
						</select>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><p class="text_ok">Respuesta correcta</p></td>
			</tr>
				<?php
				$disable = "";
				$img = "";
				$display = '';
				if ($resp [0] ["LGF0210004"] != "") {
					// $disable="disabled";
					$img = '<img alt="" src="' . $resp [0] ["LGF0210004"] . '" id="IMG_correcta' . $i . '">';
					$display = 'style="display: block;"';
				}
				?>
				<tr>
				<td id="img2"><img alt=""
					src="<?php echo IMG;?>/admin/opcion_correcta.png"></td>
				<td><span class="error"></span> <input type="text"
					name="correctaTXT" data-kind="correcta" id="correctaTXT"
					data-id="<?php  echo $resp[0]["LGF0210001"];?>"
					class="input_medium_length text_small text_color_black input_correcta addQuest"
					<?php  echo 'value="'.$resp[0]["LGF0210003"].'" '.$disable;?>> <input
					type="text" name="resp1"
					value="<?php echo $resp[0]["LGF0210001"];?>" style="display: none;"></td>
			</tr>
			<tr>
				<td id="img1"><img alt=""
					src="<?php echo IMG;?>/admin/foto_pregunta.png"></td>
				<td><input type="file" name="correctaIMG" data-kind="correcta"
					class="input_correcta addQuest2" id="correctaIMG"
					<?php echo $disable;?>> <input type="button" value="Borrar imagen"
					data-kind="correcta" class="clearBTN" id="correcta_clearBTN"
					<?php echo $display;?>>
					<div id="displayIMG_Q" class="displayIMG_correcta">
							<?php echo $img;?>
						</div></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<p class="text_error">Respuestas incorrectas</p>
				</td>
			</tr>
				
				<?php
				
				for($i = 1; $i < 4; $i ++) {
					$class = '';
					$imagen = "";
					$texto = "";
					$disableTXT = "";
					$disableIMG = "";
					$display = 'style="display: block;"';
					$id = 0;
					$idx = 0;
					if ($i > 1)
						$class = 'class="noTF"';
					
					if ($tipo == 4 || ($tipo == 2 && $i == 1)) {
						$idx = $resp [$i] ["LGF0210001"];
						$id = 'data-id="' . $resp [$i] ["LGF0210001"] . '"';
						if ($resp [$i] ["LGF0210003"] != "") {
							$texto = $resp [$i] ["LGF0210003"];
							// $disableIMG = "disabled";
							$display = "";
						}
						if ($resp [$i] ["LGF0210004"] != "") {
							$imagen = '<img src="' . $resp [$i] ["LGF0210004"] . '" id="IMG_incorrecta' . $i . '">';
							// $disableIMG = "disabled";
							// $disableTXT = "disabled";
						}
					} else if ($i > 1) {
						$class = $class . ' style="display:none;"';
					}
					
					$html = $html . '<tr ' . $class . '>
					<td id="img2"><img alt=""
						src="' . IMG . '/admin/opcion_incorrecta.png"></td>
					<td>
						<span class="error"></span>
						<input type="text" name="incorrecta' . $i . 'TXT" data-kind="incorrecta' . $i . '" id="incorrecta' . $i . 'TXT" class="input_medium_length text_small text_color_black input_incorrecta' . $i . ' addQuest" 
						' . $id . ' value="' . $texto . '" ' . $disableTXT . '>
						<input type="text" name="resp' . ($i + 1) . '" value="' . $idx . '" style="display: none;">
					</td>
				</tr>
				<tr ' . $class . '>
					<td id="img1"><img alt="" src="' . IMG . '/admin/foto_pregunta.png"></td>
					<td>
						<input type="file" name="incorrecta' . $i . 'IMG" data-kind="incorrecta' . $i . '" class="input_incorrecta' . $i . ' addQuest2" id="incorrecta' . $i . 'IMG" ' . $disableIMG . '>
						<input type="button" value="Borrar imagen"  data-kind="incorrecta' . $i . '" class="clearBTN" id="incorrecta' . $i . '_clearBTN" ' . $display . '>
						<div id="displayIMG_Q" class="displayIMG_incorrecta' . $i . '">' . $imagen . '</div>		
			    	</td>
				</tr>';
				}
				echo $html;
				?>
				
			</table>
		<div class="alert" id="mensaje" style="display: none;"></div>
		<br />
		<div class="plus">
			<input type="submit" value="Guardar Cambios"
				class="btGuardar btGuardarR">
		</div>
	</form>
	<a
		href="<?= CONTEXT ?>admin/preguntas/<?php echo $preg["LGF0200009"];?>"
		id="back" data-id="<?php echo $preg["LGF0200009"];?>"><input
		type="submit" value="Cancelar" class="btGuardar btGuardarR"></a>


</section>
<script type="text/javascript">
	
	setTimeout(function(){	
		//$.getScript("<?php echo CONTEXT;?>portal/frontend/js/jquery-ui.min.js",function(){	});
		$("head").append("<link rel='stylesheet' type='text/css' href='<?php echo CONTEXT;?>portal/frontend/css/jquery-ui.min.css'>");	
		
	},00);
</script>
<style>
.TableStyle {
	border: 0 solid #fff !important;
	border-collapse: collapse !important;
	border-spacing: 5px;
	font-family: Arial, Helvetica, sans-serif;
	width: 100%;
	font-size: 18px;
}

.align_left {
	text-align: left;
}

.TableStyle tr th {
	background-color: #202020;
	height: 28px;
	text-align: center;
	text-transform: uppercase;
	color: #fff;
	font-family: Arial, Lato, sans-serif;
	font-size: 12px;
	font-weight: bold;
}

.TableStyle tr td {
	background-color: #ecedef;
	padding: 5px;
	vertical-align: top;
	color: #666;
	font-family: Arial, Lato, sans-serif;
	font-weight: normal;
}

.input_medium_length {
	width: 95% !important;
}

#img1, #img2 {
	text-align: center;
}

#preguntaN input[type=file] {
	float: left;
	width: 60%;
}

.clearBTN {
	display: none;
	float: left;
}
</style>
