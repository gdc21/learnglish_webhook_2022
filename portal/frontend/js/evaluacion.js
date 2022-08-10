$(function() {
    $('a.arrow_rg').addClass('d-none');
    var jsonRespuesta = {};
    var moduloActual = $("#id_modulo").val();
    moduloActual = parseInt(moduloActual);
    if (moduloActual == 3 || moduloActual == 4 || moduloActual == 5) {
        // console.log('Modulo actual: '+moduloActual)
        // $("<style type='text/css'> .texto_preg img{width: 201px !important; height:150px !important;} </style>").appendTo("head");
        $("<style type='text/css'> .texto_preg img{width: 30% !important;} </style>").appendTo("head");
    }
    /*pruebas*/

    creaPregunta = function(consecutivo, pregunta) {
        // console.log("consecutivo: "+consecutivo+" pregunta: "+pregunta)
        var ocultar = (consecutivo == 1) ? '' : 'd-none';
        // console.log("pregunta : %O", pregunta );
        var p = construyeTipopregunta(pregunta);
        var respuesta = creaRespuesta(consecutivo, pregunta.respuestas),
            div = $('<div />', { class: 'superior_pregunta' }).append($('<div />', { class: 'circle evalbtn-blue', text: consecutivo }))
            .append($('<div />', { class: 'texto_preg' }).append(p)),
            boton = $('<div />').append($('<input />', { class: "btGuardar" }).attr({ 'type': 'button', value: "Siguiente", 'data-idp': consecutivo })),
            element = $('<div />', { class: 'pregunta ' + ocultar + ' preg_' + consecutivo, id: pregunta.id_pregunta }).append(div).append(respuesta).append(boton).attr('data-eval', pregunta.idprueba);
        $('#preguntas').append(element[0].outerHTML);
    }

    construyeTipopregunta = function(pregunta) {
        var p = $('<p />', { class: 'pregunta' });
        // console.log(pregunta)
        switch (pregunta.tipo_pregunta) {
            case 1:
                p.html(pregunta.pregunta);
                break;
            case 2:
                p.append($('<img />', { src: pregunta.pregunta_img }));
                break;
            case 3:
                if (pregunta.file == "") {
                    p = $('<div />').append($('<p />', { class: 'pregunta', text: pregunta.pregunta }));
                } else if (pregunta.file == "imagen") {
                    p = $('<div />').append($('<p />', { class: 'pregunta', text: pregunta.pregunta })).append($('<br>/')).append($('<img />', { src: pregunta.pregunta_img }));
                } else if (pregunta.file == "audio") {
                    p = $('<div />').append($('<p />', { class: 'pregunta', text: pregunta.pregunta })).append("<audio controls controlsList='nodownload' src='" + pregunta.pregunta_img + "'></audio>");
                } else {
                    p = $('<div />').append($('<p />', { class: 'pregunta', text: pregunta.pregunta })).append('<video  src="' + pregunta.pregunta_img + '" width="320" height="240" controls controlsList="nodownload"></video>');
                }
                break;
        }
        return p;
    }

    creaRespuesta = function(consecutivo, respuesta) {
        // console.log("respuesta : %O", respuesta );
        var div = $('<div />', { class: 'Question-resp' }),
            ul = $('<ol />').attr('type', 'A');
        var i = 0;
        $.each(respuesta.sort(function() { return Math.random() - 0.5 }), function() {
            i++;
            //console.log("this : %O", this );
            var contenido_respuesta = '';
            switch (this.tipo) {
                case 1:
                    contenido_respuesta = $('<span />', { text: obtenerletra(i) + this.texto });
                    break;
                case 2:
                    // contenido_respuesta= $('<img />',{class:'img_respuesta'}).attr('src', this.img);
                    contenido_respuesta = $('<div class="alinear"/>').append($('<span />', { text: obtenerletra(i) })).append($('<br>')).append($('<img />', { class: 'img_respuesta' }).attr('src', this.img));
                    break;
                case 3:
                    contenido_respuesta = $('<div class="alinear"/>').append($('<span />', { text: obtenerletra(i) + this.texto })).append($('<br>'))
                        .append($('<img />', { class: 'img_respuesta' }).attr('src', this.img));
                    break;
                case 4:
                    contenido_respuesta = $('<div class="alinear"/>').append($('<span />', { text: obtenerletra(i) + this.texto })).append($('<br>'))
                        .append($('<audio controls />', { class: 'img_respuesta' }).attr('src', this.img));
                    break;
                case 5:
                    // contenido_respuesta= $('<audio controls/>',{class:'img_respuesta'}).attr('src', this.img);
                    contenido_respuesta = $('<div class="alinear"/>').append($('<span />', { text: obtenerletra(i) })).append($('<br>')).append($('<audio controls/>', { class: 'img_respuesta' }).attr('src', this.img));
                    break;
            }

            /*if(this.tipo == 2){
            	contenido_respuesta= $('<img />',{class:'img_respuesta'}).attr('src', this.R);
            }*/
            ul.append($('<li />').append(
                $('<input >', {
                    class: "respuesta",
                    id: "resp_" + consecutivo,
                    name: "resp_" + consecutivo
                }).attr({
                    'type': 'radio',
                    value: this.ID
                })).append(contenido_respuesta));
        });
        //console.log("ul[0].outerHTML : %O", ul[0].outerHTML );
        return div.append(ul);
    }

    function obtenerletra(num) {
        var letra = '';
        if (num == 1) {
            letra = 'A) ';
        } else if (num == 2) {
            letra = 'B) ';
        } else if (num == 3) {
            letra = 'C) ';
        } else if (num == 4) {
            letra = 'D) ';
        }
        return letra;
    }

    mostrarPorcentaje = function(porcentaje) {
        var texto = 'No has completado la lección, intentalo de nuevo.',
            color = '#f87458',
            img_src = IMG + 'resultado/Evaluacion_Mal.png',
            img_leyenda = IMG + 'resultado/Evaluacion_Tex_Mal.png',
            boton = 'Repetir lección',
            valorBoton = 'prev';
        //img_respuesta
        if (porcentaje >= 60 && porcentaje < 80) {
            texto = 'Has completado la lección con ' + porcentaje + '% Intenta mejorar tu puntuación.';
            color = '#8899f0';
            img_src = IMG + 'resultado/Evaluacion_Regular.png';
            img_leyenda = IMG + 'resultado/Evaluacion_Tex_Regular.png';
            //$('a.arrow_rg').removeClass('d-none');
            //valorBoton = 'next';
            //$('#comportamiento').addClass('d-none');
        } else if (porcentaje >= 80) {

            porcentaje == 100 ? texto = 'Felicidades has completado la lección con un puntaje perfecto: ' + porcentaje + '%' : texto = 'Felicidades has completado la lección con: ' + porcentaje + '%';
            color = '#8899f0';
            img_src = IMG + 'resultado/Evaluacion_Excelente.png';
            img_leyenda = IMG + 'resultado/Evaluacion_Tex_Excelente.png';
            $('a.arrow_rg').removeClass('d-none');
            valorBoton = 'next';
            $('#comportamiento').addClass('d-none');
        }

        $('.img_respuesta').attr('src', img_src);
        $('.derecha1').attr('src', img_src);
        $('.derecha').attr('src', img_leyenda);
        //$('.derecha.text').css('color',color).text(leyenda);
        $('#comportamiento span').css('color', color).text(boton);
        $('#comportamiento').css('border-color', color).attr('data-value', valorBoton);

        /*$('#comportamiento1').css('border-color',color);
        $('#comportamiento1 span').css('color', color);*/

        Highcharts.setOptions({ colors: [color], credits: false });
        Highcharts.chart('chart', {
                chart: {
                    type: 'solidgauge',
                    marginTop: 65
                },
                title: {
                    text: texto,
                    style: {
                        fontSize: '18px'
                    }
                },
                tooltip: {
                    borderWidth: 0,
                    backgroundColor: 'none',
                    shadow: false,
                    style: {
                        fontSize: '16px'
                    },
                    pointFormat: '{series.name}<br><span style="font-size:2em; color: {point.color}; font-weight: bold">{point.y}%</span>',
                    positioner: function(labelWidth) {
                        return {
                            x: 200 - labelWidth / 2,
                            y: 180
                        };
                    }
                },
                pane: {
                    startAngle: 0,
                    endAngle: 360,
                    background: [{ // Track for Move
                        outerRadius: '100%',
                        innerRadius: '88%',
                        backgroundColor: Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0.3).get(),
                        borderWidth: 0
                    }]
                },
                yAxis: {
                    min: 0,
                    max: 100,
                    lineWidth: 0,
                    tickPositions: []
                },
                plotOptions: {
                    solidgauge: {
                        borderWidth: '28px',
                        dataLabels: {
                            enabled: false
                        },
                        linecap: 'round',
                        stickyTracking: false
                    }
                },
                series: [{
                    name: 'Resultado',
                    borderColor: Highcharts.getOptions().colors[0],
                    data: [{
                        color: Highcharts.getOptions().colors[0],
                        radius: '100%',
                        innerRadius: '100%',
                        y: porcentaje
                    }]
                }]
            },
            /**
             * In the chart load callback, add icons on top of the circular shapes
             */
            function callback() {
                var chart = $('#chart').highcharts(),
                    point = chart.series[0].points[0];
                point.onMouseOver(); // Show the hover marker
                chart.tooltip.refresh(point); // Show the tooltip
                chart.tooltip.hide = function() {};
            });
    }

    armaPreguntas = function(info) {
        /*Objeto de*/
        var contenedor = $('<div />', { class: 'concluido d-none' }),
            renglon2 = $('<div />', { class: 'renglon  renglon3' })
            //.append($('<img />', { class: 'img_respuesta' }))
            .append($('<div />', { class: 'izquierda text' })
                .append('<button id="comportamiento"><span></span></button>')),
            renglon = $('<div />', { class: 'renglon' })
            .append($('<img />', { class: 'derecha' }))
            .append($('<img />', { class: 'derecha1' })),
            hry = $('<div />', { class: 'hry' }),
            renglon3 = $('<div />', { class: 'renglon renglon2' })
            .append($('<div />', { class: 'izquierda2', id: "chart" })
                .attr('style', 'width: 400px; max-width:100%; height: 400px; margin: auto'))

        sec_preguntas = $('<section />', { id: 'preguntas' });
        contenedor.append(renglon[0].outerHTML + hry[0].outerHTML + renglon3[0].outerHTML + '<br>' + renglon2[0].outerHTML);
        //console.log("contenedor[0].outerHTML : %O", contenedor[0].outerHTML );
        $('#lesson-content').append(sec_preguntas[0].outerHTML).append(contenedor[0].outerHTML).append('<br/><br/>');
        //console.log(info);
        var data = getInfoAjax('getEvaluacion', info, 'home');
        //console.log("data 52: %O", data );
        /*console.log("info 52: %O", info );*/
        //console.log(data);

        if (data) {
            //console.log(data[0]);
            if (data[0].mensaje) {
                var porcentaje = parseInt(data[0].porcentaje)
                    //console.log(porcentaje);
                var msj = '<br>Resultado ' + porcentaje + '%';
                $('.concluido').removeClass('d-none');
                if (porcentaje < 80) {
                    $('.izquierda').append('<button class="comportamiento1" style="margin-top: 0px;"><span>Repetir evaluación</span></button>');
                }
                mostrarPorcentaje(Math.round(porcentaje));
            } else {
                $.each(data, function() {
                    if (this.pregunta != '') {
                        creaPregunta(set_AumentaPregunta(), this);
                    }
                });
            }
        } else {
            $('#objeto_de_aprendizaje').append('<div style="height: 350px"><br><h3 class="text-center">Esta evaluación no contiene ninguna pregunta.<h3></div>');
        }
    }

    armaRespuestaUsuario = function() {
        var preguntas = {},
            pos = 0;
        $('div[data-resp]').each(function() {
            preguntas[pos] = [{ 'id_pregunta': $(this).attr('id'), 'id_respuesta': $(this).attr('data-resp'), 'id_evaluacion': $(this).attr('data-eval') }];
            pos++;
        });
        return JSON.stringify(preguntas);
    }

    $("#contenido").on('click', '.next', function(event) {
        event.preventDefault();
        /* Act on the event */
        var pos = parseInt($(this).attr('data-idp')),
            next = pos + 1;
        $('.preg_' + pos).addClass('d-none');
        $('.preg_' + next).removeClass('d-none');
        //console.log("var : %O", next );
        total = total_Pregunta();
        if (next == total)
            finaliza();
    });

    $("#contenido").on('click', '.respuesta', function(event) {
        var padre = $(this).parents('.pregunta');
        padre.find('.btGuardar').addClass('btGuardarR next');
        padre.attr('data-resp', $(this).val());
    });

    reset_Pregugunta();
    var datos = { modulo: $("#id_modulo").val(), leccion: $("#id_leccion").val(), repetir: $("#repetir").val() };

    if (datos)
        armaPreguntas(datos);

    finaliza = function() {
        /*var pathname = window.location.pathname;
        var aux = pathname.split("/");
        if (aux[5]) {
        	var url = pathname.slice(0, -2);
        	location.href = url;
        }*/
        var data = getInfoAjax('setEvaluacion', { 'preguntas': armaRespuestaUsuario() }, 'home'),
            msj = data.mensaje;
        porcentaje = parseInt(data.porcentaje),
            t_preguntas = total_Pregunta() - 1,
            //se modifico para que muestre el porcentaje directamente
            //retro = ( aciertos * 100 ) / t_preguntas;
            retro = porcentaje;
        //console.log("preg : %O", t_preguntas );
        //console.log("retro : %O", retro );
        msj += '<br>Resultado ' + retro + '%';
        $('.concluido').removeClass('d-none');
        // console.log("Porcentaje obtenido: "+porcentaje)
        /*if (porcentaje < 60) {
        	$('.izquierda').append('<button class="comportamiento1" style="margin-top: 0px;"><span>Repetir lección</span></button>');
        }*/
        mostrarPorcentaje(Math.round(retro));
    }

    $('#contenido').on('click', '#comportamiento', function(event) {
        event.preventDefault();
        /* Act on the event */
        var opc = $(this).attr('data-value');
        // console.log("opc : %O", opc );
        if (opc == 'prev')
        // location.href= context + 'home/lessons/'+$("#id_modulo").val();
            location.href = context + 'home/navegar/' + $("#leccion_anterior").val();
        else {
            location.href = $('.arrow_rg').attr('href');
        }
    });

    $(document).on('click', '.comportamiento1', function(e) {
        // $(".comportamiento1").click(function (e) {
        e.preventDefault();
        var pathname = window.location.pathname;
        var aux = pathname.split("/");
        // console.log(aux)
        if (aux[6]) {
            location.reload();
        } else {
            location.href = location.href + "/1";
        }
    });
});