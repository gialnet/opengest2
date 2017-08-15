<?php

require_once('Redmoon_php/controlSesiones.inc.php');
require_once('Redmoon_php/pebi_cn.inc.php');
require_once('Redmoon_php/pebi_db.inc.php');

$conn = db_connect();

$sql = 'select nombre from COLABORADORES_TIPO';
	$stid = oci_parse($conn, $sql);   
	
	$r = oci_execute($stid, OCI_DEFAULT);
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>A&ntilde;adir Cliente Preferente</title>

<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>

<style type="text/css">

#DatosCOlabora{
position:absolute;
top:100px;

	width:720px;
	height:670px;
	border:thin;
	margin:15px 15px;
	padding:35px 25px;
	background-color: #FFFFCC;
}
.Estilo1 {
	color: #3c4963;
	font-weight: bold;
}
.Estilo2 {

	color: #36679f;
	font-weight: bold;
}
</style>
</head>

<body >
<?php require('cabecera.php'); ?>

<div id="documento">
<br/>
<br/>
<h4 align="center" class="Estilo1">A&ntilde;adir Cliente Preferente</h4>
<div id="DatosCOlabora">
<form id="form1" name="form1" method="post" action="Redmoon_php/ORA_AniadirClientePreferente.php">
	
    <h3><span class="Estilo1">
     <label><span class="Estilo1">Datos Solicitante, persona física o jurídica</span></label>
   </span></h3>
    <span style="color: #36679f">
    <label id="laNIF" style="color:#36679f">NIF/CIF/NIE</label>
    </span>
<input name="xNif" type="text" id="inNif" onblur="BuscaNIF();" size="14" maxlength="14" />
    <label id="laNOMBRE" style="color:#36679f">Apellidos y Nombre</label>
    <input name="xNOMBRE" type="text" id="inNombre" size="40" maxlength="40" />
      <p>
<label id="laNacionalidad" style="color:#36679f"> Nacionalidad</label>
      <input name="xNacionalidad" type="text" id="inNacionalidad" value="ESPAÑOLA" size="25" maxlength="25" />
</p>
    <h3>
    <span class="Estilo1">
    <label id="laLUGAR" >Lugar y fecha de Nacimiento.</label></span>
  </h3>
  <p>
    <label style="color:#36679f">País</label>
    <input name="xPaisOrigen" type="text" id="inPaisOrigen" size="20" maxlength="20" />
    <label style="color:#36679f">Fecha</label>
    <input name="xFecha" type="text" id="inFecha" />
  </p>
  <h3>
  <span class="Estilo1">
  <label id="laDOMICILIO" >Domicilio a efectos de Comunicación Postal.</label>
  </span>
  </h3>
  <p>
    <label style="color:#36679f">País</label>
    <input name="xPaisDomicilio" type="text" id="inPaisDomicilio" value="ESPAÑA" size="20" maxlength="20" />
    <label style="color:#36679f">Población</label>
    <input name="xPoblacion" type="text" id="inPoblacion" size="25" maxlength="25" />
  </p>
  <p>
  <label style="color:#36679f">Calle y número</label>
  <input name="xDireccion" type="text" id="inDireccion" onblur="showAddress(17);" size="50" maxlength="40" />
  </p>
  <p>
    <label style="color:#36679f">Portal, Escalera, Planta, Puerta</label>
    <input name="xPortal" type="text" id="inPortal" size="34" maxlength="25" />
  </p>
  <h3><span class="Estilo1"><label>Dirección Electrónica.</label></span></h3>
  <p>
  <label style="color:#36679f">Correo electrónico</label>
  <input name="xEmail" type="text" id="inEmail" size="30" maxlength="30" />
    <label style="color:#36679f">Teléfono
      <input name="xTelefono" type="text" id="inTelefono" size="10" maxlength="10" />
    </label>
    <label style="color:#36679f">Móvil
      <input name="xMovil" type="text" id="inMovil" size="10" maxlength="10" />
    </label>
  </p>
  <h3>
  <span class="Estilo1">
  <label >Situacion Legal.</label></span>
  </h3>
    <label style="color:#36679f">Estado Civil</label>
    <input type="text" name="xEstadoCivil" id="inEstadoCivil" />
    <label style="color:#36679f">Régimen Económico</label>
    <select name="xRegimenEconomico" id="inRegimenEconomico">
      <option selected="selected">bienes gananciales</option>
      <option>separación de bienes</option>
    </select>
    <br/>
     <br/>
  <label style="color:#36679f">Profesión</label>
  <input type="text" name="xProfesion" id="inProfesion" />
  <h3>
  <span class="Estilo1">
  <label >
  Códigos de Identificación.</label></span></h3>
<p>
    <label style="color:#36679f">Código Cliente
    <input name="xCodigoCliente" type="text" id="inCodigoCliente" size="25" maxlength="25" />
    </label>
  </p>
  <p>
    <label style="color:#36679f">N&uacute;mero de Cuenta
    <input name="xEntidad" type="text" id="incuenta"  size="20" maxlength="20" />
    </label>

  </p>
  <p align="center">
<input  name="submit" type="image"  value="A&ntilde;adir Cuenta" src="Redmoon_img/aceptar2.png"/>
  </p>

</form>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>


</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
</div>
</body>
</html>