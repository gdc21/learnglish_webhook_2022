<!-- se cierra el div del CONTENIDO EN GENERAL -->
</div>

<footer>
	<div class="footer_content">
		<div class="col-lg-12">
			<span> <?php echo date ("Y"); ?> &copy; Todos los derechos reservados <br><div id="mail" style="cursor: pointer;">soporte@learnglishpro.com</div></span>
		</div>
	</div>
	<a id="mail2" style="display: none;" href="mailto:soporte@learnglishpro.com">soporte@learnglishpro.com</a>
</footer>
<script>
	$("#mail").click(function (e) {
		url = $("#mail2").attr("href");
		window.open(url, 'mail');
	});
</script>