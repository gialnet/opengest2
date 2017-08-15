<?php
require("class.phpmailer.php");
$mail = new PHPMailer();
$mail->IsSMTP();                                      // set mailer to use SMTP
$mail->Host = "smtp.gialnet.com";  // specify main and backup server
$mail->SMTPAuth = true;     // turn on SMTP authentication
$mail->Port = 25;
$mail->Username = "abo033c";  // SMTP username
$mail->Password = "Redmoon2010"; // SMTP password
$mail->From = "antonio@gialnet.com";
$mail->FromName = "Antonio desde PHPMailer";
$mail->AddAddress("antonio.gialnet@gmail.com");
$mail->WordWrap = 50;                                 // set word wrap to 50 characters
//$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
//$mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
$mail->IsHTML(true);                                  // set email format to HTML
$mail->Subject = "Asunto del e-mail";
$mail->Body    = "Cuerpo del mensaje en HTML<b>en negrita</b>";
$mail->AltBody = "This is the body in plain text for non-HTML mail clients";
$mail->AddAttachment('solicitudProvisionyTramitacion.pdf');
if(!$mail->Send()){
   echo "Message could not be sent. <p>";
   echo "Mailer Error: " . $mail->ErrorInfo;
   exit;
}
echo "Message has been sent";
?>
