<?php 

//
// Marial del Mar Pérez Fajardo
// Agosto 2009
//

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

if(isset($_POST["xIDColaborador"]))
{ 
	
$xID=(int)$_POST["xIDColaborador"];

$xNombre=iconv('UTF-8','Windows-1252//TRANSLIT',$_POST["inNombre"]);
$xNIF=$_POST["inNIF"];
$xCP=$_POST["inCP"];
$xDIRE=iconv('UTF-8','Windows-1252//TRANSLIT',$_POST["inDireccion"]);
$xPOBLA=iconv('UTF-8','Windows-1252//TRANSLIT',$_POST["inPoblacion"]);
$xPROV=iconv('UTF-8','Windows-1252//TRANSLIT',$_POST["inProvincia"]);
$xFechaAlta=$_POST["infechAlta"];
$xMail=$_POST["ineMail"];
$xAseguradora=iconv('UTF-8','Windows-1252//TRANSLIT',$_POST["inAseguradora"]);
$xNpoliza=$_POST["inPoliza"];
$xFechaSeguro=$_POST["infechSeg"];
$xTipo=$_POST["tipoCola"];
$xINTERNO=$_POST["inInterno"];
$xmovil=$_POST["inMovil"];


$conn = db_connect();

// Nombre de procedimiento a ejecutar y sus parametros
$sql = "UPDATE COLABORADORES 
	SET NIF=:xNIF,NOMBRE=:xNombre,DIRECCION=:xDIRE,PROVINCIA=:xPROV,POBLACION=:xPOBLA,INTERNO=:xINTERNO,
	COD_POSTAL=:xCP,FECHA_ALTA=to_date(:xFechaAlta,'DD/MM/YY'),EMAIL=:xMail,ASEGURADORA=:xAseguradora,
	NPOLIZA=:xNpoliza,FECHA_SEGURO=to_date(:xFechaSeguro,'DD/MM/YY'),MOVIL=:xmovil
	WHERE ID=:xID";


    $stmt = oci_parse($conn, $sql);
    
  
    
    oci_bind_by_name($stmt, ':xID', $xID, 38, SQLT_INT);
    oci_bind_by_name($stmt, ':xNIF', $xNIF, 12, SQLT_CHR);
    oci_bind_by_name($stmt, ':xNombre', $xNombre, 50, SQLT_CHR);
    oci_bind_by_name($stmt, ':xCP', $xCP,5, SQLT_CHR);
    oci_bind_by_name($stmt, ':xDIRE', $xDIRE,50, SQLT_CHR);
    oci_bind_by_name($stmt, ':xPOBLA', $xPOBLA, 25, SQLT_CHR);
    oci_bind_by_name($stmt, ':xPROV', $xPROV,25, SQLT_CHR);
    oci_bind_by_name($stmt, ':xFechaAlta', $xFechaAlta,8, SQLT_CHR);
    oci_bind_by_name($stmt, ':xMail', $xMail,30, SQLT_CHR);
    oci_bind_by_name($stmt, ':xAseguradora', $xAseguradora,50, SQLT_CHR);
    oci_bind_by_name($stmt, ':xNpoliza', $xNpoliza,20, SQLT_CHR);
    oci_bind_by_name($stmt, ':xFechaSeguro', $xFechaSeguro,10, SQLT_CHR);
    oci_bind_by_name($stmt, ':xINTERNO', $xINTERNO,2, SQLT_CHR);
     oci_bind_by_name($stmt, ':xmovil', $xmovil,9, SQLT_CHR);
    
    $url='Location: ../Colaboradores.php?xIDColaborador='.$_POST["xIDColaborador"];
    
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
echo $xAseguradora.'<br />';
echo $xNpoliza.'<br />';
echo $xFechaSeguro.'<br />';
	   echo "Error";
}
else
	echo "No";	
?>
