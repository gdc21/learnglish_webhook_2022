<div class="container">
	<div class="page">
		<form id="importar">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-6">
					<div class="form-group">
						<label for="files">Subir archivo</label>
						<input type="file" class="form-control" id="files" name="files">
						<small id="filesHelp" class="form-text text-muted">Solo se permiten CSV</small>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3">
					<label for="files">Subir archivo</label>
					<select name="tipo" id="tipo" class="form-select">
						<option value="">Selecciona una opción</option>
						<option value="1">Usuarios</option>
						<option value="2">Instituciones</option>
						<option value="3">Docentes</option>
						<option value="4">Grupos</option>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-3">
					<button type="submit" id="subir" class="btn btn-primary">Submit</button>
				</div>

				<div class="col-lg-7 col-md-8 col-sm-8">
					<div class="alert alert-warning" role="alert" id="mensaje" style="font-size: 14px; margin-left: 10px; display: none;"></div>
				</div>
			</div>
		</form>
	</div>
</div>

<script>
	$(document).ready(function () {
		$("#subir").click(function (e) {
			e.preventDefault();
			var form = new FormData($('#importar')[0]);
	        $.ajax({
	        	url: context+'admin/subir_datos',
	        	type: "post",
	            data : form,
	            processData: false,
	            contentType: false,
	            beforeSend: function () {
	            	$("#mensaje").html("<i class='fa fa-spinner fa-spin fa-3x fa-fw' style='font-size: 1em;'></i> Espera un momento mientras se realiza la importación de registros.");
	            	$("#mensaje").show();
	            },
	            success: function(data) {
	            	console.log(data);
	            	// $("#mensaje").hide();
	            	$("#mensaje").html("");
	            	$("#mensaje").html(data.mensaje);
	            	if (data.data != null) {
	                	generarCSV(data.data, true);
	                }
	            }
	        });
		});
	});

	function generarCSV(JSONData, ShowLabel) {
	    var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;
	    var CSV = '';    
	    
	    if (ShowLabel) {
	      var row = "";
	      
	      for (var index in arrData[0]) {
	        row += index + ',';
	      }
	      row = row.slice(0, -1);
	      CSV += row + '\r\n';
	    }
	    
	    for (var i = 0; i < arrData.length; i++) {
	      var row = "";
	      for (var index in arrData[i]) {
	        row += '"' + arrData[i][index] + '",';
	      }
	      row.slice(0, row.length - 1);
	      CSV += row + '\r\n';
	    }

	    if (CSV == '') {
	      alert("Invalid data");
	      return;
	    }

	    var fileName = "Usuarios_no_registrados";
	    var uri = 'data:text/csv;charset=utf-8,' + escape(CSV);
	    var link = document.createElement("a");
	    link.href = uri;
	    link.style = "visibility:hidden";
	    link.download = fileName + ".csv";
	    document.body.appendChild(link);
	    link.click();
	    document.body.removeChild(link);
	}
</script>