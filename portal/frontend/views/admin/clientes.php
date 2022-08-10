<section class="container">
	<section id="contenido">
		<?php echo $this->temp['encabezado']; ?>
		<div class="separador">
			<div class="row">
				<div class="col-lg-6">
					<h1 class="title-section">Clientes Registrados</h1>
				</div>

				<div class="col-lg-3 offset-lg-3">
					<br>
					<a href="<?php echo CONTEXT ?>admin/addCliente"><button class="btn btn-lg registro">Nuevo cliente</button></a>
				</div>
			</div>
		</div>
		<div class="separador"></div>
		
		<div class="page">
			<div class="row">
				<div class="col-lg-12 table-responsive">
					<table class="table tabla order-table" id="tabla_clientes">
						<thead>
							<th>Cliente</th>
							<th>Contacto</th>
							<th>Instituciones</th>
							<th>Fecha</th>
							<th>Acciones</th>
						</thead>
						<tbody>
							<?php foreach ($this->temp['lista'] as $cli): ?>
								<tr>
									<td><?php echo $cli['nombre']; ?></td>
									<td><?php echo $cli['contacto']; ?></td>
									<td>
										<a href="<?php echo CONTEXT ?>admin/details/<?php echo $cli['id']; ?>">Ver instituciones (<?php echo $cli['totalInst']; ?>)</a>
									</td>
									<td><?php echo $cli['fecha']; ?></td>
									<td style="vertical-align: middle;">
										<span><a href="<?php echo CONTEXT ?>admin/editCliente/<?php echo $cli['id']; ?>">
											<i class="fa fa-pencil" aria-hidden="true"></i> Editar</a>
										</span>
										<span><a href="#" onclick="eliminar(<?php echo $cli['id']; ?>)">
											<i class="fa fa-trash" aria-hidden="true"></i> Eliminar</a>
										</span>
									</td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row">
			    <div class="offset-lg-9 col-lg-3">
			    	<a class="regresar basico menu-principal" href='<?php echo CONTEXT ?>admin/manager/'>Regresar</a>
			    </div>
			</div>
		</div>
	</section>
</section>