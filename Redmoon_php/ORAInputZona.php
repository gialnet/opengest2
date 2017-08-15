<?php 

//
// Marial del Mar Pérez Fajardo
// Agosto 2009
//

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

$conn = db_connect();

$xZona=$_POST['xZona'];
$xCoste=$_POST['xCoste'];
$xNombre=$_POST['xNombre'];


// Nombre de procedimiento a ejecutar y sus parametros
$sql = "INSERT INTO ZONAS (ZONA,NOMBRE,COSTE_COLABORADOR) VALUES (:xZona,:xNombre,to_number(:xCoste))  ";
    
    $stmt = oci_parse($conn, $sql);
    

    
    oci_bind_by_name($stmt, ':xZona', $xZona,2, SQLT_CHR);
    oci_bind_by_name($stmt, ':xCoste', $xCoste, 12);
     oci_bind_by_name($stmt, ':xNombre', $xNombre,40, SQLT_CHR);
    
	if(oci_execute($stmt))
	{
	   echo "Ok"; 
	
	}
	else
	   echo "Error";

oci_close($conn);
?>
