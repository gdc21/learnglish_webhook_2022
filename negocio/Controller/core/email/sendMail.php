<?php
require_once 'email.php';
require_once("PHPMailerAutoload.php");

/**
 *
 * Class sendMail, envia correos electronicos, utiliza la clase email para cargar la informacion del correo que se enviara.
 * @author J Carlos Alcantara M
 * 
 *
 */

class sendMail{
	
	/**
	 * 
	 * @param email $param
	 * @return number, 1 exito, 0 falla, -1 excepcion
	 * @author J Carlos Alcantara M
	 */
	public function sendMail(email $param,&$res){
		$mail = new PHPMailer();
		
// 		$mail->SMTPSecure = "tls";
// 		$mail->Host       = "smtp.gmail.com";
// 		$mail->Port       = 587;
// 		$mail->Username   = "example@gmail.com"; 
// 		$mail->Password   = "example";
 		$mail->SMTPAuth = false;
 		//$mail->SMTPDebug  = 4;
		$mail->CharSet = "utf-8";
		$mail->Host     = $param->Host;
		$mail->Username = $param->Username;
		$mail->Password = $param->Password;
		$mail->From     = $param->From;
		$mail->FromName = $param->FromName;
		$mail->AddAddress($param->AddAddress);
		$mail->WordWrap = 50;
		$mail->Subject  =  $param->Subject;
		$mail->MsgHTML($param->Body);
		//$mail->Body     =  $param->Body;
		$mail->Priority =  $param->Priority;
		$mail->Port = PORT;
		$mail->Mailer = SMTP_TYPE;
		$mail->IsHTML(true);
		
		if(!empty($param->stringFile )){
			$mail->addStringAttachment($param->stringFile["string"], $param->stringFile["filename"]);
		}
		
		if(!empty($param->File)){
			
			$mail->addAttachment($param->File[0],$param->File[1],'base64',$param->File[2],  'attachment');
		}
		
		
		try {
			if($mail->Send()) // Intenta enviar el mensaje
			{
				$res =  1; // Regresa 1 si el envio fue exitoso
			}else{
				$res =  0; // Regresa 0 si el envio fallo
			}
			
		} catch (Exception $e) {
			//echo $e->getMessage();
			$res =  -1; // Regresa -1 si genero una excepcion
		}
	}
}
?>