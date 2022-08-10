<?php 
$datos = array(
		 '1' => array('topic' => 'Introducing myself', 'grammar' => 'Verb TO BE'),
		 '2' => array('topic' => 'My family', 'grammar' => 'Parts of the Sentence/ Subject Pronouns'),
		 '3' => array('topic' => 'Best Friends', 'grammar' => 'Simple Present Tense'),
		 '4' => array('topic' => 'Healthy life ', 'grammar' => 'Yes/No questions'),
		 '5' => array('topic' => 'School', 'grammar' => 'Possessive Pronouns'),
		 '6' => array('topic' => 'Packing for the camp', 'grammar' => 'Possessive Nouns'),
		 '7' => array('topic' => 'Camping with friends', 'grammar' => 'Demonstrative Pronouns /There is -There are'),
		 '8' => array('topic' => 'Visiting the farm', 'grammar' => 'Present Progressive Tense'),
		 '9' => array('topic' => 'Birthday party', 'grammar' => 'Imperative Form'),
		'10' => array('topic' => 'Last vacations', 'grammar' => 'Simple Past Tense'),
		'11' => array('topic' => 'The new house', 'grammar' => 'Prepositions'),
		'12' => array('topic' => 'Shopping day!', 'grammar' => 'Adjectives: Comparative/Superlative'),
		'13' => array('topic' => 'My favorite Christmas', 'grammar' => 'Past Progressive Tense'),
		'14' => array('topic' => 'At the market', 'grammar' => 'Nouns: Singular and Plural'),
		'15' => array('topic' => 'My favorite food', 'grammar' => 'Indefinite Articles: a, an, some, many, any'),
		'16' => array('topic' => 'My future plans', 'grammar' => 'be goig to'),
		'17' => array('topic' => 'The lottery', 'grammar' => 'Simple Future Tense'),
		'18' => array('topic' => 'The lost wallet', 'grammar' => 'Wh-Questions'),
		'19' => array('topic' => 'The weather', 'grammar' => 'Can / Can not'),
		'20' => array('topic' => 'In the tour', 'grammar' => 'How many? How much?')

		);


?>

<h1 class="titulo">Contenidos</h1>
<h4 class="titulo_basic">Gramática I</h4>
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