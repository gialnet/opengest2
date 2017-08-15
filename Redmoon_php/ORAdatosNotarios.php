<?php 

//
// Marial del Mar Pérez Fajardo
// Agosto 2009
//

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

if(isset($_POST["xID"]))
{ 
$xID=(int)$_POST["xID"];
$xNombre=$_POST["inNombre"];
$xNIF=$_POST["inNIF"];
$xCP=$_POST["inCP"];
$xDIRE=$_POST["inDireccion"];
$xPOBLA=$_POST["inPoblacion"];
$xPROV=$_POST["inProvincia"];
//$xFechaAlta=$_POST["infechAlta"];
//$xActivo=$_POST["inActivo"];
//$xAseguradora=$_POST["inAseguradora"];
//$xNpoliza=$_POST["inPoliza"];
//$xFechaSeguro=$_POST["infechSeg"];
$xEntidad=$_POST["inEntidad"];
$xSucursal=$_POST["inOficina"];
$xDC=$_POST["inDC"];
$xNCuenta=$_POST["inCuenta"];


$conn = db_connect();
// Nombre de procedimiento a ejecutar y sus parametros
$sql = "UPDATE NOTARIOS 
	SET NIF=:xNIF,NOMBRE=:xNombre,DIRECCION=:xDIRE,PROVINCIA=:xPROV,POBLACION=:xPOBLA,
	COD_POSTAL=:xCP,ENTIDAD=:xEntidad,OFICINA=:xSucursal,DC=:xDC,CUENTA=:xNCuenta
	WHERE COD_NOTARIO=:xID";


    $stmt = oci_parse($conn, $sql);
    
  
    
    oci_bind_by_name($stmt, ':xID', $xID, 38, SQLT_INT);
    oci_bind_by_name($stmt, ':xNIF', $xNIF, 12, SQLT_CHR);
    oci_bind_by_name($stmt, ':xNombre', $xNombre, 100, SQLT_CHR);
    oci_bind_by_name($stmt, ':xCP', $xCP,5, SQLT_CHR);
    oci_bind_by_name($stmt, ':xDIRE', $xDIRE,50, SQLT_CHR);
    oci_bind_by_name($stmt, ':xPOBLA', $xPOBLA,50, SQLT_CHR);
    oci_bind_by_name($stmt, ':xPROV', $xPROV,50, SQLT_CHR);
    oci_bind_by_name($stmt, ':xEntidad', $xEntidad,4, SQLT_CHR);
    oci_bind_by_name($stmt, ':xSucursal', $xSucursal,4, SQLT_CHR);
    oci_bind_by_name($stmt, ':xDC', $xDC,2, SQLT_CHR);
    oci_bind_by_name($stmt, ':xNCuenta', $xNCuenta,10, SQLT_CHR);
    
    $url='Location: ../Notarios.php?xIDNotario='.$xID;
	if(oci_execute($stmt))
	{
	     header($url);
	}
	else
	   echo $xID.'<br />';
	   
echo $xNombre.'<br />';
echo $xNIF.'<br />';
echo $xCP.'<br />';
echo $xDIRE.'<br />';
echo $xPOBLA.'<br />';
echo $xPROV.'<br />';

	   echo "Error";
}
else
	echo "No";	
?>
