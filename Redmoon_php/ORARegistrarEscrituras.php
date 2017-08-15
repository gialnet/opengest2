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

//$conn = oci_connect('lgs','a1','//cajalgs.no-ip.org/lgs');
$conn = db_connect();
// Nombre de procedimiento a ejecutar y sus parametros
$sql = 'BEGIN  AddRegistrarEscrituras(:xIDExpe,:xFechaRegistro); END;';


    $stmt = oci_parse($conn, $sql);
    
    $xIDExpe= (int)$_POST["xIDExpe"];
    $xFechaRegistro=$_POST["fecha_registro"];
   
   
    
    
    oci_bind_by_name($stmt, ':xIDExpe', $xIDExpe, 38, SQLT_INT);
    oci_bind_by_name($stmt, ':xFechaRegistro', $xFechaRegistro,  8, SQLT_CHR);
    

	if(oci_execute($stmt))
	{
	     header("Location: ../TareasColaboradores.php");
	}
	else
	   echo "Error";
}
else
	echo "No";	
?>
