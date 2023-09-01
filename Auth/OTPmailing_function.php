<?php	
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

	function sendOTP($email,$OTP,$is_password_reset)
	{
		echo " sending mail ";
		$message_registration = "Your One Time Password for Food donation NGO Authentication is:<br/><br/><b>" . $OTP . "</b>";
		$message_password_reset = "Your One Time Password for Password Reset is:<br/><br/><b>" . $OTP . "</b>";
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
		$mail->AddAddress($email);
		$mail->Subject = $is_password_reset ? "OTP for password reset": "OTP for completing Food donation registration";
		$mail->MsgHTML($message_body);
		$mail->IsHTML(true);		
		$result = $mail->Send();
		
		return $result;
	}
?>