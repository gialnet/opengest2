<?php 


require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

// Create a database connection
//$conn = oci_connect('lgs','a1','//cajalgs.no-ip.org/lgs');
$conn = db_connect();

do_queryTodo($conn, 'SELECT ZONA, NOMBRE, COSTE_COLABORADOR FROM ZONAS');
   
// Execute query and display results
function do_queryTodo($conn, $query)
{
	$time_start = microtime(true);

$stid = oci_parse($conn, $query);
//oci_bind_by_name($stid, ':xPOBLACION', $xPOBLA, 25, SQLT_CHR);


$r = oci_execute($stid, OCI_DEFAULT);

	$suma="";
	while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) 
	{
		foreach ($row as $key =>$field) 
			{
			$field = htmlspecialchars($field, ENT_NOQUOTES);
			if ($key=='COSTE_COLABORADOR')
				$field=number_format($field, 0, ',', '.').' &#8364;';
			$suma=$suma.$field.'|';
			}
	}
// descomentar para grabar estadisticas de medición de caudal

// A configurar en cada módulo =======================
$time_end = microtime(true);
$time = $time_end - $time_start;
	
$numero_bytes=strlen($suma);
$url='serializado_MayorCuantia.php';
$opcion='Listado de expedientes de mayor cuantia pendientes de aprobar';

include 'Test_Medicion_Datos.inc';
	
echo $suma;

oci_close($conn);
}


?>

