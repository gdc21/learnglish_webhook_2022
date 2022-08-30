
<section id="contenido" class="my-2" style="padding-bottom: 0 !important;">
    <?php echo $this->temp['encabezado']; ?>
        <div class="col-12 text-center py-2" style="cursor:pointer;" id="imprimirHoja" >
            <i class="fa fa-print" aria-hidden="true"></i>
            Imprimir
        </div>
        <div class="col-12 text-center py-2" style="cursor:pointer;" id="imprimirHojaExcel" >
            <i class="fa fa-table" aria-hidden="true"></i>
            Copiar para pegar en excel
        </div>

</section>

<div class="container">
    <div class="row">
        <div class="col-12">
            <table class="table-bordered table border-secondary" id="tablaExcel">
                <tr>
                    <td colspan="1">Licencias contratadas:</td>
                    <td colspan="3"><?php echo $this->temp['data']['general']['LGF0460003']; ?></td>
                    <td colspan="2"></td>
                    <td colspan="2">Licencias cargadas:</td>
                    <td colspan="2"><?php echo $this->temp['data']['lic_cargadas']; ?></td>
                </tr>
                <tr>
                    <td colspan="1">Inicio del servicio:</td>
                    <td colspan="3"><?php echo date("d-m-Y", strtotime($this->temp['data']['general']['LGF0460004'])); ?></td>
                    <td colspan="2"></td>
                    <td colspan="2">Vencimiento:</td>
                    <td colspan="2"><?php echo date("d-m-Y", strtotime($this->temp['data']['general']['LGF0460005'])); ?></td>
                </tr>
                <!--#############################################-->

                <tr>
                    <td colspan="1" rowspan="2">Alumnos</td>
                    <td colspan="3">Registrados</td>
                    <td colspan="3">Activos</td>
                    <td colspan="3">Inactivos</td>
                </tr>
                <tr>
                    <!--<td> Proviene del rowspan anterior</td>-->
                    <td colspan="1">H</td>
                    <td colspan="1">M</td>
                    <td colspan="1">T</td>
                    <td colspan="1">H</td>
                    <td colspan="1">M</td>
                    <td colspan="1">T</td>
                    <td colspan="1">H</td>
                    <td colspan="1">M</td>
                    <td colspan="1">T</td>
                </tr>


                <?php
                foreach ($this->temp['data']['alumnos_activos'] as $alumno) { ?>
                    <tr>
                        <td colspan="1"><?php echo $alumno['nombre_nivel']; ?></td>
                        <td colspan="1"><?php echo $alumno['H_registrados']; ?></td>
                        <td colspan="1"><?php echo $alumno['M_registrados']; ?></td>
                        <td colspan="1"><?php echo $alumno['T_registrados']; ?></td>
                        <td colspan="1"><?php echo $alumno['H_activos']; ?></td>
                        <td colspan="1"><?php echo $alumno['M_activos']; ?></td>
                        <td colspan="1"><?php echo $alumno['T_activos']; ?></td>
                        <td colspan="1"><?php echo $alumno['H_registrados'] - $alumno['H_activos']; ?></td>
                        <td colspan="1"><?php echo $alumno['M_registrados'] - $alumno['M_activos']; ?></td>
                        <td colspan="1"><?php echo $alumno['T_registrados'] - $alumno['T_activos']; ?></td>
                    </tr>
                    <?php
                } ?>


                <!--#############################################-->

                <tr>
                    <td colspan="1" rowspan="2">Docentes y/o AEE</td>
                    <td colspan="3">Registrados</td>
                    <td colspan="3">Activos</td>
                    <td colspan="3">Inactivos</td>
                </tr>
                <tr>
                    <!--<td> Proviene del rowspan anterior</td>-->
                    <td colspan="1">H</td>
                    <td colspan="1">M</td>
                    <td colspan="1">T</td>
                    <td colspan="1">H</td>
                    <td colspan="1">M</td>
                    <td colspan="1">T</td>
                    <td colspan="1">H</td>
                    <td colspan="1">M</td>
                    <td colspan="1">T</td>
                </tr>

                <?php
                foreach ($this->temp['data']['docentes_activos'] as $doncente) { ?>
                    <tr>
                        <td colspan="1"><?php echo $doncente['nombre_nivel']; ?></td>
                        <td colspan="1"><?php echo $doncente['H_registrados']; ?></td>
                        <td colspan="1"><?php echo $doncente['M_registrados']; ?></td>
                        <td colspan="1"><?php echo $doncente['T_registrados']; ?></td>
                        <td colspan="1"><?php echo $doncente['H_activos']; ?></td>
                        <td colspan="1"><?php echo $doncente['M_activos']; ?></td>
                        <td colspan="1"><?php echo $doncente['T_activos']; ?></td>
                        <td colspan="1"><?php echo $doncente['H_registrados'] - $doncente['H_activos']; ?></td>
                        <td colspan="1"><?php echo $doncente['M_registrados'] - $doncente['M_activos']; ?></td>
                        <td colspan="1"><?php echo $doncente['T_registrados'] - $doncente['T_activos']; ?></td>

                    </tr>
                    <?php
                } ?>


                <!--#############################################-->

                <tr>
                    <td colspan="1" rowspan="2">Escuelas beneficiadas</td>
                    <td colspan="1" rowspan="2">Registradas</td>
                    <td colspan="3">Alumnos</td>
                    <td colspan="3">Docentes</td>
                    <td colspan="2" rowspan="5"></td>
                </tr>
                <tr>
                    <!--<td> Proviene del rowspan anterior</td>-->
                    <!--<td> Proviene del rowspan anterior</td>-->
                    <td colspan="1">H</td>
                    <td colspan="1">M</td>
                    <td colspan="1">T</td>
                    <td colspan="1">H</td>
                    <td colspan="1">M</td>
                    <td colspan="1">T</td>
                </tr>


                <?php
                foreach ($this->temp['data']['alumnos_activos'] as $key => $alumno) { ?>
                    <tr>
                        <td colspan="1">
                            <?php if ($key == 0) echo "Preescolar"; elseif ($key == 1) echo "Primaria"; else echo "Secundaria"; ?>
                        </td>
                        <td colspan="1">
                            <?php if ($key == 0) echo $this->temp['data']['er'][0]['pre']; elseif ($key == 1) echo $this->temp['data']['er'][0]['pri']; else echo $this->temp['data']['er'][0]['sec']; ?>
                        </td>

                        <td colspan="1"><?php echo $alumno['H_registrados']; ?></td>
                        <td colspan="1"><?php echo $alumno['M_registrados']; ?></td>
                        <td colspan="1"><?php echo $alumno['T_registrados']; ?></td>

                        <td colspan="1"><?php echo $this->temp['data']['docentes_activos'][$key]['H_registrados']; ?></td>
                        <td colspan="1"><?php echo $this->temp['data']['docentes_activos'][$key]['M_registrados']; ?></td>
                        <td colspan="1"><?php echo $this->temp['data']['docentes_activos'][$key]['T_registrados']; ?></td>
                    </tr>
                    <?php
                } ?>
                <!--<td> Proviene del rowspan anterior en registradas</td>-->


            </table>
            <br><br>
            <table class="table-bordered table border-secondary">
                <th colspan="2" class="text-muted">Gráficos disponibles</th>
                <tbody>
                    <!--######################-->
                    <tr class="trGraficos">
                        <td>
                            Tiempo total de conexión acumulado:
                            <div id="tiempoTotalAlumnos" class="my-3 w-100 py-4 bg-light text-center">
                                Alumnos: <?php echo $this->temp['data']['time_con_alm']['tiempo']; ?> minutos.
                            </div>
                            <div id="tiempoTotalDocentes" class="my-3 w-100 py-4 bg-light text-center">
                                Docentes: <?php echo $this->temp['data']['time_con_doc']['tiempo']; ?> minutos.
                            </div>
                        </td>
                        <td>
                            <figure class="highcharts-figure" id="tiempoPorPeriodoGrafico2"></figure>
                        </td>
                    </tr>

                    <!--######################-->
                    <tr class="trGraficos">
                        <td>
                            Tiempo total de conexión por periodo:
                            <br>
                            <label>Seleccione intervalos</label><br>
                            <input type="date"
                                   id="tiempoPorPeriodoEspecificoInicio"
                                   style="border: 2px solid rgba(0,0,0,0.1);"
                                   class="w-25 fechaInicio form-control d-inline-block w-50"
                                   min="<?php echo date("Y-m-d", strtotime($this->temp['data']['general']['LGF0460004'])); ?>"
                                   max="<?php echo date("Y-m-d", strtotime($this->temp['data']['general']['LGF0460005'])); ?>">
                            <input type="date"
                                   id="tiempoPorPeriodoEspecifico"
                                   style="border: 2px solid rgba(0,0,0,0.1);"
                                   class="w-25 fechaFin form-control d-inline-block w-50"
                                   min="<?php echo date("Y-m-d", strtotime($this->temp['data']['general']['LGF0460004'])); ?>"
                                   max="<?php echo date("Y-m-d", strtotime($this->temp['data']['general']['LGF0460005'])); ?>">
                            <div id="tiempoPorPeriodoEspecificoResultadoTexto" class="my-3 w-100 py-4 bg-light text-center"></div>
                        </td>
                        <td style="width: 70% !important;">
                            <figure class="highcharts-figure" id="tiempoPorPeriodoEspecificoGrafico"></figure>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!--################################################################################################-->
            <!--################################################################################################-->
            <!--################################################################################################-->
            <table class="table-bordered table border-secondary">
                <th colspan="2" class="text-muted">Gráficos disponibles</th>
                <tbody>
                    <!--######################-->
                    <tr class="trGraficos">
                        <td>
                            Licencias Activas vs Licencias Inactivas:
                            <br>
                            <label>Seleccione intervalos</label><br>
                            <input type="date"
                                   id="tiempoPorLicActInactivaInicio"
                                   style="border: 2px solid rgba(0,0,0,0.1);"
                                   class="w-25 fechaInicio form-control d-inline-block w-50"
                                   min="<?php echo date("Y-m-d", strtotime($this->temp['data']['general']['LGF0460004'])); ?>"
                                   max="<?php echo date("Y-m-d", strtotime($this->temp['data']['general']['LGF0460005'])); ?>">
                            <input type="date"
                                   id="tiempoPorLicActInactiva"
                                   style="border: 2px solid rgba(0,0,0,0.1);"
                                   class="w-25 fechaFin form-control d-inline-block w-50"
                                   min="<?php echo date("Y-m-d", strtotime($this->temp['data']['general']['LGF0460004'])); ?>"
                                   max="<?php echo date("Y-m-d", strtotime($this->temp['data']['general']['LGF0460005'])); ?>">
                            <div id="tiempoPorLicActInactivaResultadoTexto" class="my-3 w-100 py-4 bg-light text-center"></div>
                        </td>
                        <td style="width: 70% !important;">
                            <figure class="highcharts-figure" id="tiempoPorLicActInactivaGrafico"></figure>
                        </td>
                    </tr>
                    <!--######################-->
                    <tr class="trGraficos">
                        <td colspan="2">
                            <figure class="highcharts-figure" id="tiempoPorNivelGrafico"></figure>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!--################################################################################################-->
            <!--################################################################################################-->
            <!--################################################################################################-->
            <br><br><br>
            <table class="table-bordered table border-secondary">
                <th colspan="2" class="text-muted">Gráficos disponibles</th>
                <tbody>
                    <!--######################-->
                    <tr class="trGraficos">
                        <td colspan="2">
                            <figure class="highcharts-figure" id="tiempoPorCCTGrafico"></figure>
                        </td>
                    </tr>
                    <!--######################-->

                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script>
    $(function() {
        /*Validamos los rangos de fechas validos*/
        var fechaInicioBase = '<?php echo date("Y-m-d", strtotime($this->temp['data']['general']['LGF0460004'])); ?>';
        var fechaFinBase = '<?php echo date("Y-m-d", strtotime($this->temp['data']['general']['LGF0460005'])); ?>';

        /*Data de los graficos a manipular*/
        var tiempoPorPeriodoEspecificoGrafico;
        var tiempoPorLicActInactivaGrafico;


        function calcularTiempos(fec_inicio, fec_fin, tipo, id_elemento){

            if(fec_inicio != '' && fec_fin != ''){
                var data = getInfoAjax('datosIntervalosFechasTiempos', {
                    fec_inicio: fec_inicio,
                    fec_fin: fec_fin,
                    tipo: tipo
                }, 'admin');

                if (data) {
                    var label1 = "Alumnos";
                    var label2 = "Docentes";
                    var res = label1 + ": "+data['dato1']+" minutos <br>"+label2 + ": "+data['dato2']+" minutos";
                    var grafico = tiempoPorPeriodoEspecificoGrafico;

                    if(tipo == 'licencias'){
                        label1 = 'Licencias activas';
                        label2 = 'Licencias inactivas';
                        res = label1 + ": "+data['dato1']+"<br>"+label2 + ": "+data['dato2'];
                        grafico = tiempoPorLicActInactivaGrafico;
                    }

                    grafico.series[0].data[0].update([label1, parseInt(data['dato1'])]);
                    grafico.series[0].data[1].update([label2, parseInt(data['dato2'])]);

                    $("#"+id_elemento+"Grafico .highcharts-subtitle").text("Fechas: "+fec_inicio+" - "+fec_fin);

                    $("#"+id_elemento+"ResultadoTexto").html(res);

                }else{
                    console.log("Algo salio mal al procesar la información.");
                }
            }
        }

        $(".fechaFin").change(function () {
            var elementoComprobar = this.id + "Inicio";
            var valorFecha1 = $("#" + elementoComprobar).val();
            var valorFecha2 = this.value;

            if (valorFecha1 == '' || valorFecha2 < valorFecha1 || valorFecha1 < fechaInicioBase || valorFecha2 > fechaFinBase) {
                this.value = '';
                alert("Debes seleccionar una fecha inicial y un rango válido entre: " + fechaInicioBase + " y " + fechaFinBase);
            }else{
                /**
                 * Si no es "tiempoPorPeriodoInicio" 2o grafico -tiempo total
                 * entonces sera "tiempoPorLicActInactivaInicio" 3er grafico lic activas-inactivas
                * */
                if(elementoComprobar.indexOf('tiempoPorPeriodoEspecifico') != -1){
                    var datos = calcularTiempos(valorFecha1, valorFecha2, 'total', this.id);
                }else if(elementoComprobar.indexOf('tiempoPorLicActInactiva') != -1){
                    var datos = calcularTiempos(valorFecha1, valorFecha2, 'licencias', this.id);
                }else{
                    alert("Información no valida");
                }
            }
        });
        $(".fechaInicio").change(function () {
            var indexPalabraRecortar = this.id.indexOf('Inicio');

            /*Fecha fin*/
            var elementoComprobar = this.id.substr(0, indexPalabraRecortar);
            var valorFecha2 = $("#" + elementoComprobar).val();

            /*Fecha inicio si hay*/
            var valorFecha1 = this.value;

            if ((valorFecha1 > valorFecha2 && valorFecha2 != '')) {
                this.value = '';
                alert("Debes seleccionar una fecha inicial y un rango válido entre: " + fechaInicioBase + " y " + fechaFinBase);
            }else{
                /**
                 * Si no es "tiempoPorPeriodoInicio" 2o grafico -tiempo total
                 * entonces sera "tiempoPorLicActInactivaInicio" 3er grafico lic activas-inactivas
                 * */
                if(this.id.indexOf('tiempoPorPeriodoEspecifico') != -1){
                    var datos = calcularTiempos(valorFecha1, valorFecha2, 'total', elementoComprobar);
                }else if(this.id.indexOf('tiempoPorLicActInactivaInicio') != -1){
                    var datos = calcularTiempos(valorFecha1, valorFecha2, 'licencias', elementoComprobar);
                }else{
                    alert("Información no valida");
                }
            }
        });

        /*Seccion de impresion, oculta y muestra elementos al momento de tratar de imprimir una hoja*/
        $("#imprimirHoja").click(function () {
            window.print();
        });
        window.addEventListener('afterprint', (event) => {
            $("#mobile-chat-container").show();
            $("#imprimirHojaExcel").show();
            $("#perfil_usuario").show();
            $("#imprimirHoja").show();
            $("header").show();
            $("footer").show();
        });
        window.addEventListener('beforeprint', (event) => {
            $("#mobile-chat-container").hide();
            $("#imprimirHojaExcel").hide();
            $("#perfil_usuario").hide();
            $("#imprimirHoja").hide();
            $("header").hide();
            $("footer").hide();
        });

        /*Seccion para seleccionar la tabla de excel y copiarla al portapapeles*/
        function selectElementContents(el) {
            var body = document.body, range, sel;
            if (document.createRange && window.getSelection) {
                range = document.createRange();
                sel = window.getSelection();
                sel.removeAllRanges();
                try {
                    range.selectNodeContents(el);
                    sel.addRange(range);
                } catch (e) {
                    range.selectNode(el);
                    sel.addRange(range);
                }
            } else if (body.createTextRange) {
                range = body.createTextRange();
                range.moveToElementText(el);
                range.select();
            }
            document.execCommand('copy');
            alert("Tabla copiada al portapapeles.")
        }

        $("#imprimirHojaExcel").click(function () {
            selectElementContents(document.getElementById('tablaExcel'));
        });


        /*####################################################*/
        /*####################################################*/
        Highcharts.chart('tiempoPorPeriodoGrafico2', {
            chart: {
                width: parseInt(window.screen.width/3), // 16:9 ratio

            },
            title: {
                text: 'Tiempo total de conexión acumulado',
                align: 'center',
            },
            subtitle: {
                text: 'Fechas: '+fechaInicioBase+' - '+fechaFinBase,

            },
            plotOptions: {
                pie: {
                    dataLabels: {
                        enabled: true,
                        distance: -50,
                        style: {
                            fontWeight: 'bold',
                            color: 'white'
                        }
                    },
                    startAngle: -90,
                    endAngle: 90,
                    center: ['50%', '75%'],
                    size: '100%'
                }
            },
            series: [{
                type: 'pie',
                name: 'Minutos',
                innerSize: '60%',

                data: [
                    ['Alumnos', <?php echo $this->temp['data']['time_con_alm']['tiempo'] ?>],
                    ['Docentes', <?php echo $this->temp['data']['time_con_doc']['tiempo'] ?>],
                ]
            }]
        });

        /*####################################################*/
        /*####################################################*/
        /*Grafico donde se seleccionan rangos de fechas*/
        tiempoPorPeriodoEspecificoGrafico = Highcharts.chart('tiempoPorPeriodoEspecificoGrafico', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: 0,
                plotShadow: false
            },
            title: {
                text: 'Tiempo total de conexión entre periodos de tiempo.',
                align: 'center',
            },
            plotOptions: {
                pie: {
                    dataLabels: {
                        enabled: true,
                        distance: -50,
                        style: {
                            fontWeight: 'bold',
                            color: 'white'
                        }
                    },
                    startAngle: -90,
                    endAngle: 90,
                    center: ['50%', '75%'],
                    size: '110%'
                }
            },
            series: [{
                type: 'pie',
                name: 'Minutos',
                innerSize: '60%',

                data: [
                    ['Alumnos', 0],
                    ['Docentes', 0]
                ]
            }]
        });

        /*####################################################*/
        /*####################################################*/
        /*Grafico donde se seleccionan rangos de fechas licencias activas vs inactivas*/
        tiempoPorLicActInactivaGrafico = Highcharts.chart('tiempoPorLicActInactivaGrafico', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: 0,
                plotShadow: false
            },
            title: {
                text: 'Cantidad de licencias activas vs inactivas.',
                align: 'center',
            },
            plotOptions: {
                pie: {
                    dataLabels: {
                        enabled: true,
                        distance: -50,
                        style: {
                            fontWeight: 'bold',
                            color: 'white'
                        }
                    },
                    startAngle: -90,
                    endAngle: 90,
                    center: ['50%', '75%'],
                    size: '110%'
                }
            },
            series: [{
                type: 'pie',
                name: 'Alumnos-docentes',
                innerSize: '60%',

                data: [
                    ['Activas', 0],
                    ['Inactivas', 0]
                ]
            }]
        });
        /*####################################################*/
        /*####################################################*/
        /*Grafico donde se seleccionan rangos de fechas por nivel*/
        Highcharts.chart('tiempoPorNivelGrafico', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Tiempo total de alumnos por nivel'
            },
            subtitle: {
                text: 'Fechas: '+fechaInicioBase+' - '+fechaFinBase,
            },
            xAxis: {
                type: 'category',
                labels: {
                    rotation: -65,
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Minutos'
                }
            },
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: 'Tiempo: <b>{point.y} minutos</b>'
            },
            series: [{
                name: 'Population',
                data: [
                    <?php foreach($this->temp['data']['time_con_por_niveles'] as $nivel) { ?>

                    ['<?php echo $nivel['nivel']; ?>', <?php echo $nivel['tiempo'] > 0 ? $nivel['tiempo']:0; ?>],
                    <?php } ?>

                ],
                dataLabels: {
                    enabled: true,
                    rotation: -90,
                    color: '#FFFFFF',
                    align: 'right',
                    format: '{point.y:.1f}', // one decimal
                    y: 10, // 10 pixels down from the top
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            }]
        });
        /*####################################################*/
        /*####################################################*/
        /*Grafico donde se seleccionan rangos de fechas licencias activas vs inactivas*/
        <?php if(count($this->temp['data']['time_con_por_inst']) > 0){ ?>
        Highcharts.chart('tiempoPorCCTGrafico', {
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Tiempo total por CCT empleando el sistema - activos/inactivos.'
            },
            subtitle: {
                text: 'Presiona la columna del CCT para mostrar detalles de usuarios activos/inactivos.<br>Fechas: '+fechaInicioBase+' - '+fechaFinBase,
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: ''
                }
            },
            legend: {
                enabled: false
            },
            series: [{
                drillUpText: 'asdasd',
                    name: "Minutos empleando el sistema.",
                    colorByPoint: true,
                    data: [
                        <?php foreach ($this->temp['data']['time_con_por_inst'] as $dato) {
                        echo "{
                                name: '" . $dato['cct']." - ".$dato['nombre'] . "',
                                y: " . $dato['tiempo'] . ",
                                drilldown: 'cct_" . $dato['id'] . "'   
                            },";
                    } ?>
                    ]
            }],
            drilldown: {
                breadcrumbs: {
                    position: {
                        align: 'right'
                    }
                },
                series: [
                    <?php foreach ($this->temp['data']['time_con_por_inst'] as $dato) {
                        $activos_cct = 0;
                    echo "  {
                                    name: '" . $dato['cct']." - ".$dato['nombre'] . "',
                                    id: 'cct_" . $dato['id'] . "',
                                    data: [ ";

                            foreach ($this->temp['data']['time_con_por_inst_activos'] as $activo){
                                if($activo['id'] == $dato['id']){
                                    $activos_cct = $activo['personas_act_inac'];

                                    echo "['Activos', ".$activo['personas_act_inac']."],";
                                    break;
                                }
                            }
                            foreach ($this->temp['data']['time_con_por_inst_inactivos'] as $inactivo){
                                if($inactivo['id'] == $dato['id']){
                                    $inactivos = intval($inactivo['total_registrados'] - $activos_cct);
                                    echo "['Inactivos', ".$inactivos."],";
                                    break;
                                }
                            }
                            echo "['Total alumnos-docentes', ".intval($inactivos + $activos_cct)."]";
                            echo "]  
                            },";
                } ?>

                ]
            }
        });
        <?php }else{ ?>
            $("#tiempoPorCCTGrafico").parent().html("<h4>Por el momento no hay datos estadísticos de las instituciones por mostrar</h4>");
        <?php } ?>


        /*Para centrar en las tablas los graficos*/
        setTimeout(function(){
            var estilos = document.createElement('style');
            estilos.innerText = ".highcharts-container{width: 100% !important;}";
            estilos.innerText += ".highcharts-root{width: 100% !important;}";
            estilos.innerText += "@media print {* { -webkit-print-color-adjust: exact; } }";


            $("head").append(estilos);
        }, 1000);

    });
</script>
