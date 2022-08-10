<?php 
	$urls = $this->temp['urls'];
	$imagen = $this->temp['imagen'];
?>
	<div class="container-level">
		<div class="levelIncator">
			<div class="btn_level basico">
				<a href="<?php echo $urls[0]; ?>">
					<img src="<?php echo IMG.$imagen[0] ?>">
					<div class="level_info">
						<h3>Preescolar</h3>
					</div>
				</a>
			</div>
		</div>

		<div class="levelIncator">
			<div class="btn_level avanzado interno">
				<a href="<?php echo $urls[1]; ?>">
					<img src="<?php echo IMG.$imagen[1] ?>">
					<div class="level_info">
						<h3>Primaria</h3>
					</div>
				</a>
			</div>
		</div>

		<div class="levelIncator">
			<div class="btn_level basico">
				<a href="<?php echo $urls[2]; ?>">
					<img src="<?php echo IMG.$imagen[2] ?>">
					<div class="level_info">
						<h3>Secundaria</h3>
					</div>
				</a>
			</div>
		</div>
	</div>
