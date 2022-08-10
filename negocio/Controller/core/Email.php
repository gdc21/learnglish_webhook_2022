<?php
class Email{
	/**
	 * Llama a la función que se encarga del envio del email
	 *
	 * @param string $dest
	 * @param string $subject
	 * @param string $msj
	 * @param int $priority
	 * @return boolean
	 */
	public function sendMail($dest, $subject, $msj, $priority = 1, $file = null) {
		if (! $this->isSMTPON ()) {
			return false;
		}
		include_once MAIL . 'email.php';
		include_once MAIL . 'sendMail.php';
		$mail = new email ();
		$mail->Host = SERV_SMTP;
		$mail->Username = USER_SMTP;
		$mail->Password = PDW_SMTP;
		$mail->From = USER_SMTP;
		$mail->FromName = $subject;
		$mail->AddAddress = $dest;
		$mail->Subject = $subject;
		$mail->Body = $msj;
		$mail->Priority = $priority;
		$mail->File = $file;
		$send = new sendMail ( $mail, $res );
		if ($res === 1) {
			return true;
		}
		return false;
	}
	
}
?>