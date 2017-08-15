<?php 

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

$conn = db_connect();

$Xid=$_POST['xIDtipo'];
$XTipo=$_POST['modtipo'];

// Nombre de procedimiento a ejecutar y sus parametros
$sql = 'update tipos_asuntos set descripcion=:XTipo where id=:Xid';
    
    $stmt = oci_parse($conn, $sql);
    

    
    oci_bind_by_name($stmt, ':Xid', $Xid, 38, SQLT_INT);
    oci_bind_by_name($stmt, ':XTipo', $XTipo, 40);
    
	if(oci_execute($stmt))
	{
	   $url='Location: ../TablaTiposExpedientes.php'; 
	}
	else
	   echo "Error";


oci_close($conn);
?>
