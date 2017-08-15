<?php require('Redmoon_php/controlSesiones.inc.php');  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Introducción Impuesto</title>

<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>
</head>

<body >
<?php require('cabecera.php'); ?>
    
<div id="documento">
<br/>
<br/>
  <h4 align="center" class="Estilo1"> Introducci&oacute;n del coste del impuesto</h4>
       
    
       
        <form id="foCosteImpuesto" name="foCosteImpuesto" action="Redmoon_php/ORACosteImpuesto.php" method="POST">

          <p align="center">&nbsp;</p>
          <p><label style="position:absolute; left:50px;" class="Estilo5">Importe del impuesto:
            <input type="text" name="importe" id="importe" style="position:absolute; left:150px;"/>
            </label >
            <input style="position:absolute; left:350px; top:120px;"  name="submit" type="image" id="PasarDeFase" value="PasarDeFase"  src="Redmoon_img/aceptar2.png"/>
            <br />
          </p>
          
         
       
           <input type="hidden" name="xIDExpe" id="xIDExpe" value="<?php echo $_GET['xIDExpe'];?>" />    
           
           
            

        </form>
        <p>&nbsp;</p>
    
    
<!-- end #container --></div>

    </body>
</html>
