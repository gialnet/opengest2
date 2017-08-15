<?php 

//
// Marial del Mar Pérez Fajardo
// Agosto 2009
//

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

if(isset($_POST["xIDSegui"]))
{ 


$conn = db_connect();
// Nombre de procedimiento a ejecutar y sus parametros
$sql = 'BEGIN DelProvision(:xIDSegui); END;';
    
    $stmt = oci_parse($conn, $sql);
    
    $xIDSegui= (int)$_POST["xIDSegui"];
    
    oci_bind_by_name($stmt, ':xIDSegui', $xIDSegui, 38, SQLT_INT);
    
	if(oci_execute($stmt))
	{
	   echo "Ok"; 
	}
	else
	   echo "Error";
}
else
	echo "No";	
?>
