<<<<<<< .mine
<?php require('controlSesiones.inc.php');  ?>
=======
<?php 

require('controlSesiones.inc.php');
>>>>>>> .r60

require('pebi_cn.inc.php');
require('pebi_db.inc.php');
  
if(isset($_POST["xNIF"]))
{ 


$conn = db_connect();
// Nombre de procedimiento a ejecutar y sus parametros
$sql = 'BEGIN pkClientes.AddExpeDacion(:xNIF, :xIDExpe, :xUsuario); END;';

    
    
    $stmt = oci_parse($conn, $sql);
	if (!$stmt) {
    	$e = oci_error($conn);
    	print htmlentities($e['message']);
    	exit;
  	}
    
    $xNIF = $_POST["xNIF"];
    // variable de sesi�n
    $xUSUARIO=$_SESSION['usuario'];
    
    oci_bind_by_name($stmt, ':xNIF', $xNIF, 12, SQLT_CHR);    
    oci_bind_by_name($stmt, ':xIDExpe', $xIDExpe, 14, SQLT_CHR);
    oci_bind_by_name($stmt, ':xUSUARIO', $xUSUARIO, 30, SQLT_CHR);
    
	
        
	$r=oci_execute($stmt);
	if (!$r) {
    	$e = oci_error($stid);
    	echo htmlentities($e['message']);
    	exit;
  	}
	
	echo $xIDExpe;
}
else
	echo "No";
	
oci_close($conn);	
?>
