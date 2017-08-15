<?php

require_once('Redmoon_php/controlSesiones.inc.php');
require_once('Redmoon_php/pebi_cn.inc.php');
require_once('Redmoon_php/pebi_db.inc.php');

if(isset($_GET["xIDNotario"]))
{
// Create a database connection
//$conn = oci_connect('lgs','a1','//cajalgs.no-ip.org/lgs');
$conn = db_connect();
$sql='SELECT * FROM Notarios where COD_NOTARIO=:xIDNotario';
$stid = oci_parse($conn, $sql);
oci_bind_by_name($stid, ':xIDNotario', $xIDNotario, 14, SQLT_CHR);
$xIDNotario = $_GET["xIDNotario"];

$r = oci_execute($stid, OCI_DEFAULT);
}
?>
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
	top:230px;
	height: 50px;
	width: 700px;
	
	 border:solid 1px;
	 border-color:#ebebeb;
	margin:15px 15px;
	padding:15px 25px;
	
	background-color: #FFFFCC;
}
</style>
<script>
function LeeNotario()
{
	<?php
	$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
	$xNombre = htmlspecialchars($row['NOMBRE'], ENT_NOQUOTES);
	$xDireccion = htmlspecialchars($row['DIRECCION'], ENT_NOQUOTES);
	$xPoblacion = htmlspecialchars($row['POBLACION'], ENT_NOQUOTES);
	$xProvincia = htmlspecialchars($row['PROVINCIA'], ENT_NOQUOTES);
	?>
	document.getElementById('inNIF').value="<?php echo $row['NIF']; ?>";
	document.getElementById('inCP').value="<?php echo $row['COD_POSTAL']; ?>";
	document.getElementById('inNombre').value="<?php echo iconv ('Windows-1252', 'UTF-8//TRANSLIT',$xNombre); ?>";
	document.getElementById('inDireccion').value="<?php echo iconv ('Windows-1252', 'UTF-8//TRANSLIT',$xDireccion); ?>";
	document.getElementById('inPoblacion').value="<?php echo iconv ('Windows-1252', 'UTF-8//TRANSLIT',$xPoblacion); ?>";
	document.getElementById('inProvincia').value="<?php echo iconv ('Windows-1252', 'UTF-8//TRANSLIT',$xProvincia); ?>";
	document.getElementById('inEntidad').value="<?php echo $row['ENTIDAD']; ?>";
	document.getElementById('inOficina').value="<?php echo $row['OFICINA']; ?>";
	document.getElementById('inDC').value="<?php echo $row['DC']; ?>";
	document.getElementById('inCuenta').value="<?php echo $row['CUENTA']; ?>";

}
</script>
</head>

<body  onload="LeeNotario();">

<?php require('cabecera.php'); ?>
<div id="documento">
   <div id="rastro"><a href="MenuAdmin.php">Inicio</a> >
      <a href="NotariosTabla2.php">Lista de Notarios</a> >
            Consulta de Notario
</div>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<form id="form1" name="form1" method="post" action="Redmoon_php/ORAdatosNotarios.php">
 <label class="Estilo2" >Nombre
  <input name="inNombre" type="text" id="inNombre" size="40" maxlength="40" style="position:absolute; left:83px"/>
  </label>
  <label style="position:absolute; left:50%" class="Estilo2">NIF
  <input name="inNIF" type="text" id="inNIF" size="14" maxlength="14" style="position:absolute; left:70px" />
  </label>
 
  <p>
    <label class="Estilo2" >Dirección
    <input name="inDireccion" type="text" id="inDireccion" size="40" maxlength="50" />
    </label>
    <label style="position:absolute; left:50%" class="Estilo2">Poblaci&oacute;n
    <input name="inPoblacion" type="text" id="inPoblacion" size="40" maxlength="50" />
    </label>

    </label>
  </p>
  <p>
   <label style="position:absolute; left:50%" class="Estilo2">CP
  <input name="inCP" type="text" id="inCP" size="14" maxlength="14" style="position:absolute; left:70px" />
  </label>
      <label  class="Estilo2">Provincia
    <input type="text" name="inProvincia" id="inProvincia" size="40" maxlength="50"/>
  </p>

  <p>
  	<div id="VentanaCuenta">
    <label  class="Estilo2" style="position:absolute; left:5%">Entidad
    <input name="inEntidad" type="text" id="inEntidad" size="4" maxlength="4" />
    </label>
   <label class="Estilo2" style="position:absolute; left:22%"> Oficina
    <input name="inOficina" type="text" id="inOficina" size="4" maxlength="4" />
    </label>
    
    <label class="Estilo2"  style="position:absolute; left:40%">DC
    <input name="inDC" type="text" id="inDC" size="2" maxlength="2" />
    </label>
    
    <label class="Estilo2"  style="position:absolute; left:53%">Número de Cuenta
    <input name="inCuenta" type="text" id="inCuenta" size="10" maxlength="10" />
    </label>
    </div>
  </p>
  <p>&nbsp;</p>
   <p>&nbsp;</p>
    
   
  <label style="position:absolute; left:45%; top:350px;">
          <input  name="submit" type="image" id="Grabar" value="Grabar"  src="Redmoon_img/imgDoc/aceptar.png"/>
      </label>
       <input type="hidden" name="xID" id="xID" value="<?php echo $xIDNotario;?>" />
</form>
<p>&nbsp;</p>
</div>

</body>
</html>
