<?php 

//
// Marial del Mar Pérez Fajardo
// Agosto 2009
//

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

if(isset($_POST["xIDExpe"]))
{ 

$conn = db_connect();
// Nombre de procedimiento a ejecutar y sus parametros
$sql = 'BEGIN ModNumEscrituras(:xIDExpe,:xNumEscrituras); END;';


    $stmt = oci_parse($conn, $sql);
    
    $xIDExpe= (int)$_POST["xIDExpe"];
    $xNumEscrituras=$_POST["N_ESCRITURAS"];

    
    
    oci_bind_by_name($stmt, ':xIDExpe', $xIDExpe, 38, SQLT_INT);
    oci_bind_by_name($stmt, ':xNumEscrituras', $xNumEscrituras, 2, SQLT_CHR);

    
	if(oci_execute($stmt))
	{
		
	     header("Location: ../IntroduccionCosteRegistro.php");
	}
	else
	   echo "Error";
}
else
	echo "No";	
?>
