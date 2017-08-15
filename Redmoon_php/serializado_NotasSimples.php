<?php 

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

// Create a database connection
//$conn = oci_connect('lgs','a1','//cajalgs.no-ip.org/lgs');
$conn = db_connect();


/*
 * cuando la nota simple llega(PENDIENTES) se inserta como pendiente hasta que no se marque
 * como enviada(ENVIADOS) una vez enviada la nota simple puede encontrarse como recibida (RECIBIDOS)
 * o que no se encuentra(DENEGADOS)
 */
if (isset($_POST['xPENDIENTES']))
	do_queryPendientes($conn, "select id, fechahora,fecha_peticion,fecha_recepcion,FUP,ESCALERA,NOMBRE_T,REGISTRO,ID_FINCA,ESTADO from lgs_notas_simples where ESTADO='PE'");
if (isset($_POST['xENVIADOS']))
	do_queryEnviados($conn, "select id, fechahora,fecha_peticion,fecha_recepcion,FUP,ESCALERA,NOMBRE_T,REGISTRO,ID_FINCA,ESTADO from lgs_notas_simples where ESTADO='EN'");
if (isset($_POST['xRECIBIDOS']))
	do_queryRecibidos($conn, "select id, fechahora,fecha_peticion,fecha_recepcion,FUP,ESCALERA,NOMBRE_T,REGISTRO,ID_FINCA,ESTADO from lgs_notas_simples where ESTADO='SI'");
if (isset($_POST['xDENEGADOS']))
	do_queryDenegados($conn, "select id, fechahora,fecha_peticion,fecha_recepcion,FUP,ESCALERA,NOMBRE_T,REGISTRO,ID_FINCA,ESTADO from lgs_notas_simples where ESTADO='NO' AND IDCUADERNO='NULL'");

// Execute query and display results
function do_queryPendientes($conn, $query)
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
	
	$suma=$suma.$resultado[$j]['ID'].'|';
	$suma=$suma.$resultado[$j]['FECHAHORA'].'|';
	$suma=$suma.$resultado[$j]['FECHA_PETICION'].'|';
	$suma=$suma.$resultado[$j]['FECHA_RECEPCION'].'|';
	$suma=$suma.iconv ('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['FUP']).'|';
	$suma=$suma.iconv ('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['ESCALERA']).'|';
	$suma=$suma.iconv ('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['NOMBRE_T']).'|';
	$suma=$suma.$resultado[$j]['REGISTRO'].'|';
	$suma=$suma.$resultado[$j]['ID_FINCA'].'|';
	$suma=$suma.$resultado[$j]['ESTADO'].'|';

	
	}

	if (count($resultado)==0)
	echo 'NoDataFound';
else {
// descomentar para grabar estadisticas de medición de caudal

// A configurar en cada módulo =======================
$time_end = microtime(true);
$time = $time_end - $time_start;

$numero_bytes=strlen($suma);
$url='serializado_NotasSimples.php';
$opcion='Listados de notas simples pendientes';

include 'Test_Medicion_Datos.inc';

echo $suma;
}
oci_close($conn);

}

function do_queryEnviados($conn, $query)
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
	
	$suma=$suma.$resultado[$j]['ID'].'|';
	$suma=$suma.$resultado[$j]['FECHAHORA'].'|';
	$suma=$suma.$resultado[$j]['FECHA_PETICION'].'|';
	$suma=$suma.$resultado[$j]['FECHA_RECEPCION'].'|';
	$suma=$suma.iconv ('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['FUP']).'|';
	$suma=$suma.iconv ('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['ESCALERA']).'|';
	$suma=$suma.iconv ('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['NOMBRE_T']).'|';
	$suma=$suma.$resultado[$j]['REGISTRO'].'|';
	$suma=$suma.$resultado[$j]['ID_FINCA'].'|';
	$suma=$suma.$resultado[$j]['ESTADO'].'|';

	
	}


// descomentar para grabar estadisticas de medición de caudal

// A configurar en cada módulo =======================
$time_end = microtime(true);
$time = $time_end - $time_start;

$numero_bytes=strlen($suma);
$url='serializado_NotasSimples.php';
$opcion='Listados de notas simples enviadas';

include 'Test_Medicion_Datos.inc';

echo $suma;

oci_close($conn);

}
function do_queryRecibidos($conn, $query)
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
	
	$suma=$suma.$resultado[$j]['ID'].'|';
	$suma=$suma.$resultado[$j]['FECHAHORA'].'|';
	$suma=$suma.$resultado[$j]['FECHA_PETICION'].'|';
	$suma=$suma.$resultado[$j]['FECHA_RECEPCION'].'|';
	$suma=$suma.iconv ('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['FUP']).'|';
	$suma=$suma.iconv ('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['ESCALERA']).'|';
	$suma=$suma.iconv ('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['NOMBRE_T']).'|';
	$suma=$suma.$resultado[$j]['REGISTRO'].'|';
	$suma=$suma.$resultado[$j]['ID_FINCA'].'|';
	$suma=$suma.$resultado[$j]['ESTADO'].'|';

	
	}


// descomentar para grabar estadisticas de medición de caudal

// A configurar en cada módulo =======================
$time_end = microtime(true);
$time = $time_end - $time_start;

$numero_bytes=strlen($suma);
$url='serializado_NotasSimples.php';
$opcion='Listados de notas simples recibidas';

include 'Test_Medicion_Datos.inc';

echo $suma;

oci_close($conn);

}
function do_queryDenegados($conn, $query)
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
	
	$suma=$suma.$resultado[$j]['ID'].'|';
	$suma=$suma.$resultado[$j]['FECHAHORA'].'|';
	$suma=$suma.$resultado[$j]['FECHA_PETICION'].'|';
	$suma=$suma.$resultado[$j]['FECHA_RECEPCION'].'|';
	$suma=$suma.iconv ('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['FUP']).'|';
	$suma=$suma.iconv ('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['ESCALERA']).'|';
	$suma=$suma.iconv ('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['NOMBRE_T']).'|';
	$suma=$suma.$resultado[$j]['REGISTRO'].'|';
	$suma=$suma.$resultado[$j]['ID_FINCA'].'|';
	$suma=$suma.$resultado[$j]['ESTADO'].'|';

	
	}


// descomentar para grabar estadisticas de medición de caudal

// A configurar en cada módulo =======================
$time_end = microtime(true);
$time = $time_end - $time_start;

$numero_bytes=strlen($suma);
$url='serializado_NotasSimples.php';
$opcion='Listados de notas simples denegadas';

include 'Test_Medicion_Datos.inc';

echo $suma;

oci_close($conn);

}

?>

