<section class="container">
	<section id="contenido">
		<?php echo $this->temp['encabezado']; ?>
		<div class="separador">
			<div class="row">
				<div class="col-lg-6">
					<h1 class="title-section">Instituciones del cliente</h1>
				</div>
			</div>
		</div>
		<div class="separador"></div>
		
		<div class="page">
			<div class="row">
				<div class="col-lg-12">
					<table class="table tabla order-table" id="tabla">
						<thead>
							<th>Cliente</th>
							<th>C.C.T</th>
							<th>Institución</th>
							<th>Total de alumnos</th>
						</thead>
						<tbody>
							<?php foreach ($this->temp['lista'] as $key => $value): ?>
								<tr>
									<td><?php echo $value['cliente']; ?></td>
									<td><?php echo (empty($value['CCT']) ? "----" : $value['CCT']); ?></td>
									<td><?php echo $value['institucion']; ?></td>
									<td><?php echo $value['totalAlumnos']; ?></td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row">
			    <div class="offset-lg-9 col-lg-3">
			    	<a class="regresar basico menu-principal" href='<?php echo CONTEXT ?>admin/clientes/'>Regresar</a>
			    </div>
			</div>
		</div>
	</section>
</section>
<script>
	$(".table").dataTable({
		searching: true,
		paging: true,
		"language": {
			"paginate": {
				"next": "Siguiente",
				"previous": "Anterior"
			},
			"info": "Mostrando _START_ de _END_",
			"search": "Buscar"
		}
	});
</script>