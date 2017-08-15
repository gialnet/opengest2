<?php 

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

	
$xOficina=$_POST["inOficina"];

$xNombre=iconv('UTF-8','Windows-1252//TRANSLIT',$_POST["inNombre"]);
$xTLF=$_POST["inTLF"];
$xCP=$_POST["inCP"];
$xDIRE=iconv('UTF-8','Windows-1252//TRANSLIT',$_POST["inDireccion"]);
$xPOBLA=iconv('UTF-8','Windows-1252//TRANSLIT',$_POST["inPoblacion"]);
$xPROV=iconv('UTF-8','Windows-1252//TRANSLIT',$_POST["inProvincia"]);
$xContacto=$_POST["inContacto"];
$xMail=$_POST["ineMail"];
$xRuta=$_POST["inRuta"];
$xModo=(int)$_POST["inModo"];



//$conn = oci_connect('lgs','a1','//cajalgs.no-ip.org/lgs');
$conn = db_connect();
// Nombre de procedimiento a ejecutar y sus parametros

$sql = 'INSERT INTO OFICINAS (OFICINA,NOMBRE,DIRECCION,PROVINCIA,POBLACION,COD_POSTAL,
PERSONA_CONTACTO,EMAIL,RUTA,MODO,TELEFONO) VALUES (:xOficina,:xNombre,:xDIRE,:xPROV,:xPOBLA,
:xCP,:xContacto,:xMail,:xRuta,:xModo,:xTLF)';


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
	else{
	  
echo	$xOficina.'<br />'; 
echo $xNombre.'<br />';

echo $xCP.'<br />';
echo $xDIRE.'<br />';
echo $xPOBLA.'<br />';
echo $xPROV.'<br />';

echo $xMail.'<br />';
echo $xRuta.'<br />';
echo $xModo.'<br />';
	   echo "Error";
}

?>
