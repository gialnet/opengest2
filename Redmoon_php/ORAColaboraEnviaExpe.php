<?php 

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');
 
if(isset($_POST["xIDExpe"]))
{ 

$conn = db_connect();

// Nombre de procedimiento a ejecutar y sus parametros
$sql = 'update EXPEDIENTES SET ENVIO_COLABORADOR=sysdate where NE=:xIDExpe and ENVIO_COLABORADOR is null';


    $stmt = oci_parse($conn, $sql);
    
    $xIDExpe = (int)$_POST["xIDExpe"];  
 
    
    oci_bind_by_name($stmt, ':xIDExpe', $xIDExpe, 38, SQLT_INT);
  

    
	if(oci_execute($stmt))
	{
	     echo "Ok";
	}
	else
	   echo "Error ";
}
else
	echo "No";
	
oci_close($conn);
?>