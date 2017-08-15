<?php require_once('Redmoon_php/controlSesiones.inc.php');  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pago y Retirada de las Escrituras</title>
<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>

</head>

<body >

    <?php require('cabecera.php'); ?>
      <div id="documento">
      <br/>
      <br/>
      <form id="foJustificante" name="foJustificante" action="Redmoon_php/ORAJustificante.php" method="post" enctype="multipart/form-data" >
        <h4 align="center" class="Estilo1">Confirmar pago y retirada de las escrituras</h4>
     

       
       
          <p class="Estilo5"><strong>Fecha real de recogida de las escrituras(dd/mm/aaaa):</strong>
            <input type="text" name="fecha_recogida" id="fecha_recogida" style="position:absolute; left:400px;" />
          </p>
          <p class="Estilo5"><strong>Adjunte la factura de la escritura digitalizada (tif, pdf o jpg):</strong>
        	 <input type="file" name="DocAdjunto" id="DocAdjunto"/>
          </p>
          
        
           
          <p align="center">
             <input style="position:absolute; left:350px; "  name="submit" type="image" id="pasar_fase" value="pasar_fase"  src="Redmoon_img/aceptar2.png"/>
            <input type="hidden" name="action" value="notaria" />
            <input type="hidden" name="xIDExpe" value="<?php echo $_GET['xIDExpe'];?>" />
          </p>
        </form>
       
   </div>
   
    
   <div align="center">&copy; 2008 Redmoon Consultores</div>
    </body>
</html>
