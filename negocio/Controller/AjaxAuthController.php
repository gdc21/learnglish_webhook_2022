<?php
class AjaxAuthController extends AuthController {
	public function __construct() {
		parent::__construct ();
	}
	
	/**
	 * Metodo temporal para login
	 */
	public function login() {
		$login = (new Usuarios())->validarUsuario((object) array (
			"LGF0010005" => $_POST ["uname"],
			"LGF0010006" => $_POST ["pw"],
			"LGF0010008" => 1
		));

		if ($login == 0) { // Busca en instituciones
			$loginIns = (new Instituciones())->validarUsuario((object) array (
				"LGF0270024" => $_POST ["uname"],
				"LGF0270025" => $_POST ["pw"]
			));

			if ($loginIns == 2) { // Busca en clientes
				$loginCli = (new Clientes())->validarUsuario((object) array (
					"LGF0280019" => $_POST ["uname"],
					"LGF0280020" => $_POST ["pw"]
				));

				if ($loginCli == 2) {
					$this->renderJSON(array("error" => "Usuario o contraseña incorrectos"));
				} else { // Se inicia el proceso de session como cliente
					// $this->renderJSON(array("error" => 'Se encuentra en clientes'));
					$data = $loginCli[0];
					if ($data['LGF0280010'] == 1) {
						$_SESSION ["idUsuario"] = $loginCli[0]["LGF0280001"]; // ID del cliente
						$_SESSION ["perfil"] = $loginCli[0]["LGF0280022"]; // ID del Perfil
						$_SESSION ["nombre"] = $loginCli[0]["LGF0280002"]; // Nombre
						$_SESSION ["tipoSesion"] = 1;
						$_SESSION ["userLogged"] = true;
						
						#(new LogController())->logAccesoUser();
						$this->renderJSON(array(CONTEXT."home/menu"));
					} else {
						$this->renderJSON(array("error" => "Este usuario no se encuentra activo"));
					}
				}
			} else { // Se inicia el proceso de sesion como institucion
				// print_r($loginIns);
				$data = $loginIns[0];
				if ($data['LGF0270012'] == 1) {
					$factual = date("Y-m-d H:i:s");
					if ($data['LGF0270005'] < $factual) {
						$this->renderJSON(array("error" => "Le fecha de contrato a expirado"));
					} else {
						$_SESSION ["idUsuario"] = $loginIns[0]["LGF0270001"]; // ID de la institucion
						$_SESSION ["perfil"] = $loginIns[0]["LGF0270023"]; // ID del Perfil
						$_SESSION ["nombre"] = $loginIns[0]["LGF0270002"]; // Nombre
						$_SESSION ["tipoSesion"] = 1;
						$_SESSION ["userLogged"] = true;
						
						#(new LogController())->logAccesoUser();
						$this->renderJSON(array(CONTEXT."home/menu"));
					}
				} else {
					$this->renderJSON(array("error" => "Este usuario no se encuentra activo"));
				}
			}
		}
        else if ($login === 1) {
			$this->renderJSON(array(
				"error" => $this->ERROR_CONTRASENIA_LOGIN 
			));
		}
        else if ($login === 2) {
			$this->renderJSON(array(
				"error" => $this->ERROR_CUENTA_DESHABILITADO 
			));
		}
        else {
			$_SESSION ["idUsuario"] = $login [0] ["LGF0010001"];
			$_SESSION ["perfil"] = $login [0] ["LGF0010007"];
			$_SESSION ["nombre"] = $login [0] ["LGF0010002"];
			$_SESSION ["tipoSesion"] = 1;
			$_SESSION ["userLogged"] = true;
			/*if ($_SESSION ["perfil"] == 0 || $_SESSION ["perfil"] == 1) {
				(new LogController ())->logAccesoUser ();
			} else {
				// $_SESSION ["idInstitucion"] = $usuario [0] ["NMF0010024"];
				$_SESSION ["perfil"] = $login [0] ["LGF0010007"];

                #Por el momento no se registrara acceso de usuarios pd: No hacia nada, verificar funcion
                #02/05/2022
                #(new LogController ())->logAccesoUser ();
			}*/
		}

		if ($_SESSION['perfil'] == 2) {
			$_checkLog = (new Administrador())->check_logregistros($_SESSION ["idUsuario"], 1);

			if ($_checkLog[0]['LGF0360005'] == "" || $_checkLog[0]['LGF0360005'] == null) {
				$fecha = $_checkLog[0]['LGF0360004'];
				$fechaAuxiliar = strtotime("30 minutes", strtotime($fecha)); 
	    		$fechaSalida = date ('Y-m-d H:i:s', $fechaAuxiliar);
	    		$data['LGF0360005'] = $fechaSalida;
	    		$res = (new LogRegistros())->actualizarLogRegistros((object) $data, (object) array(
	    			"LGF0360001" => $_checkLog[0]['LGF0360001']
	    		));
			}

			$_logReg = array(
				'LGF0360002' => $_SESSION ["idUsuario"],
				'LGF0360003' => 1,
				'LGF0360004' => date("Y-m-d H:i:s")
			);
			$respuesta = (new LogRegistros())->agregarLogRegistros((object) $_logReg);
			$_SESSION['logRegistro'] = $respuesta;
		}

		if ($login [0] ["LGF0010007"] == 7) {
			$this->renderJSON(array(CONTEXT."home/tutor"));
		} else {
			$this->renderJSON(array(CONTEXT."home/menu"));
		}

		// $this->renderJSON(array(CONTEXT."home/menu"));
	}
	public function existe_usuario() {
		$em00001 = new entity_em00001 ();
		$em00001->NMF0010005 = $_POST ["usuario"];
		$user = new Usuarios ();
		$res = $user->validarUsuario ( $em00001 );
		if ($res === 0) {
			$this->renderJSON ( array (
					"mensaje" => $this->ERROR_USUARIO_LOGIN 
			) );
		} else {
			$this->renderJSON ( array (
					"error" => $this->ERROR_USUARIO_REGISTRO 
			) );
		}
	}
	public function valida_institucion($id_institucion) {
		$institucion = (new Clientes ())->obtenInstitucion ( ( object ) array (
				"LGF0270001" => $idInstitucion 
		) );
		var_dump ( $institucion );
	}
	
	/**
	 * Función que permite crear un nuevo cliente vinculado a un cliente
	 */
	public function nva_usuario() {
		$institucion = (new Clientes ())->obtenInstitucion ( ( object ) array (
				"LGF0270001" => $_SESSION ["idInstitucion"] 
		) );
		
		if (! $this->valida_vigencia_cliente ( $institucion [0] )) {
			$this->renderJSON ( array (
					"error" => $this->ERROR_CLIENTE_NO_VIGENTE 
			) );
		}
		if (! $this->valida_licencias_cliente ( $institucion [0] )) {
			$this->renderJSON ( array (
					"error" => $this->ERROR_LIMITE_CLIENTE 
			) );
		}
		$u = ( object ) array (
				"LGF0010005" => $_POST ["usuario"] 
		);
		
		$urs = (new Usuarios ())->obtenUsuario ( $u );
		if (! empty ( $urs )) {
			$this->renderJSON ( array (
					"error" => "El usuario <b>" . $_POST ["usuario"] . " </b> ya existe. Ingrese otro nombre de usuario porfavor" 
			) );
		}
		
		$u = ( object ) array (
				"LGF0010012" => $_POST ["email"] 
		);
		
		$urs = (new Usuarios ())->obtenUsuario ( $u );
		if (! empty ( $urs )) {
			$this->renderJSON ( array (
					"error" => "El email <b>" . $_POST ["email"] . "</b> ya existe. Ingrese otro nombre de usuario porfavor" 
			) );
		}
		
		$u = ( object ) array (
				"LGF0010002" => $_POST ["nombre"],
				"LGF0010005" => $_POST ["usuario"],
				"LGF0010006" => $_POST ["password"],
				"LGF0010012" => $_POST ["email"],
				"LGF0010007" => 2,
				"LGF0010008" => 1,
				"LGF0010030" => date ( "Y-m-d" ),
				"LGF0010038" => $_SESSION ["idInstitucion"] 
		);
		
		$idUsuario = (new Usuarios ())->agregarUsuario ( $u );
		if ($idUsuario) {
			$_SESSION ["idUsuario"] = $idUsuario;
			$_SESSION ["tipoSesion"] = 1;
			$_SESSION ["userLogged"] = true;
			$_SESSION ["nombre"] = $_POST ["nombre"];
			$_SESSION ["idInstitucion"] = $_SESSION ["idInstitucion"];
			$_SESSION ["perfil"] = 2;
			(new LogController ())->logAccesoUser ();
			// $this->renderJSON ( array (
			// "mensaje" => "El se ha creado exitosamente"
			// ) );
			$this->renderJSON ( array (
					"ok" => CONTEXT . "home/menu" 
			) );
		} else {
			$this->renderJSON ( array (
					"error" => "El usuario no ha sido creado" 
			) );
		}
	}

	public function recuperaUsuario() {
		$usuario = $_POST['usuario'];
		# Buscar como usuario
		$usuarios = (new Usuarios())->obtenUsuario((object) array (
			"LGF0010005" => $usuario
		));
		# Buscar como cliente
		$clientes = (new Clientes())->obtenClientes((object) array (
			"LGF0280019" => $usuario
		));
		# Buscar como institucion
		$instituciones = (new Instituciones())->obtenInstitucion((object) array (
			"LGF0270024" => $usuario
		));
		/*echo "<pre>";
		print_r($usuarios);
		print_r($clientes);
		print_r($instituciones);
		echo "</pre>";*/
		if (count($usuarios) > 0) {
			$perfil = $usuarios[0]['LGF0010007'];
			$id = $usuarios[0]['LGF0010001'];
			$data = (new PasswordReset())->obtenerPassUsuario((object) array('LGF0330001' => $id, 'LGF0330003' => $perfil));
		}
		if (count($clientes) > 0) {
			$perfil = 3;
			$id = $clientes[0]['LGF0280001'];
			$data = (new PasswordReset())->obtenerPassUsuario((object) array('LGF0330001' => $id, 'LGF0330003' => $perfil));
		}

		if (count($instituciones) > 0) {
			$perfil = 4;
			$id = $instituciones[0]['LGF0270001'];
			$data = (new PasswordReset())->obtenerPassUsuario((object) array('LGF0330001' => $id, 'LGF0330003' => $perfil));
		}

		/*echo "<pre>";
		print_r($data);
		echo "</pre>";*/
		if (count($data) > 0) {
			$this->renderJSON(array("respuesta"=>0,"mensaje"=>"Tu contraseña actual es: ".$data[0]['LGF0330002']));
		} else {
			$this->renderJSON(array("respuesta"=>1,"mensaje"=>"El sistema no pudo encontrar tu usuario, envíanos un correo a la siguiente dirección para que podamos apoyarte: soporte@learnglishpro.com"));
		}
	}
}