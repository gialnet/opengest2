<?php

require_once('Redmoon_php/controlSesiones.inc.php');
require_once('Redmoon_php/pebi_cn.inc.php');
require_once('Redmoon_php/pebi_db.inc.php');

if(isset($_GET["xID"]))
{
// Create a database connection
$conn = db_connect();
$xID=$_GET["xID"];

$sql2='SELECT uso_cc,ENTIDAD,sucursal,dc,ncuenta FROM COLABORADORES_CUENTAS where id=:xID';
$stid2 = oci_parse($conn, $sql2);
oci_bind_by_name($stid2, ':xID', $xID, 14, SQLT_CHR);


$r2 = oci_execute($stid2, OCI_DEFAULT);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Colaboradores</title>

<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>
<style type="text/css">
#recuadro{

	position:absolute;
	top:100px;
	background-color: #FFFFCC;
	width:780px;
	height:130px;
	padding:15px 15px;

		

}
.Estilo1 {
	color: #3c4963;
	font-weight: bold;
}
.Estilo2 {

	color: #36679f;
	font-weight: bold;
}
.E
</style>
<script>
function LeeCuenta()
{
	<?php
	$row = oci_fetch_array($stid2, OCI_ASSOC+OCI_RETURN_NULLS);
	
	?>
	document.getElementById('inUsoCC').value="<?php echo $row['USO_CC']; ?>";
	document.getElementById('inEntidad').value="<?php echo $row['ENTIDAD']; ?>";
	document.getElementById('inSucursal').value="<?php echo $row['SUCURSAL']; ?>";
	document.getElementById('inDC').value="<?php echo $row['DC']; ?>";
	document.getElementById('inNcuenta').value="<?php echo $row['NCUENTA']; ?>";
	

}


function FilaActiva(xID)
{
	document.getElementById(xID).style.backgroundColor ="#ECF3F5";
}
//
// Cojer el valor de la fila
//
function GetFila(xID)
{
	var oCelda=document.getElementById(xID).cells[0];
	//var fila=document.getElementById(xID).rowIndex;

	location="Colaboradores.php?xIDColaborador="+oCelda.innerHTML;
	//alert(oCelda.innerHTML);
	

}

//
//
//
function FilaDesactivar(xID)
{
document.getElementById(xID).style.backgroundColor ="#FFFFFF";
}
</script>
</head>

<body  onload="LeeCuenta();">
<?php require('cabecera.php'); ?>

<div id="documento">
<br />
<br />
<h4 align="center" class="Estilo1"> Colaboradores</h4>
<div id="recuadro">
<p>&nbsp;</p>

<form id="form1" name="form1" method="post" action="Redmoon_php/ORAcuentaColaborador.php">
   <label class="Estilo2" >Tipo de CC
  <input name="inUsoCC" type="text" id="inUsoCC" size="4" maxlength="3" disabled="disabled"/>
  </label>

  <label class="Estilo2">Entidad
  <input name="inEntidad" type="text" id="inEntidad" size="4" maxlength="4"  />
  </label>
  <label class="Estilo2">Sucursal
  <input name="inSucursal" type="text" id="inSucursal" size="4" maxlength="4" />
 	</label>
    <label class="Estilo2">DC
    <input name="inDC" type="text" id="inDC" size="2" maxlength="2" />
    </label>
    <label class="Estilo2">N&uacute;mero de Cuenta
    <input name="inNcuenta" type="text" id="inNcuenta" size="10" maxlength="10" />
 	</label>
<br/>
<br/>
<div align="center">
   <input  name="submit" type="image" id="Grabar" value="Grabar" src="Redmoon_img/aceptar2.png"/>
</div>
  </p>
    <input type="hidden" name="xID" id="xID" value="<?php echo $_GET['xID'];?>" />
    <input type="hidden" name="xIDColaborador" id="xIDColaborador" value="<?php echo $_GET["xIDColaborador"]; ?>" />
</form>
</div>






</div>

</body>
</html>
