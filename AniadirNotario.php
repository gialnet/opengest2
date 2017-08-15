<?php require('Redmoon_php/controlSesiones.inc.php');  ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Notarios</title>
<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>
<style type="text/css">

#VentanaCuenta{
	position:absolute;
	top:240px;
	left:10px;
	height: 25px;
	width: 650px;
	
	
}
#DatosOficina{
	position:absolute;
	top:50px;
	border:thin;
	left:40px;
	
}
</style>
<script>

</script>
</head>

<body id="cuerpo" >
<?php require('cabecera.php'); ?>

<div id="documento">
  <div id="rastro"><a href="MenuAdmin.php">Inicio</a> >
      <a href="NotariosTabla2.php">Lista de Notarios</a> >
            Nuevo Notario
</div>
<div id="DatosOficina">
<div id="winPop">
<form id="form1" name="form1" method="post" action="Redmoon_php/ORAaddNotarios.php">
 <label class="Estilo2">Nombre
  <input name="inNombre" type="text" id="inNombre" size="40" maxlength="40" style="position:absolute; left:82px"/>
  </label>
  <label class="Estilo2" style="position:absolute; left:55%">NIF
  <input name="inNIF" type="text" id="inNIF" size="25" maxlength="14" style="position:absolute; left:68px" />
  </label>
 
  <p>
    <label class="Estilo2">Dirección
    <input name="inDireccion" type="text" id="inDireccion" size="40" maxlength="40" />
    </label>
    <label class="Estilo2" style="position:absolute; left:55%">Poblaci&oacute;n
    <input name="inPoblacion" type="text" id="inPoblacion" size="25" maxlength="25" />
    </label>
    
  </p>
  
    <p>
   <label class="Estilo2">CP
  <input name="inCP" type="text" id="inCP" size="14" maxlength="14" style="position:absolute; left:82px" />
   </label>
  <label class="Estilo2" style="position:absolute; left:55%">Provincia
    <input type="text" size="25" maxlength="25" name="inProvincia" id="inProvincia" style="position:absolute; left:68px" />
    </label>
 

  <p>
  	
    <label class="Estilo2">Entidad
    <input name="inEntidad" type="text" id="inEntidad" size="4" maxlength="4" />  </label>
    <label class="Estilo2">
    Oficina
    <input name="inOficina" type="text" id="inOficina" size="4" maxlength="4" />  </label>
    <label class="Estilo2">
    DC
    <input name="inDC" type="text" id="inDC" size="2" maxlength="2" />  </label>
    <label class="Estilo2">
    Número de Cuenta
    <input name="inCuenta" type="text" id="inCuenta" size="10" maxlength="10" /> 
    </label>
 
  </p>

  </p>
  <p align="right">  <input  name="submit" type="image" id="Grabar" value="Grabar"  src="Redmoon_img/imgDoc/aceptar.png"/>
      
      </p>

  
    
</form>

   </div>
<p>&nbsp;</p>
</div>
</div>
</body>
</html>
