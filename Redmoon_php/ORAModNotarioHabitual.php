<?php 

//
// Marial del Mar Pérez Fajardo
// Agosto 2009
//

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

if(isset($_GET["xOficina"]))
{ 
$xID=$_GET["xOficina"];
$xNot=(int)$_GET["xNot"];


$conn = db_connect();
// Nombre de procedimiento a ejecutar y sus parametros
$sql = "UPDATE OFICINAS 
	SET NOTARIO_HABITUAL=:xNot
	WHERE oficina=:xID";


    $stmt = oci_parse($conn, $sql);
    
  
    
    oci_bind_by_name($stmt, ':xID', $xID,4, SQLT_CHR);
    oci_bind_by_name($stmt, ':xNot', $xNot, 10, SQLT_INT);
    
    
    $url='Location: ../Oficinas.php?xOficina='.$xID;
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
