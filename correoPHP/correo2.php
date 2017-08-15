<?
   //Es necesario que al menos halla una dirección de destino
   $error="";

   if ($enviar) {
      if ((!$email1) && (!$email2)) {
	$error.="Debe indicar al menos una dirección de destino";
      }
   }
	
   if ($enviar && !$error) {

      //creamos un array que estará formado por las direcciones de destino
      if ($email1) {
	$direcciones["direccion1"]=$email1;
      }
      if ($email2) {
	$direcciones["direccion2"]=$email2;
      }

	
      //pasamos a enviar el correo

      // primero hay que incluir la clase phpmailer para poder instanciar 
      //un objeto de la misma
      require "class.phpmailer.php";

      //instanciamos un objeto de la clase phpmailer al que llamamos 
      //por ejemplo mail
      $mail = new phpmailer();

      //Definimos las propiedades y llamamos a los métodos 
      //correspondientes del objeto mail

      //Con PluginDir le indicamos a la clase phpmailer donde se 
      //encuentra la clase smtp que como he comentado al principio de 
      //este ejemplo va a estar en el subdirectorio includes
	  
      //$mail->PluginDir = "includes/";

      //Con la propiedad Mailer le indicamos que vamos a usar un 
      //servidor smtp                            
      $mail->Mailer = "smtp";

      //Asignamos a Host el nombre de nuestro servidor smtp
      $mail->Host = "smtp.gialnet.com";
      
      //Le indicamos que el servidor smtp requiere autenticación
      $mail->SMTPAuth = true;

      //Le decimos cual es nuestro nombre de usuario y password
      $mail->Username = "abo033c";
      $mail->Password = "Redmoon2010";
      
      //Indicamos cual es nuestra dirección de correo y el nombre que 
      //queremos que vea el usuario que lee nuestro correo
      $mail->From = "antonio.gialnet@gmail.com";

      $mail->FromName = "Antonio Perez";

      //Asignamos asunto y cuerpo del mensaje
      //El cuerpo del mensaje lo ponemos en formato html, haciendo 
      //que se vea en negrita
      $mail->Subject = "Prueba de phpmailer";
      $mail->Body = "<b>Mensaje de prueba mandado con phpmailer  en formato html</b>";

      //Definimos AltBody por si el destinatario del correo no admite 
      //email con formato html
      $mail->AltBody ="Mensaje de prueba mandado con phpmailer en formato texto";

      //el valor por defecto 10 de Timeout es un poco escaso dado que voy a usar 
      //una cuenta gratuita y voy a usar attachments, por tanto lo pongo a 120  
      $mail->Timeout=120;

      //Indicamos el fichero a adjuntar si el usuario seleccionó uno en el formulario
      if ($achivo !="none") {
	$mail->AddAttachment($archivo,$archivo_name);
      }

      //Indicamos cuales son las direcciones de destino del correo y enviamos 
      //los mensajes
      reset($direcciones);
      while (list($clave, $valor)=each($direcciones)) {
	$mail->AddAddress($valor);

	//se envia el mensaje, si no ha habido problemas la variable $success 
	//tendra el valor true
	$exito = $mail->Send();

	//Si el mensaje no ha podido ser enviado se realizaran 4 intentos mas 
	//como mucho para intentar enviar el mensaje, cada intento se hara 5 s
	//segundos despues del anterior, para ello se usa la funcion sleep
 	$intentos=1; 
   	while((!$exito)&&($intentos<5)&&($mail->ErrorInfo!="SMTP Error: Data not accepted")){
	   sleep(5);
     	   //echo $mail->ErrorInfo;
     	   $exito = $mail->Send();
     	   $intentos=$intentos+1;				
   	}

	//La clase phpmailer tiene un pequeño bug y es que cuando envia un mail con
	//attachment la variable ErrorInfo adquiere el valor Data not accepted, dicho 
	//valor no debe confundirnos ya que el mensaje ha sido enviado correctamente
	if ($mail->ErrorInfo=="SMTP Error: Data not accepted") {
	   $exito=true;
        }
		
	if(!$exito)
	{
	   echo "Problemas enviando correo electrónico a ".$valor;
	   echo "<br>".$mail->ErrorInfo;	
	}
	else
	{
	   //Mostramos un mensaje indicando las direccion de 
	   //destino y fichero  adjunto enviado en el mensaje	
	   $mensaje="<p>Has enviado un mensaje a:<br>";
	   $mensaje.=$valor." ";
	   if ($archivo !="none") {
		$mensaje.="Con un fichero adjunto llamado ".$archivo_name;
	   }
	   $mensaje.="</p>";
     	   echo $mensaje;


	}
	// Borro las direcciones de destino establecidas anteriormente
    	$mail->ClearAddresses();
	
	}
	echo "<a href='$PHP_SELF'> VOLVER AL FORMULARIO</a>";
   }
   else {
   ?>

   <HTML>
   <BODY>
   <? If ($error) echo "<font color='red'>$error</font>";?>
   <FORM ENCTYPE="multipart/form-data" METHOD="post" ACTION="<?=$PHP_SELF?>">
   <TABLE BORDER=0 ALIGN="CENTER">
    <TR>
      <TD>Direccion de destino1:</TD>
      <TD><INPUT TYPE="text" NAME="email1" MAXLENGTH="30" SIZE="35"></TD>
    </TR>
      <TD>Direccion de destino2:</TD> 
      <TD><INPUT TYPE="text" NAME="email2" MAXLENGTH="35" SIZE="35"></TD>
    </TR>
      <TD>Fichero adjunto:</TD>
      <input type="hidden" name="MAX_FILE_SIZE" value="307200">
      <TD><INPUT TYPE="file" NAME="archivo" SIZE="35"></TD>
    </TR>
    <TR>
      <TD COLSPAN="2" ALIGN="CENTER"><INPUT TYPE="submit" VALUE="Enviar" name="enviar"></TD>
    </TR>
    </TABLE>
   </FORM>
   </BODY>
   </HTML>
   <?
   }
?>