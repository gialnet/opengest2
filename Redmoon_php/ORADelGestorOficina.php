<?php 

//
// Marial del Mar Pérez Fajardo
// Agosto 2009
//

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

if(isset($_GET["xID"]))
{ 


$conn = db_connect();
$xOficina=$_GET["xOficina"];

// Nombre de procedimiento a ejecutar y sus parametros
$sql = 'delete from oficinas_gestores where id=:xID';
    
    $stmt = oci_parse($conn, $sql);
    
    $xID=$_GET["xID"];
    
  
    
    oci_bind_by_name($stmt, ':xID',  $xID, 38, SQLT_INT);
    
	if(oci_execute($stmt))
	{
	   echo "Ok"; 
	   header("Location: ../GestoresOficinas.php?xOficinas=".$xOficina);
	}
	else
	   echo "Error";
}
else
	echo "No";	
?>
