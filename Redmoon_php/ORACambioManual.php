<?php 

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

$conn = db_connect();

if(isset($_POST["xIDAsunto"]))
{ 

// Nombre de procedimiento a ejecutar y sus parametros
$sql = 'BEGIN chgProviManual(:xIDAsunto, :xImporte, :xConcepto); END;';
    
    $stmt = oci_parse($conn, $sql);
    
    $xIDAsunto = (int)$_POST["xIDAsunto"];
    $xImporte = $_POST["xImporte"];
    $xConcepto = $_POST["xConcepto"];
    
    oci_bind_by_name($stmt, ':xIDAsunto', $xIDAsunto, 38, SQLT_INT);
    oci_bind_by_name($stmt, ':xImporte', $xImporte, 10);
    oci_bind_by_name($stmt, ':xConcepto', $xConcepto, 10, SQLT_CHR);
    
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
