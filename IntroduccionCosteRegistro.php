<?php require('Redmoon_php/controlSesiones.inc.php');  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Introducción del Coste del Registro</title>
<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>

</head>
<body >
<?php require('cabecera.php'); ?>
    <div id="documento">
 <br/>
 <br/>
        <h4 align="center" class="Estilo1">Fase de la tramitaci&oacute;n: Introducci&oacute;n del Coste del Registro</h4>
        
      <p>&nbsp;</p>
        <form id="formcostereg" name="formcostereg" method="POST" action="Redmoon_php/ORACosteRegistro.php">
         
          <p><label class="Estilo5" style="position:absolute; left:150px;">Importe:
            <input style="position:absolute; left:300px" type="text" name="importe" id="importe" />
              </label>
          </p>
         <br /> 
          <br /> 
          <p><label class="Estilo5" style="position:absolute; left:150px;">Fecha probable de recogida de la escritura:
              <input style="position:absolute; left:300px;" type="text" name="fecha_reco_escritura" id="fecha_reco_escritura " />
              </label>
          </p>
        <h3 align="right">
          <input type="hidden" name="xIDExpe" value="<?php echo $_GET['xIDExpe'];?>" />
           <br /> 
             <br /> 
        <p align="center">
          
           <input style="position:absolute; left:350px; "  name="submit" type="image" id="pasar_fase" value="pasar_fase"  src="Redmoon_img/aceptar2.png"/>
          </p>
        </h3>
         </form>
        
        
        
      
        
    
  
        <p>&nbsp;</p>
       </div>

    <div align="center">&copy; 2008 Redmoon Consultores</div>
    </body>
 
    
</html>
