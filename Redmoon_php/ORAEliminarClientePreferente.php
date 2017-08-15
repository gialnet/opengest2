<?php 

//
// Marial del Mar Pérez Fajardo
// Agosto 2009
//

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

if(isset($_POST["xID"]))
{ 

$xID=(int)$_POST["xID"];


$conn = db_connect();
// Nombre de procedimiento a ejecutar y sus parametros
$sql = 'delete from clientes_preferentes where id=:xID';



    $stmt = oci_parse($conn, $sql);
    
  
    
    oci_bind_by_name($stmt, ':xID', $xID, 38, SQLT_INT);

    
    $url='Location: ../TablaClientesPreferentes.php';
    
	if(oci_execute($stmt))
	{
	    echo "ok_borrar";
	}
	else{
	   echo "Error";
	   echo $xID.'</br>';

	}
	   

}
else
	echo "No";	
?>
