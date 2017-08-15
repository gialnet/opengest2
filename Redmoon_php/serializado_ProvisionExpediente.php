<?php 

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

// Create a database connection
$conn = db_connect();

$xIDExpe=$_GET["xIDExpe"];

do_queryTodo($conn, 'select sum(IMP_NOTARIA+IMP_IMPUESTO+IMP_REGISTRO+IMP_GESTORIA+IMP_PLUSVALIA) AS IMP_PROVISION from asuntos_expediente where NE=:xIDExpe');
   
// Execute query and display results
function do_queryTodo($conn, $query)
{

	$time_start = microtime(true);
	
$stid = oci_parse($conn, $query);

oci_bind_by_name($stid, ':xIDExpe', $xIDExpe, 14, SQLT_CHR);

$r = oci_execute($stid, OCI_DEFAULT);

	$suma="";
	while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) 
	{
		foreach ($row as $key =>$field) 
			{
			$field = htmlspecialchars($field, ENT_NOQUOTES);
			if ($key=='IMPORTE')
				if (is_null($row['IMPORTE']))
					$field=$row['IMPORTE'];
				else 
					$field=number_format($field, 0, ',', '.').' &#8364;';
			
			$suma=$suma.$field.'|';
			}
	}


// descomentar para grabar estadisticas de medición de caudal

// A configurar en cada módulo =======================
$time_end = microtime(true);
$time = $time_end - $time_start;
	
$numero_bytes=strlen($suma);
$url='serializado_ProvisionExpediente.php';
$opcion='Importe Provision de Fondos de Un Expediente';

include 'Test_Medicion_Datos.inc';

echo $suma;
oci_close($conn);
}


?>