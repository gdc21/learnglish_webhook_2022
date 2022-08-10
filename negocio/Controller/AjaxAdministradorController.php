<?php
class AjaxAdministradorController extends Controller_Learnglish {
	public function __construct() {
		parent::__construct ();
	}
	
	/**
	 * Función para recuperar las cuentas de la institución
	 */
	public function cuentas() {
		$items = (new Usuarios ())->obtenContenidoPaginacion ( ( object ) array (
				"NMF0010023" => "NOT_(1,2",
				"NMF0010022" => $_POST ["idInstitucion"] 
		), array (
				"start" => $_POST ["start"],
				"finish" => $_POST ["finish"] 
		) );
		$cuentas = array ();
		if (! empty ( $items )) {
			foreach ( $items as $item ) {
				array_push ( $cuentas, array (
						"id" => $item ["NMF0010001"],
						"nombre" => empty ( $item ["NMF0010002"] ) ? "" : $item ["NMF0010002"],
						"usuario" => $item ["NMF0010005"],
						"password" => $item ["NMF0010006"],
						"fecha" => date ( "Y-m-d", strtotime ( $item ["NMF0010019"] ) ),
						"estatus" => $item ["NMF0010024"] ? "Activo" : "Inactivo" 
				) );
			}
		}
		$this->renderJSON ( $cuentas );
	}
	
	/**
	 * Función para recuperar el total de cuentas de la institución
	 */
	public function total_cuentas() {
		$items = (new Usuarios ())->obtenUsuario ( ( object ) array (
				"NMF0010023" => "NOT_(1,2",
				"NMF0010022" => $_POST ["idInstitucion"] 
		), true );
		$this->renderJSON ( array (
				"total" => $items 
		) );
	}
	
	/**
	 * ***************************************************
	 */
	
	/**
	 * Función para dar de alta un nuevo cliente
	 */
	public function form_nva_cliente() {
		$ip = isset ( $_POST ["ip"] ) ? $_POST ["ip"] : "";
		$url = isset ( $_POST ["url"] ) ? $_POST ["url"] : "";
		$nombre = isset ( $_POST ["nombre"] ) ? $_POST ["nombre"] : "";
		$licenciasContratadas = isset ( $_POST ["contratadas"] ) ? $_POST ["contratadas"] : "";
		$fechaDeRegistro = isset ( $_POST ["fecharegistro"] ) ? $_POST ["fecharegistro"] : "";
		$fechaDeVigencia = isset ( $_POST ["vigencia"] ) ? $_POST ["vigencia"] : "";
		$estado = isset ( $_POST ["estado"] ) ? $_POST ["estado"] : "";
		// $fld_cuenta = isset ( $_POSt ["cuenta"] ) ? $_POST ["cuenta"] : "";
		$activo = isset ( $_POST ["activo"] ) ? $_POST ["activo"] : "";
		$nm00002 = new entity_NM00002 ();
		$nm00002->NMF0020002 = $nombre;
		$nm00002->NMF0020012 = $estado;
		$nm00002->NMF0020013 = date ( "Y-m-d H:i:s" );
		$nm00002->NMF0020016 = $this->userid;
		$nm00002->NMF0020019 = $licenciasContratadas;
		$modelInstitucion = new Clientes ();
		$idInstitucion = $modelInstitucion->agregarInstitucion ( $nm00002 );
		if ($idInstitucion) {
			if ($ip) {
				$nm00017 = new entity_NM00017 ();
				$nm00017->NMF0170002 = $idInstitucion;
				$nm00017->NMF0170003 = $ip;
				$nm00017->NMF0170005 = $this->userid;
				$nm00017->NMF0170006 = date ( "Y-m-d H:i:s" );
				$nm00017->NMF0170011 = 1;
				(new Ip_Instituciones ())->agregarIpInstituciones ( $nm00017 );
			}
			if ($url) {
				$nm00029 = new entity_NM00029 ();
				$nm00029->NMF0290002 = $idInstitucion;
				$nm00029->NMF0290003 = $url;
				$nm00029->NMF0290004 = $this->userid;
				$nm00029->NMF0290005 = date ( "Y-m-d H:i:s" );
				$nm00029->NMF0290010 = 1;
				(new Url_Instituciones ())->agregarUrlInstituciones ( $nm00029 );
			}
			$nm00030 = new entity_NM00030 ();
			$nm00030->NMF0300002 = $idInstitucion;
			// $nm00030->NMF0300003 = $fld_cuenta;
			$nm00030->NMF0300004 = $fechaDeRegistro;
			$nm00030->NMF0300005 = $fechaDeVigencia;
			$nm00030->NMF0300006 = $this->userid;
			$nm00030->NMF0300007 = date ( "Y-m-d H:i:s" );
			$nm00030->NMF0300012 = 1;
			(new VigenciaAccesos ())->agregarVigenciaAccesos ( $nm00030 );
			
			$this->renderJSON ( array (
					"mensaje" => "Se ha creado el cliente correctamente." 
			) );
		} else {
			$this->renderJSON ( array (
					"error" => "Ha ocurrido un error al crear el cliente." 
			) );
		}
	}
	/**
	 * Función que permite modificar la información de un cliente
	 */
	public function form_mdf_cliente() {
		$institucion = (new Clientes ())->obtenInstitucion ( ( object ) array (
				"NMF0020001" => $_POST ["id_cliente"] 
		) );
		if (empty ( $institucion )) {
			$this->renderJSON ( array (
					"error" => "No se puede modificar el cliente especificado" 
			) );
		}
		$institucion = $institucion [0];
		$institucion ["NMF0020002"] = $_POST ["nombre"];
		$institucion ["NMF0020019"] = $_POST ["contratadas"];
		$institucion ["NMF0020012"] = $_POST ["estado"];
		$institucion ["NMF0020017"] = $this->userid;
		$institucion ["NMF0020014"] = date ( "Y-m-d H:i:s" );
		if ($_POST ["fld_url"]) {
			$url = (new Url_Instituciones ())->obtenUrlInstituciones ( ( object ) array (
					"NMF0290002" => $_POST ["id_cliente"] 
			) );
			if (! empty ( $url )) {
				$url = $url [0];
				$url ["NMF0290003"] = $_POST ["url"];
				$url ["NMF0290006"] = $this->userid;
				$url ["NMF0290007"] = date ( "Y-m-d H:i:s" );
				(new Url_Instituciones ())->actualizarUrlInstituciones ( ( object ) $url, ( object ) array (
						"NMF0290002" => $url ["NMF0290001"] 
				) );
			} else {
				$nm00029 = new entity_NM00029 ();
				$nm00029->NMF0290002 = $_POST ["id_cliente"];
				$nm00029->NMF0290003 = $_POST ["url"];
				;
				$nm00029->NMF0290004 = $this->userid;
				$nm00029->NMF0290005 = date ( "Y-m-d H:i:s" );
				$nm00029->NMF0290010 = 1;
				(new Url_Instituciones ())->agregarUrlInstituciones ( $nm00029 );
			}
		}
		if ($_POST ["fld_ip"]) {
			$ip = (new Ip_Instituciones ())->obtenIpInstituciones ( ( object ) array (
					"NMF0170002" => $_POST ["id_cliente"] 
			) );
			if (! empty ( $ip )) {
				$ip = $ip [0];
				$ip ["NMF0170003"] = $_POST ["ip"];
				$ip ["NMF0170007"] = $this->userid;
				$ip ["NMF0170008"] = date ( "Y-m-d H:i:s" );
				(new Ip_Instituciones ())->actualizarIpInstituciones ( ( object ) $ip, ( object ) array (
						"NMF0170002" => $ip ["NMF0170001"] 
				) );
			} else {
				$nm00017 = new entity_NM00017 ();
				$nm00017->NMF0170002 = $_POST ["id_cliente"];
				$nm00017->NMF0170003 = $_POST ["ip"];
				$nm00017->NMF0170005 = $this->userid;
				$nm00017->NMF0170006 = date ( "Y-m-d H:i:s" );
				$nm00017->NMF0170011 = 1;
				(new Ip_Instituciones ())->agregarIpInstituciones ( $nm00017 );
			}
		}
		$vigencia = (new VigenciaAccesos ())->obtenVigenciaAccesos ( ( object ) array (
				"NMF0300002" => $_POST ["id_cliente"] 
		) );
		if ($vigencia) {
			$vigencia = $vigencia [0];
			$vigencia ["NMF0300004"] = $_POST ["fecharegistro"];
			$vigencia ["NMF0300005"] = $_POST ["vigencia"];
			$vigencia ["NMF0300008"] = $this->userid;
			$vigencia ["NMF0300009"] = date ( "Y-m-d H:i:s" );
			(new VigenciaAccesos ())->actualizarVigenciaAccesos ( ( object ) $vigencia, ( object ) array (
					"NMF0300001" => $vigencia ["NMF0300001"] 
			) );
		} else {
			$nm00030 = new entity_NM00030 ();
			$nm00030->NMF0300002 = $_POST ["id_cliente"];
			$nm00030->NMF0300004 = $_POST ["fecharegistro"];
			$nm00030->NMF0300005 = $_POST ["vigencia"];
			$nm00030->NMF0300006 = $this->userid;
			$nm00030->NMF0300007 = date ( "Y-m-d H:i:s" );
			$nm00030->NMF0300012 = 1;
			(new VigenciaAccesos ())->agregarVigenciaAccesos ( $nm00030 );
		}
		(new Clientes ())->actualizarInstitucion ( ( object ) $institucion, ( object ) array (
				"NMF0020001" => $_POST ["id_cliente"] 
		) );
		$this->renderJSON ( array (
				"mensaje" => "El cliente ha sido actualizado." 
		) );
	}
}