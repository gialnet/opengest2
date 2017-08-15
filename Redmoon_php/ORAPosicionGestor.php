<?php 

//
// Marial del Mar Pérez Fajardo
// Agosto 2009
//

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

$conn = db_connect();

if(isset($_POST["xGestor"]))
{ 

// Nombre de procedimiento a ejecutar y sus parametros
$sql = 'UPDATE oficinas_gestores SET posicion=:xPos WHERE id=:xGestor ';
    
    $stmt = oci_parse($conn, $sql);
    
    $xGestor=(int)$_POST["xGestor"];
    $xPos = (int)$_POST["xPos"];
    
    oci_bind_by_name($stmt, ':xGestor', $xGestor,38, SQLT_INT);
    oci_bind_by_name($stmt, ':xPos', $xPos, 38, SQLT_INT);
    
	if(oci_execute($stmt))
	{
	   echo "Ok"; 
	   //header("Location: ../TablaVerGestoresOficina.php");
	}
	else
	   echo "Error";
}
else
	echo "No";

oci_close($conn);
?>
