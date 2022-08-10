<style>
    button{
    	height: auto !important;
    }
</style>
<section id="contenido">
	<div class="row col-lg-12">
		<!-- <span class="learnglish"></span> -->
		<img src="<?php echo CONTEXT ?>portal/IMG/logo.png" alt="">
	</div>
	<!-- <div style="margin-top: 35%;"></div> -->
	<div class="row offset-md-0 col-lg-12 offset-md-0 col-md-12 offset-sm-1 col-sm-10">
		<img src="<?php echo CONTEXT ?>portal/IMG/slogan.png" alt="">
	</div>

	<div class="row">
		<a href="#" id="ingresar" class="btn btn-lg btn-primary">Ingresar</a>
	</div>
	<div class="row col-lg-12">
		<img src="<?php echo CONTEXT ?>portal/IMG/grados.png" alt="">
	</div>
	<div class="row col-lg-12">
		<img src="<?php echo CONTEXT ?>portal/IMG/texto.png" alt="">
		<img src="<?php echo CONTEXT ?>portal/IMG/iconos.png" alt="">
		<?php $video = CONTEXT."portal/Video/VID-20210128-WA0021.mp4"; ?>
		<div class="row">
			<a id="conozca" class="btn btn-lg btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#modal4" data-url="<?php echo $video; ?>" >Conozca más</a>
		</div>
	</div>
	
	<!-- Modal -->
    <div class="modal fade" id="modal4" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    	<div class="modal-dialog  modal-lg">
    		<div class="modal-content">
    			<div class="modal-body">
    				<div class="ratio ratio-16x9">
	    				<iframe src="" allowfullscreen></iframe>
					</div>
    			<div class="modal-footer">
    				<button type="button" class="btn btn-outline-primary btn-rounded btn-md ml-4" data-bs-dismiss="modal">Cerrar</button>
    			</div>
    		</div>
    	</div>
    </div>
</section>
<script>
	$("#ingresar").click(function () {
		$("#loginForm").modal("show");
	});

	function abremodal(){
		$("#modal-video").modal('show');
	}
</script>

<script>
	$('#modal4').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget)
		var video = button.data('url')
		//$("#myFrame").attr('src',video);  
		$('#modal4 iframe').attr("src", video);
	})

	$('#modal4').on('hidden.bs.modal', function (e) {
		// Quitar la reproduccion del video al ocutar el modal
		$('#modal4 iframe').attr("src", "#");
	});
</script>