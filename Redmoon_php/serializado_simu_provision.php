<?php 

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

// Create a database connection
$conn = db_connect();

do_queryTodo($conn, 'select asunto,cuantia,notaria,impuesto,registro,gestoria,(notaria+impuesto+registro+gestoria) AS TOTAL from tmp_simu where usuario=:xUser order by id');
   
// Execute query and display results
function do_queryTodo($conn, $query)
{

	$time_start = microtime(true);
	
	$stid = oci_parse($conn, $query);

	$xUser=$_SESSION["usuario"];
	oci_bind_by_name($stid, ':xUser', $xUser, 30, SQLT_CHR);

	if (!oci_execute($stid, OCI_DEFAULT))
	{
		oci_close($conn);
		echo "Error";
		return;
	}

	$suma="";
	while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) 
	{
		foreach ($row as $key =>$field) 
			{
			
			if ($key=='CUANTIA' || $key=='NOTARIA' || $key=='IMPUESTO' || $key=='REGISTRO' || $key=='GESTORIA' ||$key=='TOTAL')
				if (!is_null($field))
					$field=number_format($field, 0, ',', '.').' &#8364;';
			
			$suma=$suma.$field.'|';
			}
	}


// descomentar para grabar estadisticas de medición de caudal

// A configurar en cada módulo =======================
$time_end = microtime(true);
$time = $time_end - $time_start;
	
$numero_bytes=strlen($suma);
$url='serializado_simu_provision.php';
$opcion='Simulación provisión de fondos';

include 'Test_Medicion_Datos.inc';

echo $suma;
oci_close($conn);
}


?>