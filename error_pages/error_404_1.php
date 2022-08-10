<?php
$status_header = 'HTTP/1.1 404 Not Found';
header ( $status_header );
header ( 'Content-type: text/html; charset=utf-8' );
header ( 'From', APP_NAME );
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
?>
</html><html>
<head>
<title>error 404</title>
<link href="<?php echo BOOTSTRAP;?>/css/bootstrap.min.css" rel="stylesheet">
 <script src="<?php echo BOOTSTRAP;?>/../frontend/js/jquery.js"></script>
 <script src="<?php echo BOOTSTRAP;?>/js/bootstrap.min.js"></script>
 
<style>
#div-error{
  position: fixed;
  top: 50%;
  left: 50%;
  /* bring your own prefixes */
  transform: translate(-50%, -50%);
}
#img-error{
		position:relative;
		z-index: -12;
}
.salir{
    position: fixed;
	z-index: 2;
	top: 339px; 
	left: 116px;
	cursor:pointer;
}
.volver{
    position: fixed;
	z-index: 2;
	top: 339px; 
	left: 292px;
	cursor:pointer;
}
</style>

</head>
<body>
<div class="row">
<div class="col-xs-2 col-sm-3"></div>
  <div class="col-xs-8 col-sm-6">
  <div id="div-error">
  <img id="img-error" src="<?=CONTEXT?>/error_pages/Error404.png"/>
    <img class="salir" src="<?=CONTEXT?>/error_pages/Salir.png"/>
   <img class="volver" src="<?=CONTEXT?>/error_pages/Volver.png"/>
  </div>

  
  </div>
  <!-- Optional: clear the XS cols if their content doesn't match in height -->
  <div class="clearfix visible-xs-block"></div>
  <div class="col-xs-2 col-sm-3"></div>
	
</div>
</body>
<script type="text/javascript">
	$(".salir").click(function(e){
		 	window.location.href = "<?= CONTEXT?>home";
	});

	$(".volver").click(function(e){
		 if (window.history.length>2){
		 	window.history.back();
		 }else{
		 	window.location.href = "<?= CONTEXT?>home";
		 }
	});
</script>
</html>