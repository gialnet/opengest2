<?php 

//
// Marial del Mar Pérez Fajardo
// Agosto 2009
//

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

$conn = db_connect();

if(isset($_POST["xIDExpe"]))
{ 

// Nombre de procedimiento a ejecutar y sus parametros
$sql = 'BEGIN ExpedienteEntradaSalida(:xIDExpe,:xEntraSale); END;';


    $stmt = oci_parse($conn, $sql);
    
    $xIDExpe=$_POST["xIDExpe"]; 
    $xEntraSale=$_POST["xES"];
    
    
    $pasa=oci_bind_by_name($stmt, ':xIDExpe', $xIDExpe, 38, SQLT_INT);
    if(!$pasa)
    	echo "error parametro1";
    	
    if(!oci_bind_by_name($stmt, ':xEntraSale', $xEntraSale, 1, SQLT_CHR))
    	echo "error parametro2";
    
	if(oci_execute($stmt))
	{
	     echo "Ok";
	}
	else
	   echo "Error";
}
else
	echo "No";

oci_close($conn);
?>
