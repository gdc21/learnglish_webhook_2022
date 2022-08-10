<?php 
$datos = array(
	 '1' => array('topic' => 'At the airport' ),
	 '2' => array('topic' => 'At the hotel' ),
	 '3' => array('topic' => 'Transport' ),
	 '4' => array('topic' => 'Directions' ),
	 '5' => array('topic' => 'Sightseeing' ),
	 '6' => array('topic' => 'Cultural differences' ),
	 '7' => array('topic' => 'Typical food' ),
	 '8' => array('topic' => 'Emergencies' ),
	 '9' => array('topic' => 'Border crossing' ),
	'10' => array('topic' => 'History' )

	);


?>

<h1 class="titulo">Contenidos</h1>
<h4 class="titulo_advance">Inglés de Promoción Turística</h4>
<div class="table-responsive">
	<table class="table table-striped" id="tbl_advance">
		<thead>
			<tr>
				<th><div class="div_advance">Lesson</div></th>
				<th><div class="div_advance">Topic</div></th>
				
			</tr>
		</thead>
		<tbody>
		<?php 
			foreach ($datos as $key => $dato) {
				?>		
			<tr>
				<td class="text-center"> <?= $key ?></td>
				<td> <?= $dato['topic'] ?> </td>
				

			</tr>
		<?php } ?>
		</tbody>
	</table>
</div>