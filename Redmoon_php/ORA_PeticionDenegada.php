<?php 

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');


$conn = db_connect();

if(isset($_POST["xIDSegui"]))
{ 

// Nombre de procedimiento a ejecutar y sus parametros
$sql = "UPDATE seguimiento SET DH='N' WHERE ID=:xIDSegui ";
    
    $stmt = oci_parse($conn, $sql);
    
    $xIDSegui = $_POST["xIDSegui"];
    
    
    oci_bind_by_name($stmt, ':xIDSegui', $xIDSegui,38, SQLT_CHR);
   
    
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
