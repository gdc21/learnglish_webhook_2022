<style>
    .form-control {
        border: 1px solid #ced4da !important;
    }
</style>
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
                            <th>Agregar estadística</th>
                            <th>Acciones</th>
                        </thead>
                        <tbody>
                            <?php foreach ($this->temp['lista'] as $cli) : ?>
                                <tr>
                                    <td><?php echo $cli['nombre']; ?></td>
                                    <td><?php echo $cli['contacto']; ?></td>
                                    <td>
                                        <a href="<?php echo CONTEXT ?>admin/details/<?php echo $cli['id']; ?>">Ver instituciones (<?php echo $cli['totalInst']; ?>)</a>
                                    </td>
                                    <td><?php echo $cli['fecha']; ?></td>
                                    <td>
                                        <button type="button" cliente="<?php echo $cli['id']; ?>" clienteNombre="<?php echo $cli['nombre']; ?>" class="botModalAgregarEstadistica btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalAgregarEstadistica">
                                            Agregar
                                        </button>
                                    </td>
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
    <!-- Modal para agregar estadisticas -->
    <div class="modal fade" id="modalAgregarEstadistica" tabindex="-1" aria-labelledby="modalEstadFunction" aria-hidden="true">
        <div class="modal-dialog" style="min-width: 50% !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEstadFunction">Datos del cliente: <b id="nombreCliente"></b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="contenido">
                    <form action="" id="formularioAgregar">
                        <h3>Introducir los datos para generar estadisticas generales por cliente: </h3>
                        <input type="hidden" name="cliente" id="clienteHidden">
                        <label>Licencias</label>
                        <input type="number" name="licencias" step="1" placeholder="Cantidad licencias" class="mb-2 form-control" value="10000" required>
                        <hr>
                        <label>Fecha de inicio de contratación:</label>
                        <input type="date" name="fec_inicio" class="mb-2 form-control" value="<?= date('Y-m') ?>-01" required>
                        <hr>
                        <label>Fecha de finalización de contratación:</label>
                        <input type="date" name="fec_fin" class="mb-2 form-control" value="<?= date('Y-m-d') ?>" required>


                        <button class="btn-lg btn btn-success mt-3">Agregar estadística</button>
                    </form>
                    <div class="row">
                        <div class="col-lg-12 table-responsive">
                            <h4 class="my-3">Datos actuales del cliente</h4>
                            <table class="table tabla" id="tabla">
                                <thead>
                                    <th>Licencias</th>
                                    <th>Fecha inicio:</th>
                                    <th>Fecha fin:</th>
                                    <th>Acciones</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div class="alert" id="mensaje" style="display: none;"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="cerrar" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(function() {
        var cliente = "";

        $(".botModalAgregarEstadistica").click(function() {
            cliente = this.getAttribute('cliente');
            nombrecliente = this.getAttribute('clienteNombre');

            $("#nombreCliente").html(nombrecliente);
            $("#clienteHidden").val(cliente);

            cargar_tabla(cliente);
        })
        $("#formularioAgregar").submit(function(event) {
            event.preventDefault();

            data = getInfoAjax('asignarestadisticacliente', $("#formularioAgregar").serialize(), "admin");

            if (data) {
                $("#mensaje").show();
                $('#mensaje').removeClass("alert-danger");
                $('#mensaje').addClass("alert-success");
                $('#mensaje').show("swing");
                $('#mensaje').html('<b>' + data.mensaje + '</b>');

                cargar_tabla(cliente);
                window.location = "#cerrar";

                setTimeout(function() {
                    $("#mensaje").hide();
                    $("#formularioAgregar")[0].reset();
                }, 2000);

            } else {
                $("#mensaje").show();
                $('#mensaje').removeClass("alert-success");
                $('#mensaje').addClass("alert-danger");
                $('#mensaje').show("swing");
                $('#mensaje').html('<b>Algo fallo al cargar la información</b>');
                $("#tabla").dataTable().fnDestroy();

            }

        })

        function accionesEliminar() {

            $('.eliminarRegistroCliente').click(function() {
                var confirmar = confirm("¿Seguro que desea eliminar el registro?");

                if (confirmar) {
                    var registro = this.getAttribute('registro');

                    data = getInfoAjax('eliminarestadisticacliente', {
                        id: registro
                    }, "admin");
                    if (data) {
                        $("#mensaje").show();
                        $('#mensaje').removeClass("alert-danger");
                        $('#mensaje').addClass("alert-success");
                        $('#mensaje').show("swing");
                        $('#mensaje').html('<b>' + data.mensaje + '</b>');

                        cargar_tabla(cliente);
                        window.location = "#cerrar";

                        setTimeout(function() {
                            $("#mensaje").hide();
                        }, 2000);

                    } else {
                        $("#mensaje").show();
                        $('#mensaje').removeClass("alert-success");
                        $('#mensaje').addClass("alert-danger");
                        $('#mensaje').show("swing");
                        $('#mensaje').html('<b>Algo fallo al cargar la información</b>');
                        $("#tabla").dataTable().fnDestroy();

                    }
                }
            });
        }

        function cargar_tabla(cliente2) {
            $.ajax({
                type: "POST",
                url: context + "admin/obtenerestadisticacliente",
                data: {
                    cliente: cliente2
                },
                dataType: 'json',
                beforeSend: function() {
                    $("#tabla tbody").html("");
                },
                success: function(resp) {
                    if (resp.cantidad) {
                        $("#tabla").dataTable().fnDestroy();
                        $("#tabla tbody").html(resp.tabla);
                        $('#tabla').dataTable({
                            searching: true,
                            paging: true,
                            "language": {
                                "paginate": {
                                    "next": "Siguiente",
                                    "previous": "Anterior"
                                },
                                "info": "Mostrando _START_ de _END_",
                                "search": "Buscar"
                            },
                            "order": [
                                [0, "asc"]
                            ], //or asc
                            columnDefs: [{
                                type: 'de_date',
                                targets: 3
                            }]
                        });
                        accionesEliminar();
                    } else {
                        $("#tabla tbody").html(resp.tabla);
                    }
                }
            });
        }
    });
</script>