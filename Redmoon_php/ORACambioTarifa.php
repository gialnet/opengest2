<?php 


require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

$conn = db_connect();

if(isset($_POST["xID"]))
{ 

// Nombre de procedimiento a ejecutar y sus parametros
$sql = 'BEGIN chgTarifa(:xID, :xValor, :xConcepto); END;';
    
    $stmt = oci_parse($conn, $sql);
    
    $xID = (int)$_POST["xID"];
    $xValor = $_POST["xValor"];
    $xConcepto = $_POST["xConcepto"];
    
    oci_bind_by_name($stmt, ':xID', $xID, 38, SQLT_INT);
    oci_bind_by_name($stmt, ':xValor', $xValor, 20);
    oci_bind_by_name($stmt, ':xConcepto', $xConcepto, 20, SQLT_CHR);
    
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
