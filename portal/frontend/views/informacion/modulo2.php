<?php 
$datos = array(
		    '1' =>array('topic' =>'Traditions: Day of the Dead','grammar' => 'Present Perfect.'),
			'2' =>array('topic' =>'Grandparents love story','grammar' => 'Past Perfect'),
			'3' =>array('topic' =>'When I become an adult','grammar' => 'Future Perfect'),
			'4' =>array('topic' =>'My skills','grammar' => 'Reflexive Pronouns'),
			'5' =>array('topic' =>'On the daily news','grammar' => 'Tag Questions'),
			'6' =>array('topic' =>'Family Rules','grammar' => 'Modals: might, should, could'),
			'7' =>array('topic' =>'At the museum','grammar' => 'Must/Have to'),
			'8' =>array('topic' =>'The anniversary','grammar' => 'Adverbs'),
			'9' =>array('topic' =>'"I lost my backpack..!','grammar' => 'If clause'),
			'10' =>array('topic' =>'Everything done','grammar' => 'Passive Voice: Simple Tenses'),
			'11' =>array('topic' =>'The report','grammar' => 'Passive Voice: Perfect Tenses'),
			'12' =>array('topic' =>'The menu','grammar' => 'Reported Speech: Simple Tenses'),
			'13' =>array('topic' =>'To the moon and back','grammar' => 'Reported Speech: perfect Tenses'),
			'14' =>array('topic' =>'Malala!','grammar' => 'Reported Speech: Questions'),
			'15' =>array('topic' =>'Our town','grammar' => 'Adjective Clauses: whose, where, when, which'),
			'16' =>array('topic' =>'My country','grammar' => 'Gerunds and Infinitives'),
			'17' =>array('topic' =>'My favorite cartoon','grammar' => 'Connectives: Cause and effect'),
			'18' =>array('topic' =>'Nature','grammar' => 'Connectives: Condition'),
			'19' =>array('topic' =>'Technology','grammar' => 'Connectives: Contrast'),
			'20' =>array('topic' =>'My prom','grammar' => 'Essay')

		);


?>

<h1 class="titulo">Contenidos</h1>
<h4 class="titulo_basic">Gramática II</h4>
<div class="table-responsive">
	<table class="table table-striped" id="tbl_basic">
		<thead>
			<tr>
				<th><div class="div_basic">Lesson</div></th>
				<th><div class="div_basic">Topic</div></th>
				<th><div class="div_basic">Grammar</div></th>
			</tr>
		</thead>
		<tbody>
		<?php 
			foreach ($datos as $key => $dato) {
				?>		
			<tr>
				<td class="text-center"> <?= $key ?></td>
				<td> <?= $dato['topic'] ?> </td>
				<td> <?= $dato['grammar'] ?> </th>
			</tr>
		<?php } ?>
		</tbody>
	</table>
</div>