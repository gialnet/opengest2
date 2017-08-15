<?php
//
//
//
require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

$conn = db_connect();

if(isset($_POST["xID"]))
{ 
	
	$xID =$_POST["xID"];
    $xDescripcion =iconv('UTF-8','Windows-1252//TRANSLIT',$_POST["indes"]);
    $xTarifa =$_POST["intar"];

	// Nombre de procedimiento a ejecutar y sus parametros
	$sql = "BEGIN ModActo(:xID,:xDescripcion ,:xTarifa); END;";
    
    $stmt = oci_parse($conn, $sql);
    
 
    
    oci_bind_by_name($stmt, ':xID', $xID, 38, SQLT_INT);
    oci_bind_by_name($stmt, ':xDescripcion', $xDescripcion, 40,SQL_CHR);
    oci_bind_by_name($stmt, ':xTarifa', $xTarifa, 1, SQLT_CHR);
    
    $url='Location: ../Actuacion.php?xIDActo='.$xID;
	if(oci_execute($stmt))
	{
	   //echo "OK";
	header($url);

	}
	else{
	    echo "Error";
 		echo 'ID:'.$xID.'<br />';	   
   		echo 'DESCRP:'.$xDescripcion.'<br />';
   		echo 'TARIFA:'.$xTarifa.'<br />';
      

	}

	 
	
}
	else echo "NO"
	
?>