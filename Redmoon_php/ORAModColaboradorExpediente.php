<?php 

//
// Marial del Mar Pérez Fajardo
// Agosto 2009
//

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

if(isset($_GET["xIDExpe"]))
{ 
$xID=(int)$_GET["xIDExpe"];
$xNot=(int)$_GET["xIDColabora"];


$conn = db_connect();
// Nombre de procedimiento a ejecutar y sus parametros
$sql = "UPDATE EXPEDIENTES 
	SET colaborador=:xNot
	WHERE NE=:xID";


    $stmt = oci_parse($conn, $sql);
    
  
    
    oci_bind_by_name($stmt, ':xID', $xID,38, SQLT_INT);
    oci_bind_by_name($stmt, ':xNot', $xNot, 38, SQLT_INT);
    
    
    $url='Location: ../SeguiExpeConsulta.php?xIDExpe='.$xID;
	if(oci_execute($stmt))
	{
	     header($url);
	}
	else
	   echo $xID.'<br />';
	   echo $xNot.'<br />';
	   echo "Error";
}
else
	echo "No";	
?>
