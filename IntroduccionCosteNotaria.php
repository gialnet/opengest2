<?php require('Redmoon_php/controlSesiones.inc.php');  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Coste de la Escritura</title>

<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>
</head>

<body >
<?php require('cabecera.php'); ?>
   
      <div id="documento">
 
          
         <br/>
         <br/>
        <h4 align="center" class="Estilo1">Fase de la tramitación: Introducción del coste de la escritura</h4>
   
       <p>&nbsp;</p>
       <form id="foCosteNotaria" name="foCosteNotaria" action="Redmoon_php/ORACosteNotaria.php" method="POST">
         <p> <label class="Estilo5" style="position:absolute; left:10px">Importe del notario:
			<input type="text" name="coste" id="coste" style="position:absolute; left:170px" />
          </label>
            <label class="Estilo5" style="position:absolute; left:53%">Número de protocolo:
            <input type="text" name="protocol" id="protocol" style="position:absolute; left:187px" />
          </label>
          </p>
          <br />
           <br />
         <p>
                     <label class="Estilo5" style="position:absolute;  left:10px">N.escrituras resultantes:
            <input type="text" name="n_escrituras" id="n_escrituras" style="position:absolute; left:170px" />
            </label>
           
           <label class="Estilo5" style="position:absolute; left:53%">Fecha prevista de recogida:
            <input type="text" name="fecha" id="fecha" />
           </label>
          </p>
         
           <br />
            <br />
              <input style="position:absolute; left:350px; "  name="submit" type="image" id="PasarDeFase" value="PasarDeFase"  src="Redmoon_img/aceptar2.png"/>
        <input type="hidden" name="xIDExpe" id="xIDExpe" value="<?php echo $_GET['xIDExpe'];?>" />    
            
         
        
        <p>&nbsp;</p>
        
        </form>
          <br />
      
 
     </div>
    
     
  
    <div align="center">&copy; 2008 Redmoon Consultores</div>
    </body>
</html>
