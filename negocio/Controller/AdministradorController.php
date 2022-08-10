<?php
class AdministradorController extends Controller_Learnglish {
	public function __construct() {
		parent::__construct ();
		$this->header_custom = "header_admin.php";
		/**
		 * 0 - SuperAdmin
		 * 1 - Admin
		 */
		if (! isset ( $_SESSION ["userLogged"] )) {
			$this->Redirect ( "auth", "login" );
		}
		if ($_SESSION ["perfil"] != 0 && $_SESSION ["perfil"] != 1) {
			$this->Redirect ();
		}
	}
	public function index() {
		$this->header_custom = "header_admin.php";
		
		$this->render ();
	}
	
	/**
	 * Función para recuperar las cuentas de la institución
	 *
	 * @param unknown $idInstitucion        	
	 */
	public function cuentas($idInstitucion) {
		$cuenta = (new Instituciones ())->obtenInstitucion ( ( object ) array (
				"EMF0020001" => $idInstitucion 
		) ) [0];
		$items = (new Usuarios ())->obtenUsuario ( ( object ) array (
				"EMF0010023" => "NOT_(1,2",
				"EMF0010022" => $idInstitucion 
		) );
		$cuentas = array ();
		if (! empty ( $items )) {
			foreach ( $items as $item ) {
				array_push ( $cuentas, array (
						"id" => $item ["EMF0010001"],
						"nombre" => empty ( $item ["EMF0010002"] ) ? "" : $item ["EMF0010002"],
						"usuario" => $item ["EMF0010005"],
						"password" => $item ["EMF0010006"],
						"fecha" => date ( "Y-m-d", strtotime ( $item ["EMF0010019"] ) ),
						"estatus" => $item ["EMF0010024"] ? "Activo" : "Inactivo" 
				) );
			}
		}
		$this->temp ["cuentas"] = $cuentas;
		$this->temp ["cliente"] = array (
				"idCliente" => $cuenta ["EMF0020001"],
				"nombre" => $cuenta ["EMF0020002"],
				"contratadas" => $cuenta ["EMF0020027"],
				"registradas" => $this->obtenNumeroClientes ( $idInstitucion ) 
		);
		$this->recuperaPerfiles ();
		$this->render ();
	}
	public function clientes() {
		$clientes = (new Clientes ())->obtenInstitucion ();
		$c = array ();
		foreach ( $clientes as $cliente ) {
			$usuarios = $this->obtenNumeroClientes ( $cliente ["NMF0020001"] );
			$vigencia = (new VigenciaAccesos ())->obtenVigenciaAccesos ( ( object ) array (
					"NMF0300002" => $cliente ["NMF0020001"] 
			) );
			$inicio = "N/A";
			$fin = "N/A";
			if (! empty ( $vigencia )) {
				$vigencia = $vigencia [0];
				$inicio = date ( "Y-m-d", strtotime ( $vigencia ["NMF0300004"] ) );
				$fin = date ( "Y-m-d", strtotime ( $vigencia ["NMF0300005"] ) );
			}
			array_push ( $c, array (
					"id" => $cliente ["NMF0020001"],
					"nombre" => $cliente ["NMF0020002"],
					"inicio" => $inicio,
					"termino" => $fin,
					"contradas" => $cliente ["NMF0020019"],
					"utilizadas" => '<a href="' . CONTEXT . 'administrador/clientes_licencias/' . $cliente ["NMF0020001"] . '">' . $this->obtenNumeroClientes ( $cliente ["NMF0020001"] ) . '</a>',
					"registro" => date ( "Y/m/d", strtotime ( $cliente ["NMF0020013"] ) ),
					"estatus" => $cliente ["NMF0020012"] 
			) );
		}
		$this->temp ["cliente"] = $c;
		// $this->var_dump ( $this->temp ["cliente"] );
		$this->render ();
	}
	public function clientes_licencias($idCliente) {
		$u = array ();
		$usuarios = (new Usuarios ())->obtenUsuario ( ( object ) array (
				"NMF0010023" => 2,
				"NMF0010024" => $idCliente 
		) );
		if (! empty ( $usuarios )) {
			foreach ( $usuarios as $usuario ) {
				array_push ( $u, array (
						"id" => $usuario ["NMF0010001"],
						"registro" => date ( "d/m/Y", strtotime ( $usuario ["NMF0010020"] ) ),
						"nombre" => $usuario ["NMF0010002"],
						"usuario" => $usuario ["NMF0010005"],
						"estatus" => $usuario ["NMF0010025"],
						"password" => $usuario ["NMF0010006"] 
				) );
			}
		}
		$this->temp ["usuarios"] = $u;
		$this->var_dump ( $this->temp );
		$this->render ();
	}
	public function form_nva_cliente() {
		$this->temp ["fecha"] = date ( "Y/m/d" );
		$this->var_dump ( $this->temp );
		$this->render ();
	}
	public function form_mdf_cliente($idCliente) {
		$cliente = (new Clientes ())->obtenInstitucion ( ( object ) array (
				"NMF0020001" => $idCliente 
		) ) [0];
		$ip = "";
		$ips = (new Ip_Instituciones ())->obtenIpInstituciones ( ( object ) array (
				"NMF0170002" => $cliente ["NMF0020001"] 
		) );
		if (! empty ( $ips )) {
			$ip = $ips [0] ["NMF0170003"];
		}
		
		$url = "";
		$urls = (new Url_Instituciones ())->obtenUrlInstituciones ( ( object ) array (
				"NMF0290002" => $cliente ["NMF0020001"] 
		) );
		if (! empty ( $urls )) {
			$url = $urls [0] ["NMF0290003"];
		}
		$vigencias = (new VigenciaAccesos ())->obtenVigenciaAccesos ( ( object ) array (
				"NMF0300002" => $cliente ["NMF0020001"] 
		) );
		$inicio = "";
		$fin = "";
		if (! empty ( $vigencias )) {
			$inicio = date ( "Y-m-d", strtotime ( $vigencias [0] ["NMF0300004"] ) );
			$fin = date ( "Y-m-d", strtotime ( $vigencias [0] ["NMF0300005"] ) );
		}
		$this->temp ["cliente"] = array (
				"id_cliente" => $idCliente,
				"nombre" => $cliente ["NMF0020002"],
				"fecha_inicio" => $inicio,
				"fecha_fin" => $fin,
				"ip" => $ip,
				"url" => $url,
				"licencias" => $cliente ["NMF0020019"],
				"estatus" => $cliente ["NMF0020012"],
				"fecha" => date ( "Y/m/d" ) 
		);
		// $this->var_dump ( $this->temp );
		$this->render ();
	}
	public function licencias_cliente($idCliente) {
		$usuarios = (new Usuarios ())->obtenUsuario ( ( object ) array (
				"NMF0010024" => $idCliente,
				"NMF0010023" => 2 
		) );
		$u = array ();
		foreach ( $usuarios as $usuario ) {
			array_push ( $u, array (
					"id" => $usuario ["NMF0010001"],
					"nombre" => $usuario ["NMF0010002"],
					"registro" => date ( "Y/m/d", strtotime ( $usuario ["NMF0010020"] ) ),
					"usuario" => $usuario ["NMF0010005"],
					"password" => $usuario ["NMF0010006"],
					"estatus" => $usuario ["NMF0010025"] 
			) );
		}
		$this->temp ["usuarios"] = $u;
		$this->var_dump ( $this->temp );
		$this->render ();
	}
	public function administradores() {
		$admins = (new Usuarios ())->obtenUsuario ( ( object ) array (
				"NMF0010023" => "1" 
		) );
		$ad = array ();
		foreach ( $admins as $admin ) {
			$permisos = (new Usuario_Permisos ())->obtenUsuarioPermisos ( ( object ) array (
					"NMF0040002" => $admin ["NMF0010001"] 
			) );
			array_push ( $ad, array (
					"id" => $admin ["NMF0010001"],
					"nombre" => $admin ["NMF0010002"] . $admin ["NMF0010003"],
					"permisos" => $permisos,
					"user" => $admin ["NMF0010005"],
					"password" => $admin ["NMF0010006"],
					"registro" => date ( "Y-m-d", strtotime ( $admin ["NMF0010020"] ) ),
					"estatus" => $admin ["NMF0010025"] 
			) );
		}
		$this->temp ["contenido"] = $ad;
		$this->render ();
	}
	public function form_nva_administrador() {
		$permisos = (new Permisos ())->obtenPermisos ( ( object ) array (
				"NMF0030007" => 1 
		) );
		$p = array ();
		foreach ( $permisos as $permiso ) {
			array_push ( $p, array (
					"id" => $permiso ["NMF0030001"],
					"nombre" => $permiso ["NMF0030002"] 
			) );
		}
		$this->temp ["permisos"] = $p;
		$this->render ();
	}
	public function form_mdf_administrador($idAdministrador) {
		$permisos = (new Permisos ())->obtenPermisos ( ( object ) array (
				"NMF0030007" => 1 
		) );
		$p = array ();
		foreach ( $permisos as $permiso ) {
			array_push ( $p, array (
					"id" => $permiso ["NMF0030001"],
					"nombre" => $permiso ["NMF0030002"] 
			) );
		}
		$this->temp ["permisos"] = $p;
		// $this->var_dump ( $this->temp );
		
		$usuario = (new Usuarios ())->obtenUsuario ( ( object ) array (
				"NMF0010001" => $idAdministrador 
		) );
		
		$permisos = (new Usuario_Permisos ())->obtenUsuarioPermisos ( ( object ) array (
				"NMF0040002" => $usuario [0] ["NMF0010001"] 
		) );
		$p = array ();
		foreach ( $permisos as $item ) {
			array_push ( $p, $item ["NMF0040003"] );
		}
		$this->temp ["usuario"] = array (
				"id" => $usuario [0] ["NMF0010001"],
				"nombre" => $usuario [0] ["NMF0010002"],
				"activo" => $usuario [0] ["NMF0010025"],
				"usuario" => $usuario [0] ["NMF0010005"],
				"permisos" => $p 
		);
		// $this->var_dump ( $this->temp );
		$this->render ();
	}
}