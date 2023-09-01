<?php	
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
	sendotp();
	function sendOTP() 
	{
		$message_registration = "Your One Time Password for Food donation NGO Authentication is:<br/><br/><b>" . $otp . "</b>";
		$message_password_reset = "Your One Time Password for Password Reset is:<br/><br/><b>" . 123456 . "</b>";
		$message_body = $is_password_reset ? $message_password_reset : $message_registration;
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPDebug = 0;
		$mail->SMTPAuth = TRUE;
		$mail->SMTPSecure = "ssl";
		$mail->Port       = 465;
		$mail->Username   = 'fooddonation.ngo2@gmail.com';                     //SMTP username
		$mail->Password   = 'fooddonationngo@2';                
		$mail->Host       = 'smtp.gmail.com';

		$mail->SetFrom('fooddonation.ngo2@gmail.com', 'Food Donation NGO');
		$mail->AddAddress('hemang.bhagat007@gmail.com');
		$mail->MsgHTML($message_body);
		$mail->IsHTML(true);		
		$result = $mail->Send();
		
		return $result;
	}
?>