<?php require('Redmoon_php/controlSesiones.inc');  ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Oficina</title>

<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>
<style type="text/css">

#DatosOficina{
	border:thin;
	
}
</style>

</head>

<body >
<?php require('cabecera.php'); ?>
<div id="documento">

<br/>
<br/>
<h4 align="center" class="Estilo1">Oficina</h4>
<div id="DatosOficina">
<div id="winPop">
<form id="form1" name="form1" method="post" action="Redmoon_php/ORAAddOficina.php">
	<p></p>
    <p>
 	 <label class="Estilo5">Oficina
    	<input name="inOficina" type="text" id="inOficina"  size="4" maxlength="4" style="position:absolute; left:110px;"/>
     </label>
     <label class="Estilo5" style="position:absolute; left:57%">e-mail
    	<input name="ineMail" type="text" id="ineMail" size="30" maxlength="50" style="position:absolute; left:70px; top:0px;"  />
     </label>
   </p>
   <p>
   	<label class="Estilo5" >Nombre
  		<input name="inNombre" type="text" id="inNombre" size="40" maxlength="50" style="position:absolute; left:110px;"/>
  	</label>
  	<label class="Estilo5" style="position:absolute; left:57%">Telefono
  		<input name="inTLF" type="text" id="inTLF" size="12" maxlength="12" style="position:absolute; left:70px; top:0px;" />
 	</label>
  	
  </p>
  <p>
    <label class="Estilo5">Dirección
   		 <input name="inDireccion" type="text" id="inDireccion" size="40" maxlength="50" style="position:absolute; left:110px;"/>
    </label>
    <label class="Estilo5" style="position:absolute; left:57%">Poblaci&oacute;n
    	<input name="inPoblacion" type="text" id="inPoblacion" size="25" maxlength="25" style="position:absolute; left:70px; top:0px;"/>
    </label>
   
  </p>
  <p>
      <label class="Estilo5" style="position:absolute; left:57%">CP
  		<input name="inCP" type="text" id="inCP" size="5" maxlength="5" style="position:absolute; left:70px; top:0px;"/>
  	</label> 
   <label class="Estilo5" >Provincia
    	<input type="text" name="inProvincia" id="inProvincia" size="40" maxlength="50" style="position:absolute; left:110px;"/>
    </label>

  </p>

  <p>
     <label class="Estilo5">Contacto
    		<input name="inContacto" type="text" id="inContacto" size="40" maxlength="40" style="position:absolute; left:110px;"/>
	 </label>
   
     <label class="Estilo5" style="position:absolute; left:57%">Ruta
    		<input name="inRuta" type="text" id="inRuta" size="30" maxlength="50" style="position:absolute; left:70px; top:0px;" />
    </label>
  </p>
    <p>
     
     <label class="Estilo5">Modo
   		<input name="inModo" type="text" id="inModo" size="40" maxlength="38" style="position:absolute; left:110px;"/>
    </label>
    <br/>
    <br/>
   
   
      
     
      
  </p>
  <p align="right">
   <input  name="submit" type="image" id="Grabar" value="Grabar"  src="Redmoon_img/imgDoc/aceptar.png"/>
  </p>

</form>
</div>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>




</div>
</body>
</html>