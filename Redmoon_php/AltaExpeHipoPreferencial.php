<<<<<<< .mine
<?php require('controlSesiones.inc.php');  ?>
<?php
=======
<?php 

require('controlSesiones.inc.php');
>>>>>>> .r60

require('pebi_cn.inc.php');
require('pebi_db.inc.php');
  
if(isset($_POST["xNIF"]))
{ 

//$conn = oci_connect('lgs','a1','//cajalgs.no-ip.org/lgs');
$conn = db_connect();
// Nombre de procedimiento a ejecutar y sus parametros
$sql = 'BEGIN pkClientes.AddExpePreferencial(:xNIF, :xIDExpe, :xUsuario); END;';

    
    
    $stmt = oci_parse($conn, $sql);
    
    $xNIF = $_POST["xNIF"];
    $xUSUARIO=$_SESSION['usuario'];
    
    oci_bind_by_name($stmt, ':xNIF', $xNIF, 12, SQLT_CHR);    
    oci_bind_by_name($stmt, ':xIDExpe', $xIDExpe, 14, SQLT_CHR);
    
    oci_bind_by_name($stmt, ':xUSUARIO', $xUSUARIO, 30, SQLT_CHR);
    
	
        
	oci_execute($stmt);
	
	echo $xIDExpe;
}
else
	echo "No";
	
oci_close($conn);	
?>
