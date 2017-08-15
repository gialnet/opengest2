<?php 

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

$conn = db_connect();

do_queryTodo($conn, 'SELECT ID,NE,ESTADOS_EXPE,DESCRIPCION,FECHA_MOVIMIENTO,IMPORTE,DH,DOCUMENTO FROM VWSEGUI_ASUNTOHIPOTECA where NE=:xIDExpe order by FECHA_MOVIMIENTO');
   
// Execute query and display results
function do_queryTodo($conn, $query)
{
$time_start = microtime(true);

$stid = oci_parse($conn, $query);

$xIDExpe = $_POST["xIDExpe"];

oci_bind_by_name($stid, ':xIDExpe', $xIDExpe, 14, SQLT_CHR);

$r = oci_execute($stid, OCI_DEFAULT);

	$suma="";
	while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) 
	{
		foreach ($row as $key =>$field) 
			{
			$field = htmlspecialchars($field, ENT_NOQUOTES);
			if($key=='DESCRIPCION')
				$field=iconv ('Windows-1252', 'UTF-8//TRANSLIT', $row['DESCRIPCION']);
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
$url='serializado_SeguiExpeConsulta.php';
$opcion='Lista de Actos de un Expediente, el Cuaderno de Bitacoras';

include 'Test_Medicion_Datos.inc';

echo $suma;
oci_close($conn);
}


?>

