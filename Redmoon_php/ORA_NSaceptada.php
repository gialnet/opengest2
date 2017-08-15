<?php 

require('controlSesiones.inc.php'); 
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

$conn = db_connect();

if(isset($_POST["xID"]))
{ 

// Nombre de procedimiento a ejecutar y sus parametros
$sql = "UPDATE lgs_notas_simples SET estado='CE' WHERE ID=:xID ";
    
    $stmt = oci_parse($conn, $sql);
    
    $xID = $_POST["xID"];
  
    
    oci_bind_by_name($stmt, ':xID', $xID,38, SQLT_INT);
  
   
    
	if(oci_execute($stmt) )
	{
	   echo "aceptada"; 
	   //header("Location: ../ZonasGestion.php");
	}
	else
	   echo "Error";
}
else
	echo "No";

oci_close($conn);
?>
