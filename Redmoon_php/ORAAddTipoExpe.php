<?php 

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

$xTipo=$_POST["tipo"];

$conn = db_connect();
// Nombre de procedimiento a ejecutar y sus parametros
$sql = 'insert into tipos_asuntos (DESCRIPCION) 
values (:xTipo)';



    $stmt = oci_parse($conn, $sql);
    
  
    
    oci_bind_by_name($stmt, ':xTipo', $xTipo, 40, SQLT_CHR);

    $url='Location: ../TablaTiposExpedientes.php';
    
	if(oci_execute($stmt))
	{
	     header($url);
	}
	else{
	   echo "Error";
		echo $xTipo;
	}
	   



?>
