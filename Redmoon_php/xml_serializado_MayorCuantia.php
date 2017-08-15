<?php 

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');


require('autoriza_web.inc');

// Create a database connection

$conn = db_connect();

// Expedientes que superan una determinada cuantia y tienen que ser revisados por los gestores
do_queryTodo($conn, 'SELECT NE,NIF,APENOMBRE,CUANTIA,IMP_PROVISION,IMP_GESTION FROM VWMAYOR_CUANTIA');
   
// Execute query and display results
/* @var $conn db_conn */
function do_queryTodo($conn, $query)
{
	
	$time_start = microtime(true);

if (!isset($_POST['xPag']))
	$xPag=1;
else 
	$xPag=$_POST['xPag'];

	$resultado=db_get_page_data($conn, $query, $xPag, 15);

	$suma='<?xml version="1.0" encoding="UTF-8"?>'."\n";
	$suma=$suma."<FILAS>\n";
	for ($j=0; $j <=(count($resultado)-1); $j++)
	{	
	$suma=$suma."<FILA>\n";
	
	$suma=$suma."<NE>".$resultado[$j]['NE']."</NE>\n";
	$suma=$suma."<NIF>".$resultado[$j]['NIF']."</NIF>\n";
	$suma=$suma."<NOMBRE>".iconv('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['APENOMBRE'])."</NOMBRE>\n";
	$suma=$suma."<CUANTIA>".number_format($resultado[$j]['CUANTIA'], 0, ',', '.').' &#8364;'."</CUANTIA>\n";
	$suma=$suma."<IMP_PROVISION>".number_format($resultado[$j]['IMP_PROVISION'], 0, ',', '.').' &#8364;'."</IMP_PROVISION>\n";
	$suma=$suma."<IMP_GESTION>".number_format($resultado[$j]['IMP_GESTION'], 0, ',', '.').' &#8364;'."</IMP_GESTION>\n";
	$suma=$suma."</FILA>\n";
	}
	$suma=$suma."</FILAS>\n";
// descomentar para grabar estadisticas de medición de caudal

// A configurar en cada módulo =======================
$time_end = microtime(true);
$time = $time_end - $time_start;

/* @var $numero_bytes integer */
$numero_bytes=strlen($suma);
$url='XML_serializado_MayorCuantia.php';
$opcion='Listado en XML de expedientes de mayor cuantia pendientes de aprobar';

include 'Test_Medicion_Datos.inc';

echo $suma;
oci_close($conn);
}


?>
