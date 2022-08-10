<style>
    #search-box{
        padding: 10px;
        border-radius:4px;
    }
    #suggesstion-box{
        background: white;
        z-index: 9999;
        max-height: 300px;
        overflow: auto;
        position: absolute;
        padding: 7px 3px;
        border-radius: 3px;
        border: 3px solid rgba(0,0,0,0.4);
    }
    #suggesstion-box li{
        list-style: none;
        padding: 5px 2px;
    }
    #suggesstion-box li:hover{
        background: rgba(153, 217, 234, 0.4);
        cursor: pointer;
    }
    .formularioBusqueda{
        position: relative;
    }
    .botonCancelar{
        position: absolute;
        right: 10px;
        font-size: 30px;
        top: 8px;
        cursor: pointer;
        color: rgba(0,0,0,0.4);
    }
    #contenido{
        padding-bottom: 20em;
    }
    .nombreAlumno{
        font-size: 13px;
    }

</style>

<section id="contenido">
    <?php echo $this->temp['encabezado']; ?>

    <div class="separador"></div>
    <!-- Admin -->

    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php if(isset($this->temp['mensajeUsuario']) || isset($_SESSION['mensajeUsuario'])){ ?>
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <svg style="width: 30px !important;height: 30px !important;margin-right: 10px;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
                            <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z"/>
                            <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z"/>
                        </svg>
                        <div>
                            <?php echo $this->temp['mensajeUsuario']; ?>
                            <?php echo $_SESSION['mensajeUsuario']; unset($_SESSION['mensajeUsuario']); ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-md-8">
                <h2>Busca tu nombre para continuar</h2>
                <i>Recuerda verificar tu nombre, curp y posteriormente institución educativa</i>
            </div>
            <div class="col-md-4 d-flex align-items-center ">
                <a class="mx-md-auto my-2 my-md-0 btn btn-primary" href="https://www.youtube.com/watch?v=ff8Wsxye6_w&feature=youtu.be" target="_blank">
                    Tutorial
                </a>
            </div>
            <div class="col-12">
                <div class="formularioBusqueda">
                    <input type="text" id="search-box" class="form-control my-3" placeholder="Nombre de alumno" autocomplete="off"/>
                    <div id="suggesstion-box"></div>
                    <i class="fa fa-times-circle-o botonCancelar bg-white" aria-hidden="true"></i>
                    <b id="institucion" style="padding-left: 20px !important; position: absolute;"></b>
                </div>
                <form action="<?php echo CONTEXT; ?>evaluaciontrimestral/evaluacionseleccionarleccionesalumno" method="POST" id="formularioLecciones">

                    <br><br><br>
                    <div id="panelLecciones" class="d-none">

                        <h1 class="w-100 text-center" style="border:1px dashed; padding: 10px; margin-top: 25px;">Lecciones</h1>
                        <p>Selecciona mínimo 1 y máximo 3 lecciones con las que tu docente te evaluará.</p>
                        <ul id="nombreDeLecciones">

                        </ul>
                        <button type="button" id="enviarLecciones" class="btn btn-warning w-100 text-center" >Siguiente</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</section>

<script>
    $(function(){




        /*Boton de cancelar que limpia y coloca la busqueda previa que se estaba haciendo*/
        $(".botonCancelar").click(function (){
            $('#institucion').html('');
            $("#search-box").val(localStorage.getItem('prediccion'));
            $("#panelLecciones")[0].classList.add('d-none');
        })

        /*Funcion que se llama cada que una prediccion es cargada*/
        function accionesListadoAlumnos(){
            $('.nombreAlumno').click(function(){
                localStorage.setItem('prediccion', $("#search-box").val());

                $("#search-box").val(this.textContent);
                $('#institucion').html('<b>Institución:</b> '+this.getAttribute('institucion')+"<br><b>Nivel: "+this.getAttribute('nivel')+"</b><br><b>Modulo: "+this.getAttribute('modulo')+"</b>");
                $("#suggesstion-box").html('');

                var id_alumno = this.id;
                var data = getInfoAjax('obtenerleccionesalumnodesdeid', {id: id_alumno}, 'evaluaciontrimestral');
                if(data){
                    elementos = [];

                    var puedeIntentarHacerExamen = data.puedeRealizarExamen;
                    if(!puedeIntentarHacerExamen){
                        $('#institucion').html('<b style="color: red; font-weight: bold;">Máximo de intentos</b>');
                    }
                    data.data.forEach(function(item, index){
                        elementos.push("<li><input type='checkbox' class='form-check-input' name='lecciones[]' value='"+item["LGF0160001"]+"' "+(puedeIntentarHacerExamen === 1 ? '':'disabled')+"><span> "+(index+1)+" "+item["LGF0160002"]+"</span></li>");
                    });

                    $("#nombreDeLecciones").html('');
                    $("#nombreDeLecciones").html(elementos);

                    $("#panelLecciones")[0].classList.remove('d-none');
                }


            })
        }

        /*Verificar antes de enviar el formulario */

        $("#enviarLecciones").click(function(){

            var leccionesSeleccionadas = $('input[name="lecciones[]"]:checked');
            if(leccionesSeleccionadas.length > 0 && leccionesSeleccionadas.length < 4){
                $("#formularioLecciones").submit();
            }else{
                alert("Favor de seleccionar de 1 a 3 lecciones para tu evaluacion")
            }
        });



        /*Caja de busqueda predicciones*/
        $("#search-box").keyup(function(){
            $.ajax({
                type: "POST",
                url: "<?php echo CONTEXT; ?>evaluaciontrimestral/obtenerusuariosbusquedaevaluaciontrimestral",
                data:'nombre='+$(this).val(),
                beforeSend: function(){
                    $("#search-box").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
                },
                success: function(data){

                    elementos = [];
                    data.data.forEach(function(item){
                        elementos.push("<li class='nombreAlumno' institucion='"+item.escuela+"' nivel='"+item.nivel+"' modulo='"+item.modulo+"' id='"+item.id+"'>"+item.nombre +" "+ item.ap1+" " + item.ap2 +" CURP: "+ item.curp+"</li>")
                    });

                    $("#suggesstion-box").show();
                    $("#suggesstion-box").html(elementos);
                    accionesListadoAlumnos()
                }
            });
        });
    });
</script>
