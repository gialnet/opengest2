<<<<<<< .mine
<?php require('controlSesiones.inc.php');  ?>
<?php
require('pebi_cn.inc');
require('pebi_db.inc');
=======
<?php 

require('controlSesiones.inc.php');

require('pebi_cn.inc.php');
require('pebi_db.inc.php');
>>>>>>> .r60
  
if(isset($_POST["xIDExpe"]))
{ 

$conn = db_connect();
// Nombre de procedimiento a ejecutar y sus parametros
$sql = 'BEGIN AprobarHipoteca(:xNot,:xIDExpe, :xNumExpe, :xRefCaja); END;';
    
    $stmt = oci_parse($conn, $sql);
    
    oci_bind_by_name($stmt, ':xIDExpe', $xIDExpe, 38, SQLT_INT);
    
    oci_bind_by_name($stmt, ':xNumExpe', $xNumExpe, 20, SQLT_CHR);
    oci_bind_by_name($stmt, ':xRefCaja', $xRefCaja, 20, SQLT_CHR);
    oci_bind_by_name($stmt, ':xNot', $xNot, 10, SQLT_INT);
    
	$xIDExpe= (int)$_POST["xIDExpe"];
    $xRefCaja= $_POST["xprestamo"];
    $xNumExpe= $_POST["xRefCaja"];
    $xNot=(int) $_POST["xCodNot"];
    
	if(oci_execute($stmt))
	{
	   //echo "Ok";
	   //echo $xIDExpe;
	  header("Location: ../MenuTitulares.php?xIDExpe=".$xIDExpe); 
	}
	else
	   echo "Error";
}
else
	echo "No";	
?>
