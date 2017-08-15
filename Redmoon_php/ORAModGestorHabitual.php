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

	$xOficina=$_GET["xOficina"];

	$xGestor=(int)$_GET["xGestor"];


$conn = db_connect();

// Nombre de procedimiento a ejecutar y sus parametros
$sql ='BEGIN PutColaboraHabitual(:xGestor, :xOficina); END;';


    $stmt = oci_parse($conn, $sql);
    
    
    oci_bind_by_name($stmt, ':xOficina', $xOficina,4, SQLT_CHR);
    oci_bind_by_name($stmt, ':xGestor', $xGestor, 38, SQLT_INT);
    
    
    $url='Location: ../Oficinas.php?xOficina='.$xOficina;
    
    
	if(oci_execute($stmt))
	{
	     header($url);
	}
	else
	   echo $xOficina.'<br />';
	   echo $xGestor.'<br />';
	   echo "Error";
}
else
	echo "No";

oci_close($conn);
?>
