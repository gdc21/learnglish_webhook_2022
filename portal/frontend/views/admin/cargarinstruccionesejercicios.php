<?php
function listarDirectoriosLocales($dir, &$results = array()){
    $files = scandir($dir);

    foreach($files as $key => $value){
        $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
        if($value != "." && $value != "..") {
            //Es un directorio
            if(strpos($value,'obj') === false){
                listarDirectoriosLocales($path, $results);
                $results[] = $path;
            }
        }
    }

    return $results;
}

echo '<h2>Listar Directorios Locales </h2><pre>';
$directorios_lecciones =listarDirectoriosLocales(__DIR__."/../../../oda/n3");
var_dump($directorios_lecciones);
foreach ($directorios_lecciones as $directorio) {
    $files = scandir($directorio);
    $cantidad_carpetas = 0;
    echo "<h3>".substr($directorio, 51, strlen($directorio))."</h3>"."<hr>";
    foreach($files as $key => $value){
        $path = realpath($directorio.DIRECTORY_SEPARATOR.$value);
        if(is_dir($path) && $value != "." && $value != "..") {
            $cantidad_carpetas++;
            echo "------->".$value."<br>";
        }
    }
    echo "<h4>Total de carpetas: ".$cantidad_carpetas."</h4>";
}

#print_r(listarDirectoriosLocales(__DIR__."/../../../oda/n1"));
echo '</pre>';

?>
<section  id="contenido"    class="my-0">
    <?php echo $this->temp['encabezado']; ?>
    <?php #var_dump($this->temp['menuItems']); ?>

</section>
<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto text-center">
            <select name="modulo" id="modulos" class="form-control mx-auto mt-5">
                <option value="">[ Seleccionar un modulo ]</option>
                <?php foreach($this->temp['modulos'] as $modulo) { ?>
                    <option value="<?php echo $modulo['LGF0150001']; ?>">
                        <?php echo $modulo['LGF0150002']; ?>
                    </option>
                <?php } ?>
            </select>

            <div id="resultados">
                <select name="lecciones" class="form-control my-4" id="lecciones">
                    <option value="">[ Seleccione una lección del modulo ]</option>
                </select>
            </div>
            <div id="cargarElementos" class="row">
                <div class="mt-2 mb-5 col-12">
                    <form action="" id="formularioSpeaking">
                        <label>Instrucciones speaking: </label>
                        <textarea rows="5" name="speakingInstructions" class="form-control" ></textarea>

                        <label>Instrucciones speaking imagen: </label>
                        <input type="file" name="speakingImage" accept="image/*" id="speakingImage" >

                        <div id="status2" class="my-1 w-100"></div>

                        <button class=" my-3 text-white btn btn-info" id="botonEnviar2">Guardar</button>
                    </form>
                </div>

                <hr>

                <div class="mt-2 mb-5 col-12">
                    <form action="" id="formularioDocumento">
                        <label>Instrucciones documento: </label>
                        <textarea rows="5" name="documentoInstructions" class="form-control"></textarea>

                        <label>Instrucciones documento imagen: </label>
                        <input type="file" name="documentoImage" accept="image/*">

                        <button class="my-3 text-white btn btn-info">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function (){
        $("#cargarElementos")[0].style.display = 'none';

        /**
         * Cargamos las instrucciones de speaking y documentos cuando Gardar es presionado
         */
        $("#formularioSpeaking").submit(function(event){

            event.preventDefault();

            var myFile2 = document.getElementById('speakingImage');  // Our HTML files' ID
            var statusP2 = document.querySelector("#status2");
            statusP2.innerHTML = '';

            if(myFile2.value == '' && $("[name='speakingInstructions']")[0].value == ''){
                statusP2.style.color = "red";
                statusP2.innerHTML = 'Favor de cargar por lo menos 1 elemento';
                return;
            }


            var files = myFile2.files;
            var formData = new FormData();
            var file = files[0];

            if ( !file.type.match('image/*')) {
                 statusP2.innerHTML = 'El archivo cargado no es de tipo imagen.';
                 return;
            }else{
                /*spinner2.classList.remove('hide');*/
                $("#botonEnviar2")[0].classList.add("hide");
            }
            formData.append('fileAjax', file, file.name);
            formData.append('leccion', $("#lecciones")[0].value);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', '<?php echo CONTEXT; ?>admin/guardarinstrucciones/1', true);

            xhr.onload = function (event) {

                $("#botonEnviar2")[0].classList.remove("hide");
                if (xhr.status == 200 ) {
                    $("#botonEnviar2")[0].classList.remove("hide");
                    statusP2.style.color = "green";
                    statusP2.innerHTML = 'Elementos guardados';
                    /*spinner2.classList.add('hide');*/
                    /*setTimeout(function(){
                        location.reload();
                    }, 3000);*/

                } else if(xhr.status == 200 && event.target.response == 2) {
                    statusP2.innerHTML = 'Tipo de archivo no permitido.';
                } else if(xhr.status == 200 && event.target.response == 0){
                    statusP2.innerHTML = 'Hubo un error en el servidor al guardar tu archivo, recarga la página y vuelve a intentar.';
                }
            };

            // Send the data.
            xhr.send(formData);

        });

        /** Verificamos que el select de lecciones tenga una seleccionada
         * */
        $("#lecciones").change(function(){

            if(this.value != ""){
                $("#cargarElementos")[0].style.display = 'initial';
            }else{
                $("#cargarElementos")[0].style.display = 'none';
            }
        });

        /**
         * Verificamos que se seleccione un modulo para mostrar las lecciones
         */
        $("#modulos").change(function(item){
            console.log(this.value);

            var data = getInfoAjax('leccionesdemodulo', {modulo: this.value}, 'admin');
            if(data){
                console.log(data)
                var selectLecciones = document.querySelector("#lecciones");
                selectLecciones.innerHTML = '';
                selectLecciones.innerHTML = '<option value="">[ Seleccione una lección del modulo ]</option>';

                data['data'].forEach(function(item, index){
                    var option = document.createElement('option');
                    option.value = item['LGF0160001'];
                    option.innerHTML = "Leccion "+(index+1)+": "+item['LGF0160002'];
                    selectLecciones.append(option);
                })
            }else{
                console.log("Algo salio mal")
            }
        });
    });
</script>
