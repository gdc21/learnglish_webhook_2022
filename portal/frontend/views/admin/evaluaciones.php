<div class="table_Eval">
	<div class="table_head">
		<div class="th_1 az_1">Nombre</div>
		<div class="th_2 az_2">Tipo de Evaluación</div>
		<div class="th_3 az_3">Preguntas</div>
		<div class="th_4 az_1">Nivel</div>
		<div class="th_5 az_4">Módulo</div>
		<div class="th_6 az_5">Lección</div>
		<div class="th_7 az_6">Estado</div>
		<div class="th_8 az_6">Editar</div>
	</div>
	<?php
	if ($this->temp ['lista'] == false) {
		echo 'Aun no se agregan evaluaciones.';
	} else {
		foreach ( $this->temp ['lista'] as $eval ) {
			echo '<div class="table_row">
							<div class="tr_1 ">' . $eval ["Nombre"] . '</div>
							<div class="tr_2 ">' . $eval ["Tipo"] . '</div>
							<div class="tr_3 ">' . $eval ["Preguntas"] . ' / ' . $eval ["Preg_mostrar"] . '</div>
							<div class="tr_4 ">Nivel ' . $eval ["Nivel"] . '</div>
							<div class="tr_5 az_0">Módulo ' . $eval ["ID_modulo"] . ' ' . $eval ["Modulo"] . '</div>
							<div class="tr_6 ">' . $eval ["Leccion"] . '</div>
							<div class="tr_7 activa' . $eval ["ID_estado"] . '">' . $eval ["Estado"] . '</div>
							<div class="tr_8 bg_blanco">
								<a href="preguntas/' . $eval ["Id"] . '"><div class="tr_edit mor_1"><p>Preguntas</p></div></a>
								<a href="editEval/' . $eval ["Id"] . '"><div class="tr_edit mor_2"><p>Evaluación</p></div></a>
							</div>
						</div>';
		}
	}
	?>
</div>


<br>
<br>
<a href="<?=CONTEXT ?>admin/addEval"><input type="submit"
	value="Crear Evaluación" class="btGuardar btGuardarR"></a>
<a href="<?=CONTEXT ?>admin/index"><input type="submit" value="Cancelar"
	class="btGuardar btGuardarR"></a>







