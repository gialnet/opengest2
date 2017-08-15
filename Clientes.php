<?php require('Redmoon_php/controlSesiones.inc.php');  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Clientes</title>

<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<link href="Redmoon_ccs/cargando.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>
<script src="Redmoon_js/Solicitantes.js" type="text/javascript"></script>
<script>
function Cargar()
{
	document.getElementById('inNif').value="<?php echo $_GET['xNIF']; ?>";
	BuscaNIF();
}
</script>
</head>


<body  onload="Cargar();">
<?php require('cabecera.php'); ?>
<div id="documento">
<br />
<br />
<form id="foFormMapa" name="formMapa" method="get" action="#">
   <h3><span class="Estilo1"><label>Datos Solicitante, persona física o jurídica.</label></span></h3>
    <label id="laNIF" class="Estilo5">NIF/CIF/NIE</label>
    <input name="xNif" type="text" id="inNif" onblur="BuscaNIF();" size="14" maxlength="14" />
    <label class="Estilo5" id="laNOMBRE">Apellidos y Nombre</label>
    <input name="xNOMBRE" type="text" id="inNombre" size="40" maxlength="40" />
      <p>
<label class="Estilo5" id="laNacionalidad"> Nacionalidad</label>
      <input name="xNacionalidad" type="text" class="formInputText" id="inNacionalidad" value="ESPAÑOLA" size="25" maxlength="25" />
</p>
    <h3>
    <span class="Estilo1">
    <label id="laLUGAR">Lugar y fecha de Nacimiento.</label></span>
  </h3>
  <p>
    <label class="Estilo5">País</label>
    <input name="xPaisOrigen" type="text" id="inPaisOrigen" size="20" maxlength="20" />
    <label class="Estilo5">Fecha</label>
    <input name="xFecha" type="text" id="inFecha" />
  </p>
  <h3>
  <span class="Estilo1">
  <label id="laDOMICILIO">Domicilio a efectos de Comunicación Postal.</label>
  </span>
  </h3>
  <p>
    <label class="Estilo5">País</label>
    <input name="xPaisDomicilio" type="text" id="inPaisDomicilio" value="ESPAÑA" size="20" maxlength="20" />
    <label class="Estilo5">Población</label>
    <input name="xPoblacion" type="text" id="inPoblacion" size="25" maxlength="25" />
  </p>
  <p>
  <label class="Estilo5">Calle y número</label>
  <input name="xDireccion" type="text" id="inDireccion" size="50" maxlength="40" />
  </p>
  <p>
    <label class="Estilo5">Portal, Escalera, Planta, Puerta</label>
    <input name="xPortal" type="text" id="inPortal" size="34" maxlength="25" />
  </p>
  <h3><span class="Estilo1"><label>Dirección Electrónica.</label></span></h3>
  <p>
  <label class="Estilo5">Correo electrónico</label>
  <input name="xEmail" type="text" id="inEmail" size="30" maxlength="30" />
    <label class="Estilo5">Teléfono
      <input name="xTelefono" type="text" id="inTelefono" size="10" maxlength="10" />
    </label>
    <label class="Estilo5">Móvil
      <input name="xMovil" type="text" id="inMovil" size="10" maxlength="10" />
    </label>
  </p>
  <h3>
  <span class="Estilo1">
  <label>Situacion Legal.</label></span>
  </h3>
    <label class="Estilo5">Estado Civil</label>
    <input type="text" name="xEstadoCivil" id="inEstadoCivil" />
    <label class="Estilo5">Régimen Económico</label>
    <select name="xRegimenEconomico" id="inRegimenEconomico">
      <option selected="selected">bienes gananciales</option>
      <option>separación de bienes</option>
    </select>
  <label class="Estilo5">Profesión</label>
  <input type="text" name="xProfesion" id="inProfesion" />
  <h3>
  <span class="Estilo1">
  <label>
  Códigos de Identificación.</label></span></h3>
<p>
    <label class="Estilo5">Código Cliente
    <input name="xCodigoCliente" type="text" id="inCodigoCliente" size="25" maxlength="25" />
    </label>
     <label class="Estilo5">
    <input type="checkbox" id="idEmpleado" name="idEmpleado" />Empleado de la entidad</label>
  </p>
  <p>
    <label class="Estilo5">Entidad
    <input name="xEntidad" type="text" id="inEntidad" size="4" maxlength="4" />
    </label>
    <label class="Estilo5">Oficina
    <input name="xOficina" type="text" id="inOficina" size="4" maxlength="4" />
    </label>
    <label class="Estilo5">DC
    <input name="xDc" type="text" id="inDc" size="2" maxlength="2" />
    </label>
    <label class="Estilo5">Cuenta
    <input name="xCuenta" type="text" id="inCuenta" size="10" maxlength="10" />
    </label>
  </p>
  <p>
  <input type="hidden" name="xLatitud" id="inLatitud"/>
  <input type="hidden" name="xLongitud" id="inLongitud"/>
  <input type="hidden" name="xIDExpe" id="inIDExpe" />
  <input type="hidden" name="xTipoTercero" id="inTipoTercero" value="N" />
  
 
  </p>
  <p align="center"> <input  name="Grabar" type="button" id="Grabar" value="Grabar" onclick="GrabaCliente()" src="Redmoon_img/aceptar2.png"/></p>
  <p>&nbsp;</p>
</form>
</div>
<div id="Cargando">
<img src="Redmoon_img/Cargando.gif" alt="Guardando" width="25" height="25" longdesc="Guardando datos" /> 
<p>Guardando datos...</p>
</div>

</body>
</html>
