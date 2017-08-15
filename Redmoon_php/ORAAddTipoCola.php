<?php 

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');


$xTipo=iconv('UTF-8','Windows-1252//TRANSLIT',$_POST["tipo"]);

$conn = db_connect();
// Nombre de procedimiento a ejecutar y sus parametros
$sql = 'insert into colaboradores_tipo (NOMBRE) values (:xTipo)';


    $stmt = oci_parse($conn, $sql);  
    
    oci_bind_by_name($stmt, ':xTipo', $xTipo, 15, SQLT_CHR);

    $url='Location: ../TablaTiposColaboradores.php';
    
	if(oci_execute($stmt))
	{
	     header($url);
	}
	else{
	   echo "Error";
		echo $xTipo;
	}
	   



?>
