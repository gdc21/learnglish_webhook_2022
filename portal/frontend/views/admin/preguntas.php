<div class="table_Eval">
	<div class="table_head">
		<div class="th_1 az_1">Pregunta</div>
		<div class="th_2 az_2">Tipo de pregunta</div>
		<div class="th_3 az_3">Categoria</div>
		<div class="th_4 az_1">Conteo correctas</div>
		<div class="th_5 az_4">Conteo incorrectas</div>
		<div class="th_8 az_6">Editar</div>
	</div>
	<?php
	if ($this->temp ['lista'] == false) {
		echo 'Aun no se agregan preguntas a esta evaluación.';
	} else {
		foreach ( $this->temp ['lista'] as $preg ) {
			echo '<div class="table_row">
							<div class="tr_1 ">' . $preg ["Pregunta"] . '</div>
							<div class="tr_2 ">' . $preg ["Tipo"] . '</div>
							<div class="tr_3 ">###</div>
							<div class="tr_4 ">' . $preg ["Correctas"] . '</div>
							<div class="tr_5 az_0">' . $preg ["Incorrectas"] . '</div>
							<div class="tr_8 mor_1">
								<a href="../editQuest/' . $preg ["Id"] . '">Editar</a>
							</div>
						</div>';
		}
	}
	?>
</div>


<br>
<br>

<a href="<?=CONTEXT ?>admin/addQuest/<?php echo $this->temp['ID_eval'];?>"><input
	type="submit" value="Agregar Pregunta" class="btGuardar btGuardarR"></a>
<a href="<?=CONTEXT ?>admin/evaluaciones"><input type="submit" value="Cancelar"
	class="btGuardar btGuardarR"></a>







