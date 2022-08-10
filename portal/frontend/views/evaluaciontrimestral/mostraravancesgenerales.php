<style>
    #contenido{
        padding: 0 !important;
    }
    .botonMostrarInstitucion{
        width: initial;
        padding: 3px;
        margin: 0;
        height: initial;
    }
    .libotonMostrarInstitucion{
        margin: 5px 0px ;
    }
</style>
<section id="contenido">
    <?php echo $this->temp['encabezado']; ?>

    <div class="separador"></div>
    <!-- Admin -->

    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2>Avances generales de evaluaciones</h2>
                <b>Total de alumnos que han realizado su examen: <?php echo count($this->temp['estadisticas']); ?> </b>
                <br><br>
                <b>Niños: <?php echo $this->temp['hombres']; ?></b>
                <br><br>
                <b>Niñas: <?php echo $this->temp['mujeres']; ?></b>
                <hr>
                <button class="botonMostrarTodos btn btn-success btn-sm">
                    Mostrar todos
                </button>
            </div>
            <div class="col-lg-6" style="max-height: 350px; overflow: auto;">
                <p>Alumnos por institución que han hecho la evaluación:</p>
                <ul>
                    <?php foreach ($this->temp['alumnosPorInstitucion'] as $institucion){?>
                        <li class="libotonMostrarInstitucion">
                            <button id="i<?php echo $institucion['id_institucion']; ?>"
                                    class="botonMostrarInstitucion btn btn-warning btn-sm">
                                Mostrar
                            </button>
                            <?php echo $institucion['nombre'].": ".$institucion['alumnos']; ?>
                        </li>
                    <?php }?>
                </ul>

            </div>
            <div class="col-12 my-3 table-responsive">


                <table id2="dataTableEstadisticas" class="table-bordered">
                    <thead>
                        <th>Nombre Alumno</th>
                        <th>Institución</th>
                        <th>Lecciones</th>
                        <th>Calificacion</th>
                        <th>Acertadas</th>
                        <th>Erroneas</th>
                        <th>Total de preguntas</th>
                        <th>Fecha registro</th>
                        <th>Trimestre</th>
                        <th>Intentos realizados</th>
                        <th>PDF</th>
                    </thead>
                    <tbody>
                        <?php foreach($this->temp['estadisticas'] as $alumno){ ?>
                            <tr class="i<?php echo $alumno['id_institucion']; ?>">
                                <td><?php echo $alumno['nombre']; ?></td>
                                <td>* <?php echo $alumno['institucion']; ?></td>
                                <td>* <?php echo $alumno['nombreLecciones']; ?></td>
                                <td><?php echo $alumno['LGF0420004']; ?></td>
                                <td><?php echo $alumno['LGF0420006']; ?></td>
                                <td><?php echo count(json_decode($alumno['LGF0420005'])) - $alumno['LGF0420006']; ?></td>
                                <td><?php echo count(json_decode($alumno['LGF0420005'])); ?></td>
                                <td><?php echo $alumno['fecha']; ?></td>
                                <td><?php echo $alumno['LGF0420008']; ?></td>
                                <td><?php echo $alumno['LGF0420009']; ?></td>
                                <td class="p-2">
                                    <a href="<?php echo CONTEXT; ?>evaluaciontrimestral/mostrarevaluacionresumenalumno/<?php echo $alumno['LGF0420001']; ?>">
                                        Visualizar resultado
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
        </div>

    </div>
</section>
<script>
    $(document).ready( function () {
        $('#dataTableEstadisticas').DataTable({
        });
        $(".botonMostrarInstitucion").click(function(){
            var nombreInstitucion = this.id;

            var trs = document.querySelectorAll("."+nombreInstitucion);
            var table = document.querySelectorAll("table tbody tr");
            table.forEach(function(item){
                item.classList.add('d-none');
            })
            trs.forEach(function(item){
                item.classList.remove('d-none');
                item.classList.add('d-initial');

            })
        });
        $(".botonMostrarTodos").click(function(){
            var table = document.querySelectorAll("table tbody tr");
            table.forEach(function(item){
                item.classList.remove('d-none');
            })
        });


    } );
</script>

