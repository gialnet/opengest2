<?php 

//
// Marial del Mar Pérez Fajardo
// Agosto 2009
//

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

if(isset($_POST["xOficina"]))
{ 
	
$xOficina=$_POST["xOficina"];

$xNombre=iconv('UTF-8','Windows-1252//TRANSLIT',$_POST["inNombre"]);
$xTLF=$_POST["inTLF"];
$xCP=$_POST["inCP"];
$xDIRE=iconv('UTF-8','Windows-1252//TRANSLIT',$_POST["inDireccion"]);
$xPOBLA=iconv('UTF-8','Windows-1252//TRANSLIT',$_POST["inPoblacion"]);
$xPROV=iconv('UTF-8','Windows-1252//TRANSLIT',$_POST["inProvincia"]);
$xContacto=$_POST["inContacto"];
$xMail=$_POST["ineMail"];
$xRuta=(int)$_POST["inRuta"];
$xModo=$_POST["inModo"];



$conn = db_connect();
// Nombre de procedimiento a ejecutar y sus parametros
$sql = "UPDATE OFICINAS 
	SET NOMBRE=:xNombre,DIRECCION=:xDIRE,PROVINCIA=:xPROV,POBLACION=:xPOBLA,
	COD_POSTAL=:xCP,PERSONA_CONTACTO=:xContacto,EMAIL=:xMail,RUTA=:xRuta,
	MODO=:xModo,TELEFONO=:xTLF
	WHERE OFICINA=:xOficina";


    $stmt = oci_parse($conn, $sql);
    
  
    
    oci_bind_by_name($stmt, ':xOficina', $xOficina, 50, SQLT_CHR);
    oci_bind_by_name($stmt, ':xContacto', $xContacto, 50, SQLT_CHR);
    oci_bind_by_name($stmt, ':xNombre', $xNombre, 50, SQLT_CHR);
    oci_bind_by_name($stmt, ':xCP', $xCP,5, SQLT_CHR);
    oci_bind_by_name($stmt, ':xDIRE', $xDIRE,50, SQLT_CHR);
    oci_bind_by_name($stmt, ':xPOBLA', $xPOBLA, 50, SQLT_CHR);
    oci_bind_by_name($stmt, ':xPROV', $xPROV,50, SQLT_CHR);
    oci_bind_by_name($stmt, ':xRuta', $xRuta,50, SQLT_CHR);
    oci_bind_by_name($stmt, ':xMail', $xMail,50, SQLT_CHR);
    oci_bind_by_name($stmt, ':xModo', $xModo,38, SQLT_INT);
    oci_bind_by_name($stmt, ':xTLF', $xxTLF,12, SQLT_CHR);
    
    $url='Location: ../TablaOficinas.php';
    
	if(oci_execute($stmt))
	{
	     header($url);
	    
	}
	else
	  
	   
echo $xNombre.'<br />';

echo $xCP.'<br />';
echo $xDIRE.'<br />';
echo $xPOBLA.'<br />';
echo $xPROV.'<br />';

echo $xMail.'<br />';

	   echo "Error";
}
else
	echo "No";	
?>
