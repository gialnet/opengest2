<?php
require("class.phpmailer.php");

// recibe dos parametros destinatario de correo y nombre del titular
$xMail=$_POST["xMail"];
$xNombre=$_POST["xNombre"];

$asunto='Expediente de mayor cuantia revisado';
$cuerpo_mensaje="El expediente de $xNombre ha sido revisado por nuestros consultores senior y esta listo para la firma del cliente";
//$xMail="antonio.gialnet@gmail.com";

$mail = new PHPMailer();
$mail->IsSMTP();                                      // set mailer to use SMTP
$mail->Host = "smtp.gialnet.com";  // specify main and backup server
$mail->SMTPAuth = true;     // turn on SMTP authentication
$mail->Port = 25;
$mail->Username = "abo033c";  // SMTP username
$mail->Password = "Redmoon2010"; // SMTP password
$mail->From = "antonio@gialnet.com";
$mail->FromName = "Antonio desde PHPMailer";
$mail->AddAddress($xMail);
$mail->WordWrap = 50;                                 // set word wrap to 50 characters
//$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
//$mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
$mail->IsHTML(true);                                  // set email format to HTML
$mail->Subject = $asunto;
$mail->AltBody = $cuerpo_mensaje;
$mail->Body = "<b>".$cuerpo_mensaje."</b>";
//$mail->MsgHTML(file_get_contents('email_ExpeRevisadoGestoras.html'));
//$mail->AddAttachment('solicitudProvisionyTramitacion.pdf');
if(!$mail->Send()){
   echo "El mensage no se pudo enviar. <p>";
   echo "Mailer Error: " . $mail->ErrorInfo;
   exit;
}
echo "El menssaje ha sido enviado";
?>
