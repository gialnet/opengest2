<?php 

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

// Create a database connection
//$conn = oci_connect('lgs','a1','//cajalgs.no-ip.org/lgs');
$conn = db_connect();

if(isset($_POST["xColabora"]))
 do_queryColabora($conn, 'SELECT t.NE,t.NIF,t.APENOMBRE,t.FASE,s.DH FROM VWTAREAS_COLABORADOR t,seguimiento s 
WHERE t.COLABORADOR=108
and s.ne=t.ne and s.tipo_regla=12');
else 
 do_queryTodo($conn, 'SELECT t.NE,t.NIF,t.APENOMBRE,t.FASE,s.DH FROM VWTAREAS_COLABORADOR t,seguimiento s 
WHERE s.ne=t.ne and s.tipo_regla=12');

// Execute query and display results
function do_queryTodo($conn, $query)
{

	$time_start = microtime(true);

	$stid = oci_parse($conn, $query);


$r = oci_execute($stid, OCI_DEFAULT);

	$suma="";
	while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) 
	{
		foreach ($row as $key =>$field) 
			{
			$field = htmlspecialchars($field, ENT_NOQUOTES);
			$suma=$suma.$field.'|';
			}
	}
	
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

function do_queryColabora($conn, $query)
{
	$time_start = microtime(true);
	
$xColabora=$_POST["xColabora"]; // Ejemplo de un colaborador : JOSE MARIA RODRIGUEZ MILLAN
$stid = oci_parse($conn, $query);
oci_bind_by_name($stid, ':xColabora', $xColabora, 38, SQLT_INT);


$r = oci_execute($stid, OCI_DEFAULT);

	$suma="";
	while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) 
	{
		foreach ($row as $key =>$field) 
			{
			$field = htmlspecialchars($field, ENT_NOQUOTES);
			$suma=$suma.$field.'|';
			}
	}

// descomentar para grabar estadisticas de medición de caudal

// A configurar en cada módulo =======================
$time_end = microtime(true);
$time = $time_end - $time_start;
	
$numero_bytes=strlen($suma);
$url='serializado_PeticionesColaborador.php';
$opcion='Lista de Peticiones de Transferencias de Pago a Colaboradores';

include 'Test_Medicion_Datos.inc';

echo $suma;
oci_close($conn);
}


?>

