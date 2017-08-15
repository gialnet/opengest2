<?php 

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

$conn = db_connect();

if(isset($_POST["xIDZona"]))
{ 

// Nombre de procedimiento a ejecutar y sus parametros
$sql = 'UPDATE ZONAS SET COSTE_COLABORADOR=:xImporte WHERE ZONA=:xIDZona ';
    
    $stmt = oci_parse($conn, $sql);
    
    $xIDZona = $_POST["xIDZona"];
    $xImporte = $_POST["xImporte"];
    
    oci_bind_by_name($stmt, ':xIDZona', $xIDZona,2, SQLT_CHR);
    oci_bind_by_name($stmt, ':xImporte', $xImporte, 10);
    
	if(oci_execute($stmt))
	{
	   echo "Ok"; 
	   //header("Location: ../ZonasGestion.php");
	}
	else
	   echo "Error";
}
else
	echo "No";

oci_close($conn);
?>
