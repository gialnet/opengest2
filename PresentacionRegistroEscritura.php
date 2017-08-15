<?php require_once('Redmoon_php/controlSesiones.inc.php');  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Registrar Escritura</title>
<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>

</head>

<body >
<?php require('cabecera.php'); ?>
    <div id="documento">
      <br />
      <br />
        <h4 align="center"><span class="Estilo1">Presentación en el registro de la escritura</h4>
        
     
        <h1>&nbsp;</h1>
         <form id="foRegistrarEscrituras" name="foRegistrarEscrituras" action="Redmoon_php/ORARegistrarEscrituras.php" method="POST">

         
          <p align="left" class="Estilo5" style="position:absolute; left:40px; top:110px;">Fecha de la presentaciÃ³n (DD/MM/AA):
            <input type="text" name="fecha_registro" id="fecha_registro" />
          </p>
          <p>&nbsp; </p>
          <p align="center">
            <input type="hidden" name="xIDExpe" value="<?php echo $_GET['xIDExpe'];?>" />
           <input style="position:absolute; left:470px; top:110px;"  name="submit" type="image" id="PasarDeFase" value="PasarDeFase"  src="Redmoon_img/aceptar2.png"/>
            <br />
           
            
</p>
        </form>
</div>
   
  
    </body>
</html>
