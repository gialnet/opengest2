<?php 

require('controlSesiones.inc.php'); 
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

if(isset($_POST["xIDExpe"]))
{ 


$conn = db_connect();

// Nombre de procedimiento a ejecutar y sus parametros
$sql = 'BEGIN ModFinca(:xIDFinca,:xRegistro,
		:xNumRegistro,
		:xNombre,
		:xMunicipio,
		:xCalle,
		:xPortal,
		:xTomo,
		:xLibro,
		:xSeccion,
		:xFolio,
		:xLATITUD, 
		:xLONGITUD,
		:xPedirNota); END;';
    
    $stmt = oci_parse($conn, $sql);
    
    oci_bind_by_name($stmt, ':xIDFinca', $xIDFinca, 38, SQLT_INT);
    
    oci_bind_by_name($stmt, ':xNombre', $xNombre, 40, SQLT_CHR);
    oci_bind_by_name($stmt, ':xRegistro', $xRegistro, 14, SQLT_CHR);
    oci_bind_by_name($stmt, ':xNumRegistro', $xNumRegistro, 25, SQLT_CHR);
    oci_bind_by_name($stmt, ':xMunicipio', $xMunicipio, 25, SQLT_CHR);
    oci_bind_by_name($stmt, ':xCalle', $xCalle, 40, SQLT_CHR);
    oci_bind_by_name($stmt, ':xPortal', $xPortal, 25, SQLT_CHR);
    
    oci_bind_by_name($stmt, ':xTomo', $xTomo, 10, SQLT_CHR);
    oci_bind_by_name($stmt, ':xLibro', $xLibro, 10, SQLT_CHR);
    oci_bind_by_name($stmt, ':xSeccion', $xSeccion, 10, SQLT_CHR);
    oci_bind_by_name($stmt, ':xFolio', $xFolio, 10, SQLT_CHR);

    oci_bind_by_name($stmt, ':xLatitud', $xLatitud, 14, SQLT_CHR);
    oci_bind_by_name($stmt, ':xLongitud', $xLongitud, 14, SQLT_CHR);
 	oci_bind_by_name($stmt, ':xPedirNota', $xPedirNota, 1, SQLT_CHR);
    
	$xIDFinca= (int)$_POST["xIDFinca"];
    $xNombre= $_POST["xNombre"];
    $xRegistro= $_POST["xRegistro"];
    $xNumRegistro= $_POST["xNumRegistro"];
    $xMunicipio= $_POST["xMunicipio"];
    $xCalle= $_POST["xCalle"];
    $xPortal= $_POST["xPortal"];
    $xTomo= $_POST["xTomo"];
    $xLibro= $_POST["xLibro"];
    $xSeccion= $_POST["xSeccion"];
    $xFolio= $_POST["xFolio"];
    $xLatitud= $_POST["xLatitud"];
    $xLongitud= $_POST["xLongitud"];
    $xPedirNota= $_POST["xPedirNota"];
    
	if(oci_execute($stmt))
	   echo "Ok";
	else
	   echo "Error";
}
else
	echo "No";	
?>
