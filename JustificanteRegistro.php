<?php require_once('Redmoon_php/controlSesiones.inc.php');  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Envío de la Escritura Original</title>
<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>

</head>

<body >
 <?php require('cabecera.php'); ?>
    <div id="documento">
      <br/>
      <br/>
        <h4 align="center" class="Estilo1">Envío de la escritura original a la oficina</h4>

      
      <form id="foJustificante" name="foJustificante" action="Redmoon_php/ORAJustificante.php" method="post" enctype="multipart/form-data" >
          <p>&nbsp;</p>
          <p class="Estilo5">Adjunte el justificante de pago digitalizado (tif, gif o jpg):
         
            <input type="file" name="DocAdjunto" id="DocAdjunto" />
          </p>
           <br />
          <p align="center">
              <input style="position:absolute; left:350px; "  name="submit" type="image" id="pasar_fase" value="pasar_fase"  src="Redmoon_img/aceptar2.png"/><input type="hidden" name="action" value="registro" />
            <input type="hidden" name="xIDExpe" value="<?php echo $_GET['xIDExpe'];?>" />
          </p>
          <br />
        </form>
      
</div>

    </body>
</html>
