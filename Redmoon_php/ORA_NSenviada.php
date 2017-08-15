<?php 

require('controlSesiones.inc.php');  
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

$conn = db_connect();

if(isset($_POST["xID"]))
{ 

// Nombre de procedimiento a ejecutar y sus parametros
$sql = "UPDATE lgs_notas_simples SET estado='EN' WHERE ID=:xID ";
    
    $stmt = oci_parse($conn, $sql);
    
    $xID = $_POST["xID"];
  
    
    oci_bind_by_name($stmt, ':xID', $xID,38, SQLT_INT);
  
    $sql2 = "UPDATE lgs_notas_simples SET FECHA_PETICION=sysdate WHERE ID=:xID ";
    
    $stmt2 = oci_parse($conn, $sql2);
    
    $xID = $_POST["xID"];
  
    
    oci_bind_by_name($stmt2, ':xID', $xID,38, SQLT_INT);
  
    
	if(oci_execute($stmt) && oci_execute($stmt2))
	{
	   echo "enviada"; 
	   //header("Location: ../ZonasGestion.php");
	}
	else
	   echo "Error";
}
else
	echo "No";

oci_close($conn);
?>
