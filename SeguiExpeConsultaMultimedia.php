<?php 

require('Redmoon_php/controlSesiones.inc.php');  
require('Redmoon_php/pebi_cn.inc.php');
require('Redmoon_php/pebi_db.inc.php'); 


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Subir archivo</title>
<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<style type="text/css">
#campos{
	position:absolute;
	left:20px;
		color: #3c4963;
	font-weight: bold;
}
#Estilo1 {
	color: #3c4963;
	font-weight: bold;
}
#Estilo2 {

	color: #36679f;
	margin: 4px 15px;
	cursor: pointer;
	font-weight: bold;
}
#color{
background-color: #fff;

}
#Estilo5 {color: #36679f; font-weight: bold; }
</style>
<script type="text/javascript">

function Cargar()
{
	document.getElementById("xIDExpe").value='<?php echo $_GET["xIDExpe"];?>';
}

</script>
</head>

<body onload="Cargar();" id="color">
<br />
  <div align="center" id="Estilo5">
  
  Anotaci&oacute;n (y/o) Adjuntar Archivo Multimedia</div>
    <form target="SubirFile" id="form1" action="subirFile/upload.php" method="post" enctype="multipart/form-data">
    <p>
    <label id="campos">
      Descripción
        <input style="position:absolute ; left:110px;" name="xComentario" type="text" id="xComentario" size="50" maxlength="50" />
        </label>
        <br />
         <br />
         <label id="campos" >
      Fichero adjunto
    <input style="position:absolute ; left:110px;" size="33" type="file" name="FicheroAdjunto" id="FicheroAdjunto" />
    <input type="hidden" name="xIDExpe" id="xIDExpe" />
    </label>
    </p>
    <br />
    
    <p style="position:absolute ; left:394px;">
    <input type="image" name="EnviarComet" id="EnviarComet" value="Enviar" src="<?php echo IMAGENES;?>/imgDoc/aceptar.png"/>
    </p>
   
  </form>

</body>
</html>
