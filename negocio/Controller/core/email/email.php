<?php
/**
 *
 * Class email
 * @author J Carlos Alcantara M
 *
 *
 */

class email{
	/**
	 * Servidor de salida, reemplazar mail.tuservidor.net por su dominio
	 * @var string
	 */
	public $Host;
	/**
	 * username o email de la cuenta que se usara para enviar los mensajes.
	 * @var string
	 */
	public $Username;
	/**
	 * Contrase�a de la cuenta de correo.
	 * @var string
	 */
	public $Password;
	/**
	 * Mail del remitente.
	 * @var string
	 */
	public $From;
	/**
	 * Nombre del formulario.
	 * @var string
	 */
	public $FromName;
	/**
	 * email del destinatario
	 * @var string
	 */
	public $AddAddress;
	/**
	 * Titulo del e-mail.
	 * @var string
	 */
	public $Subject;
	/**
	 * Mensaje en html del e-mail.
	 * @var string
	 */
	public $Body;
	/**
	 * Prioridad del mensaje (1 = High, 3 = Normal, 5 = low).
	 * @var int
	 */
	public $Priority;
	
	
	/**
	 * Adjunta en un array(PATHARCHIVO,NOMBREARCHIVO,MIMETYPE)
	 * @var array
	 */
	public $File;
	
	/**
	 * Adjunta en un array(StringFile,NOMBREARCHIVO,MIMETYPE)
	 * @var array
	 */
	public $stringFile;
	
	
}
?>