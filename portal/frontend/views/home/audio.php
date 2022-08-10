<section class="container">
    <section id="contenido">

        <div class="separador pb-5">
            <img src="https://192.168.10.11/learnglishGit/portal/oda/instrucciones.png" alt="" width="100%">

            <form action="">
                <label for="">Subir audio de tu speaking</label>
                <input type="file" class="form-control" required>
                <button class="w-100 mt-3 btn-success btn">Enviar actividad</button>
            </form>
            <div class="row">
                <div class="offset-lg-9 col-lg-3">
                    <a class="regresar basico menu-principal" href='<?php echo CONTEXT ?>admin/manager/'>Regresar</a>
                </div>
            </div>
        </div>

        <div class="page" id="actividad">
            <div class="row">
                <div class="pt-3 col-lg-12 table-responsive">
                   Graba tu audio, descarga y después sube tu archivo.
                </div>
                <div class="col-12">
                    <div id="audioContenidoWeb">
                        <label class="d-block">Seleccionar dispositivo de grabación</label>
                        <select name="listaDeDispositivos" id="listaDeDispositivos"></select>

                        <p id="duracion"></p>

                        <button class="btn btn-info text-white botonGrabacion" id="btnComenzarGrabacion">Comenzar</button>
                        <button class="btn btn-warning text-white botonGrabacion" id="btnDetenerGrabacion">Detener</button>
                    </div>
                </div>
            </div>


        </div>
    </section>
</section>
<style>
    #actividad{
        width: 100%;
        border-top: 1px dotted black;
        padding-bottom: 10px;
        background: white;
        position: fixed;
        z-index: 9999;
        bottom: 0;
        left: 0;
        text-align: center;
    }

</style>