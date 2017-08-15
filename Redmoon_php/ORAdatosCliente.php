<?php 

//
// Marial del Mar Pérez Fajardo
// Agosto 2009
//

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');



if(isset($_POST["ID"]))
{ 
	

$xID=$_POST["ID"];
$xNombre=iconv('UTF-8','Windows-1252//TRANSLIT',$_POST["inNombre"]);
$xNIF=$_POST["inNIF"];
$xCP=$_POST["inCP"];
$xDIRE=iconv('UTF-8','Windows-1252//TRANSLIT',$_POST["inDireccion"]);
$xPOBLA=iconv('UTF-8','Windows-1252//TRANSLIT',$_POST["inPoblacion"]);
$xFechaAlta=$_POST["infechAlta"];
$xMail=$_POST["ineMail"];


$conn = db_connect();

// Nombre de procedimiento a ejecutar y sus parametros
$sql = "UPDATE DATOSPER
	SET NIF=:xNIF,RAZON_SOCIAL=:xNombre,DIRECCION=:xDIRE,POBLACION=:xPOBLA,
	CP=:xCP,UMBRAL_PROVISION=to_number(:xFechaAlta),MAX_CALCULO_PROVISION=to_number(:xMail)
	WHERE ID=:xID";


    $stmt = oci_parse($conn, $sql);
    
  
    
    oci_bind_by_name($stmt, ':xID', $xID, 38, SQLT_INT);
    oci_bind_by_name($stmt, ':xNIF', $xNIF, 10, SQLT_CHR);
    oci_bind_by_name($stmt, ':xNombre', $xNombre, 30, SQLT_CHR);
    oci_bind_by_name($stmt, ':xCP', $xCP,5, SQLT_CHR);
    oci_bind_by_name($stmt, ':xDIRE', $xDIRE,50, SQLT_CHR);
    oci_bind_by_name($stmt, ':xPOBLA', $xPOBLA, 25, SQLT_CHR);
    oci_bind_by_name($stmt, ':xFechaAlta', $xFechaAlta,4, SQLT_INT);
    oci_bind_by_name($stmt, ':xMail', $xMail,10, SQLT_INT);
   
    
    $url='Location: ../DatosCliente.php;
    
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
echo $xFechaAlta.'<br />';
echo $xMail.'<br />';

	   echo "Error";
}
else
	echo "No";	
?>
