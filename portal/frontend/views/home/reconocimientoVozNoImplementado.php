<section class="container">
    <section id="contenido">
        <?php echo $this->temp['encabezado']; ?>

        <div class="row">
            <div class="col mt-5">
                <button class="btn btn-info iniciarReconocimiento">
                    Iniciar
                </button>
            </div>
        </div>


    </section>
</section>
<script src="//cdnjs.cloudflare.com/ajax/libs/annyang/2.6.0/annyang.min.js"></script>
<script>
    $(function(){

        $('.iniciarReconocimiento').click(function(){


            var sr = new (window.SpeechRecognition || window.webkitSpeechRecognition || window.mozSpeechRecognition || window.msSpeechRecognition)();
            sr.lang = "es-MX";
            sr.onresult = resultado => {
                document.body.innerHTML = resultado.results[0][0].transcript
                console.log(resultado.results['0']['0'].transcript);
            }
            sr.start();
            setTimeout(function (){
                sr.stop();
                alert("Detenido")
            }, 3500)
        })
    });
</script>