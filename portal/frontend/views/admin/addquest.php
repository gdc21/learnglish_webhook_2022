<section id="contenido">
	<form id="preguntaN">
		<input type="text" name="id_eval"
			value="<?php echo $this->temp['id_EV'];?>" style="display: none;">
		<table class="TableStyle align_left" id="NewPreg"
			eval="<?php echo $this->temp['id_EV'];?>">
			<tr>
				<th colspan="2">Configuración Pregunta</th>
			</tr>
			<tr>
				<td></td>
				<td>
					<p id="A_Aj_salto">Texto de la pregunta</p> <span class="error"></span>
					<textarea name="preguntaTXT" id="preguntaTXT" data-kind="pregunta"
						class="input_medium_length input_pregunta"></textarea>
				</td>
			</tr>
			<tr>
				<td id="img1"><img alt=""
					src="<?php echo IMG;?>/admin/foto_pregunta.png"></td>
				<td><input type="file" name="preguntaIMG" data-kind="pregunta"
					id="preguntaIMG" class="input_pregunta"> <input type="button"
					value="Borrar imagen" data-kind="pregunta" class="clearBTN"
					id="pregunta_clearBTN">
					<div id="portadaPregunta"></div></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<p id="A_Aj_salto">Tipo de pregunta</p> <span class="error"></span>
					<select name="tipo" id="tipo">
						<option value="1">Opción multiple</option>
						<option value="2">Verdadero o falso</option>
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
								echo '<option value="' . $cat ["LGF0250001"] . '" >' . $cat ["LGF0250002"] . '</option>';
							}
							?>
						</select>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><p class="text_ok">Respuesta correcta</p></td>
			</tr>
			<tr>
				<td id="img2"><img alt=""
					src="<?php echo IMG;?>/admin/opcion_correcta.png"></td>
				<td><span class="error"></span> <input type="text"
					name="correctaTXT" data-kind="correcta" id="correctaTXT"
					class="input_medium_length text_small text_color_black input_correcta addQuest">
				</td>
			</tr>
			<tr>
				<td id="img1"><img alt=""
					src="<?php echo IMG;?>/admin/foto_pregunta.png"></td>
				<td><input type="file" name="correctaIMG" data-kind="correcta"
					class="input_correcta addQuest2" id="correctaIMG"> <input
					type="button" value="Borrar imagen" data-kind="correcta"
					class="clearBTN" id="correcta_clearBTN">
					<div id="portadaPregunta"></div></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<p class="text_error">Respuestas incorrectas</p>
				</td>
			</tr>
			<tr>
				<td id="img2"><img alt=""
					src="<?php echo IMG;?>/admin/opcion_incorrecta.png"></td>
				<td><span class="error"></span> <input type="text"
					name="incorrecta1TXT" data-kind="incorrecta1" id="incorrecta1TXT"
					class="input_medium_length text_small text_color_black input_incorrecta1 addQuest">
				</td>
			</tr>
			<tr>
				<td id="img1"><img alt=""
					src="<?php echo IMG;?>/admin/foto_pregunta.png"></td>
				<td><input type="file" name="incorrecta1IMG" data-kind="incorrecta1"
					class="input_incorrecta1 addQuest2" id="incorrecta1IMG"> <input
					type="button" value="Borrar imagen" data-kind="incorrecta1"
					class="clearBTN" id="incorrecta1_clearBTN">
					<div id="portadaPregunta"></div></td>
			</tr>
			<tr class="noTF">
				<td id="img2"><img alt=""
					src="<?php echo IMG;?>/admin/opcion_incorrecta.png"></td>
				<td><span class="error"></span> <input type="text"
					name="incorrecta2TXT" data-kind="incorrecta2" id="incorrecta2TXT"
					class="input_medium_length text_small text_color_black input_incorrecta2 addQuest">
				</td>
			</tr>
			<tr class="noTF">
				<td id="img1"><img alt=""
					src="<?php echo IMG;?>/admin/foto_pregunta.png"></td>
				<td><input type="file" name="incorrecta2IMG" data-kind="incorrecta2"
					class="input_incorrecta2 addQuest2" id="incorrecta2IMG"> <input
					type="button" value="Borrar imagen" data-kind="incorrecta2"
					class="clearBTN" id="incorrecta2_clearBTN">
					<div id="portadaPregunta"></div></td>
			</tr>
			<tr class="noTF">
				<td id="img2"><img alt=""
					src="<?php echo IMG;?>/admin/opcion_incorrecta.png"></td>
				<td><span class="error"></span> <input type="text"
					name="incorrecta3TXT" data-kind="incorrecta3" id="incorrecta3TXT"
					class="input_medium_length text_small text_color_black input_incorrecta3 addQuest">
				</td>
			</tr>
			<tr class="noTF">
				<td id="img1"><img alt=""
					src="<?php echo IMG;?>/admin/foto_pregunta.png"></td>
				<td><input type="file" name="incorrecta3IMG" data-kind="incorrecta3"
					class="input_incorrecta3 addQuest2" id="incorrecta3IMG"> <input
					type="button" value="Borrar imagen" data-kind="incorrecta3"
					class="clearBTN" id="incorrecta3_clearBTN">
					<div id="portadaPregunta"></div></td>
			</tr>
		</table>
		<div class="alert" id="mensaje" style="display: none;"></div>
		<br />
		<div class="plus">
			<input type="submit" value="GUARDAR" class="btGuardar btGuardarR">
		</div>
	</form>
	<a href="../preguntas/<?php echo $this->temp['id_EV'];?>" id="back"
		data-id="<?php echo $this->temp['id_EV'];?>"><input type="submit"
		value="Cancelar" class="btGuardar btGuardarR"></a>


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
