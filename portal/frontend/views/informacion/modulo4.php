<?php 
$datos = array(
	 '1' => array('topic' => 'Introducing myself: formal' ),
	 '2' => array('topic' => 'Looking for a job' ),
	 '3' => array('topic' => 'Personal resume' ),
	 '4' => array('topic' => 'Doing business' ),
	 '5' => array('topic' => 'Politics and social issues' ),
	 '6' => array('topic' => 'Business letter' ),
	 '7' => array('topic' => 'Applying for a VISA' ),
	 '8' => array('topic' => 'For rent' ),
	 '9' => array('topic' => 'University registration' ),
	'10' => array('topic' => 'Summary and essay' )

	);


?>

<h1 class="titulo">Contenidos</h1>
<h4 class="titulo_advance">Inglés de Profesional</h4>
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