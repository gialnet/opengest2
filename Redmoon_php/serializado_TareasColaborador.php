<?php 

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

// Create a database connection
//$conn = oci_connect('lgs','a1','//cajalgs.no-ip.org/lgs');
$conn = db_connect();

if(isset($_POST["xColabora"]))
 do_queryColabora($conn, 'SELECT NE,NIF,APENOMBRE,FASE FROM VWTAREAS_COLABORADOR WHERE COLABORADOR=:xColaborador');
else 
 do_queryTodo($conn, 'SELECT NE,NIF,APENOMBRE,FASE FROM VWTAREAS_COLABORADOR ');

// Execute query and display results
function do_queryTodo($conn, $query)
{
	$time_start = microtime(true);
	
if (!isset($_POST['xPag']))
	$xPag=1;
else 
	$xPag=$_POST['xPag'];

	$resultado=db_get_page_data($conn, $query, $xPag, 10);
	$suma='';
	for ($j=0; $j <=(count($resultado)-1); $j++)
	{
	
	$suma=$suma.$resultado[$j]['NE'].'|';
	$suma=$suma.$resultado[$j]['NIF'].'|';
	$suma=$suma.iconv('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['APENOMBRE']).'|';
	$suma=$suma.iconv('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['FASE']).'|';

	
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

function do_queryColabora($conn, $query)
{
		$time_start = microtime(true);
	
$xColabora=$_POST["xColabora"]; // Ejemplo de un colaborador : JOSE MARIA RODRIGUEZ MILLAN
$bindargs = array();
array_push($bindargs, array('XCOLABORADOR',$xColabora,38));

if (!isset($_POST['xPag']))
	$xPag=1;
else 
	$xPag=$_POST['xPag'];

	$resultado=db_get_page_data($conn, $query, $xPag, 10, $bindargs);
	$suma='';
	for ($j=0; $j <=(count($resultado)-1); $j++)
	{
	
	
	$suma=$suma.$resultado[$j]['NE'].'|';
	$suma=$suma.$resultado[$j]['NIF'].'|';
	$suma=$suma.iconv('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['APENOMBRE']).'|';
	$suma=$suma.iconv('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['FASE']).'|';
	}
// descomentar para grabar estadisticas de medición de caudal

// A configurar en cada módulo =======================
$time_end = microtime(true);
$time = $time_end - $time_start;
	
$numero_bytes=strlen($suma);
$url='serializado_TareasColaborador.php';
$opcion='Listado las tareas pendientes de un colaborador o todos los colaboradores';

include 'Test_Medicion_Datos.inc';
	
echo $suma;
oci_close($conn);
}


?>

